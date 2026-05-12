# NIRCRM Documentation - Open all HTML files for PDF generation
# This script opens all HTML files in the pdf folder for easy PDF conversion

Write-Host "NIRCRM Documentation PDF Generator" -ForegroundColor Green
Write-Host "=====================================" -ForegroundColor Green
Write-Host ""

Write-Host "Opening all HTML files for PDF generation..." -ForegroundColor Yellow
Write-Host ""
Write-Host "Instructions:" -ForegroundColor Cyan
Write-Host "1. Each file will open in your default browser" -ForegroundColor White
Write-Host "2. Use Ctrl+P to open print dialog" -ForegroundColor White
Write-Host "3. Select 'Save as PDF' as destination" -ForegroundColor White
Write-Host "4. Click 'Save' to create PDF" -ForegroundColor White
Write-Host "5. Close the browser tab when done" -ForegroundColor White
Write-Host ""

# Get the current directory and navigate to pdf folder
$pdfFolder = Join-Path $PSScriptRoot "pdf"

if (-not (Test-Path $pdfFolder)) {
    Write-Host "Error: PDF folder not found at $pdfFolder" -ForegroundColor Red
    Write-Host "Please run this script from the documents folder." -ForegroundColor Red
    exit 1
}

# Get all HTML files
$htmlFiles = Get-ChildItem -Path $pdfFolder -Filter "*.html" | Sort-Object Name

Write-Host "Found $($htmlFiles.Count) HTML files to open:" -ForegroundColor Green
Write-Host ""

foreach ($file in $htmlFiles) {
    Write-Host "Opening $($file.Name)..." -ForegroundColor Yellow
    
    try {
        Start-Process -FilePath $file.FullName -ErrorAction Stop
        Start-Sleep -Seconds 1  # Small delay between opening files
    }
    catch {
        Write-Host "Error opening $($file.Name): $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "All files have been opened!" -ForegroundColor Green
Write-Host "Follow the instructions above to create PDFs." -ForegroundColor Cyan
Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
