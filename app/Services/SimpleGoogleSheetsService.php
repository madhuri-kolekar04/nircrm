<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SimpleGoogleSheetsService
{
    protected $spreadsheetId;
    protected $apiKey;

    public function __construct()
    {
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $this->apiKey = env('GOOGLE_SHEETS_API_KEY');
    }

    /**
     * Get all data from Google Sheets
     */
    public function getAllData()
    {
        try {
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/Sheet1!A:Z";
            
            $response = Http::get($url, [
                'key' => $this->apiKey
            ]);

            if (!$response->successful()) {
                throw new \Exception('Google Sheets API Error: ' . $response->body());
            }

            $data = $response->json();
            $values = $data['values'] ?? [];
            
            if (empty($values)) {
                return [];
            }

            return $values;
        } catch (\Exception $e) {
            Log::error('Google Sheets Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get data with column headers as keys
     */
    public function getFormattedData()
    {
        $data = $this->getAllData();
        
        if (empty($data) || count($data) < 2) {
            return [];
        }

        $headers = array_shift($data); // First row as headers
        $formattedData = [];

        foreach ($data as $row) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                $header = trim($header);
                $value = isset($row[$index]) ? $row[$index] : '';
                $rowData[$header] = $value;
            }
            
            // Only add rows that have data
            if (!empty(array_filter($rowData))) {
                $formattedData[] = $rowData;
            }
        }

        return $formattedData;
    }

    /**
     * Get specific columns data
     */
    public function getColumnData($columns = [])
    {
        $data = $this->getFormattedData();
        $result = [];

        foreach ($data as $row) {
            $filteredRow = [];
            foreach ($columns as $column) {
                $filteredRow[$column] = $row[$column] ?? '';
            }
            $result[] = $filteredRow;
        }

        return $result;
    }

    /**
     * Get data by date column (new entries since last fetch)
     */
    public function getNewEntries($lastFetchDate = null, $dateColumn = 'SUBMITTED AT')
    {
        $data = $this->getFormattedData();
        $newEntries = [];

        foreach ($data as $row) {
            if (isset($row[$dateColumn]) && !empty($row[$dateColumn])) {
                try {
                    $entryDate = $this->parseDate($row[$dateColumn]);
                    
                    if (!$lastFetchDate || $entryDate > $lastFetchDate) {
                        $newEntries[] = $row;
                    }
                } catch (\Exception $e) {
                    // Skip invalid dates
                    continue;
                }
            }
        }

        return $newEntries;
    }

    /**
     * Parse date from various formats
     */
    private function parseDate($dateString)
    {
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
                return \Carbon\Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                continue;
            }
        }

        return \Carbon\Carbon::parse($dateString);
    }

    /**
     * Test connection
     */
    public function testConnection()
    {
        try {
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}";
            $response = Http::get($url, ['key' => $this->apiKey]);
            
            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Connection successful',
                    'spreadsheet_name' => $response->json()['properties']['title'] ?? 'Unknown'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Connection failed: ' . $response->body()
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get column headers
     */
    public function getHeaders()
    {
        $data = $this->getAllData();
        return !empty($data) ? array_map('trim', $data[0]) : [];
    }

    /**
     * Get data for specific column
     */
    public function getColumnValues($columnName)
    {
        $data = $this->getFormattedData();
        $values = [];

        foreach ($data as $row) {
            if (isset($row[$columnName]) && !empty($row[$columnName])) {
                $values[] = $row[$columnName];
            }
        }

        return $values;
    }
}
