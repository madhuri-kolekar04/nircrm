@extends('admin.admin_master')

@section('page-title', 'Lead Reaction Management')

@push('styles')
<style>
.reaction-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
}

.lead-info-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
    position: relative;
    z-index: 1;
    height: fit-content;
}

.reaction-type-card {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    position: relative;
    height: 100%;
}

.reaction-type-card .text-center {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.reaction-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    border-color: #007bff;
}

.reaction-type-card.selected {
    border-color: #007bff;
    background: linear-gradient(135deg, #007bff15 0%, #0056b315 100%);
    transform: scale(1.02);
}

.reaction-emoji {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.reaction-history-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid #007bff;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    position: relative;
}

.reaction-history-card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.12);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    border-radius: 8px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.lead-stat {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    padding: 1rem;
    text-align: center;
    margin-bottom: 1rem;
}

.lead-stat i {
    font-size: 2rem;
    color: #007bff;
    margin-bottom: 0.5rem;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: bold;
}

.reaction-management-container {
    padding: 0;
    margin-top: 0;
    max-width: 100%;
    width: 100%;
    background: transparent;
    min-height: 100vh;
}

/* Ensure proper spacing from header */
.reaction-management-container .reaction-card {
    margin-top: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
}

/* Make lead info cards more prominent */
.reaction-management-container .lead-info-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    position: relative;
    z-index: 1;
    height: fit-content;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

/* Ensure content is visible */
.reaction-management-container .d-flex {
    display: flex !important;
}

.reaction-management-container .row {
    display: flex !important;
    margin-left: -0.75rem;
    margin-right: -0.75rem;
}

.reaction-management-container .col-md-6,
.reaction-management-container .col-lg-6,
.reaction-management-container .col-md-8,
.reaction-management-container .col-md-4 {
    display: block !important;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}

/* Ensure form elements are visible */
.reaction-management-container form,
.reaction-management-container .reaction-type-card,
.reaction-management-container .form-control,
.reaction-management-container .form-label,
.reaction-management-container .btn,
.reaction-management-container h1,
.reaction-management-container h2,
.reaction-management-container h3,
.reaction-management-container h4,
.reaction-management-container h5,
.reaction-management-container h6,
.reaction-management-container p,
.reaction-management-container span,
.reaction-management-container small,
.reaction-management-container .badge {
    visibility: visible !important;
    display: block !important;
}

.reaction-management-container .reaction-type-card {
    display: block !important;
    cursor: pointer;
}

.reaction-management-container .text-center {
    text-align: center !important;
}

.reaction-management-container .d-flex,
.reaction-management-container .justify-content-between,
.reaction-management-container .align-items-start {
    display: flex !important;
}

.reaction-history-container {
    max-height: 600px;
    overflow-y: auto;
    padding-right: 0.5rem;
}

/* Custom scrollbar for reaction history */
.reaction-history-container::-webkit-scrollbar {
    width: 6px;
}

.reaction-history-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.reaction-history-container::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 3px;
}

.reaction-history-container::-webkit-scrollbar-thumb:hover {
    background: #5a67d8;
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

.action-buttons .btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
    background: transparent;
}

.action-buttons .btn-outline-primary:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

@media (max-width: 768px) {
    .reaction-type-card {
        margin-bottom: 0.75rem;
        padding: 1rem;
    }
    
    .reaction-emoji {
        font-size: 2rem;
    }
    
    .reaction-management-container {
        padding: 10px;
    }
    
    .reaction-card,
    .lead-info-card {
        margin-bottom: 1rem;
        padding: 1rem;
    }
    
    .lead-info-card {
        height: auto;
    }
    
    .reaction-history-container {
        max-height: 400px;
        padding-right: 0.25rem;
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
}
</style>
@endpush

@section('admin')
<div class="reaction-management-container">
    <!-- Debug Info -->
    <div style="background: #f8f9fa; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
        <small class="text-muted">Debug: Lead ID = {{ $lead->id ?? 'Not Set' }}, Lead Name = {{ $lead->name ?? 'Not Set' }}</small>
    </div>
    
    <!-- Lead Information Header -->
    <div class="reaction-card">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h2 class="mb-0" style="color: white !important;">
                        <i class="fas fa-user-tie me-3"></i>{{ $lead->name ?? 'Lead Name Not Available' }}
                    </h2>
                    <div class="action-buttons">
                        <a href="{{ route('leads.index') }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="fas fa-arrow-left me-1"></i> Back to Leads
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteLead({{ $lead->id ?? 0 }})">
                            <i class="fas fa-trash me-1"></i> Delete Lead
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-envelope me-2"></i> {{ $lead->email ?? 'N/A' }}</p>
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-phone me-2"></i> {{ $lead->phone ?? 'N/A' }}</p>
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-building me-2"></i> {{ $lead->company_name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-flag me-2"></i> 
                            <span class="badge" style="background-color: {{ App\Models\Lead::getStatusColorForValue($lead->lead_status ?? 'new') }}20; color: white;">
                                {{ App\Models\Lead::getLeadStatuses()[$lead->lead_status ?? 'new'] ?? $lead->lead_status ?? 'New' }}
                            </span>
                        </p>
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-exclamation-triangle me-2"></i> 
                            <span class="badge" style="background-color: {{ App\Models\Lead::getPriorityColorForValue($lead->priority ?? 'medium') }}20; color: white;">
                                {{ App\Models\Lead::getPriorities()[$lead->priority ?? 'medium'] ?? $lead->priority ?? 'Medium' }}
                            </span>
                        </p>
                        <p class="mb-2" style="color: white !important;"><i class="fas fa-user me-2"></i> 
                            Assigned to: {{ $lead->assignedUser->name ?? 'Unassigned' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="lead-stat" style="background: rgba(255,255,255,0.2); border-radius: 10px; padding: 1rem;">
                    <i class="fas fa-history" style="font-size: 2rem; color: white;"></i>
                    <h6 style="color: white;">Total Reactions</h6>
                    <h3 style="color: white;">{{ $reactions->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Debug Info for Form Section -->
        <div style="background: #e8f5e8; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
            <small class="text-muted">Debug: Form Section Loading - Reaction Types Count = {{ $reactionTypes->count() ?? 'Not Set' }}</small>
        </div>
        
        <!-- Add Reaction Section -->
        <div class="col-lg-6">
            <div class="lead-info-card">
                <h4 class="mb-4" style="color: #333 !important; font-weight: 600;">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>
                    Record New Reaction
                </h4>
                
                <form id="reactionForm" style="display: block !important;">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id ?? 0 }}">
                    
                    <!-- Reaction Types -->
                    <div class="mb-4" style="display: block !important;">
                        <label class="form-label fw-bold" style="display: block !important; color: #333 !important;">Select Reaction Type:</label>
                        <div class="row" style="display: flex !important;">
                            @if(isset($reactionTypes) && $reactionTypes->count() > 0)
                                @foreach($reactionTypes as $type => $details)
                                    <div class="col-md-6 mb-3" style="display: block !important;">
                                        <div class="reaction-type-card" data-type="{{ $type }}" style="display: block !important; border: 2px solid #e9ecef; border-radius: 12px; padding: 1.5rem; cursor: pointer; background: white;">
                                            <div class="text-center" style="text-align: center !important;">
                                                <div class="reaction-emoji" style="font-size: 3rem; margin-bottom: 0.5rem;">{{ $details['emoji'] ?? '❓' }}</div>
                                                <h6 class="mb-1" style="color: #333 !important;">{{ $details['label'] ?? 'Unknown' }}</h6>
                                                <small class="text-muted">{{ $details['description'] ?? 'No description' }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No reaction types available. Please configure reaction types first.
                                    </div>
                                </div>
                            @endif
                        </div>
                        <input type="hidden" name="reaction_type" id="selectedReaction" required>
                    </div>

                    <!-- Call Details -->
                    <div class="row mb-3" style="display: flex !important;">
                        <div class="col-md-6" style="display: block !important;">
                            <label for="call_duration" class="form-label" style="display: block !important; color: #333 !important;">
                                <i class="fas fa-clock me-1"></i> Call Duration (seconds)
                            </label>
                            <input type="number" class="form-control" id="call_duration" name="call_duration" 
                                   min="1" max="999" placeholder="e.g., 120" style="display: block !important; width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <div class="col-md-6" style="display: block !important;">
                            <label for="next_follow_up" class="form-label" style="display: block !important; color: #333 !important;">
                                <i class="fas fa-calendar me-1"></i> Next Follow Up
                            </label>
                            <input type="date" class="form-control" id="next_follow_up" name="next_follow_up" style="display: block !important; width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4" style="display: block !important;">
                        <label for="notes" class="form-label" style="display: block !important; color: #333 !important;">
                            <i class="fas fa-comment me-1"></i> Notes / Conversation Details
                        </label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" 
                                  placeholder="Enter details about the conversation, customer response, etc..." maxlength="1000" style="display: block !important; width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px;"></textarea>
                        <small class="text-muted">Maximum 1000 characters</small>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center" style="text-align: center !important;">
                        <button type="submit" class="btn btn-primary btn-lg" style="display: inline-block !important; padding: 0.75rem 2rem; background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border: none; border-radius: 8px; font-weight: 600;">
                            <i class="fas fa-save me-2"></i> Record Reaction
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reaction History Section -->
        <div class="col-lg-6">
            <!-- Debug Info for History Section -->
            <div style="background: #fff3cd; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;">
                <small class="text-muted">Debug: History Section Loading - Reactions Count = {{ $reactions->count() ?? 'Not Set' }}</small>
            </div>
            
            <div class="lead-info-card">
                <h4 class="mb-4" style="color: #333 !important; font-weight: 600;">
                    <i class="fas fa-history me-2 text-primary"></i>
                    Reaction History
                    @if($reactions->count() > 0)
                        <span class="notification-badge" style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;">{{ $reactions->count() }}</span>
                    @endif
                </h4>
                
                @if($reactions->count() > 0)
                    <div class="reaction-history-container" style="max-height: 600px; overflow-y: auto; padding-right: 0.5rem; display: block !important;">
                        @foreach($reactions as $reaction)
                            <?php $details = $reaction->getReactionDetails(); ?>
                            <div class="reaction-history-card" style="background: white; border-radius: 12px; padding: 1.5rem; margin-bottom: 1rem; border-left: 4px solid #007bff; box-shadow: 0 3px 10px rgba(0,0,0,0.08); position: relative; display: block !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2" style="display: flex !important;">
                                    <div class="d-flex align-items-center" style="display: flex !important;">
                                        <span class="reaction-emoji me-3" style="font-size: 2rem;">{{ $details['emoji'] ?? '❓' }}</span>
                                        <div>
                                            <h6 class="mb-1 fw-bold" style="color: #333 !important;">{{ $details['label'] ?? 'Unknown' }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i> {{ $reaction->user->name ?? 'Unknown User' }}
                                                <i class="fas fa-calendar ms-3 me-1"></i> {{ $reaction->formatted_date_time ?? 'Unknown Date' }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge" style="background-color: {{ $details['color'] ?? '#007bff' }}20; color: {{ $details['color'] ?? '#007bff' }};">
                                        {{ $details['label'] ?? 'Unknown' }}
                                    </span>
                                </div>
                                
                                @if($reaction->notes)
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-comment me-1"></i> {{ $reaction->notes }}
                                        </small>
                                    </div>
                                @endif
                                
                                <div class="row text-muted small" style="display: flex !important;">
                                    <div class="col-md-4" style="display: block !important;">
                                        @if($reaction->call_duration)
                                            <i class="fas fa-clock me-1"></i> Duration: {{ $reaction->formatted_call_duration ?? 'N/A' }}
                                        @endif
                                    </div>
                                    <div class="col-md-4" style="display: block !important;">
                                        @if($reaction->next_follow_up)
                                            <i class="fas fa-calendar-check me-1"></i> Follow-up: {{ $reaction->next_follow_up->format('M d, Y') ?? 'N/A' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5" style="text-align: center !important; padding: 3rem 1rem !important;">
                        <i class="fas fa-inbox fa-3x text-muted mb-3" style="font-size: 3rem; color: #6b7280;"></i>
                        <h5 class="text-muted" style="color: #6b7280 !important;">No reactions recorded yet</h5>
                        <p class="text-muted" style="color: #6b7280 !important;">Start by recording the first reaction for this lead.</p>
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
                    // Optionally refresh the page after a delay
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
    $('.reaction-type-card').removeClass('selected');
    $('#selectedReaction').val('');
    $('#successModal').modal('hide');
}

function confirmDeleteLead(leadId) {
    $('#deleteModal').modal('show');
}
</script>
@endpush
