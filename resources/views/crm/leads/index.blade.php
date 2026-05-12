@extends('layouts.whatsapp-crm')

@section('pageTitle', 'Leads Management')

<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                Leads Management
            </div>
            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                <!-- Filter Dropdowns -->
                <select id="filterType" style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white;">
                    <option value="">Select Filter</option>
                    <option value="status">Status</option>
                    <option value="priority">Priority</option>
                    <option value="source">Source</option>
                </select>
                
                <select id="filterValue" style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white;" disabled>
                    <option value="">Select option...</option>
                </select>
                
                <button id="clearFilter" onclick="clearFilters()" style="padding: 8px 12px; border: 1px solid #dc3545; background: #dc3545; color: white; border-radius: 6px; cursor: pointer; font-size: 14px; display: none;">
                    Clear
                </button>
                
                <button onclick="showAddLeadModal()" style="background: #00a884; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <i class="fas fa-plus" style="margin-right: 4px;"></i>
                    Add Lead
                </button>
                <button onclick="syncGoogleSheets()" style="background: #4285f4; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">
                    <i class="fas fa-sync" style="margin-right: 4px;"></i>
                    Sync Google Sheets
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Search -->
        <div style="display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" id="searchInput" placeholder="Search leads..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
            </div>
            
            <select style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px;">
                <option value="">All Departments</option>
                <option value="marketing">Marketing</option>
                <option value="sales">Sales</option>
                <option value="development">Development</option>
            </select>
        </div>
        
        <!-- Leads List -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Name</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Contact</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Source</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Status</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Priority</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Assigned To</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Description</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #495057;">Created</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #495057;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($leads) && count($leads) > 0)
                        @foreach($leads as $lead)
                        <tr style="border-bottom: 1px solid #dee2e6; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                            <td style="padding: 12px;">
                                <div style="font-weight: 600; color: #111b21;">{{ $lead->name }}</div>
                                <div style="font-size: 0.875rem; color: #667781;">{{ $lead->company ?? 'N/A' }}</div>
                            </td>
                            <td style="padding: 12px;">
                                <div style="color: #111b21;">{{ $lead->email }}</div>
                                <div style="font-size: 0.875rem; color: #667781;">{{ $lead->phone }}</div>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge badge-info">{{ ucfirst($lead->source ?? 'manual') }}</span>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge badge-{{ $lead->lead_status === 'qualified' ? 'success' : ($lead->lead_status === 'lost' ? 'danger' : ($lead->lead_status === 'hot' ? 'danger' : ($lead->lead_status === 'warm' ? 'warning' : 'info'))) }}">
                                    {{ ucfirst($lead->lead_status) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <span class="badge badge-{{ $lead->priority === 'high' ? 'danger' : ($lead->priority === 'medium' ? 'warning' : 'info') }}">
                                    {{ ucfirst($lead->priority) }}
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; border-radius: 50%; background: #00a884; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">
                                        {{ $lead->assigned_to ? strtoupper(substr($lead->assignedUser->name, 0, 1)) : 'U' }}
                                    </div>
                                    <span style="color: #111b21;">{{ $lead->assignedUser->name ?? 'Unassigned' }}</span>
                                </div>
                            </td>
                            <td style="padding: 12px;">
                                <div style="color: #111b21; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $lead->description ?? $lead->notes ?? 'N/A' }}">
                                    {{ Str::limit($lead->description ?? $lead->notes ?? 'N/A', 50) }}
                                </div>
                                @if($lead->source === 'google_sheets')
                                    <span class="badge badge-info" style="font-size: 0.75rem;">Google Sheets</span>
                                @endif
                            </td>
                            <td style="padding: 12px;">
                                <div style="color: #111b21;">{{ $lead->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 0.875rem; color: #667781;">{{ $lead->created_at->diffForHumans() }}</div>
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <button onclick="viewLead({{ $lead->id }})" style="background: #007bff; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="editLead({{ $lead->id }})" style="background: #28a745; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="createQuotation({{ $lead->id }}, event)" style="background: #6c757d; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;" title="Create Quotation">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                    <button onclick="deleteLead({{ $lead->id }})" style="background: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="9" style="padding: 40px; text-align: center; color: #667781;">
                            <i class="fas fa-user-slash" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.5;"></i>
                            <div>No leads found</div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($leads) && method_exists($leads, 'links'))
        <div style="margin-top: 20px; text-align: center;">
            {{ $leads->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Add/Edit Lead Modal -->
<div id="leadModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; width: 90%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <div style="padding: 20px; border-bottom: 1px solid #dee2e6; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: #111b21;">Add New Lead</h3>
            <button onclick="closeLeadModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #667781;">&times;</button>
        </div>
        <form style="padding: 20px;">
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Name *</label>
                <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Email *</label>
                <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Phone *</label>
                <input type="tel" name="phone" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Company</label>
                <input type="text" name="company" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Source</label>
                <select name="source" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <option value="manual">Manual</option>
                    <option value="website">Website</option>
                    <option value="referral">Referral</option>
                    <option value="social">Social Media</option>
                    <option value="email">Email Campaign</option>
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-weight: 500; color: #111b21;">Notes</label>
                <textarea name="notes" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeLeadModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 6px; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 10px 20px; background: #00a884; color: white; border: none; border-radius: 6px; cursor: pointer;">Save Lead</button>
            </div>
        </form>
    </div>
</div>

<script>
// Filter options data
const filterOptions = {
    status: {
        'hot': 'Hot',
        'cold': 'Cold',
        'warm': 'Warm',
        'qualified': 'Qualified',
        'lost': 'Lost'
    },
    priority: {
        'low': 'Low',
        'medium': 'Medium',
        'high': 'High'
    },
    source: {
        'website': 'Website',
        'referral': 'Referral',
        'social_media': 'Social Media',
        'email': 'Email',
        'phone': 'Phone',
        'advertisement': 'Advertisement',
        'other': 'Other'
    }
};

// Handle filter type change
function handleFilterTypeChange() {
    const filterType = document.getElementById('filterType').value;
    const filterValue = document.getElementById('filterValue');
    const clearButton = document.getElementById('clearFilter');
    
    // Clear current options
    filterValue.innerHTML = '<option value="">Select option...</option>';
    
    if (filterType && filterOptions[filterType]) {
        // Enable the filter value dropdown
        filterValue.disabled = false;
        
        // Add options based on selected filter type
        Object.entries(filterOptions[filterType]).forEach(([value, label]) => {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = label;
            filterValue.appendChild(option);
        });
    } else {
        // Disable if no filter type selected
        filterValue.disabled = true;
    }
}

// Apply filter
function applyFilter() {
    const filterType = document.getElementById('filterType').value;
    const filterValue = document.getElementById('filterValue').value;
    const clearButton = document.getElementById('clearFilter');
    
    if (filterType && filterValue) {
        // Build URL with filter parameters
        const url = new URL(window.location);
        url.searchParams.set('filter_type', filterType);
        url.searchParams.set('filter_value', filterValue);
        
        // Navigate to filtered page
        window.location.href = url.toString();
    }
}

// Clear filters
function clearFilters() {
    const url = new URL(window.location);
    url.searchParams.delete('filter_type');
    url.searchParams.delete('filter_value');
    window.location.href = url.toString();
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filterType');
    const filterValue = document.getElementById('filterValue');
    const clearButton = document.getElementById('clearFilter');
    
    // Add event listener for filter type change
    filterType.addEventListener('change', handleFilterTypeChange);
    
    // Add event listener for filter value change
    filterValue.addEventListener('change', applyFilter);
    
    // Check if there are active filters and show clear button
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('filter_type') && urlParams.has('filter_value')) {
        clearButton.style.display = 'block';
        
        // Set the current filter values
        filterType.value = urlParams.get('filter_type');
        handleFilterTypeChange();
        filterValue.value = urlParams.get('filter_value');
    }
});

function showAddLeadModal() {
    document.getElementById('leadModal').style.display = 'flex';
}

function closeLeadModal() {
    document.getElementById('leadModal').style.display = 'none';
}

function viewLead(id) {
    // Implementation for viewing lead details
    console.log('View lead:', id);
}

function editLead(id) {
    // Implementation for editing lead
    console.log('Edit lead:', id);
}

function deleteLead(id) {
    if(confirm('Are you sure you want to delete this lead?')) {
        // Implementation for deleting lead
        console.log('Delete lead:', id);
    }
}

function createQuotation(leadId, event) {
    // Prevent any default behavior
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Redirect to quotation creation page with lead data
    console.log('Creating quotation for lead:', leadId);
    window.location.href = '/quotations/create?lead_id=' + leadId;
}

function syncGoogleSheets() {
    // Show loading state
    const syncButton = event.target;
    const originalText = syncButton.innerHTML;
    syncButton.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 4px;"></i> Syncing...';
    syncButton.disabled = true;

    fetch('/google-sheets/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Google Sheets sync completed successfully!\n' + data.message);
            // Reload the page to show new leads
            window.location.reload();
        } else {
            alert('Sync failed: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error syncing Google Sheets:', error);
        alert('An error occurred while syncing Google Sheets');
    })
    .finally(() => {
        // Restore button state
        syncButton.innerHTML = originalText;
        syncButton.disabled = false;
    });
}
</script>
