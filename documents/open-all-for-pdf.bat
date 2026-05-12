@echo off
echo Opening all HTML files for PDF generation...
echo.
echo Instructions:
echo 1. Each file will open in your default browser
echo 2. Use Ctrl+P to open print dialog
echo 3. Select "Save as PDF" as destination
echo 4. Click "Save" to create PDF
echo 5. Close the browser tab when done
echo.

cd /d "%~dp0pdf"

echo Opening Documentation-Index.html...
start "" "Documentation-Index.html"

timeout /t 2 /nobreak >nul

echo Opening Technical-Overview.html...
start "" "Technical-Overview.html"

timeout /t 2 /nobreak >nul

echo Opening Models-Database-Schema.html...
start "" "Models-Database-Schema.html"

timeout /t 2 /nobreak >nul

echo Opening Controllers-API-Documentation.html...
start "" "Controllers-API-Documentation.html"

timeout /t 2 /nobreak >nul

echo Opening UI-UX-Design-System.html...
start "" "UI-UX-Design-System.html"

timeout /t 2 /nobreak >nul

echo Opening User-Manual-Roles.html...
start "" "User-Manual-Roles.html"

timeout /t 2 /nobreak >nul

echo Opening Installation-Deployment-Guide.html...
start "" "Installation-Deployment-Guide.html"

timeout /t 2 /nobreak >nul

echo Opening README.html...
start "" "README.html"

echo.
echo All files have been opened!
echo Follow the instructions above to create PDFs.
echo.
pause
