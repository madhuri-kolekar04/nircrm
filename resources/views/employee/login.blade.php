<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NIRCRM - Employee Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }

        input, textarea {
            -webkit-user-select: text;
            user-select: text;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .mobile-app {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .app-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .app-header h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 5px;
        }

        .app-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }

        .app-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            background: #f8f9fa;
        }

        .auth-tabs {
            display: flex;
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .auth-tab {
            flex: 1;
            padding: 15px;
            background: transparent;
            border: none;
            color: #636e72;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .auth-form {
            display: none;
            animation: fadeInUp 0.4s ease-out;
        }

        .auth-form.active {
            display: block;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 16px;
            background: white;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #636e72;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #636e72;
            cursor: pointer;
            padding: 5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .checkbox-input {
            width: 20px;
            height: 20px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-input:checked {
            background: #667eea;
            border-color: #667eea;
        }

        .checkbox-label {
            font-size: 14px;
            color: #636e72;
            cursor: pointer;
            user-select: none;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn.loading {
            opacity: 0.8;
            pointer-events: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        .submit-btn.loading .spinner {
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .biometric-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
            border: 2px dashed #e9ecef;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .biometric-section:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .biometric-icon {
            font-size: 32px;
            color: #667eea;
            margin-bottom: 8px;
            display: block;
        }

        .biometric-text {
            font-size: 14px;
            color: #636e72;
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            border: none;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fee 0%, #fdd 100%);
            color: #c33;
            border-left: 4px solid #c33;
        }

        .app-footer {
            background: white;
            padding: 15px;
            text-align: center;
            flex-shrink: 0;
            border-top: 1px solid #e9ecef;
        }

        .footer-text {
            font-size: 12px;
            color: #636e72;
            margin: 0;
        }

        .footer-version {
            font-size: 11px;
            color: #b0b0b0;
            margin-top: 5px;
        }

        /* Large screens (tablets and desktops) */
        @media (min-width: 768px) {
            .mobile-app {
                max-width: 480px;
                height: auto;
                max-height: 90vh;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                margin: 20px;
                overflow: hidden;
            }

            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                padding: 20px;
            }
        }

        /* Small phones */
        @media (max-width: 360px) {
            .app-header {
                padding: 15px;
            }

            .app-header h1 {
                font-size: 20px;
            }

            .app-content {
                padding: 15px;
            }

            .form-input {
                padding: 12px;
                font-size: 16px;
            }

            .submit-btn {
                padding: 14px;
                font-size: 15px;
            }

            .auth-tab {
                padding: 12px;
                font-size: 13px;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .submit-btn:hover {
                transform: none;
            }

            .auth-tab:hover {
                transform: none;
            }

            .biometric-section:hover {
                transform: none;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .mobile-app {
                background: #1a1a1a;
            }

            .app-content {
                background: #2a2a2a;
            }

            .auth-tabs {
                background: #2a2a2a;
            }

            .form-input {
                background: #333333;
                color: white;
                border-color: #444444;
            }

            .app-footer {
                background: #2a2a2a;
                border-color: #444444;
            }

            .biometric-section {
                background: #2a2a2a;
                border-color: #444444;
            }
        }

        /* Safe area insets */
        @supports (padding: max(0px)) {
            .mobile-app {
                padding-left: max(0px, env(safe-area-inset-left));
                padding-right: max(0px, env(safe-area-inset-right));
                padding-bottom: max(0px, env(safe-area-inset-bottom));
            }
        }
    </style>
</head>
<body>
    <div class="mobile-app">
        <!-- App Header -->
        <div class="app-header">
            <h1>Employee Portal</h1>
            <p>NIRCRM Task Management System</p>
        </div>

        <!-- App Content -->
        <div class="app-content">
            <!-- Tab Navigation -->
            <div class="auth-tabs">
                <button type="button" class="auth-tab active" onclick="switchTab('login')">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </button>
                <button type="button" class="auth-tab" onclick="switchTab('register')">
                    <i class="bi bi-person-plus"></i>
                    <span>Register</span>
                </button>
            </div>

            <!-- Login Form -->
            <div id="login-form" class="auth-form active">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Biometric Authentication -->
                <div class="biometric-section" onclick="initiateBiometricAuth()">
                    <i class="bi bi-fingerprint biometric-icon"></i>
                    <span class="biometric-text">Sign in with biometrics</span>
                </div>

                <form action="{{ route('employee.login') }}" method="POST" id="loginForm">
                    @csrf
                    <!-- Hidden field to track login origin -->
                    <input type="hidden" name="login_origin" value="employee_portal">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i>
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   name="email" 
                                   class="form-input" 
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   required>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-lock"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   name="password" 
                                   class="form-input" 
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   id="password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="bi bi-eye" id="password-toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" 
                               name="remember" 
                               class="checkbox-input"
                               id="remember">
                        <label for="remember" class="checkbox-label">
                            Stay logged in for 30 days
                        </label>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="loginBtn">
                        <div class="spinner"></div>
                        <span class="btn-text">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Sign In
                        </span>
                    </button>
                </form>
            </div>

            <!-- Registration Form -->
            <div id="register-form" class="auth-form">
                @if ($errors->has('registration'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ $errors->first('registration') }}
                    </div>
                @endif

                <form action="{{ route('employee.register') }}" method="POST" id="registerForm">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-person"></i>
                            Full Name
                        </label>
                        <div class="input-wrapper">
                            <input type="text" 
                                   name="name" 
                                   class="form-input" 
                                   placeholder="Enter your full name"
                                   value="{{ old('name') }}"
                                   autocomplete="name"
                                   required>
                            <i class="bi bi-person input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-envelope"></i>
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <input type="email" 
                                   name="email" 
                                   class="form-input" 
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}"
                                   autocomplete="email"
                                   required>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-lock"></i>
                            Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   name="password" 
                                   class="form-input" 
                                   placeholder="Create a password"
                                   autocomplete="new-password"
                                   id="reg_password"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('reg_password')">
                                <i class="bi bi-eye" id="reg_password-toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-lock-fill"></i>
                            Confirm Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-input" 
                                   placeholder="Confirm your password"
                                   autocomplete="new-password"
                                   id="reg_password_confirmation"
                                   required>
                            <button type="button" class="password-toggle" onclick="togglePassword('reg_password_confirmation')">
                                <i class="bi bi-eye" id="reg_password_confirmation-toggle-icon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="bi bi-shield"></i>
                            Role
                        </label>
                        <div class="input-wrapper">
                            <select name="role" class="form-input" required>
                                <option value="">Select your role</option>
                                <option value="Employee">Employee</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <i class="bi bi-shield input-icon"></i>
                        </div>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" 
                               name="remember" 
                               class="checkbox-input"
                               id="reg_remember">
                        <label for="reg_remember" class="checkbox-label">
                            Stay logged in for 30 days
                        </label>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="registerBtn">
                        <div class="spinner"></div>
                        <span class="btn-text">
                            <i class="bi bi-person-plus"></i>
                            Create Account
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- App Footer -->
        <div class="app-footer">
            <p class="footer-text">&copy; 2024 NIRCRM. All rights reserved.</p>
            <p class="footer-version">Version 2.0 | Mobile Optimized</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile App JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we need to clear splash flag (after logout)
            @if(session('clearSplash'))
                sessionStorage.removeItem('nircrm_splash_seen');
                console.log('Splash flag cleared after logout');
            @endif
            
            // Haptic feedback for touch devices
            if ('vibrate' in navigator) {
                document.addEventListener('touchstart', function(e) {
                    if (e.target.closest('.submit-btn, .auth-tab, .password-toggle, .biometric-section')) {
                        navigator.vibrate(10);
                    }
                });
            }

            // Android viewport fixes
            if (/Android/i.test(navigator.userAgent)) {
                const setViewportHeight = () => {
                    const vh = window.innerHeight * 0.01;
                    document.documentElement.style.setProperty('--vh', `${vh}px`);
                };
                
                setViewportHeight();
                window.addEventListener('resize', setViewportHeight);
                window.addEventListener('orientationchange', setViewportHeight);
                
                // Prevent zoom on input focus
                document.querySelectorAll('input, select, textarea').forEach(element => {
                    element.addEventListener('focus', function() {
                        document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
                    });
                    
                    element.addEventListener('blur', function() {
                        document.querySelector('meta[name="viewport"]').setAttribute('content', 'width=device-width, initial-scale=1.0, user-scalable=no');
                    });
                });
            }

            // Form submission handlers
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                const btn = document.getElementById('loginBtn');
                btn.classList.add('loading');
                btn.disabled = true;
            });

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const btn = document.getElementById('registerBtn');
                btn.classList.add('loading');
                btn.disabled = true;
            });

            // Swipe gestures for tab switching
            let touchStartX = 0;
            let touchEndX = 0;
            
            const appContent = document.querySelector('.app-content');
            
            appContent.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });
            
            appContent.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });
            
            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - go to register
                        if (document.getElementById('login-form').classList.contains('active')) {
                            switchTab('register');
                        }
                    } else {
                        // Swipe right - go to login
                        if (document.getElementById('register-form').classList.contains('active')) {
                            switchTab('login');
                        }
                    }
                }
            }

            // Password strength indicator
            document.getElementById('reg_password').addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                
                const colors = ['#ff4444', '#ff8800', '#ffcc00', '#00c851'];
                this.style.borderColor = password.length > 0 ? colors[strength - 1] || colors[0] : '#e9ecef';
            });

            // Input validation feedback
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.checkValidity()) {
                        this.style.borderColor = '#28a745';
                    } else {
                        this.style.borderColor = '#e9ecef';
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    const activeForm = document.querySelector('.auth-form.active form');
                    if (activeForm) {
                        activeForm.dispatchEvent(new Event('submit'));
                    }
                }
            });

            // Offline detection
            window.addEventListener('online', function() {
                showNotification('Connection restored', 'success');
            });
            
            window.addEventListener('offline', function() {
                showNotification('No internet connection', 'warning');
            });
        });

        function switchTab(tab) {
            // Remove active class from all tabs and forms
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
            
            // Add active class to selected tab and form
            if (tab === 'login') {
                document.querySelector('.auth-tab:first-child').classList.add('active');
                document.getElementById('login-form').classList.add('active');
                
                // Focus email field
                setTimeout(() => {
                    document.querySelector('#login-form input[name="email"]').focus();
                }, 300);
            } else {
                document.querySelector('.auth-tab:last-child').classList.add('active');
                document.getElementById('register-form').classList.add('active');
                
                // Focus name field
                setTimeout(() => {
                    document.querySelector('#register-form input[name="name"]').focus();
                }, 300);
            }
            
            // Clear alerts and reset loading states
            document.querySelectorAll('.alert').forEach(alert => alert.remove());
            document.querySelectorAll('.submit-btn').forEach(btn => {
                btn.classList.remove('loading');
                btn.disabled = false;
            });
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-toggle-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
            
            // Haptic feedback
            if ('vibrate' in navigator) {
                navigator.vibrate(5);
            }
        }

        async function initiateBiometricAuth() {
            const biometricSection = document.querySelector('.biometric-section');
            
            // Add loading state
            biometricSection.innerHTML = '<i class="bi bi-arrow-repeat biometric-icon" style="animation: spin 1s linear infinite;"></i><span class="biometric-text">Authenticating...</span>';
            biometricSection.style.pointerEvents = 'none';
            
            try {
                // First, get biometric challenge from server
                const challengeResponse = await fetch('/biometric/challenge', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const challengeData = await challengeResponse.json();
                
                if (challengeData.error) {
                    showError(challengeData.error);
                    resetBiometricPrompt();
                    return;
                }
                
                // Check if user has existing biometric credentials
                if (challengeData.credentials && challengeData.credentials.length > 0) {
                    // User has existing credentials - authenticate
                    await performBiometricAuthentication(challengeData);
                } else {
                    // User needs to register new biometric
                    showBiometricRegistration();
                }
                
            } catch (error) {
                console.error('Biometric authentication error:', error);
                showError('Biometric authentication failed');
                resetBiometricPrompt();
            }
        }

        async function performBiometricAuthentication(challengeData) {
            try {
                const credential = await navigator.credentials.get({
                    publicKey: {
                        challenge: Uint8Array.from(atob(challengeData.challenge), c => c.charCodeAt(0)),
                        allowCredentials: challengeData.allowCredentials,
                        userVerification: 'required',
                        timeout: 60000
                    }
                });
                
                // Send authentication data to server
                const authResponse = await fetch('/biometric/authenticate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        credential_id: credential.id,
                        authenticator_data: btoa(String.fromCharCode(...new Uint8Array(credential.response.authenticatorData))),
                        signature: btoa(String.fromCharCode(...new Uint8Array(credential.response.signature))),
                        client_data: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON)))
                    })
                });
                
                const authResult = await authResponse.json();
                
                if (authResult.success) {
                    const biometricSection = document.querySelector('.biometric-section');
                    biometricSection.innerHTML = '<i class="bi bi-check-circle biometric-icon" style="color: #28a745;"></i><span class="biometric-text">Authentication successful!</span>';
                    setTimeout(() => {
                        window.location.href = authResult.redirect;
                    }, 1000);
                } else {
                    showError(authResult.error || 'Authentication failed');
                    resetBiometricPrompt();
                }
                
            } catch (error) {
                console.error('Authentication error:', error);
                showError('Biometric authentication cancelled or failed');
                resetBiometricPrompt();
            }
        }

        function showBiometricRegistration() {
            const biometricSection = document.querySelector('.biometric-section');
            biometricSection.innerHTML = `
                <div style="text-align: center; padding: 10px;">
                    <i class="bi bi-person-plus biometric-icon" style="color: #667eea; font-size: 24px;"></i>
                    <p style="margin: 10px 0; color: #636e72; font-size: 14px;">No biometric credentials found</p>
                    <p style="margin: 5px 0; color: #636e72; font-size: 12px;">Please login normally first, then you can register biometric in your profile.</p>
                </div>
            `;
            
            setTimeout(() => {
                resetBiometricPrompt();
            }, 3000);
        }

        function showError(message) {
            // Remove existing alerts
            document.querySelectorAll('.alert').forEach(alert => alert.remove());
            
            // Create new error alert
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            errorDiv.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${message}`;
            
            // Insert before the biometric section
            const biometricSection = document.querySelector('.biometric-section');
            biometricSection.parentNode.insertBefore(errorDiv, biometricSection);
        }

        function resetBiometricPrompt() {
            const biometricSection = document.querySelector('.biometric-section');
            biometricSection.innerHTML = '<i class="bi bi-fingerprint biometric-icon"></i><span class="biometric-text">Sign in with biometrics</span>';
            biometricSection.style.pointerEvents = 'auto';
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
            notification.style.zIndex = '9999';
            notification.innerHTML = `<i class="bi bi-info-circle"></i> ${message}`;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</body>
</html>
