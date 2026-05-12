# Google Sheets API Key Setup

## 🔑 Get Your API Key

### Step 1: Go to Google Cloud Console
1. Visit: https://console.cloud.google.com/
2. Sign in with your Google account
3. Create a new project or select existing one

### Step 2: Enable Google Sheets API
1. In the sidebar, go to **APIs & Services** > **Library**
2. Search for "Google Sheets API"
3. Click on it and press **Enable**

### Step 3: Create API Key
1. Go to **APIs & Services** > **Credentials**
2. Click **+ CREATE CREDENTIALS**
3. Select **API Key**
4. Copy the API key that appears

### Step 4: Get Your Spreadsheet ID
1. Open your Google Sheet
2. Look at the URL:
   ```
   https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
   ```
3. The ID is: `1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms`

### Step 5: Make Spreadsheet Public
1. In your Google Sheet, click **Share**
2. Click **Publish to web**
3. Select **Entire document**
4. Click **Publish**

## ⚙️ Add to Your .env File

```env
# Google Sheets API Configuration
GOOGLE_SHEETS_SPREADSHEET_ID=1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms
GOOGLE_SHEETS_API_KEY=AIzaSyBhBSOa0vZ7L4s3vKx8Q9W2R7Y1T6U5V8I
```

**Replace the values above with:**
- Your actual spreadsheet ID
- Your actual API key

## 🧪 Test Your API Key

### Method 1: Browser Test
```
https://sheets.googleapis.com/v4/spreadsheets/YOUR_SPREADSHEET_ID/values/Sheet1!A:Z?key=YOUR_API_KEY
```

### Method 2: Using Our API
```
http://your-app.com/api/googlesheets/test-connection
```

## 📋 Example Working Setup

```env
# Example - Replace with your values
GOOGLE_SHEETS_SPREADSHEET_ID=1abc123def456ghi789jkl012mno345pqr
GOOGLE_SHEETS_API_KEY=AIzaSyAbCdEfGhIjKlMnOpQrStUvWxYz1234567
```

## 🚨 API Key Security

### Do:
- Keep your API key private
- Add restrictions to your API key
- Only allow Google Sheets API

### Don't:
- Share your API key publicly
- Commit API key to Git
- Use in client-side JavaScript

## 🔧 API Key Restrictions (Recommended)

1. Go to Google Cloud Console > Credentials
2. Click on your API key
3. Under **Application restrictions**, select:
   - **HTTP referrers** (if using from website)
   - **IP addresses** (if using from server)

4. Under **API restrictions**, select:
   - **Restrict key**
   - Choose **Google Sheets API** only

## 🎯 Quick Test Commands

### Test Connection
```bash
curl "https://sheets.googleapis.com/v4/spreadsheets/YOUR_SPREADSHEET_ID?key=YOUR_API_KEY"
```

### Test Data Fetch
```bash
curl "https://sheets.googleapis.com/v4/spreadsheets/YOUR_SPREADSHEET_ID/values/Sheet1!A:Z?key=YOUR_API_KEY"
```

## 📱 Use in Your Application

```php
// Test the connection
$response = Http::get("https://sheets.googleapis.com/v4/spreadsheets/{$spreadsheetId}?key={$apiKey}");

if ($response->successful()) {
    echo "✅ Connection successful!";
    echo "Spreadsheet: " . $response->json()['properties']['title'];
} else {
    echo "❌ Connection failed: " . $response->body();
}
```

## 🆘 Common Issues & Solutions

### Error: "API key not authorized"
- Make sure Google Sheets API is enabled
- Check API key restrictions
- Verify spreadsheet is public

### Error: "Spreadsheet not found"
- Check spreadsheet ID is correct
- Ensure spreadsheet exists
- Verify sharing permissions

### Error: "No data returned"
- Check if Sheet1 exists
- Verify data in first row (headers)
- Check range (A:Z)

## 🎉 You're Ready!

Once you have:
1. ✅ API key from Google Cloud Console
2. ✅ Spreadsheet ID from your Google Sheet
3. ✅ Made spreadsheet public
4. ✅ Added both to your .env file

Your Google Sheets API will work perfectly!
