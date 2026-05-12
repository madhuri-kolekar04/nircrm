<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - <?php echo e(Auth::user()->name); ?></title>
    <link rel="icon" href="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .splash-container {
            text-align: center;
            z-index: 10;
            position: relative;
        }

        .profile-image-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            object-fit: cover;
            animation: profileImageAnimation 3s ease-in-out;
        }

        .welcome-text {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1s forwards;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            margin-top: 1rem;
            font-size: 0.9rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1.5s forwards;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Confetti Animation - Same as login page */
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                transform: translateY(-80vh) rotate(72deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg) scale(1);
                opacity: 0;
            }
        }

        @keyframes confetti-rise {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                transform: translateY(80vh) rotate(-72deg) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) rotate(-720deg) scale(1);
                opacity: 0;
            }
        }

        @keyframes sparkle {
            0%, 100% {
                transform: scale(0) rotate(0deg);
                opacity: 0;
            }
            50% {
                transform: scale(1) rotate(180deg);
                opacity: 1;
            }
        }

        @keyframes profileImageAnimation {
            0% {
                transform: scale(0) rotate(0deg);
                opacity: 0;
                border-radius: 50%;
            }
            25% {
                transform: scale(1.2) rotate(90deg);
                opacity: 0.8;
                border-radius: 40%;
            }
            50% {
                transform: scale(1.1) rotate(180deg);
                opacity: 1;
                border-radius: 45%;
            }
            75% {
                transform: scale(1.15) rotate(270deg);
                opacity: 1;
                border-radius: 48%;
            }
            100% {
                transform: scale(1) rotate(360deg);
                opacity: 1;
                border-radius: 50%;
            }
        }

        @keyframes fadeInUp {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .confetti {
            position: fixed;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            z-index: 5;
            pointer-events: none;
        }

        .confetti-fall {
            animation: confetti-fall 3s ease-out forwards;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24, #f0932b);
        }

        .confetti-rise {
            animation: confetti-rise 3s ease-out forwards;
            background: linear-gradient(45deg, #a8e6cf, #ffd93d, #6bcf7f, #ff6b9d, #c06bff);
        }

        .sparkle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            animation: sparkle 2s ease-out forwards;
            z-index: 15;
            pointer-events: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        /* Confetti positioning */
        .confetti:nth-child(1) { left: 5%; animation-delay: 0s; }
        .confetti:nth-child(2) { left: 15%; animation-delay: 0.2s; }
        .confetti:nth-child(3) { left: 25%; animation-delay: 0.4s; }
        .confetti:nth-child(4) { left: 35%; animation-delay: 0.6s; }
        .confetti:nth-child(5) { left: 45%; animation-delay: 0.8s; }
        .confetti:nth-child(6) { left: 55%; animation-delay: 1s; }
        .confetti:nth-child(7) { left: 65%; animation-delay: 1.2s; }
        .confetti:nth-child(8) { left: 75%; animation-delay: 1.4s; }
        .confetti:nth-child(9) { left: 85%; animation-delay: 1.6s; }
        .confetti:nth-child(10) { left: 95%; animation-delay: 1.8s; }

        .confetti:nth-child(11) { left: 10%; animation-delay: 0.1s; }
        .confetti:nth-child(12) { left: 20%; animation-delay: 0.3s; }
        .confetti:nth-child(13) { left: 30%; animation-delay: 0.5s; }
        .confetti:nth-child(14) { left: 40%; animation-delay: 0.7s; }
        .confetti:nth-child(15) { left: 50%; animation-delay: 0.9s; }
        .confetti:nth-child(16) { left: 60%; animation-delay: 1.1s; }
        .confetti:nth-child(17) { left: 70%; animation-delay: 1.3s; }
        .confetti:nth-child(18) { left: 80%; animation-delay: 1.5s; }
        .confetti:nth-child(19) { left: 90%; animation-delay: 1.7s; }

        .sparkle:nth-child(20) { top: 20%; left: 15%; animation-delay: 0.3s; }
        .sparkle:nth-child(21) { top: 30%; left: 85%; animation-delay: 0.6s; }
        .sparkle:nth-child(22) { top: 60%; left: 25%; animation-delay: 0.9s; }
        .sparkle:nth-child(23) { top: 40%; left: 75%; animation-delay: 1.2s; }
        .sparkle:nth-child(24) { top: 70%; left: 60%; animation-delay: 1.5s; }

        .loading-indicator {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 2s forwards;
        }

        .loading-dots {
            display: inline-block;
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <!-- Confetti Elements - Falling from top -->
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    <div class="confetti confetti-fall"></div>
    
    <!-- Confetti Elements - Rising from bottom -->
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    <div class="confetti confetti-rise"></div>
    
    <!-- Sparkle Effects -->
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>
    <div class="sparkle"></div>

    <div class="splash-container">
        <div class="profile-image-wrapper">
            <img src="<?php echo e((!empty(Auth::user()->profile_photo_path)) ? url('upload/admin_images/' . Auth::user()->profile_photo_path) : url('upload/no_image.jpg')); ?>" 
                 alt="<?php echo e(Auth::user()->name); ?>" 
                 class="profile-image">
        </div>
        
        <h1 class="welcome-text">Welcome Back, <?php echo e(Auth::user()->name); ?>!</h1>
        <p class="subtitle">Glad to see you again</p>
        
        <div class="role-badge">
            <?php echo e(Auth::user()->role_name ?? 'User'); ?>

        </div>
        
        <div class="loading-indicator">
            Redirecting to dashboard<span class="loading-dots">...</span>
        </div>
    </div>

    <script>
        // Auto-redirect after 3 seconds
        setTimeout(function() {
            // Get the intended redirect URL from session or default
            const intendedUrl = '<?php echo e(session()->get('url.intended', route('attendance.dashboard'))); ?>';
            window.location.href = intendedUrl;
        }, 3000);

        // Clean up animations after they complete
        setTimeout(function() {
            const confettiElements = document.querySelectorAll('.confetti');
            confettiElements.forEach(confetti => {
                confetti.style.display = 'none';
            });
            
            const sparkleElements = document.querySelectorAll('.sparkle');
            sparkleElements.forEach(sparkle => {
                sparkle.style.display = 'none';
            });
        }, 3500);
    </script>
</body>
</html>
<?php /**PATH /home/u314035009/domains/talktonitesh.com/public_html/nircrm/resources/views/auth/profile-splash.blade.php ENDPATH**/ ?>