@extends('admin.admin_master')

@section('page-title', 'Lead Reaction Management')

@push('styles')
<style>
.reaction-management-wrapper {
    background: #f8f9fc;
    min-height: 100vh;
    padding: 20px;
}

.lead-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
    color: white;
    position: relative;
    overflow: hidden;
}

.lead-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.lead-header-content {
    position: relative;
    z-index: 2;
}

.lead-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.lead-meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

.lead-meta-item i {
    width: 20px;
    text-align: center;
    opacity: 0.9;
}

.lead-stats-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.lead-stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.stats-icon.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stats-icon.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.stats-icon.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.stats-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.stats-label {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

.reaction-form-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
    margin-bottom: 30px;
}

.form-section-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.reaction-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.reaction-option {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.reaction-option:hover {
    border-color: #667eea;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.reaction-option.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    transform: scale(1.05);
}

.reaction-emoji {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: block;
}

.reaction-label {
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.reaction-desc {
    font-size: 0.8rem;
    opacity: 0.8;
    line-height: 1.3;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-control {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.btn-reaction {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 14px 30px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-reaction:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.reaction-history-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e5e7eb;
}

.history-item {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 15px;
    border-left: 4px solid #667eea;
    background: #f8f9fc;
    transition: all 0.3s ease;
}

.history-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.history-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.history-reaction {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #1f2937;
}

.history-emoji {
    font-size: 1.5rem;
}

.history-meta {
    display: flex;
    gap: 20px;
    color: #6b7280;
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.history-notes {
    color: #4b5563;
    line-height: 1.5;
    font-size: 0.9rem;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6b7280;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h5 {
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #4b5563;
}

.badge-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Action Buttons Styling */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
}

.action-buttons .btn {
    white-space: nowrap;
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.action-buttons .btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: white;
}

.action-buttons .btn-danger:hover {
    background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
}

.action-buttons .btn-outline-light {
    border: 2px solid rgba(255, 255, 255, 0.7);
    color: white;
    background: transparent;
}

.action-buttons .btn-outline-light:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: white;
    color: white;
}

@media (max-width: 768px) {
    .reaction-management-wrapper {
        padding: 15px;
    }
    
    .lead-header-card {
        padding: 20px;
    }
    
    .lead-title {
        font-size: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .action-buttons .btn {
        width: 100%;
        text-align: center;
    }
    
    .reaction-grid {
        grid-template-columns: 1fr;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .reaction-form-card, .reaction-history-card {
        padding: 20px;
    }
}
</style>
@endpush

@section('admin')
<div class="reaction-management-wrapper">
    <!-- Lead Header Section -->
    <div class="lead-header-card">
        <div class="lead-header-content">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="lead-title">
                    <i class="fas fa-user-tie"></i>
                    {{ $lead->name }}
                </div>
                <div class="action-buttons">
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-1"></i> Back to Leads
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteLead({{ $lead->id }})">
                        <i class="fas fa-trash me-1"></i> Delete Lead
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="lead-meta-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $lead->email ?? 'N/A' }}</span>
                    </div>
                    <div class="lead-meta-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ $lead->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="lead-meta-item">
                        <i class="fas fa-building"></i>
                        <span>{{ $lead->company_name ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="lead-meta-item">
                        <i class="fas fa-flag"></i>
                        <span class="badge-status" style="background: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }}20; color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status) }};">
                            {{ App\Models\Lead::getLeadStatuses()[$lead->lead_status] ?? $lead->lead_status }}
                        </span>
                    </div>
                    <div class="lead-meta-item">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span class="badge-status" style="background: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }}20; color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority) }};">
                            {{ App\Models\Lead::getPriorities()[$lead->priority] ?? $lead->priority }}
                        </span>
                    </div>
                    <div class="lead-meta-item">
                        <i class="fas fa-user"></i>
                        <span>Assigned to: {{ $lead->assignedUser->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="lead-stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-history"></i>
                </div>
                <div class="stats-value">{{ $reactions->count() }}</div>
                <div class="stats-label">Total Reactions</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="lead-stats-card">
                <div class="stats-icon success">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stats-value">{{ $reactions->where('reaction_type', 'positive')->count() }}</div>
                <div class="stats-label">Positive Reactions</div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="lead-stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-value">{{ $reactions->whereNotNull('next_follow_up')->count() }}</div>
                <div class="stats-label">Pending Follow-ups</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Reaction Form -->
        <div class="col-lg-6">
            <div class="reaction-form-card">
                <h3 class="form-section-title">
                    <i class="fas fa-plus-circle"></i>
                    Record New Reaction
                </h3>
                
                <form id="reactionForm">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    
                    <!-- Reaction Types -->
                    <div class="form-group">
                        <label class="form-label">Select Reaction Type:</label>
                        <div class="reaction-grid">
                            @foreach($reactionTypes as $type => $details)
                                <div class="reaction-option" data-type="{{ $type }}">
                                    <span class="reaction-emoji">{{ $details['emoji'] }}</span>
                                    <div class="reaction-label">{{ $details['label'] }}</div>
                                    <div class="reaction-desc">{{ $details['description'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="reaction_type" id="selectedReaction" required>
                    </div>

                    <!-- Call Details -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="call_duration" class="form-label">
                                <i class="fas fa-clock"></i> Call Duration (seconds)
                            </label>
                            <input type="number" class="form-control" id="call_duration" name="call_duration" 
                                   min="1" max="999" placeholder="e.g., 120">
                        </div>
                        <div class="form-group">
                            <label for="next_follow_up" class="form-label">
                                <i class="fas fa-calendar"></i> Next Follow Up
                            </label>
                            <input type="date" class="form-control" id="next_follow_up" name="next_follow_up">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="form-group">
                        <label for="notes" class="form-label">
                            <i class="fas fa-comment"></i> Notes / Conversation Details
                        </label>
                        <textarea class="form-control" id="notes" name="notes" 
                                  placeholder="Enter details about the conversation, customer response, etc..." maxlength="1000"></textarea>
                        <small class="text-muted">Maximum 1000 characters</small>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn-reaction">
                            <i class="fas fa-save"></i>
                            Record Reaction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reaction History -->
        <div class="col-lg-6">
            <div class="reaction-history-card">
                <h3 class="form-section-title">
                    <i class="fas fa-history"></i>
                    Reaction History
                </h3>
                
                @if($reactions->count() > 0)
                    <div class="history-container" style="max-height: 600px; overflow-y: auto;">
                        @foreach($reactions as $reaction)
                            <?php $details = $reaction->getReactionDetails(); ?>
                            <div class="history-item">
                                <div class="history-header">
                                    <div class="history-reaction">
                                        <span class="history-emoji">{{ $details['emoji'] }}</span>
                                        <span>{{ $details['label'] }}</span>
                                    </div>
                                    <span class="badge-status" style="background: {{ $details['color'] }}20; color: {{ $details['color'] }};">
                                        {{ $details['label'] }}
                                    </span>
                                </div>
                                
                                <div class="history-meta">
                                    <span><i class="fas fa-user"></i> {{ $reaction->user->name }}</span>
                                    <span><i class="fas fa-calendar"></i> {{ $reaction->reaction_date->format('M d, Y') }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $reaction->reaction_time }}</span>
                                </div>
                                
                                @if($reaction->notes)
                                    <div class="history-notes">
                                        <i class="fas fa-comment me-2"></i>{{ $reaction->notes }}
                                    </div>
                                @endif
                                
                                @if($reaction->call_duration || $reaction->next_follow_up)
                                    <div class="history-meta">
                                        @if($reaction->call_duration)
                                            <span><i class="fas fa-phone"></i> Duration: {{ $reaction->formatted_call_duration }}</span>
                                        @endif
                                        @if($reaction->next_follow_up)
                                            <span><i class="fas fa-calendar-check"></i> Follow-up: {{ $reaction->next_follow_up->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                @endif
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

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i> Success!
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-check-circle fa-4x" style="color: #10b981; margin-bottom: 20px;"></i>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Handle reaction type selection
    $('.reaction-option').click(function() {
        $('.reaction-option').removeClass('selected');
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
                    // Refresh page after delay
                    setTimeout(function() {
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

function resetForm() {
    $('#reactionForm')[0].reset();
    $('.reaction-option').removeClass('selected');
    $('#selectedReaction').val('');
    $('#successModal').modal('hide');
}

function confirmDeleteLead(leadId) {
    $('#deleteModal').modal('show');
}
</script>
@endpush
