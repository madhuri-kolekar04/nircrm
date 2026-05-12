<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleSheetsService
{
    protected $spreadsheetId;
    protected $apiKey;

    public function __construct()
    {
        $this->spreadsheetId = config('services.google.sheets.spreadsheet_id');
        $this->apiKey = config('services.google.sheets.api_key');
    }

    /**
     * Get all data from the spreadsheet using public API
     */
    public function getSpreadsheetData($range = 'Sheet1!A:Z')
    {
        try {
            // Using Google Sheets API v4 with API key (for public spreadsheets)
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}/values/" . urlencode($range);
            
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
            Log::error('Google Sheets API Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch data from Google Sheets: ' . $e->getMessage());
        }
    }

    /**
     * Get spreadsheet metadata
     */
    public function getSpreadsheetMetadata()
    {
        try {
            $url = "https://sheets.googleapis.com/v4/spreadsheets/{$this->spreadsheetId}";
            
            $response = Http::get($url, [
                'key' => $this->apiKey
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to get spreadsheet metadata: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Google Sheets Metadata Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch spreadsheet metadata: ' . $e->getMessage());
        }
    }

    /**
     * Get data with headers mapped as associative array
     */
    public function getMappedData($range = 'Sheet1!A:Z')
    {
        $data = $this->getSpreadsheetData($range);
        
        if (empty($data)) {
            return [];
        }

        $headers = array_shift($data); // First row as headers
        $mappedData = [];

        foreach ($data as $row) {
            $rowData = [];
            foreach ($headers as $index => $header) {
                $header = trim($header);
                $value = isset($row[$index]) ? $row[$index] : '';
                $rowData[$header] = $value;
            }
            
            // Only add rows that have at least some data
            if (!empty(array_filter($rowData))) {
                $mappedData[] = $rowData;
            }
        }

        return $mappedData;
    }

    /**
     * Map Google Sheets columns to database fields based on configuration
     */
    public function mapToLeadFields($rowData)
    {
        $fieldMapping = $this->getFieldMapping();
        $leadData = [];

        foreach ($fieldMapping as $sheetColumn => $dbField) {
            $value = null;
            
            // Find the value in the row data
            foreach ($rowData as $column => $columnValue) {
                // Handle case-insensitive matching and partial matching
                if (strtolower($column) === strtolower($sheetColumn) || 
                    strpos(strtolower($column), strtolower($sheetColumn)) !== false) {
                    $value = $columnValue;
                    break;
                }
            }

            // Special handling for description and notes fields
            if ($dbField === 'description') {
                $leadData[$dbField] = $this->formatDescriptionField($rowData, $sheetColumn);
            } elseif ($dbField === 'notes') {
                $leadData[$dbField] = $this->formatNotesField($rowData, $sheetColumn);
            } else {
                $leadData[$dbField] = $this->sanitizeFieldValue($value, $dbField);
            }
        }

        return $leadData;
    }

    /**
     * Get the field mapping configuration
     */
    protected function getFieldMapping()
    {
        return [
            'full_name' => 'name',
            'business_name' => 'company_name',
            'email' => 'email',
            'whatsapp' => 'phone',
            'website_url' => 'website',
            'business_type' => 'business_type',
            'primary_goal' => 'primary_goal',
            'budget_range' => 'budget',
            'score' => 'score',
            'tier' => 'tier',
            'submitted_at' => 'submitted_at',
            'audit_report' => 'audit_report',
            'audit_report_plain' => 'audit_report_plain'
        ];
    }

    /**
     * Format description field with column names
     */
    protected function formatDescriptionField($rowData, $primaryColumn)
    {
        $description = '';
        
        // Add primary description field
        if (isset($rowData[$primaryColumn]) && !empty($rowData[$primaryColumn])) {
            $description .= $primaryColumn . ': ' . $rowData[$primaryColumn] . "\n";
        }

        // Add other description-related fields
        $descriptionFields = ['Primary Goal', 'Business Type', 'Score'];
        
        foreach ($descriptionFields as $field) {
            if (isset($rowData[$field]) && !empty($rowData[$field])) {
                $description .= $field . ': ' . $rowData[$field] . "\n";
            }
        }

        return trim($description);
    }

    /**
     * Format notes field with column names
     */
    protected function formatNotesField($rowData, $primaryColumn)
    {
        $notes = '';
        
        // Add primary notes field
        if (isset($rowData[$primaryColumn]) && !empty($rowData[$primaryColumn])) {
            $notes .= $primaryColumn . ': ' . $rowData[$primaryColumn] . "\n";
        }

        // Add other notes-related fields
        $notesFields = ['Audit Report', 'Audit Report Plain', 'Submitted At'];
        
        foreach ($notesFields as $field) {
            if (isset($rowData[$field]) && !empty($rowData[$field])) {
                $notes .= $field . ': ' . $rowData[$field] . "\n";
            }
        }

        return trim($notes);
    }

    /**
     * Sanitize and format field values
     */
    protected function sanitizeFieldValue($value, $field)
    {
        if (empty($value)) {
            return null;
        }

        // Clean up the value
        $value = trim($value);
        
        // Handle specific field types
        switch ($field) {
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
            
            case 'phone':
                // Clean phone number format
                return preg_replace('/[^0-9+\s]/', '', $value);
            
            case 'website':
                // Ensure URL format
                if (!empty($value) && !preg_match('/^https?:\/\//', $value)) {
                    $value = 'https://' . $value;
                }
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
            
            case 'budget':
                // Remove currency symbols and convert to number
                $budget = preg_replace('/[^0-9.]/', '', $value);
                return is_numeric($budget) ? (float) $budget : null;
            
            case 'follow_up_date':
                // Format date
                $date = \DateTime::createFromFormat('Y-m-d', $value) ?: 
                       \DateTime::createFromFormat('d/m/Y', $value) ?: 
                       \DateTime::createFromFormat('m/d/Y', $value);
                return $date ? $date->format('Y-m-d') : null;
            
            case 'lead_status':
                // Normalize lead status
                return $this->normalizeLeadStatus($value);
            
            case 'priority':
                // Normalize priority
                return $this->normalizePriority($value);
            
            default:
                return $value;
        }
    }

    /**
     * Normalize lead status values
     */
    protected function normalizeLeadStatus($status)
    {
        if (empty($status)) {
            return 'cold'; // Default status
        }

        $status = strtolower(trim($status));
        
        $statusMap = [
            'hot' => 'hot',
            'warm' => 'warm', 
            'cold' => 'cold',
            'qualified' => 'qualified',
            'lost' => 'lost',
            'new' => 'cold',
            'pending' => 'warm',
            'interested' => 'warm',
            'not interested' => 'lost'
        ];

        return $statusMap[$status] ?? 'cold';
    }

    /**
     * Normalize priority values
     */
    protected function normalizePriority($priority)
    {
        if (empty($priority)) {
            return 'medium'; // Default priority
        }

        $priority = strtolower(trim($priority));
        
        $priorityMap = [
            'high' => 'high',
            'medium' => 'medium',
            'low' => 'low',
            'urgent' => 'high',
            'normal' => 'medium',
            'low priority' => 'low'
        ];

        return $priorityMap[$priority] ?? 'medium';
    }

    /**
     * Check if a lead already exists based on email and phone
     */
    public function checkLeadExists($leadData)
    {
        $query = \App\Models\Lead::query();
        
        if (!empty($leadData['email'])) {
            $query->orWhere('email', $leadData['email']);
        }
        
        if (!empty($leadData['phone'])) {
            $query->orWhere('phone', $leadData['phone']);
        }
        
        if (!empty($leadData['name'])) {
            $query->orWhere('name', $leadData['name']);
        }
        
        return $query->first();
    }

    /**
     * Get the last sync timestamp
     */
    public function getLastSyncTimestamp()
    {
        return Cache::get('google_sheets_last_sync', null);
    }

    /**
     * Update the last sync timestamp
     */
    public function updateLastSyncTimestamp()
    {
        Cache::put('google_sheets_last_sync', now(), now()->addHours(24));
    }

    /**
     * Test connection to Google Sheets
     */
    public function testConnection()
    {
        try {
            $metadata = $this->getSpreadsheetMetadata();
            return [
                'success' => true,
                'message' => 'Successfully connected to Google Sheets',
                'spreadsheet_name' => $metadata['properties']['title'] ?? 'Unknown'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to connect to Google Sheets: ' . $e->getMessage()
            ];
        }
    }
}
