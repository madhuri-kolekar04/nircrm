@echo off
echo ========================================
echo   Google Sheets Credentials Setup
echo ========================================
echo.
echo This script will help you set up Google Sheets credentials.
echo.
echo STEPS:
echo 1. Go to https://console.cloud.google.com/
echo 2. Create a Service Account
echo 3. Download JSON credentials file
echo 4. Copy the file to storage/app/google-credentials.json
echo.
echo Press any key to open Google Cloud Console...
pause > nul
start https://console.cloud.google.com/
echo.
echo After downloading the JSON file:
echo 1. Rename it to "google-credentials.json"
echo 2. Copy it to: storage\app\google-credentials.json
echo.
echo Press any key to open the correct folder...
pause > nul
explorer "storage\app"
echo.
echo Setup complete! Your Google Sheets sync will work now.
pause
