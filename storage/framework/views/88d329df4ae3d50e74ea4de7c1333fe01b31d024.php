


<!-- MODAL -->
<div class="modal fade" id="attendancePopupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0 bg-primary text-white">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-clock me-2"></i>Attendance Required
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="attendancePopupContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary"></div>
                        <p class="mt-3 text-muted">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button"
                        class="btn btn-primary btn-lg"
                        id="quickCheckInBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Check In Now
                </button>
            </div>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
(function ($) {
    'use strict';

    console.log("Attendance script loaded");

    // =========================
    // 1. OPEN MODAL EVENT
    // =========================
    $('#attendancePopupModal').on('shown.bs.modal', function () {
        window.loadAttendance();
    });

    // =========================
    // 2. MAIN LOAD FUNCTION
    // =========================
    window.loadAttendance = function () {

        console.log("Loading attendance...");

        $('#attendancePopupContent').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3 text-muted">Checking your attendance status...</p>
            </div>
        `);

        $('#quickCheckInBtn').show();

        $.get('/attendance/check-status')
            .done(function (response) {

                console.log("API Response:", response);

                if (response.show_attendance && !response.already_checked_in) {
                    renderAttendanceUI(response);
                } else {
                    $('#attendancePopupContent').html(`
                        <div class="text-center py-4">
                            <div class="rounded-circle bg-success bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-check text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-success">Already Marked</h5>
                        </div>
                    `);

                    $('#quickCheckInBtn').hide();
                }
            })
            .fail(function (err) {

                console.log("API Error:", err);

                $('#attendancePopupContent').html(`
                    <div class="text-center py-4">
                        <h5 class="text-danger">Failed to load attendance</h5>
                    </div>
                `);
            });
    };

    // =========================
    // 3. RENDER UI
    // =========================
    function renderAttendanceUI(data) {

        $('#attendancePopupContent').html(`
            <div class="text-center">

                <div class="mb-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-4 d-inline-block">
                        <i class="fas fa-clock text-primary fs-1"></i>
                    </div>
                </div>

                <h5 class="fw-bold">
                    Welcome, ${data.user_name ?? 'User'}
                </h5>

                <p class="text-muted">Please mark your attendance</p>

                <div class="row mt-3">

                    <div class="col-md-6">
                        <p><b>Shift:</b> ${data.shift_name}</p>
                        <p><b>Time:</b> ${data.shift_time}</p>
                    </div>

                    <div class="col-md-6">
                        <p>
                            <b>Status:</b>
                            <span class="badge bg-${data.is_on_time ? 'success' : 'warning'}">
                                ${data.status_message}
                            </span>
                        </p>

                        <p><b>Now:</b> ${new Date().toLocaleTimeString()}</p>
                    </div>

                </div>

            </div>
        `);
    }

    // =========================
    // 4. CHECK-IN ACTION
    // =========================
    $('#quickCheckInBtn').on('click', function () {

        var btn = $(this);

        btn.prop('disabled', true).html(`
            <i class="fas fa-spinner fa-spin me-2"></i>Checking In...
        `);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('/attendance/check-in', { location: 'Office' })
            .done(function (response) {

                if (response.success) {

                    $('#attendancePopupContent').html(`
                        <div class="text-center py-4">
                            <div class="rounded-circle bg-success bg-opacity-10 p-4 d-inline-block mb-3">
                                <i class="fas fa-check text-success fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-success">Check-in Successful!</h5>
                        </div>
                    `);

                    setTimeout(function () {
                        $('#attendancePopupModal').modal('hide');
                        location.reload();
                    }, 2000);
                } else {
                    btn.prop('disabled', false).html(`
                        <i class="fas fa-sign-in-alt me-2"></i>Check In Now
                    `);
                }
            })
            .fail(function () {

                btn.prop('disabled', false).html(`
                    <i class="fas fa-sign-in-alt me-2"></i>Check In Now
                `);

                alert("Check-in failed");
            });
    });

})(jQuery);
</script><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/partials/attendance-popup-new.blade.php ENDPATH**/ ?>