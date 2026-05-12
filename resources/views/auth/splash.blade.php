<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading - Niranjan Enterprises</title>
    <link rel="icon" href="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }
        
        .splash-container {
            text-align: center;
            z-index: 10;
            position: relative;
        }
        
        .logo-container {
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }
        
        .logo {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }
        
        .logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }
        
        .logo.rotating {
            animation: rotate 2s linear infinite;
        }
        
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .company-name {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-top: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }
        
        .tagline {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            margin-top: 0.5rem;
            opacity: 0;
            animation: fadeInUp 1s ease-out 1s forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.1;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 0.3;
            }
        }
        
        .loading-bar {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            z-index: 10;
        }
        
        .loading-progress {
            height: 100%;
            background: linear-gradient(90deg, #ffffff, #667eea);
            border-radius: 2px;
            width: 0%;
            animation: loadingProgress 3s ease-out forwards;
        }
        
        @keyframes loadingProgress {
            to {
                width: 100%;
            }
        }
        
        .fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
            }
        }
    </style>
</head>
<body>
    <!-- Background Particles -->
    <div class="particles" id="particles"></div>
    
    <!-- Main Splash Content -->
    <div class="splash-container" id="splashContent">
        <div class="logo-container">
            <div class="logo" id="logo">
                <img src="https://niranjanenterprises.com/wp-content/uploads/2024/10/niranjan-enterprises-logo-300x92.webp" alt="Niranjan Enterprises Logo">
            </div>
        </div>
        
        <h1 class="company-name">Niranjan Enterprises</h1>
        <p class="tagline">Help Desk Management System</p>
    </div>
    
    <!-- Loading Bar -->
    <div class="loading-bar">
        <div class="loading-progress"></div>
    </div>
    
    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.width = Math.random() * 20 + 5 + 'px';
                particle.style.height = particle.style.width;
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (Math.random() * 3 + 3) + 's';
                particlesContainer.appendChild(particle);
            }
        }
        
        // Start logo rotation after 1 second
        function startLogoRotation() {
            setTimeout(() => {
                const logo = document.getElementById('logo');
                logo.classList.add('rotating');
            }, 1000);
        }
        
        // Redirect to login after 3 seconds
        function redirectToLogin() {
            setTimeout(() => {
                const splashContent = document.getElementById('splashContent');
                splashContent.classList.add('fade-out');
                
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}';
                }, 500);
            }, 3000);
        }
        
        // Initialize splash screen
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            startLogoRotation();
            redirectToLogin();
        });
    </script>
</body>
</html>
