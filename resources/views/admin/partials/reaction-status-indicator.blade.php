<!-- Real-time Reaction Notification Status Indicator -->
<div id="reactionStatusIndicator" class="reaction-status-indicator">
    <div class="status-header">
        <i class="fas fa-bell"></i>
        <span>Reaction Notifications</span>
        <span class="status-badge" id="notificationCount">0</span>
    </div>
    <div class="status-content" id="statusContent">
        <div class="status-item">
            <i class="fas fa-clock text-info"></i>
            <span>Scheduled: <strong id="scheduledCount">0</strong></span>
        </div>
        <div class="status-item">
            <i class="fas fa-envelope text-success"></i>
            <span>Sent Today: <strong id="sentCount">0</strong></span>
        </div>
        <div class="status-item">
            <i class="fas fa-exclamation-triangle text-warning"></i>
            <span>Overdue: <strong id="overdueCount">0</strong></span>
        </div>
    </div>
    <div class="status-footer">
        <small class="text-muted">Last check: <span id="lastCheck">--:--</span></small>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="refreshReactionStatus()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>
</div>

<style>
.reaction-status-indicator {
    position: fixed;
    top: 80px;
    right: 20px;
    width: 280px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    z-index: 1000;
    font-family: 'Inter', sans-serif;
}

.status-header {
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
}

.status-header i {
    margin-right: 0.5rem;
}

.status-badge {
    background: rgba(255,255,255,0.2);
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-content {
    padding: 1rem;
}

.status-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f3f4;
}

.status-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.status-item i {
    margin-right: 0.5rem;
}

.status-footer {
    padding: 0.75rem 1rem;
    border-top: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8f9fa;
    border-radius: 0 0 12px 12px;
}

.status-footer .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .reaction-status-indicator {
        position: relative;
        top: auto;
        right: auto;
        width: 100%;
        margin-bottom: 1rem;
    }
}
</style>

<script>
function refreshReactionStatus() {
    fetch('{{ route("reactions.system.status") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('scheduledCount').textContent = data.scheduled || 0;
            document.getElementById('sentCount').textContent = data.sent_today || 0;
            document.getElementById('overdueCount').textContent = data.overdue || 0;
            document.getElementById('notificationCount').textContent = data.total || 0;
            document.getElementById('lastCheck').textContent = new Date().toLocaleTimeString();
            
            // Update status indicator color based on overdue count
            const indicator = document.getElementById('reactionStatusIndicator');
            if (data.overdue > 0) {
                indicator.style.borderLeft = '4px solid #ffc107';
            } else if (data.scheduled > 0) {
                indicator.style.borderLeft = '4px solid #17a2b8';
            } else {
                indicator.style.borderLeft = '4px solid #28a745';
            }
        })
        .catch(error => {
            console.error('Error refreshing reaction status:', error);
        });
}

// Auto-refresh every 30 seconds
setInterval(refreshReactionStatus, 30000);

// Initial load
document.addEventListener('DOMContentLoaded', refreshReactionStatus);
</script>
