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
                                        @if($reaction->priority ?? null)
                                            <span class="priority-badge priority-{{ $reaction->priority }}">
                                                {{ ucfirst($reaction->priority) }}
                                            </span>
                                        @endif
                                        @if($reaction->status ?? null)
                                            <span class="status-badge status-{{ $reaction->status }}">
                                                {{ ucfirst($reaction->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="reaction-content">
                                    @if($reaction->notes ?? null)
                                        <p><strong>Notes:</strong> {{ $reaction->notes }}</p>
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
                        $recentNotifications = \App\Models\LeadReaction::with(['lead', 'lead.assignedUser'])
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
                                        Sent to {{ $notification->lead->assignedUser->name ?? 'Unknown User' }} 
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
        $('#loadingSpinner').addClass('active');
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
                    $('.success-message').addClass('show');
                    
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
                $('#loadingSpinner').removeClass('active');
                $('#submitBtn').prop('disabled', false);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert('Error: ' + errorMessage);
                $('#loadingSpinner').removeClass('active');
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
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .reaction-logo {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .reaction-logo:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .form-section, .reactions-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title i {
            color: #667eea;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .reaction-type-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .reaction-type-card {
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .reaction-type-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
        }

        .reaction-type-card.selected {
            border-color: #667eea;
            background: var(--primary-gradient);
            color: white;
        }

        .reaction-emoji {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .reaction-label {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .reactions-list {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 1rem;
        }

        .reaction-item {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }

        .reaction-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .reaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .reaction-type-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .reaction-meta {
            display: flex;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .reaction-content {
            margin-bottom: 1rem;
        }

        .reaction-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            font-size: 0.9rem;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-item i {
            color: #667eea;
            width: 20px;
        }

        .priority-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .priority-low { background: #d4edda; color: #155724; }
        .priority-medium { background: #fff3cd; color: #856404; }
        .priority-high { background: #f8d7da; color: #721c24; }
        .priority-urgent { background: #f5c6cb; color: #721c24; }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .status-postponed { background: #fff3cd; color: #856404; }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .loading-spinner.active {
            display: block;
        }

        .success-message {
            display: none;
            background: var(--success-gradient);
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 500;
        }

        .success-message.show {
            display: block;
            animation: slideInDown 0.5s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            
            .reaction-type-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-content">
            <div class="logo-section">
                <div class="reaction-logo" onclick="window.location.href='{{ route('reactions-system.index') }}'">
                    <i class="fas fa-reaction"></i>
                </div>
                <div class="logo-text">Reactions System</div>
            </div>
            <div class="user-info">
                <span class="text-muted">Welcome, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Professional Reactions System</h1>
            <p class="page-subtitle">Manage all customer interactions and follow-ups in one place</p>
        </div>

        <!-- Success Message -->
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle me-2"></i>
            <span id="successText">Reaction recorded successfully!</span>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Form Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-plus-circle"></i>
                    Add New Reaction
                </h2>

                <form id="reactionForm">
                    @csrf
                    <input type="hidden" name="lead_id" id="leadId" value="{{ old('lead_id') }}">

                    <!-- Lead Selection -->
                    <div class="form-group">
                        <label class="form-label">Select Lead *</label>
                        <select name="lead_id" class="form-control" id="leadSelect" required>
                            <option value="">Choose a lead...</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                    {{ $lead->name }} - {{ $lead->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reaction Type -->
                    <div class="form-group">
                        <label class="form-label">Reaction Type *</label>
                        <div class="reaction-type-grid">
                            @foreach($reactionTypes as $key => $label)
                                <div class="reaction-type-card" data-type="{{ $key }}">
                                    <div class="reaction-emoji">{{ substr($label, 0, 3) }}</div>
                                    <div class="reaction-label">{{ substr($label, 4) }}</div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="reaction_type" id="reactionType" required>
                    </div>

                    <!-- Notes -->
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4" placeholder="Enter detailed notes about this reaction...">{{ old('notes') }}</textarea>
                    </div>

                    <!-- Follow-up Details -->
                    <div class="form-group">
                        <label class="form-label">Next Follow-up</label>
                        <input type="date" name="next_follow_up" class="form-control" value="{{ old('next_follow_up') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Follow-up Time</label>
                        <input type="time" name="follow_up_time" class="form-control" value="{{ old('follow_up_time') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Follow-up Priority</label>
                        <select name="follow_up_priority" class="form-control">
                            @foreach($priorities as $key => $label)
                                <option value="{{ $key }}" {{ old('follow_up_priority') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Call Details -->
                    <div class="form-group">
                        <label class="form-label">Call Duration (seconds)</label>
                        <input type="number" name="call_duration" class="form-control" placeholder="120" value="{{ old('call_duration') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Call Type</label>
                        <select name="call_type" class="form-control">
                            <option value="">Select type...</option>
                            <option value="incoming" {{ old('call_type') == 'incoming' ? 'selected' : '' }}>Incoming</option>
                            <option value="outgoing" {{ old('call_type') == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                            <option value="missed" {{ old('call_type') == 'missed' ? 'selected' : '' }}>Missed</option>
                        </select>
                    </div>

                    <!-- Meeting Details -->
                    <div class="form-group">
                        <label class="form-label">Meeting Date</label>
                        <input type="date" name="meeting_date" class="form-control" value="{{ old('meeting_date') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meeting Time</label>
                        <input type="time" name="meeting_time" class="form-control" value="{{ old('meeting_time') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Meeting Location</label>
                        <input type="text" name="meeting_location" class="form-control" placeholder="Office, Client Location, etc." value="{{ old('meeting_location') }}">
                    </div>

                    <!-- Additional Fields -->
                    <div class="form-group">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-control">
                            @foreach($priorities as $key => $label)
                                <option value="{{ $key }}" {{ old('priority') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Rating (1-5)</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" placeholder="5" value="{{ old('rating') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Source</label>
                        <input type="text" name="source" class="form-control" placeholder="Phone, Email, Website, etc." value="{{ old('source') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Campaign</label>
                        <input type="text" name="campaign" class="form-control" placeholder="Marketing campaign name" value="{{ old('campaign') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deal Value ($)</label>
                        <input type="number" name="value" class="form-control" step="0.01" placeholder="10000.00" value="{{ old('value') }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tags (comma-separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="hot-lead, follow-up, important" value="{{ old('tags') }}">
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-save me-2"></i>
                            Record Reaction
                        </button>
                    </div>
                </form>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Recording reaction...</p>
                </div>
            </div>

            <!-- Reactions List Section -->
            <div class="reactions-section">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    Recent Reactions
                </h2>

                <div class="reactions-list" id="reactionsList">
                    @forelse($reactions as $reaction)
                            <div class="reaction-item" data-id="{{ $reaction->id }}">
                                <div class="reaction-header">
                                    <div class="reaction-type-badge">
                                        {{ $reaction->reaction_type_label }}
                                    </div>
                                    <div class="reaction-meta">
                                        <span class="priority-badge priority-{{ $reaction->priority }}">
                                            {{ $reaction->priority_label }}
                                        </span>
                                        <span class="status-badge status-{{ $reaction->status }}">
                                            {{ $reaction->status_label }}
                                        </span>
                                    </div>
                                </div>

                                <div class="reaction-content">
                                    @if($reaction->notes)
                                        <p><strong>Notes:</strong> {{ $reaction->notes }}</p>
                                    @endif
                                    @if($reaction->reaction_details)
                                        <p><strong>Details:</strong> {{ $reaction->reaction_details }}</p>
                                    @endif
                                </div>

                                <div class="reaction-details">
                                    @if($reaction->user)
                                        <div class="detail-item">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $reaction->user->name }}</span>
                                        </div>
                                    @endif
                                    @if($reaction->lead)
                                        <div class="detail-item">
                                            <i class="fas fa-user-tie"></i>
                                            <span>{{ $reaction->lead->name }}</span>
                                        </div>
                                    @endif
                                    @if($reaction->formatted_call_duration)
                                        <div class="detail-item">
                                            <i class="fas fa-clock"></i>
                                            <span>{{ $reaction->formatted_call_duration }}</span>
                                        </div>
                                    @endif
                                    @if($reaction->formatted_follow_up_date)
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-check"></i>
                                            <span>{{ $reaction->formatted_follow_up_date }}</span>
                                        </div>
                                    @endif
                                    @if($reaction->value)
                                        <div class="detail-item">
                                            <i class="fas fa-dollar-sign"></i>
                                            <span>${{ number_format($reaction->value, 2) }}</span>
                                        </div>
                                    @endif
                                    <div class="detail-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $reaction->reaction_timestamp->format('M d, Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p>No reactions recorded yet</p>
                            </div>
                    @endforelse
                </div>
            </div>

            <!-- Notification Management Section -->
            <div class="reactions-section">
                <h2 class="section-title">
                    <i class="fas fa-bell"></i>
                    Notification Management
                </h2>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="notification-card">
                            <div class="card-body text-center">
                                <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                <h5>Scheduled Notifications</h5>
                                <h3 class="text-primary">
                                    @php
                                        $scheduledCount = \App\Models\LeadReaction::where('notification_sent', false)
                                            ->where('next_follow_up', '>=', now()->format('Y-m-d'))
                                            ->count();
                                    @endphp
                                    {{ $scheduledCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notification-card">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope fa-2x text-success mb-2"></i>
                                <h5>Sent Today</h5>
                                <h3 class="text-success">
                                    @php
                                        $sentTodayCount = \App\Models\LeadReaction::where('notification_sent', true)
                                            ->whereDate('notification_sent_at', today())
                                            ->count();
                                    @endphp
                                    {{ $sentTodayCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="notification-card">
                            <div class="card-body text-center">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                                <h5>Overdue</h5>
                                <h3 class="text-warning">
                                    @php
                                        $overdueCount = \App\Models\LeadReaction::where('notification_sent', false)
                                            ->where('next_follow_up', '<', now()->format('Y-m-d'))
                                            ->count();
                                    @endphp
                                    {{ $overdueCount }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs"></i>
                            Notification Controls
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" onclick="testNotifications()">
                                    <i class="fas fa-play"></i> Test Notification System
                                </button>
                                <button type="button" class="btn btn-success ms-2" onclick="sendPendingNotifications()">
                                    <i class="fas fa-paper-plane"></i> Send Pending Now
                                </button>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Automated notifications run every minute
                                </small>
                            </div>
                        </div>
                        
                        <div id="notificationStatus" class="mt-3"></div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-history"></i>
                            Recent Notification History
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentNotifications = \App\Models\LeadReaction::with(['lead', 'lead.assignedUser'])
                                ->where('notification_sent', true)
                                ->orderBy('notification_sent_at', 'desc')
                                ->limit(10)
                                ->get();
                        @endphp
                        
                        @forelse($recentNotifications as $notification)
                            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                <div class="me-3">
                                    {{ $notification->getReactionEmoji() }}
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ $notification->lead->name ?? 'Unknown Lead' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        Sent to {{ $notification->lead->assignedUser->name ?? 'Unknown User' }} 
                                        - {{ $notification->notification_sent_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div>
                                    <span class="badge bg-success">Sent</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-envelope-open fa-3x mb-3"></i>
                                <p>No notifications sent yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Reaction type selection
            $('.reaction-type-card').click(function() {
                $('.reaction-type-card').removeClass('selected');
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
                $('#loadingSpinner').addClass('active');
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
                            $('.success-message').addClass('show');

                            // Add new reaction to list
                            addReactionToList(response.reaction);

                            // Reset form
                            $('#reactionForm')[0].reset();
                            $('.reaction-type-card').removeClass('selected');
                            $('#reactionType').val('');

                            // Hide loading
                            $('#loadingSpinner').removeClass('active');
                            $('#submitBtn').prop('disabled', false);

                            // Hide success message after 3 seconds
                            setTimeout(function() {
                                $('.success-message').removeClass('show');
                            }, 3000);
                        } else {
                            alert('Error: ' + response.message);
                            $('#loadingSpinner').removeClass('active');
                            $('#submitBtn').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        alert('Error: ' + errorMessage);
                        $('#loadingSpinner').removeClass('active');
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
                $('#reactionsList .text-center').remove();
            }

            // Test notification system
            window.testNotifications = function() {
                $('#notificationStatus').html('<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Testing notification system...</div>');
                
                $.ajax({
                    url: '{{ route("reactions.send.test") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#notificationStatus').html('<div class="alert alert-success"><i class="fas fa-check"></i> ' + response.message + '</div>');
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $('#notificationStatus').html('<div class="alert alert-danger"><i class="fas fa-exclamation"></i> Error: ' + errorMessage + '</div>');
                    }
                });
            };

            // Send pending notifications now
            window.sendPendingNotifications = function() {
                $('#notificationStatus').html('<div class="alert alert-info"><i class="fas fa-spinner fa-spin"></i> Sending pending notifications...</div>');
                
                $.ajax({
                    url: '{{ route("reactions.send.pending") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#notificationStatus').html('<div class="alert alert-success"><i class="fas fa-check"></i> ' + response.message + '</div>');
                        setTimeout(() => location.reload(), 2000);
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $('#notificationStatus').html('<div class="alert alert-danger"><i class="fas fa-exclamation"></i> Error: ' + errorMessage + '</div>');
                    }
                });
            };
        });
    </script>
</body>
</html>
