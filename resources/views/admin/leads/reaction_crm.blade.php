@extends('admin.admin_master')

@section('page-title', 'Lead Reaction Management')

@push('styles')
<style>
.reaction-type-card:hover {
    border-color: #007bff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.reaction-type-card.selected {
    border-color: #007bff !important;
    background-color: #007bff;
    color: white;
}

.reaction-type-card.selected .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.page-content {
    padding: 20px;
}

.page-actions {
    display: flex;
    gap: 0.5rem;
}

/* Notification Bell Styling */
.notification-bell {
    position: relative;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    background: #f8f9fa;
    display: inline-block;
    transition: all 0.3s ease;
}

.notification-bell:hover {
    background: #e9ecef;
    transform: scale(1.1);
}

.notification-bell.ringing {
    animation: ring 1s ease-in-out infinite;
}

.notification-bell.ringing i {
    color: #dc3545 !important;
    animation: shake 0.5s ease-in-out infinite;
}

@keyframes ring {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(15deg); }
    75% { transform: rotate(-15deg); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-2px); }
    75% { transform: translateX(2px); }
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: bold;
}

.notification-dropdown {
    display: none;
    position: absolute;
    top: 60px;
    right: 0;
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 350px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 9999;
}

.notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background 0.3s ease;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-item.overdue {
    border-left: 4px solid #dc3545;
    background: #fff5f5;
}

.notification-item.today {
    border-left: 4px solid #ffc107;
    background: #fffdf5;
}

.notification-item.upcoming {
    border-left: 4px solid #28a745;
}

.notification-title {
    font-weight: 600;
    margin-bottom: 4px;
}

.notification-message {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 4px;
}

.notification-meta {
    font-size: 0.8rem;
    color: #999;
}

.notification-empty {
    padding: 20px;
    text-align: center;
    color: #666;
}

@media (max-width: 768px) {
    .page-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .page-actions .btn {
        width: 100%;
    }
    
    .notification-dropdown {
        min-width: 300px;
        right: -10px;
    }
}
</style>
@endpush

@section('admin')
<div class="page-content">
    <!-- Page Header with Notifications -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <div class="d-flex align-items-center mb-2">
                    <h4 class="page-title mb-0">
                        Lead Reaction Management
                    </h4>
                    <!-- Lead Notification Bell -->
                    <div class="notification-bell" id="leadNotificationBell" onclick="toggleLeadNotifications()" style="display: inline-block; margin-left: 20px; position: relative; z-index: 9999;">
                        <i class="fa fa-bell" style="color: #FFD700; font-size: 20px;"></i>
                        <span id="leadNotificationCount" class="notification-badge" style="display: none;">0</span>
                    </div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">{{ $lead->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="page-actions">
                <a href="{{ route('leads.index') }}" class="btn btn-outline-primary me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Leads
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteLead({{ $lead->id }})">
                    <i class="fas fa-trash me-1"></i> Delete Lead
                </button>
            </div>
        </div>
    </div>

    <!-- Lead Notification Dropdown -->
    <div id="leadNotificationDropdown" class="notification-dropdown">
        <div style="padding: 15px; border-bottom: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; font-size: 16px;">Lead Follow-ups</h4>
                <a href="#" onclick="markAllLeadNotificationsRead(); return false;" style="color: #007bff; text-decoration: none; font-size: 14px;">Mark all read</a>
            </div>
        </div>
        <div id="leadNotificationList">
            <div class="notification-empty">
                <i class="fa fa-bell-slash" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                <span>No follow-up reminders</span>
            </div>
        </div>
    </div>

    <!-- Lead Information Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-user-tie me-2"></i>Lead Information
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $lead->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $lead->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $lead->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Company:</strong></td>
                            <td>{{ $lead->company_name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge" style="background-color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }}20; color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }};">
                                    {{ App\Models\Lead::getLeadStatuses()[$lead->lead_status] ?? $lead->lead_status }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Priority:</strong></td>
                            <td>
                                <span class="badge" style="background-color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }}20; color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }};">
                                    {{ App\Models\Lead::getPriorities()[$lead->priority] ?? $lead->priority }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Assigned To:</strong></td>
                            <td>{{ $lead->assignedUser->name ?? 'Unassigned' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Reactions:</strong></td>
                            <td><span class="badge bg-info">{{ $reactions->count() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Reaction Form -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Record New Reaction
                    </h5>
                </div>
                <div class="card-body">
                    <form id="reactionForm">
                        @csrf
                        <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                        
                        <!-- Reaction Types -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Reaction Type:</label>
                            <div class="row">
                                @foreach($reactionTypes as $type => $details)
                                    <div class="col-md-6 mb-3">
                                        <div class="reaction-type-card" data-type="{{ $type }}" style="border: 2px solid #e9ecef; border-radius: 8px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                                            <div class="reaction-emoji" style="font-size: 2rem; margin-bottom: 8px;">{{ $details['emoji'] }}</div>
                                            <h6 class="mb-1">{{ $details['label'] }}</h6>
                                            <small class="text-muted">{{ $details['description'] }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="reaction_type" id="selectedReaction" required>
                        </div>

                        <!-- Call Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="call_duration" class="form-label">
                                    <i class="fas fa-clock me-1"></i> Call Duration (seconds)
                                </label>
                                <input type="number" class="form-control" id="call_duration" name="call_duration" 
                                       min="1" max="999" placeholder="e.g., 120">
                            </div>
                            <div class="col-md-6">
                                <label for="next_follow_up" class="form-label">
                                    <i class="fas fa-calendar me-1"></i> Next Follow Up
                                </label>
                                <input type="date" class="form-control" id="next_follow_up" name="next_follow_up">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <i class="fas fa-comment me-1"></i> Notes / Conversation Details
                            </label>
                            <textarea class="form-control" id="notes" name="notes" rows="4" 
                                      placeholder="Enter details about the conversation, customer response, etc..." maxlength="1000"></textarea>
                            <small class="text-muted">Maximum 1000 characters</small>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-2"></i> Record Reaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reaction History -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Reaction History
                        @if($reactions->count() > 0)
                            <span class="badge bg-light text-dark float-end">{{ $reactions->count() }}</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($reactions->count() > 0)
                        <div class="reaction-history-container" style="max-height: 500px; overflow-y: auto;">
                            @foreach($reactions as $reaction)
                                <?php $details = $reaction->getReactionDetails(); ?>
                                <div class="alert alert-light mb-3" style="border-left: 4px solid {{ $details['color'] ?? '#007bff' }};">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center">
                                            <span class="reaction-emoji me-2" style="font-size: 1.5rem;">{{ $details['emoji'] }}</span>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $details['label'] }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i> {{ $reaction->user->name }}
                                                    <i class="fas fa-calendar ms-2 me-1"></i> {{ $reaction->formatted_date_time }}
                                                </small>
                                            </div>
                                        </div>
                                        <span class="badge" style="background-color: {{ $details['color'] ?? '#007bff' }}20; color: {{ $details['color'] ?? '#007bff' }};">
                                            {{ $details['label'] }}
                                        </span>
                                    </div>
                                    
                                    @if($reaction->notes)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-comment me-1"></i> {{ $reaction->notes }}
                                            </small>
                                        </div>
                                    @endif
                                    
                                    <div class="row text-muted small">
                                        <div class="col-md-6">
                                            @if($reaction->call_duration)
                                                <i class="fas fa-clock me-1"></i> Duration: {{ $reaction->formatted_call_duration ?? 'N/A' }}
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($reaction->next_follow_up)
                                                <i class="fas fa-calendar-check me-1"></i> Follow-up: {{ $reaction->next_follow_up->format('M d, Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No reactions recorded yet</h5>
                            <p class="text-muted">Start by recording the first reaction for this lead.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i> Delete Lead
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center">
                    <i class="fas fa-trash fa-3x text-danger mb-3"></i>
                    <h5>Are you sure you want to delete this lead?</h5>
                    <p class="text-muted mb-0">
                        <strong>{{ $lead->name }}</strong><br>
                        This action cannot be undone and all reaction history will be permanently deleted.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="{{ route('leads.destroy', $lead->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete Lead
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i> Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h5>Reaction Recorded Successfully!</h5>
                <p class="text-muted mb-0">The reaction has been saved and notification sent.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="resetForm()">Add Another</button>
            </div>
        </div>
    </div>
</div>

<style>
.reaction-type-card:hover {
    border-color: #007bff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.reaction-type-card.selected {
    border-color: #007bff !important;
    background-color: #007bff;
    color: white;
}

.reaction-type-card.selected .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.page-content {
    padding: 20px;
}

.page-actions {
    display: flex;
    gap: 0.5rem;
}

@media (max-width: 768px) {
    .page-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .page-actions .btn {
        width: 100%;
    }
}
</style>

<script>
$(document).ready(function() {
    // Load lead notifications on page load
    loadLeadNotifications();
    
    // Auto-refresh notifications every 30 seconds
    setInterval(loadLeadNotifications, 30000);
    
    // Test notification (remove this in production)
    setTimeout(function() {
        console.log('Creating test notification...');
        // Test the bell with a fake notification
        $('#leadNotificationCount').text('1');
        $('#leadNotificationCount').show();
        $('#leadNotificationBell').addClass('ringing');
        
        // Add test notification to dropdown
        $('#leadNotificationList').html(`
            <div class="notification-item overdue" onclick="alert('Test notification clicked!')">
                <div class="notification-title">
                    🚨 Test Follow-up Required
                </div>
                <div class="notification-message">
                    This is a test notification to verify the system is working.
                </div>
                <div class="notification-meta">
                    Lead: Test Lead | Follow-up: Today
                </div>
            </div>
        `);
    }, 2000);
    
    // Handle reaction type selection
    $('.reaction-type-card').click(function() {
        $('.reaction-type-card').removeClass('selected');
        $(this).addClass('selected');
        $('#selectedReaction').val($(this).data('type'));
    });

    // Handle form submission
    $('#reactionForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        // Validate reaction type selection
        if (!$('#selectedReaction').val()) {
            alert('Please select a reaction type');
            return;
        }

        $.ajax({
            url: '{{ route("leads.reaction.store", $lead->id) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#successModal').modal('show');
                    // Refresh notifications after successful submission
                    setTimeout(function() {
                        loadLeadNotifications();
                        location.reload();
                    }, 2000);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                var errorMessage = 'An error occurred while recording the reaction.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    });
});

// Lead Notification Functions
function loadLeadNotifications() {
    console.log('Loading lead notifications...');
    $.ajax({
        url: '{{ route("lead-notifications.index") }}',
        type: 'GET',
        success: function(response) {
            console.log('Notifications loaded:', response);
            updateLeadNotificationBell(response);
            updateLeadNotificationDropdown(response.notifications);
        },
        error: function(xhr, status, error) {
            console.log('Error loading lead notifications:', error);
            console.log('Response:', xhr.responseText);
        }
    });
}

function updateLeadNotificationBell(data) {
    var bell = $('#leadNotificationBell');
    var countBadge = $('#leadNotificationCount');
    
    console.log('Updating bell with data:', data);
    
    if (data.unread_count > 0) {
        countBadge.text(data.unread_count);
        countBadge.show();
        
        // Add ringing animation for overdue notifications
        var hasOverdue = data.notifications && data.notifications.some(function(notif) {
            return notif.is_overdue;
        });
        
        if (hasOverdue) {
            bell.addClass('ringing');
            console.log('Adding ringing animation - overdue notifications found');
        } else {
            bell.removeClass('ringing');
        }
    } else {
        countBadge.hide();
        bell.removeClass('ringing');
    }
}

function updateLeadNotificationDropdown(notifications) {
    var listContainer = $('#leadNotificationList');
    
    if (!notifications || notifications.length === 0) {
        listContainer.html(`
            <div class="notification-empty">
                <i class="fa fa-bell-slash" style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                <span>No follow-up reminders</span>
            </div>
        `);
        return;
    }
    
    var html = '';
    notifications.forEach(function(notification) {
        var itemClass = 'notification-item';
        if (notification.is_overdue) {
            itemClass += ' overdue';
        } else if (notification.is_today) {
            itemClass += ' today';
        } else {
            itemClass += ' upcoming';
        }
        
        var priorityIcon = '';
        if (notification.is_overdue) {
            priorityIcon = '🚨';
        } else if (notification.is_today) {
            priorityIcon = '⏰';
        } else {
            priorityIcon = '📅';
        }
        
        html += `
            <div class="${itemClass}" onclick="viewLeadNotification(${notification.id}, '${notification.redirect_url}')">
                <div class="notification-title">
                    ${priorityIcon} ${notification.title}
                </div>
                <div class="notification-message">
                    ${notification.message}
                </div>
                <div class="notification-meta">
                    Lead: ${notification.lead_name} | Follow-up: ${notification.follow_up_date}
                </div>
            </div>
        `;
    });
    
    listContainer.html(html);
}

function toggleLeadNotifications() {
    console.log('Toggle lead notifications clicked');
    var dropdown = $('#leadNotificationDropdown');
    var isVisible = dropdown.is(':visible');
    
    console.log('Dropdown visible:', isVisible);
    
    // Close all other dropdowns
    $('.notification-dropdown').hide();
    
    if (!isVisible) {
        dropdown.show();
        loadLeadNotifications(); // Refresh when opening
        console.log('Showing dropdown');
    } else {
        console.log('Hiding dropdown');
    }
    
    return false; // Prevent event bubbling
}

function viewLeadNotification(notificationId, redirectUrl) {
    console.log('Viewing notification:', notificationId);
    
    // Mark as read
    $.ajax({
        url: `/lead-notifications/${notificationId}/read`,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Notification marked as read:', response);
            loadLeadNotifications(); // Refresh notifications
            window.location.href = redirectUrl;
        },
        error: function(xhr, status, error) {
            console.log('Error marking notification as read:', error);
            window.location.href = redirectUrl;
        }
    });
}

function markAllLeadNotificationsRead() {
    console.log('Marking all notifications as read');
    $.ajax({
        url: '{{ route("lead-notifications.read-all") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('All notifications marked as read:', response);
            if (response.success) {
                loadLeadNotifications();
            }
        },
        error: function(xhr, status, error) {
            console.log('Error marking all as read:', error);
        }
    });
}

// Close dropdown when clicking outside
$(document).click(function(event) {
    if (!$(event.target).closest('#leadNotificationBell, #leadNotificationDropdown').length) {
        $('#leadNotificationDropdown').hide();
    }
});

// Prevent dropdown from closing when clicking inside
$('#leadNotificationDropdown').click(function(event) {
    event.stopPropagation();
});

function resetForm() {
    $('#reactionForm')[0].reset();
    $('.reaction-type-card').removeClass('selected');
    $('#selectedReaction').val('');
    $('#successModal').modal('hide');
}

function confirmDeleteLead(leadId) {
    $('#deleteModal').modal('show');
}
</script>
@endsection
