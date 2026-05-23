

<?php $__env->startSection('page-title', 'Invoice Update - ' . $project->project_name); ?>
<?php $__env->startSection('admin'); ?>




<div class="d-flex justify-content-center align-items-center">

 <div style="width: 70%;">
    
<div class="card bg-primary bg-gradient text-white ">
            <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="card-title mb-2">
                                Monthly Reporting
                            </h3>
                            
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="<?php echo e(route('project-updates.show', $project->id)); ?>" class="btn btn-light">
                                <i class="fas fa-arrow-left"></i>  Invoice Details
                            </a>
                        </div>
                    </div>
             </div>
</div>



    <div class="card-body">
        <form action="<?php echo e(route('monthly-report.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">

             <div class="mb-3">
                <label>Report Title</label>
                <input type="text"name="title" class="form-control">
            </div>

            <div class="mb-3">
                <label>Select Month</label>
                <input type="month" name="month" class="form-control">
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="5"></textarea>
            </div>

             <div class="mb-3">
                <label>Upload Attachment</label>
                <input type="file" name="attachment" class="form-control">
            </div>

            <button type="submit" class="btn btn-success"> Submit Report </button>


        </form>
    </div>
</div>

</div>


<form class="main-class">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="project_id" value="<?php echo e($project->id); ?>">
</form>



<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.admin_master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/project_updates/monthly_reporting.blade.php ENDPATH**/ ?>