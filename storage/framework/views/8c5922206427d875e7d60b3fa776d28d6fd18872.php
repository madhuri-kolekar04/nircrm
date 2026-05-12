<?php
$prefix = Request::route() ? Request::route()->getPrefix() : '';
$route = Route::current() ? Route::current()->getName() : '';

// Get visible menus for current user's role
$visibleMenus = getVisibleMenusForCurrentUser();
?>

<!-- Dynamic Menu Based on User Role Permissions -->
<?php $__currentLoopData = $visibleMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(url($menu['url'])); ?>" class="menu-item <?php echo e(($prefix == '/' . $menu['url'] || $route == str_replace('/', '.', $menu['url']))? 'active':''); ?>">
        <i class="<?php echo e($menu['icon']); ?>"></i>
        <span><?php echo e($menu['name']); ?></span>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Logout Menu Item -->
<a href="#" onclick="document.getElementById('logoutForm').submit(); return false;" class="menu-item logout-menu-item" style="color: #dc3545 !important; border-left-color: #dc3544 !important; background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%) !important; margin-top: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1rem;">
    <i class="fas fa-sign-out-alt" style="color: #dc3544 !important;"></i>
    <span>Logout</span>
</a>
<?php /**PATH /home/u314035009/domains/talktonitesh.com/public_html/nircrm/resources/views/admin/body/sidebar.blade.php ENDPATH**/ ?>