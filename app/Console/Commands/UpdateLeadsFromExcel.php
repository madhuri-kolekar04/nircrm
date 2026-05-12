<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Lead;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UpdateLeadsFromExcel extends Command
{
    protected $signature = 'leads:update-from-excel {file}';
    protected $description = 'Update leads with work-related data from Excel file';

    public function handle()
    {
        $excelFile = $this->argument('file');
        
        if (!file_exists($excelFile)) {
            $this->error("Excel file not found: {$excelFile}");
            return 1;
        }

        $this->info("Loading Excel file: {$excelFile}");
        
        try {
            $spreadsheet = IOFactory::load($excelFile);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            
            $this->info("Found {$highestRow} rows in Excel file");
            
            $updatedCount = 0;
            $notFoundCount = 0;
            $noDataCount = 0;
            $skippedCount = 0;
            
            // Process each row starting from row 2 (assuming row 1 is headers)
            for ($row = 2; $row <= $highestRow; $row++) {
                $name = $worksheet->getCell('A' . $row)->getValue();
                
                if (empty($name)) {
                    continue;
                }
                
                $this->line("Processing: {$name}");
                
                // Get the work-related data from columns B, C, D, E
                $workStatus = $worksheet->getCell('B' . $row)->getValue() ?? null;
                $workType = $worksheet->getCell('C' . $row)->getValue() ?? null;
                $currentService = $worksheet->getCell('D' . $row)->getValue() ?? null;
                $dateOfCompletion = $worksheet->getCell('E' . $row)->getValue() ?? null;
                
                // Find the lead by name
                $lead = Lead::where('name', $name)->first();
                
                if ($lead) {
                    $this->info("  - Found lead: {$lead->name} (ID: {$lead->id})");
                    
                    // Update the lead with work-related data (always update if lead exists in Excel)
                    $updateData = [];
                    
                    // Always include the work-related fields in update data
                    // This ensures we process the lead even if some fields are empty
                    $updateData['work_status'] = $workStatus;
                    $updateData['work_type'] = $workType;
                    $updateData['current_service'] = $currentService;
                    $updateData['date_of_completion'] = $dateOfCompletion && !is_numeric($dateOfCompletion) && strtotime($dateOfCompletion) ? \Carbon\Carbon::parse($dateOfCompletion)->format('Y-m-d') : null;
                    
                    // Only update fields that have actual data (non-empty)
                    $filteredUpdateData = [];
                    if (!empty($workStatus) && $workStatus !== null && $workStatus !== '' && strlen(trim($workStatus)) > 0) {
                        $filteredUpdateData['work_status'] = $workStatus;
                    }
                    if (!empty($workType) && $workType !== null && $workType !== '' && strlen(trim($workType)) > 0) {
                        $filteredUpdateData['work_type'] = $workType;
                    }
                    if (!empty($currentService) && $currentService !== null && $currentService !== '' && strlen(trim($currentService)) > 0) {
                        $filteredUpdateData['current_service'] = $currentService;
                    }
                    if (!empty($dateOfCompletion) && $dateOfCompletion !== null && $dateOfCompletion !== '' && strlen(trim($dateOfCompletion)) > 0) {
                        if (is_numeric($dateOfCompletion)) {
                            // Handle Excel numeric dates
                            try {
                                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateOfCompletion);
                                $filteredUpdateData['date_of_completion'] = $date->format('Y-m-d');
                            } catch (\Exception $e) {
                                $filteredUpdateData['date_of_completion'] = null;
                            }
                        } else {
                            // Handle text dates
                            $filteredUpdateData['date_of_completion'] = strtotime($dateOfCompletion) ? \Carbon\Carbon::parse($dateOfCompletion)->format('Y-m-d') : null;
                        }
                    }
                    
                    if (!empty($filteredUpdateData)) {
                        $lead->update($filteredUpdateData);
                        $updatedCount++;
                        $this->info("  - Updated with work data:");
                        $this->line("    - Work Status: {$workStatus}");
                        $this->line("    - Work Type: {$workType}");
                        $this->line("    - Current Service: {$currentService}");
                        $this->line("    - Date of Completion: {$dateOfCompletion}");
                    } else {
                        // Check if ALL work-related columns are completely empty
                        $allWorkColumnsEmpty = empty($workStatus) && empty($workType) && empty($currentService) && empty($dateOfCompletion);
                        
                        if ($allWorkColumnsEmpty) {
                            // Force clear work-related fields in database when Excel columns are empty
                            // This ensures no wrong data (like email/phone) appears in work-related fields
                            $lead->update([
                                'work_status' => null,
                                'work_type' => null,
                                'current_service' => null,
                                'date_of_completion' => null,
                            ]);
                            $this->warn("  - CLEARED: All work-related columns (B, C, D, E) are empty - forced cleared in database");
                            $skippedCount++;
                        } else {
                            $this->warn("  - No work data to update (all 4 columns empty)");
                            $noDataCount++;
                        }
                    }
                } else {
                    $this->error("  - Lead not found: {$name}");
                    $notFoundCount++;
                }
                
                $this->line("---");
            }
            
            $this->info("\n=== UPDATE SUMMARY ===");
            $this->info("Total leads processed: " . ($highestRow - 1));
            $this->info("Leads updated: {$updatedCount}");
            $this->info("Leads not found: {$notFoundCount}");
            $this->info("Leads with no data: {$noDataCount}");
            $this->info("Leads skipped: {$skippedCount}");
            
            if ($updatedCount > 0) {
                $this->info("\n" . str_repeat("=", 50));
                $this->info("  SUCCESSFULLY UPDATED {$updatedCount} LEADS!");
                $this->info(str_repeat("=", 50));
                return 0;
            } else {
                $this->warn("\nNo leads were updated. Please check the Excel file and database.");
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }
    }
}
