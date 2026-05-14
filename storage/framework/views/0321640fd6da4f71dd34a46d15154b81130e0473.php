<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIRCRM - Customer Relationship Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
            background: #000;
        }

        /* Flash Screen Styles */
        .flash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        .flash-screen.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .flash-logo {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            padding: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }

        .flash-title {
            font-size: 3rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: slideInDown 1s ease-out;
        }

        .flash-subtitle {
            font-size: 1.5rem;
            color: rgba(255,255,255,0.9);
            animation: slideInUp 1s ease-out;
        }

        .loading-bar {
            width: 200px;
            height: 4px;
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
            margin-top: 2rem;
            overflow: hidden;
        }

        .loading-progress {
            height: 100%;
            background: white;
            border-radius: 2px;
            animation: loading 2s ease-out forwards;
        }

        /* Login Container Styles */
        .login-container {
            display: flex;
            height: 100vh;
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }

        .login-container.show {
            opacity: 1;
        }

        .left-section {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff20" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,133.3C960,128,1056,96,1152,90.7C1248,85,1344,107,1392,117.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .company-info {
            text-align: center;
            z-index: 1;
            padding: 2rem;
        }

        .company-logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 50%;
            padding: 15px;
            margin: 0 auto 2rem auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .company-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .company-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
        }

        .features-list li {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .features-list i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        .right-section {
            flex: 1;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-form-container {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            animation: slideInUp 0.8s ease-out;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            padding: 15px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 1.5rem;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes loading {
            from {
                width: 0%;
            }
            to {
                width: 100%;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .left-section {
                display: none;
            }
            
            .right-section {
                flex: 1;
            }

            .flash-title {
                font-size: 2rem;
            }

            .flash-subtitle {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Flash Screen -->
    <div class="flash-screen" id="flashScreen">
        <div class="flash-logo">
            <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
        </div>
        <h1 class="flash-title">NIRCRM</h1>
        <p class="flash-subtitle">Customer Relationship Management</p>
        <div class="loading-bar">
            <div class="loading-progress"></div>
        </div>
    </div>

    <!-- Login Container -->
    <div class="login-container" id="loginContainer">
        <!-- Left Section - Niranjan Enterprises Details -->
        <div class="left-section">
            <div class="company-info">
                <div class="company-logo floating">
                    <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                </div>
                <h1 class="company-title">Niranjan Enterprises</h1>
                <p class="company-subtitle">Complete Business Solution Provider</p>
                
                <ul class="features-list">
                    <li><i class="fas fa-users"></i> Customer Management</li>
                    <li><i class="fas fa-headset"></i> Help Desk Support</li>
                    <li><i class="fas fa-chart-line"></i> Sales Tracking</li>
                    <li><i class="fas fa-tasks"></i> Task Management</li>
                    <li><i class="fas fa-file-invoice"></i> Invoice System</li>
                </ul>
                
                <div class="mt-4">
                    <p class="lead mb-0">Empowering Business Growth</p>
                    <small>Since 2010</small>
                </div>
            </div>
        </div>
        
        <!-- Right Section - NIRCRM Login -->
        <div class="right-section">
            <div class="login-form-container">
                <div class="login-header">
                    <div class="login-logo">
                        <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="NIRCRM Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <h2 class="login-title">NIRCRM Login</h2>
                    <p class="login-subtitle">Enter your credentials to access the system</p>
                </div>
                
                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>
                    <!-- Hidden field to track login origin -->
                    <input type="hidden" name="login_origin" value="crmlogin">
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="<?php echo e(old('email')); ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        © 2026 Niranjan Enterprises. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Flash screen and login transition
        document.addEventListener('DOMContentLoaded', function() {
            const flashScreen = document.getElementById('flashScreen');
            const loginContainer = document.getElementById('loginContainer');
            
            // Check if we need to clear the splash flag (after logout)
            <?php if(session('clearSplash')): ?>
                sessionStorage.removeItem('nircrm_splash_seen');
                console.log('Splash flag cleared after logout');
            <?php endif; ?>
            
            // Check if this is first visit (no session storage flag)
            const hasSeenSplash = sessionStorage.getItem('nircrm_splash_seen');
            
            if (!hasSeenSplash) {
                // Show splash screen for first-time visitors
                sessionStorage.setItem('nircrm_splash_seen', 'true');
                
                // Hide flash screen and show login after 3 seconds
                setTimeout(function() {
                    flashScreen.classList.add('fade-out');
                    loginContainer.classList.add('show');
                    
                    // Remove flash screen from DOM after fade out
                    setTimeout(function() {
                        flashScreen.style.display = 'none';
                    }, 500);
                }, 3000);
            } else {
                // Hide splash screen immediately for returning visitors
                flashScreen.style.display = 'none';
                loginContainer.classList.add('show');
            }
            
            // Add floating animation to icons
            const icons = document.querySelectorAll('.fa-users, .fa-headset, .fa-chart-line, .fa-tasks, .fa-file-invoice');
            icons.forEach(icon => {
                icon.classList.add('floating');
            });
        });
        
        // Clear splash flag when user successfully logs out
        window.addEventListener('beforeunload', function() {
            // Only clear if navigating away from login page (not during login attempts)
            if (window.location.pathname === '/crmlogin') {
                // Don't clear the flag on normal page refresh of login page
                // The flag will be cleared when user explicitly logs out
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Nilesh\Desktop\nircrm 12-5-26\resources\views/crmlogin.blade.php ENDPATH**/ ?>