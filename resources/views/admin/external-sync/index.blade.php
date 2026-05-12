@extends('admin.admin_master')

@section('page-title', 'External Database Sync')

@push('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #13B497 0%, #59D4A8 100%);
    --info-gradient: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

body {
    background: #f8f9fa;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.gradient-primary {
    background: var(--primary-gradient);
}

.gradient-success {
    background: var(--success-gradient);
}

.gradient-info {
    background: var(--info-gradient);
}

.gradient-warning {
    background: var(--warning-gradient);
}

.stats-card {
    border: none;
    border-radius: 15px;
    color: white;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.15);
}

.sql-code {
    background: #1e1e1e;
    color: #d4d4d4;
    border-radius: 8px;
    padding: 1rem;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.5;
    max-height: 400px;
    overflow-y: auto;
}

.sql-code pre {
    margin: 0;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.nav-tabs .nav-link {
    border-radius: 8px 8px 0 0;
    border: none;
    background: #f8f9fa;
    color: #6b7280;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link.active {
    background: var(--primary-gradient);
    color: white;
}

.nav-tabs .nav-link:hover {
    background: #e5e7eb;
}

.nav-tabs .nav-link.active:hover {
    background: var(--primary-gradient);
}
</style>
@endpush

@section('admin')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-database text-primary me-2"></i>
                                External Database Sync
                            </h4>
                            <p class="text-muted mb-0">
                                Automatically sync leads from external databases to NIRCRM
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <button onclick="loadSyncStatus()" class="btn btn-info">
                                <i class="fas fa-sync me-2"></i>Refresh Status
                            </button>
                            <button onclick="syncNow()" class="btn btn-success" id="syncBtn">
                                <i class="fas fa-play me-2"></i>Sync Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card gradient-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0">Total Synced</h6>
                            <h3 class="mb-0" id="totalSynced">0</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card gradient-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0">Last 24 Hours</h6>
                            <h3 class="mb-0" id="synced24h">0</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card gradient-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0">Last Hour</h6>
                            <h3 class="mb-0" id="synced1h">0</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-hourglass-half fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card gradient-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-0">Last Sync</h6>
                            <h6 class="mb-0" id="lastSync">Never</h6>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-history fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="syncTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="config-tab" data-bs-toggle="tab" data-bs-target="#config" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Database Configuration
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sql-tab" data-bs-toggle="tab" data-bs-target="#sql" type="button" role="tab">
                                <i class="fas fa-code me-2"></i>SQL Commands
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent" type="button" role="tab">
                                <i class="fas fa-list me-2"></i>Recent Syncs
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="syncTabContent">
                        <!-- Configuration Tab -->
                        <div class="tab-pane fade show active" id="config" role="tabpanel">
                            <form id="syncConfigForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Database Host</label>
                                            <input type="text" class="form-control" name="host" value="localhost" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Database Port</label>
                                            <input type="text" class="form-control" name="port" value="3306" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Database Name</label>
                                            <input type="text" class="form-control" name="database" placeholder="your_external_db" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Table Name</label>
                                            <input type="text" class="form-control" name="table" placeholder="leads" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="createTrigger">
                                                <label class="form-check-label" for="createTrigger">
                                                    Create database triggers for automatic sync
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <button type="button" onclick="testConnection()" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-plug me-2"></i>Test Connection
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- SQL Commands Tab -->
                        <div class="tab-pane fade" id="sql" role="tabpanel">
                            <div class="mb-3">
                                <button onclick="generateSQL()" class="btn btn-primary">
                                    <i class="fas fa-code me-2"></i>Generate SQL Commands
                                </button>
                                <button onclick="copySQL()" class="btn btn-outline-secondary">
                                    <i class="fas fa-copy me-2"></i>Copy SQL
                                </button>
                            </div>
                            <div id="sqlOutput" class="sql-code" style="display: none;">
                                <pre id="sqlCode"></pre>
                            </div>
                        </div>

                        <!-- Recent Syncs Tab -->
                        <div class="tab-pane fade" id="recent" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped" id="recentSyncsTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Database</th>
                                            <th>Last Sync</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recentSyncsBody">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                <i class="fas fa-spinner fa-spin me-2"></i>Loading recent syncs...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function loadSyncStatus() {
    fetch('/external-sync/status')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalSynced').textContent = data.stats.total_synced || 0;
                document.getElementById('synced24h').textContent = data.stats.synced_last_24h || 0;
                document.getElementById('synced1h').textContent = data.stats.synced_last_1h || 0;
                document.getElementById('lastSync').textContent = data.stats.last_sync ? 
                    new Date(data.stats.last_sync).toLocaleString() : 'Never';
                
                // Update recent syncs table
                const tbody = document.getElementById('recentSyncsBody');
                tbody.innerHTML = '';
                
                if (data.recent_syncs && data.recent_syncs.length > 0) {
                    data.recent_syncs.forEach(sync => {
                        const row = tbody.insertRow();
                        row.innerHTML = `
                            <td>${sync.name}</td>
                            <td>${sync.email || '-'}</td>
                            <td>${sync.company_name || '-'}</td>
                            <td><span class="badge bg-info">${sync.external_database_name}</span></td>
                            <td>${new Date(sync.last_synced_at).toLocaleString()}</td>
                        `;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No recent syncs found</td></tr>';
                }
            }
        })
        .catch(error => {
            console.error('Failed to load sync status:', error);
        });
}

function syncNow() {
    const btn = document.getElementById('syncBtn');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Syncing...';
    btn.disabled = true;
    
    const formData = new FormData(document.getElementById('syncConfigForm'));
    const data = Object.fromEntries(formData);
    
    fetch('/external-sync/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showAlert('success', result.message);
            loadSyncStatus();
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        console.error('Sync error:', error);
        showAlert('error', 'Sync failed: ' + error.message);
    })
    .finally(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}

function generateSQL() {
    const formData = new FormData(document.getElementById('syncConfigForm'));
    const data = Object.fromEntries(formData);
    
    fetch('/external-sync/generate-sql', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            const sqlOutput = document.getElementById('sqlOutput');
            const sqlCode = document.getElementById('sqlCode');
            
            let combinedSQL = '';
            combinedSQL += '-- 1. Create External Sync Table in NIRCRM\n\n';
            combinedSQL += result.sql_commands.create_sync_table + '\n\n';
            
            combinedSQL += '-- 2. Create Trigger in External Database\n\n';
            combinedSQL += result.sql_commands.create_trigger + '\n\n';
            
            combinedSQL += '-- 3. Create Update Trigger in External Database\n\n';
            combinedSQL += result.sql_commands.create_update_trigger + '\n\n';
            
            combinedSQL += '-- 4. Create Sync Procedure in NIRCRM\n\n';
            combinedSQL += result.sql_commands.create_procedure + '\n\n';
            
            combinedSQL += '-- 5. Execute Sync Procedure\n\n';
            combinedSQL += 'CALL sync_external_leads_to_nircrm();\n\n';
            
            combinedSQL += '-- 6. Schedule Cron Job (add to crontab)\n\n';
            combinedSQL += '*/5 * * * * /usr/bin/php /path/to/nircrm/artisan schedule:run >> /dev/null 2>&1\n';
            
            sqlCode.textContent = combinedSQL;
            sqlOutput.style.display = 'block';
            
            showAlert('success', 'SQL commands generated successfully!');
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        console.error('SQL generation error:', error);
        showAlert('error', 'Failed to generate SQL: ' + error.message);
    });
}

function copySQL() {
    const sqlCode = document.getElementById('sqlCode').textContent;
    navigator.clipboard.writeText(sqlCode).then(() => {
        showAlert('success', 'SQL commands copied to clipboard!');
    });
}

function testConnection() {
    const formData = new FormData(document.getElementById('syncConfigForm'));
    const data = Object.fromEntries(formData);
    
    fetch('/external-sync/test-connection', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            showAlert('success', 'Database connection successful!');
        } else {
            showAlert('error', result.message);
        }
    })
    .catch(error => {
        console.error('Connection test error:', error);
        showAlert('error', 'Connection test failed: ' + error.message);
    });
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Load sync status on page load
document.addEventListener('DOMContentLoaded', function() {
    loadSyncStatus();
});
</script>
@endpush
