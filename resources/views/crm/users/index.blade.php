@extends('layouts.whatsapp-crm')

@section('pageTitle', 'User Management')

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="fas fa-users" style="margin-right: 8px;"></i>
                User Management
            </div>
            @if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
            <button onclick="showAddUserModal()" style="background: #00a884; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                <i class="fas fa-user-plus" style="margin-right: 4px;"></i>
                Add User
            </button>
            @endif
        </div>
    </div>
    <div class="card-body">
        <!-- Search and Filter -->
        <div style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" placeholder="Search users..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
            </div>
            <select style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                <option value="">All Roles</option>
                <option value="super_admin">Super Admin</option>
                <option value="department_admin">Department Admin</option>
                <option value="manager">Manager</option>
                <option value="user">Staff</option>
            </select>
            <select style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                <option value="">All Departments</option>
                <option value="hr">HR</option>
                <option value="marketing">Marketing</option>
                <option value="sales">Sales</option>
                <option value="development">Development</option>
                <option value="operations">Operations</option>
                <option value="accounts">Accounts</option>
                <option value="client">Client</option>
                <option value="it">IT</option>
            </select>
            <select style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="suspended">Suspended</option>
            </select>
        </div>
        
        <!-- Users Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            @if(isset($users) && count($users) > 0)
                @foreach($users as $user)
                <div style="background: white; border: 1px solid #e9edef; border-radius: 8px; padding: 20px; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #00a884, #008066); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #111b21; font-size: 1.1rem; margin-bottom: 4px;">{{ $user->name }}</div>
                            <div style="color: #667781; font-size: 0.875rem;">{{ $user->email }}</div>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 8px; margin-bottom: 12px; flex-wrap: wrap;">
                        <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
                        <span class="badge badge-warning">{{ ucfirst($user->department ?? 'Unassigned') }}</span>
                        @if($user->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </div>
                    
                    <div style="color: #667781; font-size: 0.875rem; margin-bottom: 16px;">
                        <div style="margin-bottom: 4px;"><i class="fas fa-phone" style="width: 16px;"></i> {{ $user->phone ?? 'N/A' }}</div>
                        <div><i class="fas fa-calendar" style="width: 16px;"></i> Joined {{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    <div style="display: flex; gap: 8px;">
                        <button onclick="viewUser({{ $user->id }})" style="flex: 1; background: #007bff; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                            <i class="fas fa-eye"></i> View
                        </button>
                        @if(in_array(auth()->user()->role, [1, 4, 5]) || in_array(auth()->user()->position, ['CEO', 'Admin', 'Manager']))
                        <button onclick="editUser({{ $user->id }})" style="flex: 1; background: #28a745; color: white; border: none; padding: 8px; border-radius: 6px; cursor: pointer; font-size: 0.875rem;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #667781;">
                <i class="fas fa-users" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                <div>No users found</div>
            </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if(isset($users) && method_exists($users, 'links'))
        <div style="margin-top: 20px; text-align: center;">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add/Edit User Modal -->
<div id="userModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 90%; max-width: 600px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #111b21;">Add New User</h3>
            <button onclick="closeUserModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
        </div>
        <form style="padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">First Name *</label>
                    <input type="text" name="first_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Last Name *</label>
                    <input type="text" name="last_name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                </div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Email *</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Phone</label>
                <input type="tel" name="phone" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Role *</label>
                    <select name="role" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Select Role</option>
                        <option value="user">Staff</option>
                        <option value="manager">Manager</option>
                        @if(auth()->user()->role === 'super_admin')
                        <option value="department_admin">Department Admin</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Department *</label>
                    <select name="department" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="">Select Department</option>
                        <option value="hr">HR</option>
                        <option value="marketing">Marketing</option>
                        <option value="sales">Sales</option>
                        <option value="development">Development</option>
                        <option value="operations">Operations</option>
                        <option value="accounts">Accounts</option>
                        <option value="client">Client</option>
                        <option value="it">IT</option>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Password *</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Confirm Password *</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeUserModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 10px 20px; background: #00a884; color: white; border: none; border-radius: 6px; cursor: pointer;">Create User</button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddUserModal() {
    document.getElementById('userModal').style.display = 'flex';
}

function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

function viewUser(id) {
    // Implementation for viewing user details
    console.log('View user:', id);
}

function editUser(id) {
    // Implementation for editing user
    console.log('Edit user:', id);
}
</script>
