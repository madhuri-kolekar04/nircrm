<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class GoogleSheetsApiService
{
    protected $spreadsheetId;
    protected $apiKey;
    protected $serviceAccountFile;
    protected $accessToken;

    public function __construct()
    {
        $this->spreadsheetId = config('services.google.sheets.spreadsheet_id');
        $this->apiKey = config('services.google.sheets.api_key');
        $this->serviceAccountFile = config('services.google.sheets.service_account_file');
    }

    /**
     * Get OAuth 2.0 Access Token using Service Account
     */
    public function getAccessToken()
    {
        if (Cache::has('google_sheets_access_token')) {
            return Cache::get('google_sheets_access_token');
        }

        try {
            if (!file_exists(storage_path('app/' . $this->serviceAccountFile))) {
                throw new \Exception('Service account file not found');
            }

            $serviceAccount = json_decode(
                file_get_contents(storage_path('app/' . $this->serviceAccountFile)), 
                true
            );

            $jwt = $this->createJWT($serviceAccount);
            
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to get access token: ' . $response->body());
            }

            $tokenData = $response->json();
            $accessToken = $tokenData['access_token'];
            $expiresIn = $tokenData['expires_in'] - 60; // Buffer time

            Cache::put('google_sheets_access_token', $accessToken, $expiresIn);

            return $accessToken;

        } catch (\Exception $e) {
            Log::error('Google Sheets Access Token Error: ' . $e->getMessage());
            throw new \Exception('Failed to get access token: ' . $e->getMessage());
        }
    }

    /**
     * Create JWT for Service Account authentication
     */
    private function createJWT($serviceAccount)
    {
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $now = time();
        
        $payload = json_encode([
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/spreadsheets.readonly',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now
        ]);

        $headerEncoded = $this->base64UrlEncode($header);
        $payloadEncoded = $this->base64UrlEncode($payload);

        $signatureInput = $headerEncoded . '.' . $payloadEncoded;
        
        $privateKey = $serviceAccount['private_key'];
        openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signatureEncoded = $this->base64UrlEncode($signature);

        return $signatureInput . '.' . $signatureEncoded;
    }

    /**
     * Base64 URL encode
     */
    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Get spreadsheet data with automatic retry and error handling
     */
    public function getSpreadsheetData($range = 'Sheet1!A:Z', $useOAuth = true)
    {
        try {
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/" . urlencode($range);
            
            $headers = [
                'Accept' => 'application/json'
            ];

            if ($useOAuth) {
                $accessToken = $this->getAccessToken();
                $headers['Authorization'] = 'Bearer ' . $accessToken;
            } else {
                // Fallback to API key for public spreadsheets
                $url .= '?key=' . $this->apiKey;
            }

            $response = Http::withHeaders($headers)->get($url);

            if (!$response->successful()) {
                if ($response->status() === 401 && $useOAuth) {
                    // Token expired, refresh and retry
                    Cache::forget('google_sheets_access_token');
                    return $this->getSpreadsheetData($range, $useOAuth);
                }
                throw new \Exception('Google Sheets API Error: ' . $response->body());
            }

            $data = $response->json();
            $values = $data['values'] ?? [];
            
            if (empty($values)) {
                return [];
            }

            // Add metadata about the fetch
            $values['fetch_metadata'] = [
                'fetched_at' => now()->toISOString(),
                'range' => $range,
                'total_rows' => count($values) - 1, // Exclude header
                'method' => $useOAuth ? 'oauth' : 'api_key'
            ];

            return $values;

        } catch (\Exception $e) {
            Log::error('Google Sheets Data Fetch Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch data from Google Sheets: ' . $e->getMessage());
        }
    }

    /**
     * Get data with incremental updates based on timestamp
     */
    public function getIncrementalData($lastSyncTime = null, $dateColumn = 'SUBMITTED AT')
    {
        try {
            $allData = $this->getSpreadsheetData();
            
            if (empty($allData) || count($allData) < 2) {
                return [];
            }

            $headers = array_shift($allData);
            $dateColumnIndex = $this->findColumnIndex($headers, $dateColumn);
            
            if ($dateColumnIndex === -1) {
                // If date column not found, return all data
                return $this->formatDataWithHeaders($allData, $headers);
            }

            $incrementalData = [];
            $lastSync = $lastSyncTime ? Carbon::parse($lastSyncTime) : null;

            foreach ($allData as $row) {
                if (isset($row[$dateColumnIndex]) && !empty($row[$dateColumnIndex])) {
                    try {
                        $rowDate = $this->parseSheetDate($row[$dateColumnIndex]);
                        
                        if ($lastSync && $rowDate->greaterThan($lastSync)) {
                            $incrementalData[] = $row;
                        } elseif (!$lastSync) {
                            // If no last sync time, return all data
                            $incrementalData[] = $row;
                        }
                    } catch (\Exception $e) {
                        // Skip rows with invalid dates
                        continue;
                    }
                }
            }

            return $this->formatDataWithHeaders($incrementalData, $headers);

        } catch (\Exception $e) {
            Log::error('Incremental Data Fetch Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch incremental data: ' . $e->getMessage());
        }
    }

    /**
     * Find column index by name (case-insensitive)
     */
    private function findColumnIndex($headers, $columnName)
    {
        foreach ($headers as $index => $header) {
            if (strtolower(trim($header)) === strtolower(trim($columnName))) {
                return $index;
            }
        }
        return -1;
    }

    /**
     * Parse date from Google Sheets format
     */
    private function parseSheetDate($dateString)
    {
        // Handle various date formats from Google Sheets
        $formats = [
            'Y-m-d H:i:s',
            'Y-m-d',
            'd/m/Y H:i',
            'd/m/Y',
            'm/d/Y H:i',
            'm/d/Y',
            'M d, Y H:i',
            'M d, Y'
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                continue;
            }
        }

        // Try parsing as relative time
        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            throw new \Exception("Unable to parse date: {$dateString}");
        }
    }

    /**
     * Format data with headers as associative arrays
     */
    private function formatDataWithHeaders($data, $headers)
    {
        $formattedData = [];

        foreach ($data as $row) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                $header = trim($header);
                $value = isset($row[$index]) ? $row[$index] : '';
                $rowData[$header] = $value;
            }
            
            // Only add rows that have at least some data
            if (!empty(array_filter($rowData))) {
                $formattedData[] = $rowData;
            }
        }

        return $formattedData;
    }

    /**
     * Get last sync timestamp from cache
     */
    public function getLastSyncTimestamp()
    {
        return Cache::get('google_sheets_last_sync', null);
    }

    /**
     * Update last sync timestamp
     */
    public function updateLastSyncTimestamp()
    {
        Cache::put('google_sheets_last_sync', now()->toISOString(), now()->addDays(30));
    }

    /**
     * Test connection with both API key and OAuth
     */
    public function testConnection()
    {
        $results = [];

        // Test with API Key
        try {
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}";
            $response = Http::get($url, ['key' => $this->apiKey]);
            
            if ($response->successful()) {
                $results['api_key'] = [
                    'success' => true,
                    'message' => 'API Key connection successful',
                    'spreadsheet_name' => $response->json()['properties']['title'] ?? 'Unknown'
                ];
            } else {
                $results['api_key'] = [
                    'success' => false,
                    'message' => 'API Key connection failed: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            $results['api_key'] = [
                'success' => false,
                'message' => 'API Key test error: ' . $e->getMessage()
            ];
        }

        // Test with OAuth
        try {
            $accessToken = $this->getAccessToken();
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}";
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get($url);
            
            if ($response->successful()) {
                $results['oauth'] = [
                    'success' => true,
                    'message' => 'OAuth connection successful',
                    'spreadsheet_name' => $response->json()['properties']['title'] ?? 'Unknown'
                ];
            } else {
                $results['oauth'] = [
                    'success' => false,
                    'message' => 'OAuth connection failed: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            $results['oauth'] = [
                'success' => false,
                'message' => 'OAuth test error: ' . $e->getMessage()
            ];
        }

        return $results;
    }

    /**
     * Get spreadsheet metadata with detailed information
     */
    public function getSpreadsheetMetadata()
    {
        try {
            $accessToken = $this->getAccessToken();
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}";
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken
            ])->get($url);

            if (!$response->successful()) {
                throw new \Exception('Failed to get spreadsheet metadata: ' . $response->body());
            }

            $metadata = $response->json();
            
            // Add sheets information
            $sheets = [];
            foreach ($metadata['sheets'] as $sheet) {
                $sheets[] = [
                    'title' => $sheet['properties']['title'],
                    'sheet_id' => $sheet['properties']['sheetId'],
                    'grid_properties' => $sheet['properties']['gridProperties'] ?? []
                ];
            }

            return [
                'title' => $metadata['properties']['title'],
                'spreadsheet_id' => $metadata['spreadsheetId'],
                'locale' => $metadata['properties']['locale'] ?? 'en_US',
                'time_zone' => $metadata['properties']['timeZone'] ?? 'UTC',
                'sheets' => $sheets,
                'created_time' => $metadata['properties']['createdTime'] ?? null,
                'modified_time' => $metadata['properties']['modifiedTime'] ?? null
            ];

        } catch (\Exception $e) {
            Log::error('Google Sheets Metadata Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch spreadsheet metadata: ' . $e->getMessage());
        }
    }
}
