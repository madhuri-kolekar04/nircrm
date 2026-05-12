# Employee Task Management System Setup Guide

This guide will help you set up the complete Employee Task Management System with Google Sheets integration.

## System Overview

The Employee Task Management System provides:
- Mobile-responsive employee login interface
- Task creation, editing, and deletion
- Automatic task numbering (1, 2, 3...)
- Google Sheets synchronization for 5 employees
- Cookie-based authentication for "stay logged in" functionality
- Modern Bootstrap UI with mobile-first design

## Features

### Employee Authentication
- Login at `/niremplogin`
- Email and password authentication
- Only users with "Employee" position can access
- Cookie-based remember me functionality (30 days)
- Auto-redirect to task dashboard

### Task Management
- Add tasks with date/time, description, client/project name, and status
- Automatic task numbering per day
- Edit tasks with modal popup
- Delete tasks with confirmation
- Status options: Pending, In Progress, Completed, Stopped, On Hold

### Google Sheets Integration
- Sync tasks to specific employee sheets
- Supports 5 employees: Manali, Kiran, Mohit, Shubham, Prathamesh
- Automatic data mapping to correct sheet
- Real-time sync with confirmation

## Setup Instructions

### 1. Database Migration

Run the migration to create the employee_tasks table:

```bash
php artisan migrate
```

### 2. Google Sheets API Setup

#### Step 1: Google Cloud Console
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google Sheets API

#### Step 2: Create Service Account
1. Go to "APIs & Services" > "Credentials"
2. Click "Create Credentials" > "Service Account"
3. Fill in service account details
4. Click "Create and Continue"
5. Skip granting roles (optional)
6. Click "Done"

#### Step 3: Create JSON Key
1. Find your service account in the list
2. Click on the service account email
3. Go to "Keys" tab
4. Click "Add Key" > "Create new key"
5. Select "JSON" and click "Create"
6. Download the JSON file

#### Step 4: Configure Google Sheets Access
1. Rename the downloaded JSON file to `google-credentials.json`
2. Place it in `storage/app/` directory
3. Open your Google Sheet: https://docs.google.com/spreadsheets/d/125KWWjtxDw4iriHc1qzeuX3KPb_04NkbTBnEqliwnNk/edit
4. Click "Share"
5. Add the service account email (from JSON file) with "Editor" access

### 3. Create Employee Sheets

In your Google Sheet, create 5 sheets with exact names:
- Manali
- Kiran  
- Mohit
- Shubham
- Prathamesh

Each sheet should have these columns:
- Column A: Date (date and time)
- Column B: Task Description (numbered tasks)
- Column C: Client/Project Name
- Column D: Status
- Column E: Task Number

### 4. Update Employee Users

Ensure your users table has employees with position "Employee":

```sql
UPDATE users SET position = 'Employee' WHERE email IN (
    'manali@company.com',
    'kiran@company.com', 
    'mohit@company.com',
    'shubham@company.com',
    'prathamesh@company.com'
);
```

Replace with actual employee emails.

### 5. Test the System

#### Test Login
1. Go to `http://your-domain.com/niremplogin`
2. Login with an employee account
3. Should redirect to task dashboard

#### Test Task Management
1. Click "Add Task" button
2. Fill in task details
3. Save and verify task appears
4. Test edit and delete functionality

#### Test Google Sheets Sync
1. Add some tasks
2. Click "Sync to Sheets" button
3. Select your name from dropdown
4. Verify data appears in your Google Sheet

## File Structure

```
app/
  Http/Controllers/
    - EmployeeTaskController.php
  Models/
    - EmployeeTask.php
database/
  migrations/
    - 2026_04_15_120000_create_employee_tasks_table.php
resources/views/employee/
  - login.blade.php
  - dashboard.blade.php
routes/
  - web.php (updated with employee routes)
storage/app/
  - google-credentials.json (you need to add this)
```

## URL Structure

- `/niremplogin` - Employee login page
- `/niremptask` - Task dashboard (requires auth)
- `/employee/task/store` - Store new task (API)
- `/employee/task/{id}/edit` - Get task for editing (API)
- `/employee/task/{id}/update` - Update task (API)
- `/employee/task/{id}/delete` - Delete task (API)
- `/employee/sync-to-google-sheets` - Sync to Google Sheets (API)
- `/employee/logout` - Logout endpoint

## Mobile Responsiveness

The system is fully mobile-responsive:
- Bootstrap 5 framework
- Touch-friendly buttons and forms
- Optimized layouts for mobile devices
- Proper viewport meta tags
- Responsive grid system

## Security Features

- CSRF protection on all forms
- Authentication middleware on protected routes
- User-specific task access (employees can only see their own tasks)
- Input validation and sanitization
- SQL injection prevention through Eloquent ORM

## Troubleshooting

### Common Issues

1. **"Unauthorized" error**
   - Check user has "Employee" position
   - Verify user is logged in

2. **Google Sheets sync fails**
   - Check google-credentials.json exists in storage/app/
   - Verify service account has editor access to sheet
   - Check sheet names match exactly (case-sensitive)

3. **Tasks not saving**
   - Check database migration ran successfully
   - Verify form validation passes
   - Check Laravel logs for errors

### Debug Commands

```bash
# Check migration status
php artisan migrate:status

# Clear cache
php artisan cache:clear
php artisan config:clear

# Check logs
tail -f storage/logs/laravel.log
```

## Support

The system includes comprehensive error handling and logging. Check `storage/logs/laravel.log` for detailed error messages if issues occur.

## Future Enhancements

Potential future features:
- Task notifications
- Task categories
- Time tracking
- Team collaboration
- Advanced reporting
- Mobile app (PWA)
