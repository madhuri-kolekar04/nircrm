<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LeadsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $rowCount = 0;
    private $errors = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $this->rowCount++;
            
            // Debug: Log all available row keys to understand the structure
            \Log::info('Excel Row ' . $this->rowCount . ' - All keys: ' . json_encode(array_keys($row)));
            
            // Check if name is present (required field)
            $name = $row['name'] ?? $row['Name'] ?? null;
            if (empty($name)) {
                $this->errors[] = "Row {$this->rowCount}: Name is required";
                return null;
            }
            
            // Helper function to find value by multiple possible column names
            $findValue = function($possibleNames) use ($row) {
                foreach ($possibleNames as $name) {
                    if (array_key_exists($name, $row) && $row[$name] !== null && $row[$name] !== '') {
                        return $row[$name];
                    }
                }
                return null;
            };
            
            // Try multiple possible column names for status, source, and priority
            $leadStatus = $this->normalizeLeadStatus(
                $findValue([
                    'lead_status',
                    'Lead Status* (hot/cold/warm/qualified/lost)',
                    'Lead Status',
                    'Status',
                    'lead_status'
                ])
            );
            
            $source = $this->normalizeSource(
                $findValue([
                    'source',
                    'Source* (website/referral/social_media/email/phone/advertisement/other)',
                    'Source',
                    'source'
                ])
            );
            
            $priority = $this->normalizePriority(
                $findValue([
                    'priority',
                    'Priority* (low/medium/high)',
                    'Priority',
                    'priority'
                ])
            );
            
            // Debug: Log the normalized values
            \Log::info('Normalized Row ' . $this->rowCount . ': ' . json_encode([
                'lead_status_normalized' => $leadStatus,
                'source_normalized' => $source,
                'priority_normalized' => $priority
            ]));
            
            return new Lead([
                'name' => $name,
                'email' => $row['email'] ?? $row['Email'] ?? null,
                'phone' => $this->handleArrayValue($row, ['phone', 'Phone']),
                'company_name' => $this->handleArrayValue($row, ['company_name', 'Company Name']),
                'website' => $this->handleArrayValue($row, ['website', 'Website']),
                'address' => $this->handleArrayValue($row, ['address', 'Address']),
                'city' => $this->handleArrayValue($row, ['city', 'City']),
                'state' => $this->handleArrayValue($row, ['state', 'State']),
                'country' => $this->handleArrayValue($row, ['country', 'Country']),
                'pincode' => $this->handleArrayValue($row, ['pincode', 'Pincode', 'Records']), // Handle Records column
                'industry' => $this->handleArrayValue($row, ['industry', 'Industry']),
                'lead_status' => $leadStatus,
                'source' => $source,
                'description' => $this->handleArrayValue($row, ['description', 'Description']),
                'budget' => $this->parseBudget($row['budget'] ?? $row['Budget'] ?? 0),
                'follow_up_date' => $this->parseDate($row['follow_up_date'] ?? $row['Follow Up Date (YYYY-MM-DD)'] ?? null),
                'notes' => $this->handleArrayValue($row, ['notes', 'Notes', 'Remarks']), // Handle Remarks column
                'priority' => $priority,
                'department' => $this->handleArrayValue($row, ['department', 'Department']),
                'work_status' => $this->handleArrayValue($row, ['work_status', 'Work Status']),
                'work_type' => $this->handleArrayValue($row, ['work_type', 'Work Type']),
                'current_service' => $this->handleArrayValue($row, ['current_service', 'Current Service']),
                'date_of_completion' => $this->parseDate($row['date_of_completion'] ?? $row['Date of Completion'] ?? null),
                'created_by' => Auth::id(),
            ]);
        } catch (\Exception $e) {
            $this->errors[] = "Row {$this->rowCount}: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Handle array values by converting them to strings or returning null.
     */
    private function handleArrayValue($row, $possibleKeys): ?string
    {
        foreach ($possibleKeys as $key) {
            if (isset($row[$key])) {
                return is_array($row[$key]) ? implode(', ', $row[$key]) : (string) $row[$key];
            }
        }
        return null;
    }

    /**
     * Normalize lead status value.
     */
    private function normalizeLeadStatus($value): string
    {
        // If value is explicitly null or empty string, return default
        if ($value === null || $value === '') {
            return 'cold'; // Return database default if empty
        }
        
        // Handle if value is an array (convert to string)
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['hot', 'h', 'hot lead', 'hot_lead', 'hotlead'])) {
            return 'hot';
        }
        if (in_array($value, ['cold', 'c', 'cold lead', 'cold_lead', 'coldlead'])) {
            return 'cold';
        }
        if (in_array($value, ['warm', 'w', 'warm lead', 'warm_lead', 'warmlead'])) {
            return 'warm';
        }
        if (in_array($value, ['qualified', 'q', 'qualified lead', 'qualified_lead', 'qualifiedlead'])) {
            return 'qualified';
        }
        if (in_array($value, ['lost', 'l', 'lost lead', 'lost_lead', 'lostlead'])) {
            return 'lost';
        }
        
        return 'cold'; // Return database default if no match
    }

    /**
     * Normalize source value.
     */
    private function normalizeSource($value): string
    {
        // If value is explicitly null or empty string, return default
        if ($value === null || $value === '') {
            return 'other'; // Return database default if empty
        }
        
        // Handle if value is an array (convert to string)
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['website', 'web', 'site', 'online'])) {
            return 'website';
        }
        if (in_array($value, ['referral', 'ref', 'refer'])) {
            return 'referral';
        }
        if (in_array($value, ['social media', 'social_media', 'social', 'fb', 'instagram', 'linkedin', 'twitter'])) {
            return 'social_media';
        }
        if (in_array($value, ['email', 'mail', 'e-mail'])) {
            return 'email';
        }
        if (in_array($value, ['phone', 'call', 'mobile', 'telephone'])) {
            return 'phone';
        }
        if (in_array($value, ['advertisement', 'ad', 'ads', 'marketing'])) {
            return 'advertisement';
        }
        if (in_array($value, ['other', 'others', 'misc', 'miscellaneous'])) {
            return 'other';
        }
        
        return 'other'; // Return database default if no match
    }

    /**
     * Normalize priority value.
     */
    private function normalizePriority($value): string
    {
        // If value is explicitly null or empty string, return default
        if ($value === null || $value === '') {
            return 'medium'; // Return database default if empty
        }
        
        // Handle if value is an array (convert to string)
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        
        $value = strtolower(trim($value));
        
        // Handle various case formats and common variations
        if (in_array($value, ['low', 'l', 'low priority', 'lowpriority'])) {
            return 'low';
        }
        if (in_array($value, ['medium', 'med', 'm', 'medium priority', 'mediumpriority'])) {
            return 'medium';
        }
        if (in_array($value, ['high', 'h', 'high priority', 'urgent', 'highpriority'])) {
            return 'high';
        }
        
        return 'medium'; // Return database default if no match
    }

    /**
     * Parse budget value.
     */
    private function parseBudget($value): ?float
    {
        if (empty($value)) {
            return null;
        }
        
        // Remove currency symbols and commas
        $value = preg_replace('/[^\d.]/', '', $value);
        
        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * Parse date value.
     */
    private function parseDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }
        
        try {
            $date = new \DateTime($value);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Batch size.
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk size.
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Get row count.
     */
    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    /**
     * Get errors.
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
