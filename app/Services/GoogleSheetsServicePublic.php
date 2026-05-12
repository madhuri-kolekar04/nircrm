<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GoogleSheetsServicePublic
{
    protected $spreadsheetId;

    public function __construct()
    {
        // Your Google Sheet ID - hardcoded since we're using public access
        $this->spreadsheetId = '1o0fn4TiF45i5I1SJrYawpT6JmShBbVYlBXRR9AUMHKg';
    }

    /**
     * Get all data from the spreadsheet using public CSV export
     */
    public function getSpreadsheetData()
    {
        try {
            // Using public CSV export - no API key needed
            $url = "https://docs.google.com/spreadsheets/d/{$this->spreadsheetId}/export?format=csv&gid=0";
            
            $response = Http::get($url);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch spreadsheet data: ' . $response->body());
            }

            $csvData = $response->body();
            $lines = explode("\n", $csvData);
            
            $data = [];
            foreach ($lines as $line) {
                if (!empty(trim($line))) {
                    // Parse CSV line
                    $data[] = str_getcsv($line);
                }
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('Google Sheets CSV Error: ' . $e->getMessage());
            throw new \Exception('Failed to fetch spreadsheet data: ' . $e->getMessage());
        }
    }

    /**
     * Get data with headers mapped as associative array
     */
    public function getMappedData()
    {
        // Try to get from cache first
        $cacheKey = 'google_sheets_data_' . $this->spreadsheetId;
        $cachedData = Cache::get($cacheKey);
        
        if ($cachedData !== null) {
            Log::info('Google Sheets data loaded from cache');
            return $cachedData;
        }
        
        Log::info('Fetching fresh Google Sheets data');
        $data = $this->getSpreadsheetData();
        
        if (empty($data)) {
            return [];
        }

        $headers = array_shift($data); // First row as headers
        $mappedData = [];
        $currentRow = null;
        $auditReportContent = '';
        $auditReportPlainContent = '';

        foreach ($data as $rowIndex => $row) {
            $rowData = [];
            $hasContent = false;
            
            foreach ($headers as $index => $header) {
                $header = trim($header);
                $value = isset($row[$index]) ? trim($row[$index]) : '';
                $rowData[$header] = $value;
                
                if (!empty($value)) {
                    $hasContent = true;
                }
            }
            
            // Check if this row starts a new record (has name/email)
            $isNewRecord = !empty($rowData['full_name']) && 
                          !empty($rowData['email']) && 
                          filter_var($rowData['email'], FILTER_VALIDATE_EMAIL);
            
            if ($isNewRecord) {
                // Save previous row if exists
                if ($currentRow !== null) {
                    // Add accumulated audit report content
                    if (!empty($auditReportContent)) {
                        $currentRow['audit_report'] = trim($auditReportContent);
                    }
                    if (!empty($auditReportPlainContent)) {
                        $currentRow['audit_report_plain'] = trim($auditReportPlainContent);
                    }
                    
                    // Only add rows that have at least some data
                    if (!empty(array_filter($currentRow))) {
                        $mappedData[] = $currentRow;
                    }
                }
                
                // Start new row
                $currentRow = $rowData;
                $auditReportContent = '';
                $auditReportPlainContent = '';
                
                // Check if this row already has audit report content
                if (!empty($rowData['audit_report'])) {
                    $auditReportContent = $rowData['audit_report'];
                }
                if (!empty($rowData['audit_report_plain'])) {
                    $auditReportPlainContent = $rowData['audit_report_plain'];
                }
                
            } else {
                // This is a continuation line - accumulate audit report content
                if ($currentRow !== null) {
                    // Check if this looks like audit report content
                    $fullRowContent = implode(' ', array_filter($rowData));
                    
                    if (stripos($fullRowContent, 'FREE AI MARKETING AUDIT REPORT') !== false ||
                        stripos($fullRowContent, 'Website First Impression') !== false ||
                        stripos($fullRowContent, 'SEO & Google Visibility') !== false ||
                        stripos($fullRowContent, 'Lead Generation Gaps') !== false ||
                        stripos($fullRowContent, 'Quick Win') !== false ||
                        stripos($fullRowContent, 'The Bottom Line') !== false) {
                        
                        // This looks like formatted audit report
                        $auditReportContent .= "\n" . $fullRowContent;
                        
                    } elseif (stripos($fullRowContent, 'Loading Speed') !== false ||
                              stripos($fullRowContent, 'Mobile Experience') !== false ||
                              stripos($fullRowContent, 'Trust Signals') !== false ||
                              stripos($fullRowContent, 'Domain Authority') !== false ||
                              stripos($fullRowContent, 'Organic Keywords') !== false) {
                        
                        // This looks like plain audit report
                        $auditReportPlainContent .= "\n" . $fullRowContent;
                    }
                }
            }
        }
        
        // Don't forget the last row
        if ($currentRow !== null) {
            if (!empty($auditReportContent)) {
                $currentRow['audit_report'] = trim($auditReportContent);
            }
            if (!empty($auditReportPlainContent)) {
                $currentRow['audit_report_plain'] = trim($auditReportPlainContent);
            }
            
            if (!empty(array_filter($currentRow))) {
                $mappedData[] = $currentRow;
            }
        }

        // Cache the processed data for 10 minutes
        Cache::put($cacheKey, $mappedData, 600); // 10 minutes
        Log::info('Google Sheets data cached for 10 minutes');

        return $mappedData;
    }

    /**
     * Clear Google Sheets cache
     */
    public function clearCache()
    {
        $cacheKey = 'google_sheets_data_' . $this->spreadsheetId;
        Cache::forget($cacheKey);
        Log::info('Google Sheets cache cleared');
    }

    /**
     * Map Google Sheets columns to database fields
     */
    public function mapToLeadFields($rowData)
    {
        $fieldMapping = $this->getFieldMapping();
        $leadData = [];

        foreach ($fieldMapping as $sheetColumn => $dbField) {
            $value = $rowData[$sheetColumn] ?? null;
            $leadData[$dbField] = $this->sanitizeFieldValue($value, $dbField);
        }

        // Create description from available fields
        $description = $this->createDescription($rowData);
        if ($description) {
            $leadData['description'] = $description;
        }

        // Set source
        $leadData['source'] = 'google_sheets';

        return $leadData;
    }

    /**
     * Create description from row data
     */
    protected function createDescription($rowData)
    {
        $descriptionParts = [];
        
        $descriptiveFields = [
            'business_type' => 'Business Type',
            'primary_goal' => 'Primary Goal', 
            'budget_range' => 'Budget Range',
            'score' => 'Score',
            'tier' => 'Tier'
        ];

        foreach ($descriptiveFields as $field => $label) {
            $value = $rowData[$field] ?? '';
            if (!empty(trim($value))) {
                $descriptionParts[] = "$label: " . trim($value);
            }
        }

        return implode(' | ', $descriptionParts);
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
     * Sanitize and validate field values
     */
    protected function sanitizeFieldValue($value, $field)
    {
        if (empty($value)) {
            return null;
        }

        $value = trim($value);

        switch ($field) {
            case 'name':
                // Limit name length to prevent database errors
                return !empty($value) ? substr($value, 0, 255) : null;
            
            case 'company_name':
                // Limit company name length
                return !empty($value) ? substr($value, 0, 255) : null;
            
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) ? $value : null;
            
            case 'phone':
                // Clean phone number
                return preg_replace('/[^0-9+\s]/', '', $value);
            
            case 'website':
                // Add protocol if missing
                if (!empty($value) && !preg_match('/^https?:\/\//', $value)) {
                    return 'https://' . $value;
                }
                return $value;
            
            case 'submitted_at':
                // Try to parse date
                $date = \DateTime::createFromFormat('Y-m-d', $value);
                return $date ? $date->format('Y-m-d') : null;
            
            case 'lead_status':
                // Normalize status
                $status = strtolower($value);
                $validStatuses = ['hot', 'warm', 'cold', 'qualified', 'lost'];
                return in_array($status, $validStatuses) ? $status : 'new';
            
            case 'priority':
                // Normalize priority
                $priority = strtolower($value);
                $validPriorities = ['high', 'medium', 'low'];
                return in_array($priority, $validPriorities) ? $priority : 'medium';
            
            case 'budget':
                // Handle budget range - try to extract numeric value or set to null
                if (empty($value)) {
                    return null;
                }
                
                // Try to extract numeric value from budget range
                // Examples: "₹8-12 lakhs", "50000-100000", "$1000-$5000"
                if (preg_match('/(\d+(?:,\d+)*)/', $value, $matches)) {
                    $numericValue = str_replace(',', '', $matches[1]);
                    return is_numeric($numericValue) ? (float) $numericValue : null;
                }
                
                // If no numeric value found, return null to avoid decimal cast error
                return null;
            
            case 'business_type':
            case 'primary_goal':
            case 'tier':
            case 'score':
                // Limit text fields to reasonable length
                return !empty($value) ? substr($value, 0, 100) : null;
            
            case 'website':
                // Add protocol if missing and limit length
                if (!empty($value) && !preg_match('/^https?:\/\//', $value)) {
                    return substr('https://' . $value, 0, 255);
                }
                return substr($value, 0, 255);
            
            default:
                return $value;
        }
    }

    /**
     * Check if lead already exists
     */
    public function checkLeadExists($leadData)
    {
        // Check by email (most reliable)
        if (!empty($leadData['email'])) {
            $existingLead = \App\Models\Lead::where('source', 'google_sheets')
                ->where('email', $leadData['email'])
                ->first();
            
            if ($existingLead) {
                return $existingLead;
            }
        }

        // Check by phone (if email not found)
        if (!empty($leadData['phone'])) {
            $existingLead = \App\Models\Lead::where('source', 'google_sheets')
                ->where('phone', $leadData['phone'])
                ->first();
            
            if ($existingLead) {
                return $existingLead;
            }
        }

        // Check by name + business combination (last resort)
        if (!empty($leadData['name']) && !empty($leadData['company_name'])) {
            $existingLead = \App\Models\Lead::where('source', 'google_sheets')
                ->where('name', $leadData['name'])
                ->where('company_name', $leadData['company_name'])
                ->first();
            
            if ($existingLead) {
                return $existingLead;
            }
        }

        return null;
    }

    /**
     * Test connection to Google Sheets
     */
    public function testConnection()
    {
        try {
            $data = $this->getSpreadsheetData();
            
            if (empty($data)) {
                return [
                    'success' => false,
                    'message' => 'No data found in Google Sheets'
                ];
            }

            return [
                'success' => true,
                'message' => 'Successfully connected to Google Sheets',
                'rows_found' => count($data) - 1, // Exclude header
                'columns' => count($data[0] ?? [])
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update last sync timestamp
     */
    public function updateLastSyncTimestamp()
    {
        Cache::put('google_sheets_last_sync', now(), now()->addHours(24));
    }

    /**
     * Get last sync timestamp
     */
    public function getLastSyncTimestamp()
    {
        return Cache::get('google_sheets_last_sync');
    }
}
