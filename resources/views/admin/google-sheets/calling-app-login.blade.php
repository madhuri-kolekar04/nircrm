<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Calling App Login - Lead Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --primary-dark: #5a67d8;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --danger-color: #f56565;
            --warning-color: #ed8936;
            --info-color: #4299e1;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --bg-primary: #ffffff;
            --bg-secondary: #f7fafc;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1), 0 6px 10px rgba(0, 0, 0, 0.08);
            --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.15), 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-primary);
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -200px;
            right: -200px;
            animation: float 20s ease-in-out infinite;
        }

        .bg-animation::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 15s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-container {
            background: var(--bg-primary);
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            width: 100%;
            max-width: 480px;
            padding: 40px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .logo-container::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .logo-container i {
            font-size: 2rem;
            color: white;
            z-index: 1;
        }

        .login-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-input::placeholder {
            color: var(--text-secondary);
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.1rem;
            z-index: 1;
        }

        .input-group .form-input {
            padding-left: 48px;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 1;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .form-checkbox label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            cursor: pointer;
            user-select: none;
        }

        .login-button {
            width: 100%;
            padding: 14px 24px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            top: 0;
            left: -100%;
            transition: left 0.5s ease;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .login-button.loading {
            color: transparent;
        }

        .login-button.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid white;
            border-top: 2px solid transparent;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(72, 187, 120, 0.2);
        }

        .alert-danger {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(245, 101, 101, 0.2);
        }

        .role-info {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .role-info h4 {
            color: var(--primary-color);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .role-info p {
            color: var(--text-secondary);
            font-size: 0.75rem;
            line-height: 1.5;
            margin: 0;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--primary-color);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 8px;
        }

        .footer-info {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .footer-info p {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin: 0;
        }

        .footer-info a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-info a:hover {
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 640px) {
            body {
                padding: 16px;
                min-height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            /* Handle keyboard viewport changes - allow manual scrolling */
            body.keyboard-open {
                /* overflow: hidden; - Removed to allow manual scrolling */
            }

            .login-container {
                padding: 32px 24px;
                border-radius: 16px;
                margin-bottom: 20vh;
            }

            .login-title {
                font-size: 1.5rem;
            }

            /* Mobile input focus handling */
            .form-input:focus {
                transform: translateY(-2px);
            }

            /* Ensure password field is visible on mobile */
            #password:focus {
                scroll-margin-top: 100px;
            }

            .login-subtitle {
                font-size: 0.875rem;
            }

            .form-input {
                padding: 12px 14px;
                font-size: 0.9rem;
            }

            .input-group .form-input {
                padding-left: 44px;
            }

            .input-icon {
                left: 14px;
                font-size: 1rem;
            }

            .password-toggle {
                right: 14px;
                font-size: 1rem;
            }

            .login-button {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 24px 20px;
            }

            .logo-container {
                width: 60px;
                height: 60px;
            }

            .logo-container i {
                font-size: 1.5rem;
            }

            .login-title {
                font-size: 1.25rem;
            }
        }

        /* Error states */
        .form-group.has-error .form-input {
            border-color: var(--danger-color);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.75rem;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Success animation */
        @keyframes success-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .login-container.success {
            animation: success-pulse 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="login-container">
        <div class="login-header">
            <div class="logo-container">
                <i class="fas fa-phone-alt"></i>
            </div>
            <h1 class="login-title">Calling App</h1>
            <p class="login-subtitle">Lead Management System</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Role Information -->
        <div class="role-info">
            <h4>
                <i class="fas fa-info-circle"></i>
                Access Information
            </h4>
            <p>This system is restricted to authorized personnel only. Valid login credentials are required for access.</p>
            <div class="role-badge">
                <i class="fas fa-shield-alt"></i>
                Admin & Employee Access
            </div>
        </div>

        <form method="POST" action="{{ route('callingapp.login.post') }}" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-input @error('email') has-error @enderror" 
                           placeholder="Enter your email address"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           autofocus>
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-input @error('password') has-error @enderror" 
                           placeholder="Enter your password"
                           required
                           autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-checkbox">
                <input type="checkbox" id="remember" name="remember" value="1">
                <label for="remember">Remember me for 30 days</label>
            </div>

            <button type="submit" class="login-button" id="loginButton">
                <span id="buttonText">Sign In to Calling App</span>
            </button>
        </form>

        <div class="footer-info">
            <p>
                Secure Login System • 
                <a href="#" onclick="showHelp()">Need Help?</a> • 
                <a href="#" onclick="showSecurityInfo()">Security Info</a>
            </p>
            <p style="margin-top: 8px;">
                © {{ date('Y') }} Calling App Lead Management System
            </p>
        </div>
    </div>

    <script>
        // Password visibility toggle
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'fas fa-eye';
            }
        }

        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginButton');
            const buttonText = document.getElementById('buttonText');
            
            // Show loading state
            button.classList.add('loading');
            button.disabled = true;
            
            // Reset loading state after 10 seconds (fallback)
            setTimeout(() => {
                button.classList.remove('loading');
                button.disabled = false;
            }, 10000);
        });

        // Help function
        function showHelp() {
            alert('If you need assistance accessing the Calling App:\n\n' +
                  '1. Ensure you have valid login credentials\n' +
                  '2. Only Admin and Employee roles can access this system\n' +
                  '3. Contact your system administrator for password reset\n' +
                  '4. Check that your account is active and not locked');
        }

        // Security info function
        function showSecurityInfo() {
            alert('Security Features:\n\n' +
                  '• Encrypted login transmission\n' +
                  '• Session timeout protection\n' +
                  '• Role-based access control\n' +
                  '• Automatic logout on inactivity\n' +
                  '• Secure password storage\n\n' +
                  'For security concerns, contact your IT department.');
        }

        // Auto-focus on email field
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
            
            // Mobile keyboard detection and scroll handling
            let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                // Handle input focus on mobile - auto-scroll to focused field
                const inputs = document.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        setTimeout(() => {
                            this.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 300);
                    });
                    
                    // Also handle input events to keep field visible while typing
                    input.addEventListener('input', function() {
                        setTimeout(() => {
                            this.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 100);
                    });
                });
            }
            
            // Add enter key support for form fields
            const inputs = document.querySelectorAll('input');
            inputs.forEach((input, index) => {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        } else {
                            document.getElementById('loginForm').submit();
                        }
                    }
                });
            });
        });

        // Add success animation when redirected with success message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.querySelector('.login-container');
                container.classList.add('success');
            });
        @endif
    </script>
</body>
</html>
