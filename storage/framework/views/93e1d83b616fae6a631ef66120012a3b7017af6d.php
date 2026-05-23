<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    
   
    
    <body class="font-sans antialiased">
    <script>
        // Set the session lifetime in milliseconds (1 minute * 60 seconds * 1000 milliseconds)
        const sessionLifetime = 540 * 60 * 1000;
        let sessionTimeout;

        function startSessionTimer() {
            clearTimeout(sessionTimeout);
            sessionTimeout = setTimeout(function() {
                // Perform logout action when session expires
                logout();
            }, sessionLifetime);
        }

        // Start the session timer on page load
        window.onload = startSessionTimer;

        // Restart the session timer on user activity
        document.onmousemove = startSessionTimer;
        document.onkeypress = startSessionTimer;

        // Function to logout the user
        function logout() {
            fetch('<?php echo e(route('logout')); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            }).then(response => {
                // Redirect to login page after logout
                window.location.href = '<?php echo e(route('login')); ?>';
            }).catch(error => {
                console.error('Logout error:', error);
            });
        }
    </script>
  
    
        <div class="min-h-screen bg-gray-100">
            <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>

        // Include the attendance-popup modal
        <?php echo $__env->make('partials.attendance-popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
<?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/layouts/app.blade.php ENDPATH**/ ?>