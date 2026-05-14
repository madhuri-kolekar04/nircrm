<?php if($paginator->hasPages()): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&laquo;</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($page); ?></span></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&raquo;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
        
        
        <div class="text-center mt-2">
            <small class="text-muted">
                Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> of <?php echo e($paginator->total()); ?> results
            </small>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /home/u314035009/domains/talktonitesh.com/public_html/nircrm/resources/views/vendor/pagination/custom.blade.php ENDPATH**/ ?>