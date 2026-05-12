---
description: Role Menu Management System
---

# Role Menu Management Workflow

This workflow explains how to manage role-based menu permissions in the CRM system.

## Steps to Manage Role Menus

### 1. Access Role Menu Management
- Login as Admin user
- Navigate to **Menu Management** in the admin sidebar
- URL: `/role-menus`

### 2. View Current Menu Assignments
- The page displays a table with:
  - **Rows**: User roles (Admin, Employee, Customer, Manager, General Manager)
  - **Columns**: Available menu items (Dashboard, Leads, Categories, etc.)
  - **Toggles**: On/off switches for each menu per role

### 3. Modify Menu Permissions
- **Toggle Switches**: Click toggles to enable/disable menus for each role
- **Visual Feedback**: 
  - ✅ Blue when enabled
  - ⚪ Gray when disabled
- **Scrolling**: Use horizontal scroll to see all menu columns

### 4. Save Changes
- Click **"Save Changes"** button to apply modifications
- Success message will appear at the top of the page

### 5. Initialize Default Settings
- Click **"Initialize Defaults"** to reset to recommended settings
- **Admin Role**: Gets ALL menus enabled by default
- **Other Roles**: Get limited access based on function

## Role Permissions Overview

### Admin (Role 1)
- **Access**: ALL menus by default
- **Purpose**: Full system control and management

### Employee (Role 2)
- **Default Access**: Dashboard, Project Updates, Approval Status, My Menu
- **Purpose**: Daily work functions and project oversight

### Customer (Role 3)
- **Default Access**: Dashboard, Invoices, Project Updates, My Menu
- **Purpose**: View projects and invoices

### Manager (Role 4)
- **Default Access**: Dashboard, Project Updates, Approval Status, My Menu
- **Purpose**: Team management and project oversight

### General Manager (Role 5)
- **Default Access**: Dashboard, Project Updates, Approval Status, My Menu
- **Purpose**: Strategic oversight and high-level management

## Available Menu Items

1. **Dashboard** - Main system overview
2. **Leads Generation** - Lead management system
3. **Categories** - Category management
4. **Employees** - Employee management
5. **Customers** - Customer management
6. **Invoices** - Invoice system
7. **Account** - User account settings
8. **Project Updates** - Project status updates
9. **Approval Status** - Approval workflow
10. **Sales Department** - Sales management
11. **My Menu** - Personal menu items

## Troubleshooting

### Table Not Displaying Properly
- **Check**: Browser cache cleared
- **Verify**: All roles have menu assignments
- **Solution**: Click "Initialize Defaults" button

### Scrolling Issues
- **Horizontal**: Use scrollbar at bottom of table
- **Vertical**: Table has max height of 80vh
- **Mobile**: Table becomes responsive with smaller font

### Changes Not Saving
- **Verify**: Click "Save Changes" button
- **Check**: Success message appears
- **Refresh**: Page to confirm changes applied

## Best Practices

1. **Start with Defaults**: Use "Initialize Defaults" first
2. **Test Roles**: Login with different roles to verify access
3. **Regular Reviews**: Periodically review and update permissions
4. **Document Changes**: Keep record of permission modifications
5. **Backup Settings**: Note default settings before major changes