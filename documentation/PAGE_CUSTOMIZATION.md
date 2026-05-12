# Page Customization System Documentation

## Overview
The Page Customization System allows administrators to control the visibility of specific elements (tables, columns, buttons, forms, fields) on any page for different roles or individual employees.

## Features
- **Menu-Level Permission Control**: Control which menu items are visible to which roles/employees
- **Element-Level Customization**: Hide/show specific columns, buttons, form fields, and more
- **AI-Powered Technical Analysis**: Automatically detect all page elements for easy customization
- **Role-Based & Employee-Specific**: Apply customizations at role level or individual employee level

## How to Use

### 1. Setting Menu Visibility
1. Go to **Menu Controller** or **Employee Menu Controller**
2. Select a Role or Employee
3. In the "Visible" column, select "Show" or "Hide" for each menu item
4. When "Show" is selected, a **gear icon** (⚙️) appears next to it

### 2. Customizing Page Elements
1. Click the **gear icon** next to a visible menu item
2. This opens the **Page Customization** page
3. Click **"Analyze Page & Fetch Technical Details"** to detect all elements
4. Use the toggles to show/hide specific elements:
   - Tables
   - Columns within tables
   - Buttons
   - Forms
   - Input fields
5. Click **"Save All Changes"** to apply

### 3. For Developers - Using in Views

#### Blade Directives
```blade
{{-- Check if element is visible --}}
@isVisible('element-id')
    <button id="element-id">Click me</button>
@endIsVisible

{{-- Check if element is hidden --}}
@isHidden('element-id')
    <div class="alert">This element is hidden</div>
@endIsHidden
```

#### Helper Class
```php
use App\Helpers\PageCustomizationHelper;

// Check element visibility
@if (PageCustomizationHelper::isVisible('add-lead-btn'))
    <button id="add-lead-btn">Add Lead</button>
@endif

// Check column visibility
@if (PageCustomizationHelper::isColumnVisible('leads-table', 'Email'))
    <th>Email</th>
@endif

// Check button visibility
@if (PageCustomizationHelper::isButtonVisible('save-permissions-btn'))
    <button id="save-permissions-btn">Save</button>
@endif

// Check field visibility
@if (PageCustomizationHelper::isFieldVisible('lead-form', 'phone'))
    <input name="phone" type="text">
@endif
```

#### Using Hidden Elements Array
```blade
{{-- Available in all views --}}
@if (!in_array('delete-btn', $hiddenElements ?? []))
    <button class="delete">Delete</button>
@endif
```

## Database Schema

### page_customizations Table
- `id` - Primary key
- `menu_name` - Name of the menu (e.g., "Leads Generation")
- `menu_url` - URL of the menu
- `role_id` - Role ID (nullable for employee-specific)
- `employee_id` - Employee ID (nullable for role-based)
- `element_type` - Type: table, column, button, form, field
- `element_name` - Human-readable name
- `element_identifier` - ID, class, or selector
- `is_visible` - Boolean (true = visible, false = hidden)
- `element_metadata` - JSON with additional details
- `notes` - Optional notes
- `timestamps` - Created/updated dates

## API Endpoints

### Get Customizations
```
GET /page-customization/api/customizations?menu_name=Leads%20Generation&role_id=2
```

### Save Customizations
```
POST /page-customization/store
{
    "menu_name": "Leads Generation",
    "menu_url": "leads",
    "role_id": 2,
    "elements": [
        {
            "type": "button",
            "name": "Add Lead",
            "identifier": "add-lead-btn",
            "visible": true
        }
    ]
}
```

### Batch Update
```
POST /page-customization/api/batch-update
{
    "items": [
        {
            "id": 1,
            "is_visible": false
        }
    ]
}
```

### Delete Customization
```
DELETE /page-customization/{id}
```

## Examples

### Example 1: Hiding "Delete" Button for Employees
1. Go to Menu Controller
2. Select role "Employee"
3. Find "Leads Generation" menu
4. Set Visible to "Show"
5. Click gear icon
6. Click "Analyze Page"
7. Find "Delete" button in Buttons section
8. Toggle it to "Hide"
9. Save changes

### Example 2: Hiding "Email" Column for Certain Employees
1. Go to Employee Menu Controller
2. Select specific employee
3. Find menu with table
4. Click gear icon
5. Analyze page
6. In Columns section, find "Email"
7. Toggle to "Hide"
8. Save changes

### Example 3: Developer Implementation
```blade
{{-- In a Blade view --}}
<table id="leads-table">
    <thead>
        <tr>
            @isVisible('leads-table.ID')
                <th>ID</th>
            @endIsVisible
            
            @isVisible('leads-table.Name')
                <th>Name</th>
            @endIsVisible
            
            @isVisible('leads-table.Email')
                <th>Email</th>
            @endIsVisible
            
            @isVisible('leads-table.Phone')
                <th>Phone</th>
            @endIsVisible
            
            <th>Actions</th>
        </tr>
    </thead>
</table>

<div class="actions">
    @isVisible('add-lead-btn')
        <button id="add-lead-btn" class="btn btn-primary">Add Lead</button>
    @endIsVisible
    
    @isVisible('upload-excel-btn')
        <button id="upload-excel-btn" class="btn btn-warning">Upload Excel</button>
    @endIsVisible
    
    @isVisible('delete-btn')
        <button id="delete-btn" class="btn btn-danger">Delete</button>
    @endIsVisible
</div>
```

## Troubleshooting

### Customizations Not Applying
1. Clear cache: `php artisan cache:clear`
2. Check database: Verify records exist in `page_customizations` table
3. Check role/employee: Ensure correct role_id or employee_id is set
4. Check element identifier: Must match exactly (case-sensitive)

### Page Not Analyzing
1. Check browser console for JavaScript errors
2. Verify the page URL is accessible
3. Ensure jQuery is loaded on the page

### Gear Icon Not Showing
1. Select "Show" in the Visible dropdown
2. Save the menu permissions first
3. Refresh the page

## Best Practices

1. **Use Descriptive Identifiers**: Use clear, unique IDs for elements
2. **Test Changes**: Always test customizations with affected user roles
3. **Document Changes**: Use the notes field to explain why elements are hidden
4. **Use Role-Based First**: Apply role-based customizations first, then employee-specific if needed
5. **Regular Reviews**: Periodically review customizations to ensure they're still relevant

## Support
For issues or questions, contact the development team or check the system logs at `/storage/logs/laravel.log`.
