

<?php $__env->startSection('page-title', 'Monthly report'); ?>

<?php $__env->startSection('admin'); ?>

<div class="d-flex justify-content-center align-items-center">

    <div style="width: 90%;">

        <!-- Header Card -->
        <div class="card bg-primary bg-gradient text-white mb-4">
            <div class="card-body">
                <div class="row align-items-center">

                    <div class="col-md-8">
                        <h3 class="card-title mb-2">
                            Monthly Reporting
                        </h3>
                    </div>

                    <div class="col-md-4 text-end">
                        <a href="<?php echo e(route('project-updates.show', $project->id)); ?>"
                           class="btn btn-light">

                            <i class="fas fa-arrow-left"></i>
                            Invoice Details
                        </a>
                    </div>

                </div>
            </div>
        </div>

       

        <!-- Filter + Report Table -->
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">Past Reports</h5>
            </div>

            <div class="card-body">

                <!-- Filter Form -->
                <form method="GET" class="row mb-4">

                    <div class="col-md-4">
                        <label>Filter by Month</label>

                        <input type="month"
                               name="month"
                               value="<?php echo e(request('month')); ?>"
                               class="form-control">
                    </div> 

                    <div class="col-md-4 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-primary me-2">

                            Filter
                        </button>

                        <a href="<?php echo e(route('monthly-report.details', $project->id)); ?>"
                           class="btn btn-secondary me-2">

                            Reset
                        </a>

                        <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#addReportModal">
                            Add  Report
                        </button>

                    </div>

                </form>

                <!-- Reports Table -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-dark">

                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Month</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                <tr>

                                    <td><?php echo e($loop->iteration); ?></td>

                                    <td><?php echo e($report->title); ?></td>

                                    <td><?php echo e($report->month); ?></td>

                                    <td><?php echo e($report->description); ?></td>


                                    <td>
                                        <?php echo e($report->created_at->format('d M Y')); ?>

                                    </td>
                                    <td>
                                        <a href="#"
                                           class="btn btn-sm btn-warning editReportBtn" data-title="<?php echo e($report->title); ?>" data-url="<?php echo e(route('monthly-report.update', $report->id)); ?>"
                                           data-month="<?php echo e($report->month); ?>" data-description="<?php echo e($report->description); ?>" data-id="<?php echo e($report->id); ?>"
                                           data-bs-toggle="modal" data-bs-target="#editReportModal">
                                           <i class="fa fa-pencil"></i> </a>

                                        <form action="<?php echo e(route('monthly-report.destroy', $report->id)); ?>" method="post" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>

                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you Sure you want to delete this report?')"><i class="fa fa-trash"></i></button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-info viewReportBtn" data-title="<?php echo e($report->title); ?>"
                                        data-month="<?php echo e($report->month); ?>"
                                        data-description="<?php echo e($report->description); ?>"
                                        data-created="<?php echo e($report->created_at->format('d M Y')); ?>"
                                        data-attachment="<?php echo e($report->attachment); ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewReportModal"><i class="fa fa-eye"></i></button>

                                        <a href="<?php echo e(route('monthly-report.sendMail', $report->id)); ?>" class="btn btn-sm btn-primary"
                                        onclick="return confirm('Send report to customer email?')">
                                        <i class="fa fa-envelope"></i></a>
                                                                                
                                    </td>

                                   

                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <tr>

                                    <td colspan="7" class="text-center">
                                        No reports found
                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- new report form -->
<div class="modal fade" id="addReportModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Add Monthly Report</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <form action="<?php echo e(route('monthly-report.store')); ?>" method="POST" enctype="multipart/form-data">

                <?php echo csrf_field(); ?>

                <div class="modal-body">

                    <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">

                    <div class="mb-3">

                        <label>Report Title</label>

                        <input type="text" name="title" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Select Month</label>

                        <input type="month" name="month" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label>Description</label>

                        <textarea name="description"  class="form-control"  rows="5" required></textarea>

                    </div>

                    <div class="mb-3">

                        <label>Upload Attachment</label>

                        <input type="file" name="attachment" class="form-control">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> Close</button>

                    <button type="submit"  class="btn btn-success"> Submit Report</button>

                </div>

            </form>

        </div>

    </div>

</div>




<!-- edit form -->

<div class="modal fade" id="editReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Edit Monthly Report
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>


            <form id="editReportForm" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('put'); ?>

                <div class="modal-body">
                    <div class="mb-3">

                       <label>Report Title</label>
                       <input type="text" name="title" id="edit_title" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>select Month</label>
                        <input type="month" name="month" id="edit_month" class="form-control" >
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="5" ></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Upload New Attachment</lable>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update Report</button>
                </div>
            </form>

        </div>

    </div>

</div>


<!-- view Report -->
 <div class="modal" id="viewReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Report</h5>
                <button class="btn-close" type="submit" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="fw-bold">Title</label>
                    <p id="view_title"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Month</label>
                    <p id="view_month"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Description</label>
                    <p id="view_description"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Created Date</label>
                    <p id="view_created"></p>
                </div>

                 <div class="mb-3">
                    <label class="fw-bold">Attachment</label>
                    <p id="view_attachment"></p>
                </div>
            </div>
        </div>
    </div>

 </div>





<script>
    document.addEventListener('DOMContentLoaded',function(){

       const editButtons= document.querySelectorAll('.editReportBtn');

         editButtons.forEach(button=>{

           button.addEventListener('click',function (){
                
              let url= this.getAttribute('data-url');
              let title= this.getAttribute('data-title');
              let month= this.getAttribute('data-month');
              let description= this.getAttribute('data-description');

              document.getElementById('edit_title').value= title;
              document.getElementById('edit_month').value= month;
              document.getElementById('edit_description').value = description;
              document.getElementById('editReportForm').action = url;
           });
         });
    });


// view



document.addEventListener('DOMContentLoaded', function () {

    const viewButtons = document.querySelectorAll('.viewReportBtn');

    viewButtons.forEach(button => {

        button.addEventListener('click', function () {

            let title = this.getAttribute('data-title');
            let month = this.getAttribute('data-month');
            let description = this.getAttribute('data-description');
            let created = this.getAttribute('data-created');
            let attachment = this.getAttribute('data-attachment');

            document.getElementById('view_title').innerText = title;
            document.getElementById('view_month').innerText = month;
            document.getElementById('view_description').innerText = description;
            document.getElementById('view_created').innerText = created;

          if (attachment && attachment !== "null" && attachment !== "") {

    document.getElementById('view_attachment').innerHTML =
        `<a href="/storage/${attachment}" target="_blank" class="btn btn-primary btn-sm">
            View Attachment
        </a>`;

} else {

    document.getElementById('view_attachment').innerHTML =
        `<span class="text-danger fw-bold">No Attachment Uploaded</span>`;
}
        });

    });

});



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/project_updates/monthly_reports_details.blade.php ENDPATH**/ ?>