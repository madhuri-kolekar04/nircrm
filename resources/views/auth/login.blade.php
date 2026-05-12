
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niranjan Enterprises - Help Desk Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-container {
            display: flex;
            height: 100vh;
        }
        
        .banner-section {
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
        
        .banner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff20" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,133.3C960,128,1056,96,1152,90.7C1248,85,1344,107,1392,117.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .banner-content {
            text-align: center;
            z-index: 1;
            padding: 2rem;
        }
        
        .banner-logo {
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
        
        .banner-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .banner-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        .login-section {
            flex: 1;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
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
        
        @media (max-width: 768px) {
            .banner-section {
                display: none;
            }
            
            .login-section {
                flex: 1;
            }
        }
        
        /* Celebration Animation */
        @keyframes celebration {
            0% {
                transform: scale(0) rotate(0deg);
                opacity: 0;
            }
            25% {
                transform: scale(1.3) rotate(90deg);
                opacity: 1;
            }
            50% {
                transform: scale(1.1) rotate(180deg);
                opacity: 1;
            }
            75% {
                transform: scale(1.2) rotate(270deg);
                opacity: 1;
            }
            100% {
                transform: scale(1) rotate(360deg);
                opacity: 1;
            }
        }
        
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
        
        .celebration-logo {
            animation: celebration 2s ease-out;
        }
        
        .confetti {
            position: fixed;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            z-index: 9999;
            pointer-events: none;
        }
        
        .confetti-fall {
            animation: confetti-fall 2s ease-out forwards;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #f9ca24, #f0932b);
        }
        
        .confetti-rise {
            animation: confetti-rise 2s ease-out forwards;
            background: linear-gradient(45deg, #a8e6cf, #ffd93d, #6bcf7f, #ff6b9d, #c06bff);
        }
        
        /* Confetti falling from top */
        .confetti:nth-child(1) { left: 5%; animation-delay: 0s; }
        .confetti:nth-child(2) { left: 15%; animation-delay: 0.1s; }
        .confetti:nth-child(3) { left: 25%; animation-delay: 0.2s; }
        .confetti:nth-child(4) { left: 35%; animation-delay: 0.3s; }
        .confetti:nth-child(5) { left: 45%; animation-delay: 0.4s; }
        .confetti:nth-child(6) { left: 55%; animation-delay: 0.5s; }
        .confetti:nth-child(7) { left: 65%; animation-delay: 0.6s; }
        .confetti:nth-child(8) { left: 75%; animation-delay: 0.7s; }
        .confetti:nth-child(9) { left: 85%; animation-delay: 0.8s; }
        .confetti:nth-child(10) { left: 95%; animation-delay: 0.9s; }
        
        /* Confetti rising from bottom */
        .confetti:nth-child(11) { left: 10%; animation-delay: 0.05s; }
        .confetti:nth-child(12) { left: 20%; animation-delay: 0.15s; }
        .confetti:nth-child(13) { left: 30%; animation-delay: 0.25s; }
        .confetti:nth-child(14) { left: 40%; animation-delay: 0.35s; }
        .confetti:nth-child(15) { left: 50%; animation-delay: 0.45s; }
        .confetti:nth-child(16) { left: 60%; animation-delay: 0.55s; }
        .confetti:nth-child(17) { left: 70%; animation-delay: 0.65s; }
        .confetti:nth-child(18) { left: 80%; animation-delay: 0.75s; }
        .confetti:nth-child(19) { left: 90%; animation-delay: 0.85s; }
        
        /* Sparkle effects */
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
        
        .sparkle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            animation: sparkle 1.5s ease-out forwards;
            z-index: 10000;
            pointer-events: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }
        
        .sparkle:nth-child(20) { top: 20%; left: 15%; animation-delay: 0.2s; }
        .sparkle:nth-child(21) { top: 30%; left: 85%; animation-delay: 0.4s; }
        .sparkle:nth-child(22) { top: 60%; left: 25%; animation-delay: 0.6s; }
        .sparkle:nth-child(23) { top: 40%; left: 75%; animation-delay: 0.8s; }
        .sparkle:nth-child(24) { top: 70%; left: 60%; animation-delay: 1.0s; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes slideInUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
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
    
    <div class="login-container">
        <!-- Banner Section -->
        <div class="banner-section">
            <div class="banner-content">
                <div class="banner-logo celebration-logo">
                    <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                </div>
                <h1 class="banner-title">Welcome to Niranjan Enterprises</h1>
                <p class="banner-subtitle">Help Desk Support System</p>
                <div class="mt-4">
                    <i class="fas fa-ticket-alt fa-3x mb-3"></i>
                    <p class="lead">Streamline your support process</p>
                </div>
            </div>
        </div>
        
        <!-- Login Section -->
        <div class="login-section">
            <div class="login-form-container">
                <div class="login-header">
                    <div class="login-logo">
                        <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                    <h2 class="login-title">Sign In</h2>
                    <p class="login-subtitle">Enter your credentials to access your account</p>
                </div>
                
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <!-- Hidden field to track login origin -->
                    <input type="hidden" name="login_origin" value="employee_portal">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
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
        // Trigger celebration animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add floating animation to icons
            const icons = document.querySelectorAll('.fa-ticket-alt, .fa-sign-in-alt');
            icons.forEach(icon => {
                icon.classList.add('floating');
            });
            
            // Clean up confetti after animation (2 seconds + small buffer)
            setTimeout(() => {
                const confettiElements = document.querySelectorAll('.confetti');
                confettiElements.forEach(confetti => {
                    confetti.style.display = 'none';
                });
            }, 2500);
            
            // Clean up sparkles after animation
            setTimeout(() => {
                const sparkleElements = document.querySelectorAll('.sparkle');
                sparkleElements.forEach(sparkle => {
                    sparkle.style.display = 'none';
                });
            }, 2000);
            
            // Remove celebration class from logo after animation
            setTimeout(() => {
                const logo = document.querySelector('.celebration-logo');
                if (logo) {
                    logo.classList.remove('celebration-logo');
                }
            }, 2000);
        });
        
        // Trigger celebration on page refresh
        window.addEventListener('beforeunload', function() {
            // Reset animations for next load
            const logo = document.querySelector('.banner-logo');
            if (logo) {
                logo.classList.add('celebration-logo');
            }
        });
    </script>
</body>
</html>
















