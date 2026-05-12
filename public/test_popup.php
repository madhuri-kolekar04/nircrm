<!DOCTYPE html>
<html>
<head>
    <title>Attendance Popup Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h2>Attendance Popup Test</h2>
        <p>This page simulates the attendance popup that should appear after login.</p>
        
        <button type="button" class="btn btn-primary" onclick="showTestPopup()">
            <i class="fas fa-clock me-2"></i>Show Attendance Popup
        </button>
    </div>

    <!-- Attendance Popup Modal -->
    <div class="modal fade" id="attendancePopupModal" tabindex="-1" role="dialog">
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
                            <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-clock text-primary fs-1"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-3">Welcome, Test User!</h5>
                        <p class="text-muted mb-4">Please mark your attendance for today</p>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Shift:</strong> Morning Shift</p>
                                <p class="mb-2"><strong>Shift Time:</strong> 09:00 - 18:00</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Status:</strong> <span class="badge bg-success">On Time</span></p>
                                <p class="mb-2"><strong>Current Time:</strong> <span id="currentTime"></span></p>
                            </div>
                        </div>
                        
                        <div class="alert alert-success">
                            <i class="fas fa-info-circle me-2"></i>
                            Click "Check In Now" to record your attendance for today.
                        </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showTestPopup() {
            $('#attendancePopupModal').modal('show');
        }
        
        // Update current time
        function updateCurrentTime() {
            document.getElementById('currentTime').textContent = new Date().toLocaleTimeString();
        }
        
        setInterval(updateCurrentTime, 1000);
        updateCurrentTime();
        
        // Show popup automatically after page load
        $(document).ready(function() {
            setTimeout(function() {
                showTestPopup();
            }, 1000);
        });
        
        // Quick check-in button
        $('#quickCheckInBtn').click(function() {
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Checking In...');
            
            // Simulate API call
            setTimeout(function() {
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
                }, 2000);
            }, 1500);
        });
    </script>
</body>
</html>
