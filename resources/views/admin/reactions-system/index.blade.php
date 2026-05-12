@extends('admin.admin_master')

@section('page-title', 'Reactions System')

@push('styles')
<style>
.reactions-system-container {
    padding: 20px;
}

.reactions-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.reactions-header h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 700;
}

.reactions-header p {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

.reaction-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.reaction-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.reaction-card h3 {
    color: #1f2937;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.reaction-card h3 i {
    margin-right: 0.75rem;
    color: #667eea;
}

.reaction-types {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.reaction-type-btn {
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    font-weight: 500;
}

.reaction-type-btn:hover {
    border-color: #667eea;
    background: #f3f4f6;
    transform: translateY(-2px);
}

.reaction-type-btn.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.reaction-type-btn .emoji {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    display: block;
}

.form-select, .form-control {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-primary-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.reaction-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.reaction-item:hover {
    background: #f3f4f6;
    transform: translateX(5px);
}

.reaction-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.reaction-type-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
}

.reaction-meta {
    display: flex;
    gap: 0.5rem;
}

.priority-badge, .status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.priority-low { background: #dbeafe; color: #1e40af; }
.priority-medium { background: #fed7aa; color: #c2410c; }
.priority-high { background: #fecaca; color: #b91c1c; }
.priority-urgent { background: #f3e8ff; color: #7c3aed; }

.status-active { background: #d1fae5; color: #065f46; }
.status-completed { background: #dbeafe; color: #1e40af; }
.status-cancelled { background: #f3f4f6; color: #374151; }
.status-postponed { background: #fef3c7; color: #d97706; }

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.notification-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.notification-card:hover {
    border-color: #667eea;
    transform: translateY(-3px);
}

.notification-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0.5rem 0;
}

.notification-card h5 {
    color: #6b7280;
    font-weight: 500;
    margin: 0;
}

.notification-card .fa-2x {
    color: #667eea;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .reactions-header h1 {
        font-size: 2rem;
    }
    
    .reaction-types {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    }
}
</style>
@endpush

@section('admin')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reactions System</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Reactions System</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="reactions-system-container">
                <!-- Header Section -->
                <div class="reactions-header">
                    <h1><i class="fas fa-comments me-3"></i>Professional Reactions System</h1>
                    <p>Manage all customer interactions and follow-ups in one place</p>
                </div>

                <!-- Notification Management Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="notification-card">
                            <i class="fas fa-clock fa-2x"></i>
                            <h3>
                                @php
                                    $scheduledCount = \App\Models\LeadReaction::where('notification_sent', false)
                                        ->where('next_follow_up', '>=', now()->format('Y-m-d'))
                                        ->count();
                                @endphp
                                {{ $scheduledCount }}
                            </h3>
                            <h5>Scheduled Notifications</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notification-card">
                            <i class="fas fa-envelope fa-2x"></i>
                            <h3>
                                @php
                                    $sentTodayCount = \App\Models\LeadReaction::where('notification_sent', true)
                                        ->whereDate('notification_sent_at', today())
                                        ->count();
                                @endphp
                                {{ $sentTodayCount }}
                            </h3>
                            <h5>Sent Today</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notification-card">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                            <h3>
                                @php
                                    $overdueCount = \App\Models\LeadReaction::where('notification_sent', false)
                                        ->where('next_follow_up', '<', now()->format('Y-m-d'))
                                        ->count();
                                @endphp
                                {{ $overdueCount }}
                            </h3>
                            <h5>Overdue</h5>
                        </div>
                    </div>
                </div>

                <!-- Control Panel -->
                <div class="reaction-card">
                    <h3><i class="fas fa-cogs"></i>Notification Controls</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary-custom me-2" onclick="testNotifications()">
                                <i class="fas fa-play me-2"></i>Test Notification System
                            </button>
                            <button type="button" class="btn btn-success me-2" onclick="sendPendingNotifications()">
                                <i class="fas fa-paper-plane me-2"></i>Send Pending Now
                            </button>
                        </div>
                        <div class="col-md-6 text-end">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Automated notifications run every minute
                            </small>
                        </div>
                    </div>
                    <div id="notificationStatus" class="mt-3"></div>
                </div>

                <!-- Add New Reaction Section -->
                <div class="reaction-card">
                    <h3><i class="fas fa-plus-circle"></i>Add New Reaction</h3>
                    
                    <form id="reactionForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="leadSelect" class="form-label">Select Lead</label>
                                    <select class="form-select" id="leadSelect" name="lead_id" required>
                                        <option value="">Choose a lead...</option>
                                        @if(isset($leads))
                                            @foreach($leads as $lead)
                                                <option value="{{ $lead->id }}">{{ $lead->name }} - {{ $lead->email }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reactionType" class="form-label">Reaction Type</label>
                                    <input type="hidden" id="reactionType" name="reaction_type" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reaction Type</label>
                            <div class="reaction-types">
                                <div class="reaction-type-btn" data-type="positive">
                                    <span class="emoji">😊</span>
                                    Positive
                                </div>
                                <div class="reaction-type-btn" data-type="neutral">
                                    <span class="emoji">😐</span>
                                    Neutral
                                </div>
                                <div class="reaction-type-btn" data-type="negative">
                                    <span class="emoji">😞</span>
                                    Negative
                                </div>
                                <div class="reaction-type-btn" data-type="follow_up">
                                    <span class="emoji">📞</span>
                                    Follow Up Required
                                </div>
                                <div class="reaction-type-btn" data-type="interested">
                                    <span class="emoji">🔥</span>
                                    Highly Interested
                                </div>
                                <div class="reaction-type-btn" data-type="not_reachable">
                                    <span class="emoji">📵</span>
                                    Not Reachable
                                </div>
                                <div class="reaction-type-btn" data-type="hot_lead">
                                    <span class="emoji">🔥</span>
                                    Hot Lead
                                </div>
                                <div class="reaction-type-btn" data-type="cold_lead">
                                    <span class="emoji">❄️</span>
                                    Cold Lead
                                </div>
                                <div class="reaction-type-btn" data-type="appointment_set">
                                    <span class="emoji">📅</span>
                                    Appointment Set
                                </div>
                                <div class="reaction-type-btn" data-type="meeting_scheduled">
                                    <span class="emoji">🤝</span>
                                    Meeting Scheduled
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="followUpDate" class="form-label">Follow-up Date</label>
                                    <input type="date" class="form-control" id="followUpDate" name="next_follow_up">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="followUpTime" class="form-label">Follow-up Time</label>
                                    <input type="time" class="form-control" id="followUpTime" name="reaction_time">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter reaction notes..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary-custom" id="submitBtn">
                                <i class="fas fa-save me-2"></i>Save Reaction
                            </button>
                            <div id="loadingSpinner" class="spinner-border spinner-border-sm d-none ms-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div class="success-message alert alert-success mt-3 d-none" id="successMessage">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="successText">Reaction saved successfully!</span>
                        </div>
                    </form>
                </div>

                <!-- Recent Reactions Section -->
                <div class="reaction-card">
                    <h3><i class="fas fa-history"></i>Recent Reactions</h3>
                    
                    <div id="reactionsList">
                        @forelse($reactions as $reaction)
                            <div class="reaction-item">
                                <div class="reaction-header">
                                    <div class="reaction-type-badge">
                                        {{ $reaction->getReactionDetails()['label'] ?? 'Unknown' }}
                                    </div>
                                    <div class="reaction-meta">
                                        @if($reaction->next_follow_up)
                                            <span class="badge bg-info">
                                                <i class="fas fa-calendar me-1"></i>
                                                Follow-up: {{ $reaction->next_follow_up->format('M d, Y') }} @ {{ $reaction->reaction_time }}
                                            </span>
                                        @endif
                                        @if($reaction->call_duration)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $reaction->call_duration }}s
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="reaction-content">
                                    @if($reaction->notes)
                                        <p><strong>Notes:</strong> {{ $reaction->notes }}</p>
                                    @endif
                                    @if($reaction->lead)
                                        <p><strong>Lead:</strong> {{ $reaction->lead->name }} ({{ $reaction->lead->email }})</p>
                                    @endif
                                </div>
                                <div class="reaction-details">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>
                                                {{ $reaction->user ? $reaction->user->name : 'Unknown' }}
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $reaction->created_at->format('M d, Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>No reactions recorded yet</h4>
                                <p>Start adding reactions to track customer interactions</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Notification History -->
                <div class="reaction-card">
                    <h3><i class="fas fa-envelope"></i>Recent Notification History</h3>
                    
                    @php
                        $recentNotifications = \App\Models\LeadReaction::with(['lead', 'user'])
                            ->where('notification_sent', true)
                            ->orderBy('notification_sent_at', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    
                    @forelse($recentNotifications as $notification)
                        <div class="reaction-item">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    {{ $notification->getReactionEmoji() }}
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ $notification->lead->name ?? 'Unknown Lead' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        Sent to {{ $notification->lead->email ?? 'Unknown Email' }} 
                                        - {{ $notification->notification_sent_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Sent</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-envelope-open"></i>
                            <h4>No notifications sent yet</h4>
                            <p>Notifications will appear here once they are sent</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    // Reaction type selection
    $('.reaction-type-btn').click(function() {
        $('.reaction-type-btn').removeClass('selected');
        $(this).addClass('selected');
        $('#reactionType').val($(this).data('type'));
    });

    // Form submission
    $('#reactionForm').submit(function(e) {
        e.preventDefault();

        // Validate required fields
        if (!$('#leadSelect').val()) {
            alert('Please select a lead');
            return;
        }

        if (!$('#reactionType').val()) {
            alert('Please select a reaction type');
            return;
        }

        // Show loading
        $('#submitBtn').prop('disabled', true);
        $('#loadingSpinner').removeClass('d-none').addClass('active');
        $('.success-message').removeClass('show');

        // Submit form
        $.ajax({
            url: '{{ route("reactions-system.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#successText').text(response.message);
                    $('.success-message').removeClass('d-none').addClass('show');
                    
                    // Reset form
                    $('#reactionForm')[0].reset();
                    $('.reaction-type-btn').removeClass('selected');
                    $('#reactionType').val('');
                    
                    // Add reaction to list
                    if (response.reaction) {
                        addReactionToList(response.reaction);
                    }
                } else {
                    alert('Error: ' + response.message);
                }
                $('#loadingSpinner').addClass('d-none').removeClass('active');
                $('#submitBtn').prop('disabled', false);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert('Error: ' + errorMessage);
                $('#loadingSpinner').addClass('d-none').removeClass('active');
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

    function addReactionToList(reaction) {
        const reactionHtml = `
            <div class="reaction-item" style="animation: slideInDown 0.5s ease;">
                <div class="reaction-header">
                    <div class="reaction-type-badge">
                        ${reaction.reaction_type_label}
                    </div>
                    <div class="reaction-meta">
                        <span class="priority-badge priority-${reaction.priority}">
                            ${reaction.priority_label}
                        </span>
                        <span class="status-badge status-${reaction.status}">
                            ${reaction.status_label}
                        </span>
                    </div>
                </div>
                <div class="reaction-content">
                    ${reaction.notes ? `<p><strong>Notes:</strong> ${reaction.notes}</p>` : ''}
                </div>
                <div class="reaction-details">
                    <div class="detail-item">
                        <i class="fas fa-user"></i>
                        <span>${reaction.user ? reaction.user.name : 'Unknown'}</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar"></i>
                        <span>${new Date(reaction.reaction_timestamp).toLocaleString()}</span>
                    </div>
                </div>
            </div>
        `;

        // Add to top of list
        $('#reactionsList').prepend(reactionHtml);

        // Remove empty state if exists
        $('#reactionsList .empty-state').remove();
    }

    // Test notification system
    window.testNotifications = function() {
        $('#notificationStatus').html('<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-2"></i>Testing notification system...</div>');
        
        $.ajax({
            url: '{{ route("reactions.send.test") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#notificationStatus').html('<div class="alert alert-success"><i class="fas fa-check me-2"></i>' + response.message + '</div>');
                setTimeout(() => location.reload(), 2000);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#notificationStatus').html('<div class="alert alert-danger"><i class="fas fa-exclamation me-2"></i>Error: ' + errorMessage + '</div>');
            }
        });
    };

    // Send pending notifications now
    window.sendPendingNotifications = function() {
        $('#notificationStatus').html('<div class="alert alert-info"><i class="fas fa-spinner fa-spin me-2"></i>Sending pending notifications...</div>');
        
        $.ajax({
            url: '{{ route("reactions.send.pending") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#notificationStatus').html('<div class="alert alert-success"><i class="fas fa-check me-2"></i>' + response.message + '</div>');
                setTimeout(() => location.reload(), 2000);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#notificationStatus').html('<div class="alert alert-danger"><i class="fas fa-exclamation me-2"></i>Error: ' + errorMessage + '</div>');
            }
        });
    };
});
</script>
@endsection
