# Department-Based User Filtering for Lead Edit Page

## Overview
Implemented dynamic user filtering in the lead edit page so that when a department is selected, the "Assigned To" dropdown shows only users from that department.

## What Was Implemented

### 1. Backend Changes

#### Added Route
```php
Route::get('/users-by-department/{department}', [LeadController::class, 'getUsersByDepartment'])->name('leads.users.by.department');
```

#### Added Controller Method
```php
public function getUsersByDepartment($department)
{
    $users = User::where('department', $department)->get(['id', 'name']);
    return response()->json($users);
}
```

#### Updated Edit Method
Changed from filtering only Sales users to showing all users initially:
```php
// Before: Only Sales users
$users = User::where('department', 'Sales')
             ->where('position', 'Employee')
             ->get();

// After: All users
$users = User::all();
```

### 2. Frontend Changes

#### Added JavaScript to Edit View
```javascript
document.addEventListener('DOMContentLoaded', function() {
    const departmentSelect = document.getElementById('department');
    const assignedToSelect = document.getElementById('assigned_to');
    
    if (departmentSelect && assignedToSelect) {
        departmentSelect.addEventListener('change', function() {
            const department = this.value;
            
            if (department) {
                // Show loading state
                assignedToSelect.innerHTML = '<option value="">Loading...</option>';
                assignedToSelect.disabled = true;
                
                // Fetch users for selected department
                fetch(`{{ route('leads.users.by.department', ':department') }}`.replace(':department', department))
                    .then(response => response.json())
                    .then(users => {
                        // Clear and populate dropdown
                        assignedToSelect.innerHTML = '<option value="">Select User</option>';
                        assignedToSelect.disabled = false;
                        
                        users.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = user.name;
                            // Set selected if it matches current value
                            @if(old('assigned_to', $lead->assigned_to))
                            if (user.id == {{ old('assigned_to', $lead->assigned_to) }}) {
                                option.selected = true;
                            }
                            @endif
                            assignedToSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                        assignedToSelect.innerHTML = '<option value="">Error loading users</option>';
                        assignedToSelect.disabled = false;
                    });
            } else {
                // Reset to all users if no department selected
                location.reload();
            }
        });
    }
});
```

## How It Works

### User Experience
1. **Initial Load**: Page loads with all users in "Assigned To" dropdown
2. **Department Selection**: User selects a department (e.g., "Wordpress")
3. **AJAX Call**: JavaScript sends request to get users for that department
4. **Dynamic Update**: "Assigned To" dropdown updates with filtered users
5. **Loading State**: Shows "Loading..." while fetching
6. **Error Handling**: Shows error message if fetch fails

### Example Flow

#### When User Selects "Wordpress" Department:
1. JavaScript detects change event
2. AJAX call to: `/leads/users-by-department/Wordpress`
3. Backend returns JSON:
   ```json
   [
       {"id": 0, "name": "admin"},
       {"id": 5, "name": "shubham"},
       {"id": 13, "name": "pooja ashok pandvir"},
       {"id": 19, "name": "Prathamesh khobre"},
       {"id": 20, "name": "Mohit Patil"},
       {"id": 27, "name": "Ganesh Shendye"}
   ]
   ```
4. Frontend populates dropdown with these 6 users
5. User can select the appropriate user

### Available Departments

Based on current database:
- **Administration** (1 user)
- **Customer** (5 users)
- **Google Ad Manager** (1 user)
- **Marketing & Sales** (1 user)
- **Website Developer** (1 user)
- **Wordpress** (6 users) ← Your example case

### Benefits

1. **Improved UX**: Users only see relevant users for selected department
2. **Faster Selection**: No need to scroll through all users
3. **Better Organization**: Logical grouping of users by department
4. **Dynamic Updates**: Real-time filtering without page reload
5. **Error Handling**: Graceful handling of network issues

### Testing Results

✅ **Backend Test**: Successfully returns 6 users for "Wordpress" department  
✅ **Route Working**: `/leads/users-by-department/Wordpress` endpoint functional  
✅ **JSON Response**: Proper format with id and name fields  
✅ **Frontend Ready**: JavaScript implemented for dynamic updates  

## Usage

1. Go to `/leads/65/edit` (or any lead edit page)
2. Select "Wordpress" from Department dropdown
3. "Assigned To" dropdown will automatically show only Wordpress users
4. Select the desired user and save the lead

The system now provides intelligent department-based user filtering!
