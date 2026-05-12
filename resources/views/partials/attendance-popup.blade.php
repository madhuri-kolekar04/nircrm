<!-- Attendance Popup Modal -->
<div class="modal fade" id="attendancePopupModal" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-clock me-2"></i>Attendance Required
                </h5>
            </div>
            <div class="modal-body">
                <div id="attendancePopupContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Checking your attendance status...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary btn-lg" id="quickCheckInBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Check In Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
(function($) {
    'use strict';
    
    // Check if we should show attendance popup
    @if(Auth::check() && Auth::user()->role != 3)
    var showPopup = {{ session('show_attendance_popup', false) }};
    
    if (showPopup) {
        // Clear the session variable
        $.get('/attendance/clear-popup-session');
        
        // Show popup after a short delay
        setTimeout(function() {
            checkAndShowAttendancePopup();
        }, 1500);
    } else {
        // Check normally on page load
        $(document).ready(function() {
            checkAndShowAttendancePopup();
        });
    }
    @endif

    function checkAndShowAttendancePopup() {
        // Don't show if already checked in today
        var hasCheckedIn = localStorage.getItem('attendance_checked_in_' + {{ Auth::user()->id }});
        var today = new Date().toDateString();
        
        if (hasCheckedIn === today) {
            console.log('Already checked in today, skipping popup');
            return;
        }

        $.get('/attendance/check-status')
            .done(function(response) {
                console.log('Attendance status response:', response);
                
                if (response.show_attendance && !response.already_checked_in) {
                    showAttendancePopup(response);
                } else if (response.already_checked_in) {
                    // Mark as checked in for today
                    localStorage.setItem('attendance_checked_in_' + {{ Auth::user()->id }}, today);
                }
            })
            .fail(function(xhr) {
                console.log('Failed to check attendance status:', xhr.responseText);
            });
    }

    function showAttendancePopup(data) {
        var content = `
            <div class="text-center">
                <div class="mb-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                        <i class="fas fa-clock text-primary fs-1"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-3">Welcome, {{ Auth::user()->name }}!</h5>
                <p class="text-muted mb-4">Please mark your attendance for today</p>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Shift:</strong> ${data.shift_name}</p>
                        <p class="mb-2"><strong>Shift Time:</strong> ${data.shift_time}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Status:</strong> <span class="badge bg-${data.is_on_time ? 'success' : 'warning'}">${data.status_message}</span></p>
                        <p class="mb-2"><strong>Current Time:</strong> ${new Date().toLocaleTimeString()}</p>
                    </div>
                </div>
                
              
            </div>
        `;
        
        $('#attendancePopupContent').html(content);
        $('#attendancePopupModal').modal('show');
        
        // Auto-hide after 10 seconds if no action
        setTimeout(function() {
            if ($('#attendancePopupModal').hasClass('show')) {
                $('#attendancePopupModal').modal('hide');
            }
        }, 10000);
    }

    // Quick check-in button
    $('#quickCheckInBtn').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Checking In...');
        
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.post('/attendance/check-in', {location: 'Office'})
            .done(function(response) {
                if (response.success) {
                    // Mark as checked in for today
                    localStorage.setItem('attendance_checked_in_' + {{ Auth::user()->id }}, new Date().toDateString());
                    
                    // Show success message
                    $('#attendancePopupContent').html(`
                        <div class="text-center py-4">
                            <div class="rounded-circle bg-success bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-check text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-3">Check-in Successful!</h5>
                            <p class="text-muted">Your attendance has been marked for today.</p>
                            <p class="text-muted small">This popup will close automatically...</p>
                        </div>
                    `);
                    
                    // Close modal after 2 seconds
                    setTimeout(function() {
                        $('#attendancePopupModal').modal('hide');
                        // Refresh page to update dashboard
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }, 2000);
                } else {
                    // Show error in the popup instead of alert
                    $('#attendancePopupContent').html(`
                        <div class="text-center py-4">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-exclamation-circle text-warning fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-warning mb-3">Check-in Issue</h5>
                            <p class="text-muted">${response.message || 'Failed to check in. Please try again.'}</p>
                            <button type="button" class="btn btn-primary" onclick="location.reload()">
                                <i class="fas fa-redo me-2"></i>Try Again
                            </button>
                        </div>
                    `);
                }
            })
            .fail(function(xhr) {
                console.log('Check-in failed:', xhr.responseText);
                var errorMessage = 'Failed to check in. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        // If JSON parsing fails, use the response text
                        if (xhr.responseText.length < 200) {
                            errorMessage = xhr.responseText;
                        }
                    }
                }
                
                // Show error in the popup instead of alert
                $('#attendancePopupContent').html(`
                    <div class="text-center py-4">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-4 d-inline-block mb-3">
                            <i class="fas fa-exclamation-triangle text-danger fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-danger mb-3">Check-in Failed</h5>
                        <p class="text-muted">${errorMessage}</p>
                        <button type="button" class="btn btn-primary" onclick="location.reload()">
                            <i class="fas fa-redo me-2"></i>Try Again
                        </button>
                    </div>
                `);
            });
    });

    // Prevent modal from closing with escape key or backdrop click
    $('#attendancePopupModal').on('hide.bs.modal', function(e) {
        if (!$(e.target).hasClass('btn-close') && !$(e.target).hasClass('btn')) {
            e.preventDefault();
            return false;
        }
    });
    
})(jQuery);
</script>
