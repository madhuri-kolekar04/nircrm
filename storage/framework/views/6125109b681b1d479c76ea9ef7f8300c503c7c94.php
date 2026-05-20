

<?php $__env->startSection('page-title', 'Activity Logs'); ?>

<?php $__env->startSection('admin'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="page-title mb-0">
                            <i class="fas fa-history text-primary mr-2"></i>
                            Activity Logs
                        </h2>
                        <p class="text-muted mt-2">Monitor all system activities and user actions</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary-custom" onclick="refreshLogs()">
                            <i class="fas fa-sync-alt mr-2"></i>Refresh
                        </button>
                        <button class="btn btn-success-custom" onclick="markAllLogsAsRead()">
                            <i class="fas fa-check-double mr-2"></i>Mark All Read
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="row">
                    <div class="col-md-3">
                        <label for="filterType" class="form-label">Filter by Type</label>
                        <select class="form-select" id="filterType" onchange="filterLogs()">
                            <option value="">All Types</option>
                            <option value="login">Login Activity</option>
                            <option value="ticket">Ticket Activity</option>
                            <option value="system">System Activity</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterDate" class="form-label">Filter by Date</label>
                        <select class="form-select" id="filterDate" onchange="filterLogs()">
                            <option value="">All Time</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterUser" class="form-label">Filter by User</label>
                        <select class="form-select" id="filterUser" onchange="filterLogs()">
                            <option value="">All Users</option>
                            <option value="<?php echo e(auth()->user()->name); ?>">Me</option>
                            <?php if(auth()->user()->role == 1): ?>
                                <option value="System">System</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-warning-custom w-100" onclick="clearFilters()">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Container -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="logs-container" id="logsContainer">
                    <!-- Loading State -->
                    <div class="text-center py-5" id="loadingState">
                        <div class="loading mb-3"></div>
                        <p class="text-muted">Loading activity logs...</p>
                    </div>

                    <!-- Logs List -->
                    <div class="logs-list" id="logsList" style="display: none;">
                        <!-- Logs will be loaded here dynamically -->
                    </div>

                    <!-- Load More Button -->
                    <div class="text-center mt-4" id="loadMoreContainer" style="display: none;">
                        <button class="btn btn-outline-primary" id="loadMoreBtn" onclick="loadMoreLogs()">
                            <i class="fas fa-arrow-down mr-2"></i>Load More
                        </button>
                    </div>

                    <!-- Empty State -->
                    <div class="text-center py-5" id="emptyState" style="display: none;">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Activity Logs Found</h4>
                        <p class="text-muted">No logs match your current filters.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.logs-container {
    min-height: 400px;
}

.log-item {
    display: flex;
    align-items: flex-start;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    transition: all 0.2s ease;
    position: relative;
}

.log-item:hover {
    background: #f8f9fa;
    border-left: 4px solid #667eea;
    padding-left: calc(1.5rem - 4px);
}

.log-item:last-child {
    border-bottom: none;
}

.log-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-right: 1rem;
    color: white;
}

.log-icon.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.log-icon.info {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.log-icon.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.log-icon.danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.log-icon.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.log-content {
    flex: 1;
    min-width: 0;
}

.log-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.log-title {
    font-weight: 600;
    color: #374151;
    font-size: 1rem;
    margin: 0;
}

.log-timestamp {
    font-size: 0.875rem;
    color: #6b7280;
    white-space: nowrap;
}

.log-message {
    color: #6b7280;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.log-details {
    font-size: 0.875rem;
    color: #9ca3af;
    background: #f3f4f6;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    border-left: 3px solid #e5e7eb;
}

.log-meta {
    display: flex;
    gap: 1rem;
    margin-top: 0.75rem;
    font-size: 0.875rem;
}

.log-user {
    color: #667eea;
    font-weight: 500;
}

.log-type {
    background: #e5e7eb;
    color: #6b7280;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.log-type.login {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.log-type.ticket {
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

.log-type.system {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.load-more-btn {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(102, 126, 234, 0.05) 100%);
    border: 1px solid #667eea;
    color: #667eea;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.load-more-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

@media (max-width: 768px) {
    .log-item {
        flex-direction: column;
        text-align: center;
    }
    
    .log-icon {
        margin: 0 auto 1rem auto;
    }
    
    .log-header {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .log-meta {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
}
</style>

<script>
let currentPage = 1;
let hasMoreLogs = true;
let isLoading = false;

// Load logs when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadLogs();
});

function loadLogs(reset = true) {
    if (isLoading) return;
    
    isLoading = true;
    
    if (reset) {
        currentPage = 1;
        hasMoreLogs = true;
        document.getElementById('logsList').innerHTML = '';
    }
    
    // Show loading state
    if (reset) {
        document.getElementById('loadingState').style.display = 'block';
        document.getElementById('logsList').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('loadMoreContainer').style.display = 'none';
    }
    
    const params = new URLSearchParams({
        page: currentPage,
        limit: 20,
        type: document.getElementById('filterType').value,
        date: document.getElementById('filterDate').value,
        user: document.getElementById('filterUser').value
    });
    
    fetch('<?php echo e(route("logs.api")); ?>?' + params.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        isLoading = false;
        
        if (reset) {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('logsList').style.display = 'block';
        }
        
        if (data.logs && data.logs.length > 0) {
            renderLogs(data.logs, reset);
            hasMoreLogs = data.has_more;
            currentPage++;
            
            // Show/hide load more button
            document.getElementById('loadMoreContainer').style.display = hasMoreLogs ? 'block' : 'none';
            document.getElementById('emptyState').style.display = 'none';
        } else {
            if (reset) {
                document.getElementById('logsList').style.display = 'none';
                document.getElementById('emptyState').style.display = 'block';
                document.getElementById('loadMoreContainer').style.display = 'none';
            }
        }
    })
    .catch(error => {
        isLoading = false;
        console.error('Error loading logs:', error);
        
        if (reset) {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('logsList').style.display = 'none';
            document.getElementById('emptyState').style.display = 'block';
            document.getElementById('emptyState').innerHTML = `
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <h4 class="text-danger">Error Loading Logs</h4>
                <p class="text-muted">Unable to load activity logs. Please try again.</p>
            `;
        }
    });
}

function renderLogs(logs, reset = true) {
    const logsList = document.getElementById('logsList');
    
    logs.forEach(log => {
        const logElement = createLogElement(log);
        if (reset) {
            logsList.innerHTML += logElement;
        } else {
            logsList.insertAdjacentHTML('beforeend', logElement);
        }
    });
}

function createLogElement(log) {
    return `
        <div class="log-item" data-log-id="${log.id}">
            <div class="log-icon ${log.color}">
                <i class="fas ${log.icon}"></i>
            </div>
            <div class="log-content">
                <div class="log-header">
                    <h4 class="log-title">${log.title}</h4>
                    <span class="log-timestamp">${formatTimestamp(log.timestamp)}</span>
                </div>
                <p class="log-message">${log.message}</p>
                <div class="log-details">
                    <i class="fas fa-info-circle mr-2"></i>${log.details}
                </div>
                <div class="log-meta">
                    <span class="log-user">
                        <i class="fas fa-user mr-1"></i>${log.user_name}
                    </span>
                    <span class="log-type ${log.type}">${log.type}</span>
                    <span class="log-role">
                        <i class="fas fa-user-tag mr-1"></i>${log.user_role}
                    </span>
                </div>
            </div>
        </div>
    `;
}

function formatTimestamp(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) { // Less than 1 minute
        return 'Just now';
    } else if (diff < 3600000) { // Less than 1 hour
        return Math.floor(diff / 60000) + ' minutes ago';
    } else if (diff < 86400000) { // Less than 1 day
        return Math.floor(diff / 3600000) + ' hours ago';
    } else if (diff < 604800000) { // Less than 1 week
        return Math.floor(diff / 86400000) + ' days ago';
    } else {
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }
}

function loadMoreLogs() {
    if (!hasMoreLogs || isLoading) return;
    loadLogs(false);
}

function refreshLogs() {
    loadLogs(true);
}

function filterLogs() {
    loadLogs(true);
}

function clearFilters() {
    document.getElementById('filterType').value = '';
    document.getElementById('filterDate').value = '';
    document.getElementById('filterUser').value = '';
    loadLogs(true);
}

function markAllLogsAsRead() {
    fetch('<?php echo e(route("logs.read-all")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('All logs marked as read', 'success');
        }
    })
    .catch(error => {
        console.error('Error marking logs as read:', error);
    });
}

function showNotification(message, type = 'info') {
    // Simple notification - you can replace with toastr if available
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>