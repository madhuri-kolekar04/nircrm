# Simple Google Sheets API Integration

## 🚀 Quick Setup

### 1. Add Environment Variables

Add these to your `.env` file:

```env
# Google Sheets API (Simple Version)
GOOGLE_SHEETS_SPREADSHEET_ID=your_spreadsheet_id_here
GOOGLE_SHEETS_API_KEY=your_api_key_here
```

### 2. Get Your Google Sheets API Key

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable **Google Sheets API**
4. Create **API Key** from Credentials section
5. Make your spreadsheet **public** (File > Share > Publish to web)

### 3. Find Your Spreadsheet ID

Your spreadsheet ID is in the URL:
```
https://docs.google.com/spreadsheets/d/SPREADSHEET_ID_HERE/edit
```

## 📊 Column Mapping

The system automatically maps these columns:

| Google Sheet Column | Database Field |
|---------------------|----------------|
| FULL NAME | name |
| BUSINESS NAME | company_name |
| EMAIL | email |
| WHATSAPP | phone |
| WEBSITE URL | website |
| BUSINESS TYPE | business_type |
| PRIMARY GOAL | primary_goal |
| BUDGET RANGE | budget |
| SCORE | score |
| TIER | tier |
| SUBMITTED AT | submitted_at |

## 🎯 API Endpoints

### Test Connection
```http
GET /api/googlesheets/test-connection
```

### Get New Entries (since last fetch)
```http
GET /api/googlesheets/new-entries?last_fetch=2024-03-15T10:00:00Z
```

### Get Specific Columns
```http
GET /api/googlesheets/column-data?columns[]=FULL NAME&columns[]=EMAIL&columns[]=BUSINESS NAME
```

### Sync to Database
```http
POST /api/googlesheets/sync
```

### Export to Excel
```http
GET /api/googlesheets/export
```

## 📱 Usage Examples

### JavaScript - Get New Entries
```javascript
// Get new entries since last fetch
fetch('/api/googlesheets/new-entries?last_fetch=2024-03-15T10:00:00Z')
    .then(response => response.json())
    .then(data => {
        console.log('New entries:', data.data);
        console.log('Count:', data.count);
    });
```

### JavaScript - Sync Data
```javascript
// Sync data to database
fetch('/api/googlesheets/sync', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    });
```

### JavaScript - Test Connection
```javascript
// Test Google Sheets connection
fetch('/api/googlesheets/test-connection')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Connected to:', data.spreadsheet_name);
        } else {
            console.error('Connection failed:', data.message);
        }
    });
```

### JavaScript - Get Column Data
```javascript
// Get specific columns only
fetch('/api/googlesheets/column-data?columns[]=FULL NAME&columns[]=EMAIL&columns[]=WHATSAPP')
    .then(response => response.json())
    .then(data => {
        console.log('Column data:', data.data);
    });
```

## 🔄 Automatic Date-Based Fetching

The system automatically detects new entries based on the `SUBMITTED AT` column.

### Supported Date Formats
- `2024-03-15 14:30:00`
- `2024-03-15`
- `15/03/2024 14:30`
- `15/03/2024`
- `03/15/2024 14:30`
- `03/15/2024`
- `Mar 15, 2024 14:30`
- `Mar 15, 2024`

### Example Usage
```javascript
// Get entries added in the last hour
const oneHourAgo = new Date(Date.now() - 60 * 60 * 1000).toISOString();
fetch(`/api/googlesheets/new-entries?last_fetch=${oneHourAgo}`)
    .then(response => response.json())
    .then(data => {
        console.log(`Found ${data.count} new entries`);
    });
```

## 📋 Dashboard Integration

Your existing `/googlesheet` page will work with this simple API. The dashboard shows:

- All Google Sheets data in table format
- Connection status
- Sync button to import to database
- Export to Excel functionality

## 🎨 Simple HTML Example

```html
<!DOCTYPE html>
<html>
<head>
    <title>Google Sheets API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <button onclick="testConnection()">Test Connection</button>
    <button onclick="getNewEntries()">Get New Entries</button>
    <button onclick="syncData()">Sync to Database</button>
    
    <div id="results"></div>
    
    <script>
        function testConnection() {
            fetch('/api/googlesheets/test-connection')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('results').innerHTML = 
                        data.success ? 
                        '✅ Connected to: ' + data.spreadsheet_name : 
                        '❌ Error: ' + data.message;
                });
        }
        
        function getNewEntries() {
            fetch('/api/googlesheets/new-entries')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('results').innerHTML = 
                        `📊 Found ${data.count} new entries`;
                });
        }
        
        function syncData() {
            fetch('/api/googlesheets/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('results').innerHTML = 
                    data.success ? 
                    '✅ ' + data.message : 
                    '❌ Error: ' + data.message;
            });
        }
    </script>
</body>
</html>
```

## 🔧 Troubleshooting

### Common Issues

1. **API Key Not Working**
   - Make sure Google Sheets API is enabled
   - Check API key restrictions
   - Ensure spreadsheet is public

2. **Spreadsheet Not Found**
   - Verify spreadsheet ID is correct
   - Check if spreadsheet is published to web

3. **No Data Returned**
   - Check if Sheet1 exists and has data
   - Verify column headers match exactly

4. **Date Parsing Issues**
   - Check date format in SUBMITTED AT column
   - Ensure dates are not empty

### Debug Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Test API directly
curl -X GET "http://your-app.com/api/googlesheets/test-connection"
```

## 🚀 You're Ready!

Your simple Google Sheets API is now ready. You can:

1. **Fetch data** automatically based on timestamps
2. **Sync to database** with one click
3. **Export to Excel** for offline use
4. **Get specific columns** only what you need
5. **Test connection** easily

Visit `/googlesheet` to see your dashboard or use the API endpoints directly!
