@extends('layouts.whatsapp-crm')

@section('pageTitle', 'Activity Logs')

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
}

.modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 24px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 16px 16px 0 0;
}

.modal-body {
    padding: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #495057;
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success { background: #28a745; color: white; }
.badge-warning { background: #ffc107; color: #212529; }
.badge-danger { background: #dc3545; color: white; }
.badge-info { background: #17a2b8; color: white; }
.badge-primary { background: #007bff; color: white; }
.badge-secondary { background: #6c757d; color: white; }

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, #6c757d, #545b62);
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>

<div class="card" style="border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: none;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; padding: 24px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 16px 16px 0 0;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-history" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700;">Activity Logs</h1>
                <div style="font-size: 0.9rem; opacity: 0.9;">Monitor and track system activities</div>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <button onclick="refreshLogs()" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
            <button onclick="markAllAsRead()" class="btn btn-primary" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-check-double"></i>
                <span>Mark All as Read</span>
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Statistics Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 8px;">{{ $totalLogs ?? 0 }}</div>
                <div style="font-size: 0.95rem; opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-chart-line"></i>
                    Total Activities
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; box-shadow: 0 8px 32px rgba(245, 87, 108, 0.3); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 8px;">{{ $unreadLogs ?? 0 }}</div>
                <div style="font-size: 0.95rem; opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-envelope"></i>
                    Unread Activities
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; box-shadow: 0 8px 32px rgba(79, 172, 254, 0.3); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 8px;">{{ $todayLogs ?? 0 }}</div>
                <div style="font-size: 0.95rem; opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-calendar-day"></i>
                    Today's Activities
                </div>
            </div>
            <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 24px; border-radius: 16px; text-align: center; color: white; box-shadow: 0 8px 32px rgba(250, 112, 154, 0.3); transform: translateY(0); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="font-size: 2.5rem; font-weight: 700; margin-bottom: 8px;">{{ $criticalLogs ?? 0 }}</div>
                <div style="font-size: 0.95rem; opacity: 0.9; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Critical Issues
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div style="margin-bottom: 24px; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div style="flex: 1; min-width: 250px;">
                <input type="text" id="searchInput" placeholder="🔍 Search activities..." 
                       style="width: 100%; padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s ease;"
                       onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102,126,234,0.1)'"
                       onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
            </div>
            <select id="typeFilter" style="padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.95rem; background: white; cursor: pointer; transition: all 0.3s ease;"
                    onfocus="this.style.borderColor='#667eea'"
                    onblur="this.style.borderColor='#e9ecef'">
                <option value="">📊 All Types</option>
                <option value="login">🔑 Login</option>
                <option value="logout">🚪 Logout</option>
                <option value="create">➕ Create</option>
                <option value="update">✏️ Update</option>
                <option value="delete">🗑️ Delete</option>
                <option value="view">👁️ View</option>
                <option value="export">📤 Export</option>
                <option value="error">❌ Error</option>
            </select>
            <select id="userFilter" style="padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.95rem; background: white; cursor: pointer; transition: all 0.3s ease;"
                    onfocus="this.style.borderColor='#667eea'"
                    onblur="this.style.borderColor='#e9ecef'">
                <option value="">👥 All Users</option>
                @foreach($users ?? \App\Models\User::orderBy('name')->get() as $user)
                <option value="{{ $user->id }}">👤 {{ $user->name }}</option>
                @endforeach
            </select>
            <input type="date" id="dateFilter" style="padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.95rem; cursor: pointer; transition: all 0.3s ease;"
                   onfocus="this.style.borderColor='#667eea'"
                   onblur="this.style.borderColor='#e9ecef'">
            <select id="statusFilter" style="padding: 12px 16px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 0.95rem; background: white; cursor: pointer; transition: all 0.3s ease;"
                    onfocus="this.style.borderColor='#667eea'"
                    onblur="this.style.borderColor='#e9ecef'">
                <option value="">📋 All Status</option>
                <option value="read">✅ Read</option>
                <option value="unread">📨 Unread</option>
            </select>
        </div>

        <!-- Activity Logs Table -->
        <div style="overflow-x: auto; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <thead>
                    <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <th style="padding: 16px; text-align: left; font-weight: 600; border-radius: 12px 0 0 0;">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" style="transform: scale(1.2);">
                        </th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">Status</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">Type</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">User</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">Description</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">IP Address</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600;">Date & Time</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; border-radius: 0 12px 0 0;">Actions</th>
                    </tr>
                </thead>
                <tbody id="logsTableBody">
                    @forelse($logs ?? [] as $log)
                    <tr style="border-bottom: 1px solid #e9edef; {{ !$log->read_at ? 'background: linear-gradient(90deg, #fff3cd 0%, #fff8dc 100%);' : 'background: white;' }} transition: all 0.2s ease;" 
                        class="log-row" 
                        onmouseover="this.style.background='{{ !$log->read_at ? '#ffeaa7' : '#f8f9fa' }}'" 
                        onmouseout="this.style.background='{{ !$log->read_at ? 'linear-gradient(90deg, #fff3cd 0%, #fff8dc 100%)' : 'white' }}'"
                        data-type="{{ $log->type ?? '' }}" 
                        data-user="{{ $log->user_id ?? '' }}" 
                        data-status="{{ $log->read_at ? 'read' : 'unread' }}"
                        data-date="{{ $log->created_at ? $log->created_at->format('Y-m-d') : '' }}"
                        data-search="{{ strtolower($log->description ?? '') . ' ' . strtolower($log->user->name ?? '') }}">
                        <td style="padding: 12px;">
                            <input type="checkbox" class="log-checkbox" value="{{ $log->id }}">
                        </td>
                        <td style="padding: 12px;">
                            @if(!$log->read_at)
                                <span class="badge badge-warning">Unread</span>
                            @else
                                <span class="badge badge-success">Read</span>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <span class="badge badge-{{ getActivityTypeColor($log->type ?? '') }}" style="font-size: 0.75rem; padding: 4px 8px;">
                                <i class="fas fa-{{ getActivityIcon($log->action ?? '') }}" style="margin-right: 4px;"></i>
                                {{ ucfirst($log->type ?? 'general') }}
                            </span>
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #00a884, #008066); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.75rem; box-shadow: 0 2px 4px rgba(0,168,132,0.3);">
                                    {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500; color: #111b21;">{{ $log->user->name ?? 'System' }}</div>
                                    <div style="font-size: 0.75rem; color: #667781;">{{ $log->user->role == 1 ? 'Admin' : ($log->user->role == 2 ? 'Employee' : 'Customer') }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            <div style="color: #111b21; font-weight: 500;">{{ $log->description ?? 'No description' }}</div>
                            @if($log->action)
                            <div style="font-size: 0.75rem; color: #667781; margin-top: 4px;">
                                <i class="fas fa-cog" style="margin-right: 4px;"></i>{{ ucfirst(str_replace('_', ' ', $log->action)) }}
                            </div>
                            @endif
                            @if($log->url)
                            <div style="font-size: 0.75rem; color: #667781; margin-top: 2px;">
                                <i class="fas fa-link" style="margin-right: 4px;"></i>{{ parse_url($log->url, PHP_URL_PATH) }}
                            </div>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <code style="background: #f8f9fa; padding: 2px 6px; border-radius: 4px; font-size: 0.875rem;">
                                {{ $log->ip_address ?? 'N/A' }}
                            </code>
                        </td>
                        <td style="padding: 12px;">
                            <div style="color: #111b21; font-weight: 500;">{{ $log->created_at ? $log->created_at->format('M d, Y') : 'N/A' }}</div>
                            <div style="font-size: 0.75rem; color: #667781;">{{ $log->created_at ? $log->created_at->format('H:i:s') : 'N/A' }}</div>
                            @if($log->read_at)
                            <div style="font-size: 0.7rem; color: #28a745; margin-top: 2px;">
                                <i class="fas fa-check-circle" style="margin-right: 2px;"></i>Read {{ $log->read_at->diffForHumans() }}
                            </div>
                            @endif
                        </td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px;">
                                @if(!$log->read_at)
                                <button onclick="markAsRead({{ $log->id }})" 
                                        style="background: linear-gradient(135deg, #00a884, #008066); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(0,168,132,0.3); transition: all 0.3s ease; display: flex; align-items: center; gap: 6px;"
                                        title="Mark as Read"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0,168,132,0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0,168,132,0.3)'">
                                    <i class="fas fa-check"></i>
                                    <span>Read</span>
                                </button>
                                @endif
                                <button onclick="viewLogDetails({{ $log->id }})" 
                                        style="background: linear-gradient(135deg, #17a2b8, #138496); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(23,162,184,0.3); transition: all 0.3s ease; display: flex; align-items: center; gap: 6px;"
                                        title="View Details"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(23,162,184,0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(23,162,184,0.3)'">
                                    <i class="fas fa-eye"></i>
                                    <span>View</span>
                                </button>
                                <button onclick="deleteLog({{ $log->id }})" 
                                        style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border: none; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(220,53,69,0.3); transition: all 0.3s ease; display: flex; align-items: center; gap: 6px;"
                                        title="Delete"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220,53,69,0.4)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(220,53,69,0.3)'">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 60px 20px; color: #667781; background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
                            <div style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
                                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; box-shadow: 0 8px 32px rgba(102,126,234,0.3);">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div style="font-size: 1.2rem; font-weight: 600; color: #495057;">No activity logs found</div>
                                <div style="color: #6c757d; font-size: 0.95rem;">Start performing activities to see them appear here</div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($logs) && $logs->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Log Details Modal -->
<div id="logDetailsModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 style="margin: 0; color: #111b21;">Activity Log Details</h3>
            <button onclick="closeModal('logDetailsModal')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
        </div>
        <div class="modal-body" id="logDetailsContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>


<script>
// Search and filter functionality
document.getElementById('searchInput').addEventListener('input', filterLogs);
document.getElementById('typeFilter').addEventListener('change', filterLogs);
document.getElementById('userFilter').addEventListener('change', filterLogs);
document.getElementById('dateFilter').addEventListener('change', filterLogs);
document.getElementById('statusFilter').addEventListener('change', filterLogs);

function filterLogs() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const typeFilter = document.getElementById('typeFilter').value;
    const userFilter = document.getElementById('userFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.log-row');

    rows.forEach(row => {
        const search = row.dataset.search;
        const type = row.dataset.type;
        const user = row.dataset.user;
        const date = row.dataset.date;
        const status = row.dataset.status;

        const matchesSearch = !searchTerm || search.includes(searchTerm);
        const matchesType = !typeFilter || type === typeFilter;
        const matchesUser = !userFilter || user === userFilter;
        const matchesDate = !dateFilter || date === dateFilter;
        const matchesStatus = !statusFilter || status === statusFilter;

        row.style.display = matchesSearch && matchesType && matchesUser && matchesDate && matchesStatus ? '' : 'none';
    });
}

function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.log-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function markAsRead(logId) {
    fetch(`/api/logs/${logId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking log as read:', error);
    });
}

function markAllAsRead() {
    if (!confirm('Are you sure you want to mark all logs as read?')) {
        return;
    }

    fetch('/api/logs/read-all', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking all logs as read:', error);
    });
}

function viewLogDetails(logId) {
    fetch(`/api/logs/${logId}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const log = data.log;
            const content = `
                <div style="display: grid; gap: 16px;">
                    <div class="form-group">
                        <label class="form-label">Activity Type</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${log.activity_type}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">User</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${log.user_name} (${log.user_email})
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${log.description}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Module</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${log.module_name || 'N/A'}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">IP Address</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${log.ip_address}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">User Agent</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px; font-size: 0.875rem;">
                            ${log.user_agent || 'N/A'}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Created At</label>
                        <div style="padding: 8px 12px; background: #f8f9fa; border-radius: 4px;">
                            ${new Date(log.created_at).toLocaleString()}
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('logDetailsContent').innerHTML = content;
            document.getElementById('logDetailsModal').classList.add('show');
        }
    })
    .catch(error => {
        console.error('Error fetching log details:', error);
    });
}

function deleteLog(logId) {
    if (!confirm('Are you sure you want to delete this log entry?')) {
        return;
    }

    fetch(`/api/logs/${logId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error deleting log:', error);
    });
}

function refreshLogs() {
    location.reload();
}
</script>
