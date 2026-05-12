@extends('admin.admin_master')

@section('page-title', 'Lead Reaction Management')

@push('styles')
<style>
.reaction-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
}

.reaction-main-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: none;
    overflow: hidden;
}

.reaction-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    position: relative;
}

.reaction-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.1;
}

.lead-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.lead-subtitle {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 20px;
}

.notification-bell {
    position: relative;
    cursor: pointer;
    padding: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: inline-block;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.3);
}

.notification-bell:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
    border-color: rgba(255,255,255,0.5);
}

.notification-bell.ringing {
    animation: ring 1s ease-in-out infinite;
    background: rgba(220,53,69,0.3);
    border-color: rgba(220,53,69,0.5);
}

.notification-bell.ringing i {
    color: #ff6b6b !important;
    animation: shake 0.5s ease-in-out infinite;
}

@keyframes ring {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(15deg); }
    75% { transform: rotate(-15deg); }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-3px); }
    75% { transform: translateX(3px); }
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff6b6b;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: bold;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(255,107,107,0.3);
}

.notification-dropdown {
    display: none;
    position: absolute;
    top: 80px;
    right: 0;
    background: white;
    border: none;
    border-radius: 15px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    min-width: 380px;
    max-height: 450px;
    overflow-y: auto;
    z-index: 9999;
    backdrop-filter: blur(20px);
}

.notification-item {
    padding: 18px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.notification-item:hover {
    background: #f8f9fa;
    transform: translateX(5px);
}

.notification-item.overdue {
    border-left: 4px solid #ff6b6b;
    background: linear-gradient(90deg, rgba(255,107,107,0.05) 0%, transparent 100%);
}

.notification-item.today {
    border-left: 4px solid #ffd93d;
    background: linear-gradient(90deg, rgba(255,217,61,0.05) 0%, transparent 100%);
}

.notification-item.upcoming {
    border-left: 4px solid #6bcf7f;
    background: linear-gradient(90deg, rgba(107,207,127,0.05) 0%, transparent 100%);
}

.notification-title {
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 15px;
    display: flex;
    align-items: center;
}

.notification-message {
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
    line-height: 1.5;
}

.notification-meta {
    font-size: 12px;
    color: #999;
    display: flex;
    align-items: center;
    gap: 10px;
}

.lead-info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.info-item {
    background: white;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.info-label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    font-weight: 600;
}

.info-value {
    font-size: 16px;
    color: #333;
    font-weight: 500;
}

.reaction-form-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.reaction-types-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.reaction-type-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid transparent;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.reaction-type-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102,126,234,0.1), transparent);
    transition: left 0.5s ease;
}

.reaction-type-card:hover::before {
    left: 100%;
}

.reaction-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(102,126,234,0.2);
    border-color: #667eea;
}

.reaction-type-card.selected {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(102,126,234,0.3);
}

.reaction-emoji {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: block;
}

.reaction-label {
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 14px;
}

.reaction-desc {
    font-size: 12px;
    opacity: 0.8;
}

.form-floating-custom {
    position: relative;
    margin-bottom: 20px;
}

.form-floating-custom label {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    font-size: 14px;
    color: #666;
    transition: all 0.3s ease;
    background: white;
    padding: 0 5px;
}

.form-floating-custom input:focus + label,
.form-floating-custom input:not(:placeholder-shown) + label,
.form-floating-custom textarea:focus + label,
.form-floating-custom textarea:not(:placeholder-shown) + label {
    top: -10px;
    font-size: 12px;
    color: #667eea;
}

.form-control-custom {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.form-control-custom:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
}

.btn-reaction {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 15px 30px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-reaction::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-reaction:hover::before {
    left: 100%;
}

.btn-reaction:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(102,126,234,0.3);
}

.history-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.history-item {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.history-item:hover {
    transform: translateX(5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.history-emoji {
    font-size: 2rem;
    margin-right: 10px;
}

.history-title {
    font-weight: 600;
    font-size: 16px;
    color: #333;
}

.history-meta {
    font-size: 12px;
    color: #666;
}

.history-content {
    font-size: 14px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 10px;
}

.history-details {
    display: flex;
    gap: 20px;
    font-size: 13px;
    color: #777;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #999;
    margin-bottom: 10px;
}

@media (max-width: 768px) {
    .reaction-container {
        padding: 10px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .reaction-types-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .notification-dropdown {
        min-width: 320px;
        right: -10px;
    }
}
</style>
@endpush

@section('admin')
<div class="reaction-container">
    <div class="reaction-main-card">
        <!-- Header -->
        <div class="reaction-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="lead-title">{{ $lead->name }}</h1>
                    <p class="lead-subtitle">Lead Reaction Management System</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- Notification Bell -->
                    <div class="notification-bell" id="leadNotificationBell" onclick="toggleLeadNotifications()">
                        <i class="fa fa-bell" style="color: white; font-size: 20px;"></i>
                        <span id="leadNotificationCount" class="notification-badge" style="display: none;">0</span>
                    </div>
                    <!-- Action Buttons -->
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteLead({{ $lead->id }})">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Dropdown -->
        <div id="leadNotificationDropdown" class="notification-dropdown">
            <div style="padding: 20px; border-bottom: 1px solid #f0f0f0;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0; font-size: 16px; font-weight: 600;">
                        <i class="fas fa-bell me-2"></i>All Notifications
                    </h4>
                    <a href="#" onclick="markAllLeadNotificationsRead(); return false;" style="color: #667eea; text-decoration: none; font-size: 14px; font-weight: 500;">
                        Mark all read
                    </a>
                </div>
            </div>
            <div id="leadNotificationList">
                <div class="empty-state">
                    <i class="fas fa-bell-slash"></i>
                    <h5>No notifications</h5>
                    <p>Reaction and follow-up notifications will appear here</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <!-- Lead Information -->
            <div class="lead-info-card">
                <h3 class="mb-4" style="color: #333; font-weight: 600;">
                    <i class="fas fa-user-tie me-2" style="color: #667eea;"></i>Lead Information
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $lead->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $lead->email ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $lead->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Company</div>
                        <div class="info-value">{{ $lead->company_name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="badge" style="background-color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }}20; color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }}; padding: 8px 12px; border-radius: 20px; font-size: 12px;">
                                {{ App\Models\Lead::getLeadStatuses()[$lead->lead_status] ?? $lead->lead_status }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Priority</div>
                        <div class="info-value">
                            <span class="badge" style="background-color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }}20; color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }}; padding: 8px 12px; border-radius: 20px; font-size: 12px;">
                                {{ App\Models\Lead::getPriorities()[$lead->priority] ?? $lead->priority }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Assigned To</div>
                        <div class="info-value">{{ $lead->assignedUser->name ?? 'Unassigned' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Total Reactions</div>
                        <div class="info-value">
                            <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 12px; border-radius: 20px; font-size: 12px;">
                                {{ $reactions->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Reaction Form -->
                <div class="col-lg-6">
                    <div class="reaction-form-card">
                        <h3 class="mb-4" style="color: #333; font-weight: 600;">
                            <i class="fas fa-plus-circle me-2" style="color: #6bcf7f;"></i>Record New Reaction
                        </h3>
                        
                        <form id="reactionForm" method="POST" action="{{ route('leads.reaction.store', $lead->id) }}">
                            @csrf
                            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                            
                            <!-- Reaction Types -->
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-3">Select Reaction Type:</label>
                                <div class="reaction-types-grid">
                                    @foreach($reactionTypes as $type => $details)
                                        <div class="reaction-type-card" data-type="{{ $type }}" onclick="selectReactionType(this)">
                                            <div class="reaction-emoji">{{ $details['emoji'] }}</div>
                                            <div class="reaction-label">{{ $details['label'] }}</div>
                                            <div class="reaction-desc">{{ $details['description'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="reaction_type" id="selectedReaction" required>
                            </div>

                            <!-- Call Details -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-floating-custom">
                                        <input type="time" class="form-control-custom" id="reaction_time" name="reaction_time" 
                                               placeholder=" " value="{{ date('H:i') }}">
                                        <label for="reaction_time">
                                            <i class="fas fa-clock me-1"></i> Reaction Time
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating-custom">
                                        <input type="number" class="form-control-custom" id="call_duration" name="call_duration" 
                                               min="1" max="999" placeholder=" ">
                                        <label for="call_duration">
                                            <i class="fas fa-clock me-1"></i> Call Duration (seconds)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating-custom">
                                        <input type="date" class="form-control-custom" id="next_follow_up" name="next_follow_up" placeholder=" ">
                                        <label for="next_follow_up">
                                            <i class="fas fa-calendar me-1"></i> Next Follow-up Date
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-floating-custom mb-4">
                                <textarea class="form-control-custom" id="notes" name="notes" rows="4" 
                                          placeholder=" " style="resize: vertical; min-height: 100px;"></textarea>
                                <label for="notes">
                                    <i class="fas fa-comment me-1"></i> Conversation Notes
                                </label>
                                <small class="text-muted">Maximum 1000 characters</small>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn-reaction">
                                    <i class="fas fa-save me-2"></i>Record Reaction
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Reaction History -->
                <div class="col-lg-6">
                    <div class="history-card">
                        <h3 class="mb-4" style="color: #333; font-weight: 600;">
                            <i class="fas fa-history me-2" style="color: #667eea;"></i>Reaction History
                            @if($reactions->count() > 0)
                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 10px; border-radius: 15px; font-size: 11px; margin-left: 10px;">
                                    {{ $reactions->count() }}
                                </span>
                            @endif
                        </h3>
                        
                        @if($reactions->count() > 0)
                            <div style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                                @foreach($reactions as $reaction)
                                    <?php $details = $reaction->getReactionDetails(); ?>
                                    <div class="history-item">
                                        <div class="history-header">
                                            <div class="d-flex align-items-center">
                                                <span class="history-emoji">{{ $details['emoji'] }}</span>
                                                <div>
                                                    <div class="history-title">{{ $details['label'] }}</div>
                                                    <div class="history-meta">
                                                        <i class="fas fa-user me-1"></i> {{ $reaction->user->name }}
                                                        <i class="fas fa-calendar ms-2 me-1"></i> {{ $reaction->formatted_date_time }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($reaction->notes)
                                            <div class="history-content">
                                                <i class="fas fa-comment me-2"></i>{{ $reaction->notes }}
                                            </div>
                                        @endif
                                        
                                        <div class="history-details">
                                            @if($reaction->call_duration)
                                                <div>
                                                    <i class="fas fa-clock me-1"></i> Duration: {{ $reaction->formatted_call_duration }}
                                                </div>
                                            @endif
                                            @if($reaction->next_follow_up)
                                                <div>
                                                    <i class="fas fa-calendar-check me-1"></i> Follow-up: {{ $reaction->next_follow_up->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h5>No reactions recorded yet</h5>
                                <p>Start by recording the first reaction for this lead.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #6bcf7f 0%, #4caf50 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i> Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-4x" style="color: #6bcf7f; margin-bottom: 20px;"></i>
                <h5>Reaction Recorded Successfully!</h5>
                <p class="text-muted mb-0">The reaction has been saved and notifications sent.</p>
            </div>
            <div class="modal-footer" style="border: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="resetForm()">Add Another</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #ff6b6b 0%, #dc3545 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i> Delete Lead
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-trash fa-3x" style="color: #ff6b6b; margin-bottom: 20px;"></i>
                <h5>Are you sure you want to delete this lead?</h5>
                <p class="text-muted mb-0">
                    <strong>{{ $lead->name }}</strong><br>
                    This action cannot be undone and all reaction history will be permanently deleted.
                </p>
            </div>
            <div class="modal-footer" style="border: none;">
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

<script>
$(document).ready(function() {
    // Load lead notifications on page load
    loadLeadNotifications();
    
    // Auto-refresh notifications every 30 seconds
    setInterval(loadLeadNotifications, 30000);
    
    // Add test button for debugging
    $('.history-card h3').append(`
        <button type="button" class="btn btn-sm btn-outline-primary ms-2" onclick="testAddReaction()" style="font-size: 12px;">
            <i class="fas fa-plus me-1"></i>Test Add Reaction
        </button>
    `);
});

function selectReactionType(element) {
    $('.reaction-type-card').removeClass('selected');
    $(element).addClass('selected');
    $('#selectedReaction').val($(element).data('type'));
}

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
            <div class="empty-state">
                <i class="fas fa-bell-slash"></i>
                <h5>No notifications</h5>
                <p>Reaction and follow-up notifications will appear here</p>
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
        var typeIcon = '';
        
        if (notification.is_overdue) {
            priorityIcon = '🚨';
        } else if (notification.is_today) {
            priorityIcon = '⏰';
        } else {
            priorityIcon = '📅';
        }
        
        // Set icon based on notification type
        if (notification.type === 'lead_reaction') {
            typeIcon = notification.reaction_emoji;
        } else if (notification.type === 'all_followups') {
            typeIcon = '👥';
        } else {
            typeIcon = notification.reaction_emoji || '📋';
        }
        
        var additionalInfo = '';
        if (notification.assigned_to) {
            additionalInfo = `<div style="font-size: 11px; color: #999; margin-top: 5px;">
                <i class="fas fa-user me-1"></i> Assigned to: ${notification.assigned_to}
            </div>`;
        } else if (notification.recorded_by) {
            additionalInfo = `<div style="font-size: 11px; color: #999; margin-top: 5px;">
                <i class="fas fa-pen me-1"></i> Recorded by: ${notification.recorded_by}
            </div>`;
        }
        
        html += `
            <div class="${itemClass}" onclick="viewLeadNotification('${notification.id}', '${notification.redirect_url}')">
                <div class="notification-title">
                    ${priorityIcon} ${typeIcon} ${notification.title}
                </div>
                <div class="notification-message">
                    ${notification.message}
                </div>
                <div class="notification-meta">
                    <i class="fas fa-user me-1"></i> ${notification.lead_name} 
                    <i class="fas fa-calendar ms-2 me-1"></i> ${notification.follow_up_date || notification.created_at}
                </div>
                ${additionalInfo}
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

// Handle form submission
$('#reactionForm').submit(function(e) {
    e.preventDefault();
    
    // Prevent default form submission and handle via AJAX
    var formData = new FormData(this);
    
    // Add reaction_time if not already included
    if (!formData.has('reaction_time')) {
        var reactionTime = $('#reaction_time').val();
        if (reactionTime) {
            formData.append('reaction_time', reactionTime);
        }
    }
    
    // Validate reaction type selection
    if (!$('#selectedReaction').val()) {
        alert('Please select a reaction type');
        return false;
    }

    // Show loading state
    $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Recording...');

    $.ajax({
        url: '{{ route("leads.reaction.store", $lead->id) }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            // Reset button state
            $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Record Reaction');
            
            try {
                if (response.success) {
                    // Show success message
                    var successHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Success!</strong> ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    
                    // Insert success message at the top of the form
                    $('.reaction-form-card').prepend(successHtml);
                    
                    // Add the new reaction to history dynamically
                    if (response.reaction) {
                        addNewReactionToHistory(response.reaction);
                    }
                    
                    // Refresh notifications if function exists
                    if (typeof loadLeadNotifications === 'function') {
                        loadLeadNotifications();
                    }
                    
                    // Reset form
                    if (typeof resetForm === 'function') {
                        resetForm();
                    }
                    
                    // Remove success message after 5 seconds
                    setTimeout(function() {
                        $('.alert-success').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 5000);
                    
                } else {
                    // Show error message
                    var errorHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error!</strong> ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('.reaction-form-card').prepend(errorHtml);
                }
            } catch (e) {
                console.error('Error processing response:', e);
                alert('Error processing response. Please try again.');
            }
        },
        error: function(xhr, status, error) {
            // Reset button state
            $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Record Reaction');
            
            try {
                var errorMessage = 'An error occurred while recording reaction.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        var errorData = JSON.parse(xhr.responseText);
                        errorMessage = errorData.message || errorMessage;
                    } catch (e) {
                        errorMessage = xhr.responseText.substring(0, 200);
                    }
                }
                
                // Show error message
                var errorHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> ${errorMessage}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $('.reaction-form-card').prepend(errorHtml);
            } catch (e) {
                console.error('Error handling AJAX error:', e);
                alert('An unexpected error occurred. Please try again.');
            }
        },
        complete: function() {
            // Always reset button state when AJAX completes
            $('#submitBtn').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Record Reaction');
        }
    });
    
    return false; // Prevent default form submission
});

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

function testAddReaction() {
    console.log('Testing add reaction function...');
    
    // Create a test reaction object
    var testReaction = {
        id: 'test_' + Date.now(),
        reaction_type: 'positive',
        notes: 'This is a test reaction to verify the history update functionality.',
        call_duration: 120,
        next_follow_up: new Date().toISOString().split('T')[0],
        user: {
            name: 'Test User'
        },
        created_at: new Date().toISOString()
    };
    
    // Test the add function
    addNewReactionToHistory(testReaction);
    
    alert('Test reaction added! Check the history section and browser console for details.');
}

function addNewReactionToHistory(reaction) {
    console.log('Adding new reaction to history:', reaction);
    
    // Get reaction details
    var details = {
        'positive': { emoji: '😊', label: 'Positive', color: '#28a745' },
        'neutral': { emoji: '😐', label: 'Neutral', color: '#ffc107' },
        'negative': { emoji: '😞', label: 'Negative', color: '#dc3545' },
        'follow_up': { emoji: '📞', label: 'Follow Up Required', color: '#17a2b8' },
        'interested': { emoji: '🔥', label: 'Highly Interested', color: '#fd7e14' },
        'not_reachable': { emoji: '📵', label: 'Not Reachable', color: '#6c757d' }
    };
    
    var reactionDetails = details[reaction.reaction_type] || { emoji: '❓', label: 'Unknown', color: '#6c757d' };
    
    // Create new history item HTML
    var newHistoryHtml = `
        <div class="history-item" style="animation: slideInLeft 0.5s ease-out; border-left-color: ${reactionDetails.color};">
            <div class="history-header">
                <div class="d-flex align-items-center">
                    <span class="history-emoji">${reactionDetails.emoji}</span>
                    <div>
                        <div class="history-title">${reactionDetails.label}</div>
                        <div class="history-meta">
                            <i class="fas fa-user me-1"></i> ${reaction.user.name}
                            <i class="fas fa-calendar ms-2 me-1"></i> Just now
                        </div>
                    </div>
                </div>
            </div>
            
            ${reaction.notes ? `
                <div class="history-content">
                    <i class="fas fa-comment me-2"></i>${reaction.notes}
                </div>
            ` : ''}
            
            <div class="history-details">
                ${reaction.call_duration ? `
                    <div>
                        <i class="fas fa-clock me-1"></i> Duration: ${formatCallDuration(reaction.call_duration)}
                    </div>
                ` : ''}
                ${reaction.next_follow_up ? `
                    <div>
                        <i class="fas fa-calendar-check me-1"></i> Follow-up: ${formatFollowUpDate(reaction.next_follow_up)}
                    </div>
                ` : ''}
            </div>
        </div>
    `;
    
    // Find the history container and scrollable div
    var historyCard = $('.history-card');
    var scrollableContainer = historyCard.find('div[style*="overflow-y: auto"]');
    
    // Remove empty state if it exists
    $('.empty-state').parent().remove();
    
    if (scrollableContainer.length === 0) {
        // If no scrollable container found, try to find where to add the item
        if (historyCard.find('.history-item').length === 0) {
            // No existing items, append to the card
            historyCard.append(newHistoryHtml);
        } else {
            // Add to the beginning of existing items
            historyCard.find('.history-item').first().before(newHistoryHtml);
        }
    } else {
        // Add to the beginning of existing history in the scrollable container
        scrollableContainer.prepend(newHistoryHtml);
    }
    
    // Update reaction count badge
    var countBadge = historyCard.find('.badge').first();
    if (countBadge.length > 0) {
        var currentCount = parseInt(countBadge.text()) || 0;
        countBadge.text(currentCount + 1);
    }
    
    console.log('New reaction added to history successfully');
    console.log('History container found:', scrollableContainer.length > 0 ? 'Yes' : 'No');
}

function formatCallDuration(seconds) {
    if (!seconds) return 'N/A';
    var minutes = Math.floor(seconds / 60);
    var remainingSeconds = seconds % 60;
    return minutes > 0 ? minutes + 'm ' + remainingSeconds + 's' : remainingSeconds + 's';
}

function formatFollowUpDate(dateString) {
    var date = new Date(dateString);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// Add CSS animation for new items
$('<style>')
    .text('@keyframes slideInLeft { from { transform: translateX(-100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }')
    .appendTo('head');

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
