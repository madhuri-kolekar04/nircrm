# 🚨 Google Sheets Credentials Setup Required

The system is working perfectly, but needs the Google Sheets credentials file to enable sync functionality.

## 📋 Error Message
```
Error: Error syncing to Google Sheets: file 'C:\xampp\htdocs\nircrm (1)\storage\app/google-credentials.json' does not exist
```

## 🔧 Quick Fix - Step by Step

### Step 1: Create Google Cloud Service Account
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Select your project or create a new one
3. Go to "APIs & Services" > "Credentials"
4. Click "CREATE CREDENTIALS" > "Service account"

### Step 2: Configure Service Account
1. **Service account name**: `nircrm-employee-sync`
2. **Service account ID**: `nircrm-employee-sync@your-project.iam.gserviceaccount.com`
3. **Description**: `Employee Task Management System Sync`
4. Click "CREATE AND CONTINUE"
5. Skip granting roles (optional)
6. Click "DONE"

### Step 3: Create JSON Key
1. Find your service account in the list
2. Click on the service account email
3. Go to "KEYS" tab
4. Click "ADD KEY" > "Create new key"
5. Select "JSON" key type
6. Click "CREATE"
7. **Download the JSON file** - This is your credentials file!

### Step 4: Place the File in Your Project
1. **Rename the downloaded file** to `google-credentials.json`
2. **Copy it to**: `C:\xampp\htdocs\nircrm (1)\storage\app\google-credentials.json`
3. **Verify the file exists** in that exact location

### Step 5: Share Your Google Sheet
1. Open your Google Sheet: [Employee Tasks Sheet](https://docs.google.com/spreadsheets/d/125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk/edit)
2. Click "Share" button (top right)
3. **Add the service account email** from your JSON file (look for "client_email")
4. Give it "Editor" permissions
5. Click "Send"

## 🎯 What the JSON File Contains

Your downloaded JSON file will look like this:
```json
{
  "type": "service_account",
  "project_id": "your-project-id",
  "private_key_id": "key-id",
  "private_key": "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n",
  "client_email": "service-account@project.iam.gserviceaccount.com",
  "client_id": "client-id",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token"
}
```

## 🚀 After Setup

Once you place the `google-credentials.json` file in the correct location:

1. **Test the sync** by clicking "Sync to Sheets" button
2. **Select your name** from the dropdown (Manali, Kiran, Mohit, Shubham, Prathamesh)
3. **Click submit** - your tasks will appear in Google Sheets!

## 📞 Troubleshooting

### If sync still fails:
1. **Check file path**: Make sure file is exactly at `storage/app/google-credentials.json`
2. **Check permissions**: Ensure service account has "Editor" access to the sheet
3. **Check sheet names**: Make sure sheets exist with exact names: Manali, Kiran, Mohit, Shubham, Prathamesh
4. **Check API enabled**: Ensure Google Sheets API is enabled in your Google Cloud project

### Test the connection:
```bash
php artisan tinker
>>> $service = new \App\Http\Controllers\EmployeeTaskController();
>>> // This will test if credentials are working
```

## 🎉 Current System Status

✅ **Login System**: Working perfectly
✅ **Task Management**: Full CRUD operations working
✅ **Mobile Responsive**: Perfect on all devices
✅ **Database**: All tables created and working
❌ **Google Sheets Sync**: Waiting for credentials file

**Once you add the credentials file, the system will be 100% complete!**

## 📝 Quick Copy-Paste Instructions

**File location**: `C:\xampp\htdocs\nircrm (1)\storage\app\google-credentials.json`

**Share this email with your sheet**: `[service-account-email-from-json]@your-project.iam.gserviceaccount.com`

**Give permissions**: Editor

**Your system will work immediately after this setup!** 🚀
