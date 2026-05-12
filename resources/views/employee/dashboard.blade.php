<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Dashboard - NIRCRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            /* Premium Color System */
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;
            --primary-300: #7dd3fc;
            --primary-400: #38bdf8;
            --primary-500: #0ea5e9;
            --primary-600: #0284c7;
            --primary-700: #0369a1;
            --primary-800: #075985;
            --primary-900: #0c4a6e;
            
            --accent: #f97316;
            --accent-light: #fb923c;
            --accent-dark: #ea580c;
            --accent-50: #fff7ed;
            --accent-100: #ffedd5;
            --accent-200: #fed7aa;
            --accent-300: #fdba74;
            --accent-400: #fb923c;
            --accent-500: #f97316;
            --accent-600: #ea580c;
            --accent-700: #c2410c;
            --accent-800: #9a3412;
            --accent-900: #7c2d12;
            
            --success: #10b981;
            --success-light: #34d399;
            --success-dark: #059669;
            --success-50: #ecfdf5;
            --success-100: #d1fae5;
            --success-200: #a7f3d0;
            --success-300: #6ee7b7;
            --success-400: #34d399;
            --success-500: #10b981;
            --success-600: #059669;
            --success-700: #047857;
            --success-800: #065f46;
            --success-900: #064e3b;
            
            --warning: #f59e0b;
            --warning-light: #fbbf24;
            --warning-dark: #d97706;
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-200: #fde68a;
            --warning-300: #fcd34d;
            --warning-400: #fbbf24;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --warning-700: #b45309;
            --warning-800: #92400e;
            --warning-900: #78350f;
            
            --danger: #ef4444;
            --danger-light: #f87171;
            --danger-dark: #dc2626;
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-200: #fecaca;
            --danger-300: #fca5a5;
            --danger-400: #f87171;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --danger-700: #b91c1c;
            --danger-800: #991b1b;
            --danger-900: #7f1d1d;
            
            --info: #3b82f6;
            --info-light: #60a5fa;
            --info-dark: #2563eb;
            --info-50: #eff6ff;
            --info-100: #dbeafe;
            --info-200: #bfdbfe;
            --info-300: #93c5fd;
            --info-400: #60a5fa;
            --info-500: #3b82f6;
            --info-600: #2563eb;
            --info-700: #1d4ed8;
            --info-800: #1e40af;
            --info-900: #1e3a8a;
            
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
            
            --white: #ffffff;
            --black: #000000;
            
            /* Premium Shadows */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-3xl: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
            --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
            
            /* Premium Gradients */
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #4f46e5 50%, #3730a3 100%);
            --gradient-accent: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #c2410c 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
            --gradient-info: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            --gradient-hero: linear-gradient(135deg, #6366f1 0%, #8b5cf6 25%, #ec4899 50%, #f97316 75%, #f59e0b 100%);
            --gradient-background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #f0f9ff 50%, #ecfdf5 75%, #fff7ed 100%);
            --gradient-glass: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            
            /* Premium Transitions */
            --transition-fast: 100ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-bounce: 600ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Reset and Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
            -moz-text-size-adjust: 100%;
            text-size-adjust: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: clamp(0.875rem, 2vw, 1rem);
            font-weight: 400;
            line-height: 1.6;
            color: var(--neutral-800);
            background: var(--gradient-background);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Premium Mobile Header */
        .mobile-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all var(--transition-normal);
        }

        .mobile-header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-2xl);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: clamp(0.75rem, 2vw, 1rem);
            gap: 1rem;
            position: relative;
        }
        
        .header-content::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .mobile-menu-btn {
            display: flex;
            flex-direction: column;
            gap: 4px;
            background: var(--gradient-glass);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 10px;
            cursor: pointer;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .mobile-menu-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-primary);
            transition: left var(--transition-normal);
            opacity: 0.1;
        }

        .mobile-menu-btn:hover::before {
            left: 0;
        }

        .mobile-menu-btn:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-md);
        }

        .mobile-menu-btn:active {
            transform: scale(0.95);
        }

        .mobile-menu-btn span {
            width: 24px;
            height: 2px;
            background: var(--neutral-700);
            border-radius: 2px;
            transition: all var(--transition-bounce);
            position: relative;
            z-index: 1;
        }

        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
            background: var(--primary-600);
        }

        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
            transform: scale(0);
        }

        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
            background: var(--primary-600);
        }

        .user-info-mobile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar-mobile {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.125rem;
            flex-shrink: 0;
            position: relative;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-md);
        }
        
        .user-avatar-mobile::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 50%;
            background: var(--gradient-primary);
            z-index: -1;
            opacity: 0.3;
            animation: pulse 2s infinite;
        }
        
        .user-avatar-mobile:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .user-details-mobile {
            flex: 1;
            min-width: 0;
        }

        .user-name-mobile {
            font-size: clamp(0.875rem, 2vw, 1rem);
            font-weight: 700;
            color: var(--neutral-900);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: -0.025em;
        }

        .user-email-mobile {
            font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            color: var(--neutral-500);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-weight: 500;
        }

        .logout-btn-mobile {
            background: var(--gradient-danger);
            color: var(--white);
            border: none;
            padding: 0.625rem 1.125rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }
        
        .logout-btn-mobile::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left var(--transition-normal);
        }
        
        .logout-btn-mobile:hover::before {
            left: 0;
        }

        .logout-btn-mobile:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: var(--shadow-lg);
        }
        
        .logout-btn-mobile:active {
            transform: translateY(0) scale(0.98);
        }
        
        /* Simple Mobile Alert Popup - Fixed */
        .simple-alert {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.5);
        }
        
        .simple-alert.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .alert-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        
        .alert-content {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-2xl);
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 1px solid var(--border-color);
            position: relative;
            z-index: 10;
            opacity: 0;
            transition: all 0.3s ease-out;
        }
        
        .simple-alert.show .alert-content {
            opacity: 1;
        }
        
        /* Force alert content visibility */
        .simple-alert.show .alert-backdrop,
        .simple-alert.show .alert-content,
        .simple-alert.show .alert-icon,
        .simple-alert.show .alert-message,
        .simple-alert.show .alert-actions {
            display: block;
            visibility: visible;
            opacity: 1;
        }
        
        .alert-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        
        .alert-content {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-2xl);
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 1px solid var(--border-color);
            position: relative;
            z-index: 10;
        }
        
        .alert-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-danger);
            border-radius: 50%;
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            box-shadow: var(--shadow-lg);
        }
        
        .alert-message h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--neutral-900);
            margin: 0 0 0.5rem 0;
        }
        
        .alert-message p {
            font-size: 1rem;
            color: var(--neutral-500);
            margin: 0 0 1.5rem 0;
        }
        
        .alert-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn-cancel {
            background: var(--neutral-100);
            color: var(--neutral-700);
            border: 1px solid var(--neutral-200);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .btn-cancel:hover {
            background: var(--neutral-200);
            transform: translateY(-1px);
        }
        
        .btn-logout {
            background: var(--gradient-danger);
            color: var(--white);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }
        
        /* Mobile Responsive Alert */
        @media (max-width: 768px) {
            .alert-content {
                width: 95%;
                max-width: 350px;
                padding: 1.5rem;
            }
            
            .alert-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }
            
            .alert-message h4 {
                font-size: 1.125rem;
            }
            
            .alert-message p {
                font-size: 0.875rem;
                margin: 0 0 1rem 0;
            }
            
            .alert-actions {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .btn-cancel, .btn-logout {
                width: 100%;
                padding: 0.875rem 1rem;
                font-size: 0.875rem;
            }
        }
        
        @media (max-width: 480px) {
            .alert-content {
                width: 98%;
                max-width: 320px;
                padding: 1.25rem;
            }
            
            .alert-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin-bottom: 0.75rem;
            }
            
            .alert-message h4 {
                font-size: 1rem;
            }
            
            .alert-message p {
                font-size: 0.75rem;
            }
            
            .btn-cancel, .btn-logout {
                padding: 0.75rem 0.875rem;
                font-size: 0.75rem;
            }
        }

        /* Premium Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 320px;
            height: 100vh;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-3xl);
            z-index: 999;
            transition: all var(--transition-bounce);
            overflow-y: auto;
        }

        .mobile-sidebar.active {
            left: 0;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all var(--transition-normal);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-header {
            padding: 2rem;
            background: var(--gradient-hero);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="sidebar-grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23sidebar-grid)"/></svg>');
            opacity: 0.3;
        }

        .sidebar-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav-item {
            display: block;
            padding: 1rem 2rem;
            color: var(--neutral-700);
            text-decoration: none;
            font-weight: 600;
            transition: all var(--transition-normal);
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-glass);
            transition: left var(--transition-normal);
            z-index: 0;
        }
        
        .sidebar-nav-item:hover::before {
            left: 0;
        }
        
        .sidebar-nav-item i {
            position: relative;
            z-index: 1;
            transition: all var(--transition-normal);
            font-size: 1.125rem;
        }
        
        .sidebar-nav-item span {
            position: relative;
            z-index: 1;
            transition: all var(--transition-normal);
        }

        .sidebar-nav-item:hover {
            background: var(--primary-50);
            color: var(--primary-600);
            border-left-color: var(--primary-500);
            transform: translateX(4px);
        }
        
        .sidebar-nav-item:hover i {
            transform: scale(1.1);
        }

        .sidebar-nav-item.active {
            background: linear-gradient(90deg, var(--primary-50) 0%, rgba(99, 102, 241, 0.1) 100%);
            color: var(--primary-700);
            border-left-color: var(--primary-600);
            font-weight: 700;
            transform: translateX(4px);
        }
        
        .sidebar-nav-item.active i {
            transform: scale(1.1);
        }

        /* Premium Main Container */
        .main-container {
            padding: clamp(1rem, 3vw, 2rem);
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Premium Welcome Section */
        .welcome-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: clamp(2rem, 4vw, 3rem);
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: clamp(2rem, 4vw, 3rem);
            position: relative;
            overflow: hidden;
            transition: all var(--transition-normal);
        }
        
        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-hero);
        }
        
        .welcome-section::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, var(--primary-200) 0%, transparent 70%);
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .welcome-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .welcome-text {
            flex: 1;
            min-width: 0;
        }

        .welcome-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            line-height: 1.1;
            letter-spacing: -0.05em;
        }

        .welcome-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: var(--neutral-600);
            margin: 0;
            font-weight: 500;
            line-height: 1.5;
        }

        .welcome-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Premium Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: clamp(1.25rem, 3vw, 2rem);
            margin-bottom: clamp(2.5rem, 5vw, 4rem);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: clamp(2rem, 4vw, 3rem);
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all var(--transition-bounce);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
        }
        
        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, var(--primary-200) 0%, transparent 70%);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .stat-card.success::before { background: var(--gradient-success); }
        .stat-card.warning::before { background: var(--gradient-warning); }
        .stat-card.danger::before { background: var(--gradient-danger); }
        .stat-card.info::before { background: var(--gradient-info); }
        
        .stat-card.success::after { background: radial-gradient(circle, var(--success-200) 0%, transparent 70%); }
        .stat-card.warning::after { background: radial-gradient(circle, var(--warning-200) 0%, transparent 70%); }
        .stat-card.danger::after { background: radial-gradient(circle, var(--danger-200) 0%, transparent 70%); }
        .stat-card.info::after { background: radial-gradient(circle, var(--info-200) 0%, transparent 70%); }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }
        
        .stat-card:hover::after {
            opacity: 0.3;
        }

        .stat-icon {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: var(--white);
            margin-bottom: 1.5rem;
            background: var(--gradient-primary);
            position: relative;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-icon::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 18px;
            background: var(--gradient-primary);
            opacity: 0.3;
            z-index: -1;
        }

        .stat-icon.success { background: var(--gradient-success); }
        .stat-icon.success::before { background: var(--gradient-success); }
        .stat-icon.warning { background: var(--gradient-warning); }
        .stat-icon.warning::before { background: var(--gradient-warning); }
        .stat-icon.danger { background: var(--gradient-danger); }
        .stat-icon.danger::before { background: var(--gradient-danger); }
        .stat-icon.info { background: var(--gradient-info); }
        .stat-icon.info::before { background: var(--gradient-info); }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-size: clamp(2.5rem, 5vw, 3rem);
            font-weight: 900;
            color: var(--neutral-900);
            line-height: 1;
            margin-bottom: 0.75rem;
            letter-spacing: -0.05em;
            transition: all var(--transition-normal);
        }
        
        .stat-card:hover .stat-value {
            transform: scale(1.05);
        }

        .stat-label {
            font-size: clamp(0.875rem, 2vw, 1rem);
            font-weight: 700;
            color: var(--neutral-500);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Premium Task Form Section */
        .task-form-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: clamp(2rem, 4vw, 3rem);
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: clamp(2.5rem, 5vw, 4rem);
            position: relative;
            overflow: hidden;
        }
        
        .task-form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-accent);
        }
        
        .task-form-section::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--accent-200) 0%, transparent 70%);
            opacity: 0.05;
            animation: float 8s ease-in-out infinite;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.05em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select, .form-textarea {
            font-size: 1rem;
            padding: 1rem 1.25rem;
            border: 2px solid var(--neutral-200);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: var(--neutral-900);
            transition: all var(--transition-normal);
            min-height: 56px;
            font-weight: 500;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            touch-action: manipulation;
            position: relative;
            z-index: 1;
        }

        .form-textarea {
            min-height: 140px;
            resize: vertical;
            cursor: text;
        }
        
        .form-control::placeholder, .form-select::placeholder, .form-textarea::placeholder {
            color: var(--neutral-500);
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-500);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2), var(--shadow-lg);
            transform: translateY(-1px);
            z-index: 10;
        }

        .form-control:hover, .form-select:hover, .form-textarea:hover {
            border-color: var(--primary-300);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }
        
        /* Fix for mobile select dropdown */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 3rem;
        }
        
        /* Mobile specific fixes */
        @media (max-width: 768px) {
            .form-control, .form-select, .form-textarea {
                min-height: 60px;
                font-size: 16px; /* Prevents zoom on iOS */
                padding: 1.125rem 1.25rem;
                touch-action: manipulation;
                -webkit-tap-highlight-color: transparent;
            }
            
            .form-textarea {
                min-height: 120px;
            }
            
            .form-select {
                padding-right: 3.5rem;
            }
        }
        
        /* Ensure labels don't block clicks */
        .form-label {
            pointer-events: none;
            position: relative;
            z-index: 2;
        }
        
        .form-group {
            position: relative;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--neutral-700);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition-bounce);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            min-height: 56px;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left var(--transition-normal);
        }
        
        .btn:hover::before {
            left: 0;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--gradient-warning);
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .btn-success {
            background: var(--gradient-success);
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .btn:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: var(--shadow-xl);
        }

        .btn:active {
            transform: translateY(-2px) scale(0.98);
        }
        
        .btn i {
            font-size: 1.125rem;
        }

        /* Task List Section */
        .task-list-section {
            background: var(--white);
            border-radius: 16px;
            padding: clamp(1.5rem, 3vw, 2rem);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--gray-200);
        }

        /* Task Cards */
        .task-card {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-200);
            border-bottom: 3px solid var(--primary-300);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-200);
        }

        .task-card:hover::before {
            opacity: 1;
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .task-number {
            background: var(--gradient-primary);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .task-date {
            font-size: 0.875rem;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .task-section {
            margin-bottom: 1rem;
        }

        .task-section strong {
            font-size: 0.875rem;
            color: var(--gray-700);
            display: block;
            margin-bottom: 0.25rem;
        }

        .task-section span {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .task-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .task-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            min-height: 40px;
        }

        .btn-edit {
            background: var(--gradient-info);
            color: var(--white);
        }

        .btn-delete {
            background: var(--gradient-danger);
            color: var(--white);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: var(--gradient-warning);
            color: var(--white);
        }

        .status-in_progress {
            background: var(--gradient-info);
            color: var(--white);
        }

        .status-completed {
            background: var(--gradient-success);
            color: var(--white);
        }

        .status-stopped {
            background: var(--gradient-danger);
            color: var(--white);
        }

        .status-on_hold {
            background: linear-gradient(135deg, var(--gray-600) 0%, var(--gray-700) 100%);
            color: var(--white);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--gray-50);
            border-radius: 16px;
            border: 1px solid var(--gray-200);
        }

        /* Date Group Headers */
        .date-group-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .date-group-header::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--neutral-200);
            z-index: 0;
        }
        
        .date-group-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            box-shadow: var(--shadow-sm);
            position: relative;
            z-index: 1;
        }
        
        .date-group-header.today .date-group-info {
            background: var(--gradient-success);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }
        
        .date-group-header.yesterday .date-group-info {
            background: var(--gradient-warning);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }
        
        .date-group-title {
            font-size: 1.125rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.025em;
        }
        
        .date-group-count {
            font-size: 0.875rem;
            font-weight: 600;
            opacity: 0.8;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
        }
        
        .date-group-header.today .date-group-count {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .date-group-header.yesterday .date-group-count {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .date-group-line {
            width: 60px;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
            position: relative;
            z-index: 1;
        }
        
        .date-group-header.today .date-group-line {
            background: var(--gradient-success);
        }
        
        .date-group-header.yesterday .date-group-line {
            background: var(--gradient-warning);
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--neutral-400);
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--neutral-900);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--neutral-500);
            margin: 0;
        }

        /* Loading State */
        .loading {
            display: none;
            text-align: center;
            padding: 3rem;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-200);
            border-top: 4px solid var(--primary-500);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Premium Responsive Design */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
            }
            
            .welcome-section {
                padding: clamp(1.5rem, 3vw, 2rem);
            }
            
            .task-form-section {
                padding: clamp(1.5rem, 3vw, 2rem);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
            
            .welcome-section {
                padding: clamp(1.25rem, 2.5vw, 2rem);
            }
            
            .welcome-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
            }

            .welcome-actions {
                width: 100%;
                justify-content: stretch;
            }

            .welcome-actions .btn {
                flex: 1;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .form-actions {
                justify-content: stretch;
            }

            .form-actions .btn {
                flex: 1;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .welcome-section {
                padding: 1.5rem;
            }
            
            .welcome-title {
                font-size: clamp(1.5rem, 3vw, 2rem);
            }
            
            .welcome-subtitle {
                font-size: 1rem;
            }
            
            .task-form-section {
                padding: 1.5rem;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .section-title {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .header-content {
                padding: 1rem;
            }

            .user-info-mobile {
                gap: 0.75rem;
            }

            .user-avatar-mobile {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .user-name-mobile {
                font-size: 0.875rem;
            }

            .user-email-mobile {
                font-size: 0.75rem;
            }

            .logout-btn-mobile {
                padding: 0.5rem 0.875rem;
                font-size: 0.75rem;
            }

            .mobile-sidebar {
                width: 100%;
                max-width: 320px;
            }

            .main-container {
                padding: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-icon {
                width: 56px;
                height: 56px;
                font-size: 1.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .stat-label {
                font-size: 0.875rem;
            }

            .task-form-section,
            .task-list-section {
                padding: 1.5rem;
            }
            
            .form-control, .form-select, .form-textarea {
                padding: 0.875rem 1rem;
                min-height: 52px;
            }
            
            .btn {
                padding: 0.875rem 1.5rem;
                min-height: 52px;
                font-size: 0.8rem;
            }
            
            .btn i {
                font-size: 1rem;
            }

            .task-card {
                padding: 1rem;
                margin-bottom: 1rem;
                border-radius: 16px;
            }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
                margin-bottom: 0.75rem;
            }

            .task-number {
                width: 100%;
                justify-content: space-between;
            }

            .task-date {
                font-size: 0.875rem;
                color: var(--neutral-600);
            }

            .number {
                font-weight: 700;
                color: var(--neutral-800);
            }

            .task-status {
                align-self: flex-start;
                padding: 0.5rem 0.75rem;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .task-body {
                margin-bottom: 0.75rem;
            }

            .task-description p {
                font-size: 0.9rem;
                line-height: 1.5;
                margin: 0;
            }

            .task-client {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.875rem;
                color: var(--neutral-600);
                margin-bottom: 0.75rem;
            }

            .task-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.5rem;
            }

            .task-time {
                font-size: 0.8rem;
                color: var(--neutral-500);
            }

            .task-actions {
                display: flex;
                gap: 0.5rem;
            }

            .btn-action {
                padding: 0.5rem 0.75rem;
                border-radius: 8px;
                font-size: 0.875rem;
                min-width: 44px; /* Touch friendly */
                min-height: 44px; /* Touch friendly */
            }

            .btn-edit {
                background: var(--info-100);
                color: var(--info-700);
                border: 1px solid var(--info-200);
            }

            .btn-edit:hover {
                background: var(--info-200);
            }

            .btn-delete {
                background: var(--danger-100);
                color: var(--danger-700);
                border: 1px solid var(--danger-200);
            }

            .btn-delete:hover {
                background: var(--danger-200);
            }
            
            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-icon {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .main-container {
                padding: 0.5rem;
                padding-bottom: 5rem; /* Space for bottom nav */
            }
            
            .welcome-section {
                padding: 1rem;
            }
            
            .task-card {
                padding: 0.75rem;
                margin-bottom: 0.75rem;
                border-radius: 12px;
                border: 1px solid var(--gray-200);
                border-bottom: 3px solid var(--primary-300);
            }
            
            .task-header {
                margin-bottom: 0.5rem;
            }
            
            .task-number {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .task-status {
                padding: 0.375rem 0.5rem;
                font-size: 0.625rem;
                border-radius: 12px;
            }
            
            .task-description p {
                font-size: 0.875rem;
                line-height: 1.4;
            }
            
            .task-client {
                font-size: 0.8rem;
                margin-bottom: 0.5rem;
            }
            
            .task-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
            
            .task-actions {
                width: 100%;
                justify-content: flex-end;
            }
            
            .btn-action {
                min-width: 48px;
                min-height: 48px;
                font-size: 0.8rem;
            }
            
            /* Force task visibility on small mobile */
            .task-group, .task-card {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                min-height: auto !important;
                height: auto !important;
            }
            
            .task-group {
                margin-bottom: 1rem !important;
            }
            
            .task-card {
                background: var(--gray-50) !important;
                border: 1px solid var(--gray-200) !important;
                border-bottom: 3px solid var(--primary-300) !important;
                border-radius: 12px !important;
                padding: 1rem !important;
            }
        }
            
            .stats-grid {
                gap: 1rem;
            }
            
            .stat-card {
                padding: 1.25rem;
            }
            
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }
            
            .stat-value {
                font-size: 1.75rem;
            }
            
            .task-form-section,
            .task-list-section {
                padding: 1.25rem;
            }
            
            #taskContainer {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
            
            /* Disable AOS animations on mobile to show tasks immediately */
            .task-group, .task-card {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            
            .task-group [data-aos], .task-card [data-aos] {
                opacity: 1 !important;
                transform: none !important;
            }
            
            .form-control, .form-select, .form-textarea {
                padding: 0.75rem 0.875rem;
                min-height: 48px;
            }
            
            .btn {
                padding: 0.75rem 1.25rem;
                min-height: 48px;
                font-size: 0.75rem;
            }
        }
        
        /* Mobile App Navigation Display */
        @media (max-width: 768px) {
            .bottom-nav {
                display: flex;
                justify-content: space-around;
            }
            
            .fab-main {
                display: flex;
            }
            
            .fab-menu {
                display: block;
            }
            
            /* Adjust main content for bottom nav */
            .main-container {
                padding-bottom: 5rem;
            }
        }
        
        @media (max-width: 576px) {
            .bottom-nav-item span {
                font-size: 0.7rem;
            }
            
            .bottom-nav-item i {
                font-size: 1.125rem;
            }
            
            .fab-main {
                width: 52px;
                height: 52px;
                right: 1rem;
                bottom: 1.5rem;
            }
            
            .fab-menu {
                right: 1rem;
                bottom: 2.25rem;
            }
            
            .fab-item {
                min-width: 160px;
                padding: 0.625rem 1.25rem;
            }
            
            .fab-item i {
                width: 36px;
                height: 36px;
                font-size: 0.875rem;
            }
            
            .fab-item span {
                font-size: 0.875rem;
            }
        }

        /* Premium Animations */
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

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(-50%, -50%) translateY(0);
            }
            50% {
                transform: translate(-50%, -50%) translateY(-10px);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        .task-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .welcome-section {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .task-form-section {
            animation: fadeInUp 0.9s ease-out;
        }
        
        .task-list-section {
            animation: fadeInUp 1s ease-out;
        }

        /* Premium Bottom Navigation Bar */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 0.5rem 0;
            padding-bottom: env(safe-area-inset-bottom, 0.5rem);
        }
        
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            color: var(--neutral-500);
            text-decoration: none;
            transition: all var(--transition-normal);
            position: relative;
            cursor: pointer;
            min-height: 60px;
        }
        
        .bottom-nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: var(--gradient-primary);
            border-radius: 2px;
            transition: width var(--transition-normal);
        }
        
        .bottom-nav-item.active::before {
            width: 30px;
        }
        
        .bottom-nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
            transition: all var(--transition-normal);
        }
        
        .bottom-nav-item span {
            font-size: 0.75rem;
            font-weight: 600;
            transition: all var(--transition-normal);
        }
        
        .bottom-nav-item.active {
            color: var(--primary-600);
        }
        
        .bottom-nav-item.active i {
            transform: scale(1.1);
        }
        
        .bottom-nav-item:hover {
            color: var(--primary-500);
        }
        
        .bottom-nav-item:hover i {
            transform: scale(1.15);
        }
        
        /* Premium Floating Action Button */
        .fab-main {
            display: none;
            position: fixed;
            bottom: 2rem;
            right: 1.5rem;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
            box-shadow: var(--shadow-2xl);
            cursor: pointer;
            transition: all var(--transition-bounce);
            z-index: 999;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .fab-main::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: 50%;
            background: var(--gradient-primary);
            opacity: 0.3;
            z-index: -1;
            animation: pulse 2s infinite;
        }
        
        .fab-main:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: var(--shadow-3xl);
        }
        
        .fab-main:active {
            transform: scale(0.95);
        }
        
        .fab-main.active {
            transform: rotate(45deg);
        }
        
        .fab-menu {
            display: none;
            position: fixed;
            bottom: 2.75rem;
            right: 1.5rem;
            z-index: 998;
        }
        
        .fab-item {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            background: var(--white);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            transition: all var(--transition-bounce);
            gap: 1rem;
            min-width: 180px;
            position: relative;
            overflow: hidden;
        }
        
        .fab-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-glass);
            transition: left var(--transition-normal);
        }
        
        .fab-item:hover::before {
            left: 0;
        }
        
        .fab-item i {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }
        
        .fab-item span {
            font-weight: 600;
            color: var(--neutral-700);
            position: relative;
            z-index: 1;
        }
        
        .fab-item:hover {
            transform: translateX(-5px);
            box-shadow: var(--shadow-xl);
        }
        
        .fab-item:hover i {
            transform: scale(1.1);
        }
        
        .fab-menu.show {
            animation: fabMenuShow 0.4s ease-out;
        }
        
        .fab-menu.hide {
            animation: fabMenuHide 0.3s ease-out;
        }
        
        @keyframes fabMenuShow {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fabMenuHide {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .btn, .mobile-menu-btn {
                min-height: 44px;
                min-width: 44px;
            }

            .stat-card:hover,
            .task-card:hover {
                transform: none;
            }

            .btn:hover {
                transform: none;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        
        /* Inline Filter Section Styles */
        .inline-filter-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 0;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: clamp(2rem, 4vw, 3rem);
            overflow: hidden;
            transition: all var(--transition-normal);
        }

        .filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: var(--gradient-primary);
            color: var(--white);
            cursor: pointer;
            user-select: none;
        }

        .filter-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-toggle {
            display: flex;
            align-items: center;
        }

        .toggle-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: var(--white);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-normal);
            font-size: 1.125rem;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .toggle-btn:active {
            transform: scale(0.95);
        }

        .filter-content {
            padding: 1.5rem;
            max-height: 500px;
            overflow-y: auto;
            transition: all var(--transition-bounce);
        }

        .filter-content.hidden {
            max-height: 0;
            padding: 0;
            overflow: hidden;
        }

        .filter-content.show {
            padding: 1.5rem;
            max-height: 500px;
            overflow-y: auto;
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group.full-width {
            grid-column: 1 / -1;
        }

        .filter-label {
            font-weight: 600;
            color: var(--neutral-700);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .filter-group .form-control {
            border: 2px solid var(--neutral-200);
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 0.875rem;
            transition: all var(--transition-normal);
        }

        .filter-group .form-control:focus {
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .status-checkboxes {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .status-checkbox-inline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all var(--transition-normal);
            background: var(--neutral-50);
        }

        .status-checkbox-inline:hover {
            background: var(--neutral-100);
            transform: translateY(-1px);
        }

        .status-checkbox-inline input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-600);
        }

        .status-label-inline {
            font-weight: 500;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            text-transform: capitalize;
        }

        .status-label-inline.pending {
            background: var(--warning-100);
            color: var(--warning-700);
        }

        .status-label-inline.in-progress {
            background: var(--info-100);
            color: var(--info-700);
        }

        .status-label-inline.completed {
            background: var(--success-100);
            color: var(--success-700);
        }

        .status-label-inline.stopped {
            background: var(--danger-100);
            color: var(--danger-700);
        }

        .status-label-inline.on-hold {
            background: var(--neutral-100);
            color: var(--neutral-700);
        }

        .filter-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 1rem;
            border-top: 1px solid var(--neutral-200);
        }

        .filter-actions .btn {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: all var(--transition-normal);
        }

        .filter-actions .btn-secondary {
            background: var(--neutral-200);
            color: var(--neutral-700);
            border: 1px solid var(--neutral-300);
        }

        .filter-actions .btn-secondary:hover {
            background: var(--neutral-300);
            transform: translateY(-1px);
        }

        .filter-actions .btn-primary {
            background: var(--gradient-primary);
            color: var(--white);
            border: none;
        }

        .filter-actions .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Mobile Responsive Inline Filter */
        @media (max-width: 768px) {
            .filter-header {
                padding: 1rem 1.25rem;
            }

            .filter-title {
                font-size: 1rem;
            }

            .toggle-btn {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .filter-content.show {
                padding: 1.25rem;
            }

            .filter-row {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-bottom: 1rem;
            }

            .status-checkboxes {
                flex-direction: column;
                gap: 0.5rem;
            }

            .filter-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .filter-actions .btn {
                width: 100%;
                padding: 0.875rem 1rem;
            }
        }

        @media (max-width: 480px) {
            .inline-filter-section {
                margin-bottom: 1.5rem;
                border-radius: 16px;
            }

            .filter-header {
                padding: 0.875rem 1rem;
            }

            .filter-title {
                font-size: 0.875rem;
            }

            .filter-content.show {
                padding: 1rem;
                max-height: 400px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header -->
    <header class="mobile-header">
        <div class="header-content">
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <div class="user-info-mobile">
                <div class="user-avatar-mobile">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="user-details-mobile">
                    <div class="user-name-mobile">{{ Auth::user()->name }}</div>
                    <div class="user-email-mobile">{{ Auth::user()->email }}</div>
                </div>
            </div>
            
            <button type="button" class="logout-btn-mobile" onclick="showLogoutAlert()" aria-label="Logout">
                <i class="bi bi-box-arrow-right"></i>
               
            </button>
        </div>
    </header>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">NIRCRM</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('employee.dashboard') }}" class="sidebar-nav-item active">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="bi bi-clipboard-data"></i>
                My Tasks
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="bi bi-graph-up"></i>
                Reports
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="bi bi-gear"></i>
                Settings
            </a>
        </nav>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Welcome Section -->
     

        <style>
        .stat-card {
    display: flex;
    flex-direction: column; /* 🔥 THIS MAKES IT VERTICAL */
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    background: #ffffff;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
}

/* Icon */
.stat-icon {
    width: 40px;
    height: 40px;
    margin-bottom: 8px; /* spacing below icon */
    border-radius: 10px;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

/* Text */
.stat-value {
    font-size: 18px;
    font-weight: 600;
}

.stat-label {
    font-size: 12px;
    color: #777;
}
        </style>
        <style>.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}

/* Tablet */
@media (max-width: 992px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* Mobile */
@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr); /* 🔥 2 per row */
    }
}</style>

        <!-- Statistics Cards -->
        <section class="stats-grid" aria-label="Task Statistics">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon success">
                    <i class="bi bi-clipboard-data"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalTasks ?? 0 }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
            </div>
            <div class="stat-card success" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $completedTasks ?? 0 }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
            <div class="stat-card warning" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon warning">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pendingTasks ?? 0 }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="stat-card info" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-icon info">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $inProgressTasks ?? 0 }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
            </div>
        </section>

        <!-- Task Form Section -->
        <section class="task-form-section" id="taskFormSection">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-plus-circle"></i>
                    <span>Create New Task</span>
                </h2>
            </div>
            
            <form id="taskForm">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="task_date" class="form-label">
                            <i class="bi bi-calendar"></i>
                            <span>Date & Time</span>
                        </label>
                        <input type="datetime-local" id="task_date" name="task_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="client_project_name" class="form-label">
                            <i class="bi bi-briefcase"></i>
                            <span>Client/Project Name</span>
                        </label>
                        <input type="text" id="client_project_name" name="client_project_name" class="form-control" placeholder="Enter client or project name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="task_description" class="form-label">
                        <i class="bi bi-text-paragraph"></i>
                        <span>Task Description</span>
                    </label>
                    <textarea id="task_description" name="task_description" class="form-textarea" placeholder="Describe your task in detail..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="bi bi-flag"></i>
                        <span>Status</span>
                    </label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="pending" selected>Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="stopped">Stopped</option>
                        <option value="on_hold">On Hold</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="resetTaskForm()">
                        <i class="bi bi-x-circle"></i>
                        <span>Clear</span>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i>
                        <span>Create Task</span>
                    </button>
                </div>
            </form>
        </section>
        
         <!-- Inline Filter Section -->
        <section class="inline-filter-section" id="inlineFilterSection">
            <div class="filter-header">
                <h3 class="filter-title">
                    <i class="bi bi-funnel"></i>
                    <span>Filter Tasks</span>
                </h3>
                <div class="filter-toggle">
                    <button type="button" class="toggle-btn" id="filterToggleBtn" onclick="toggleInlineFilter()">
                        <i class="bi bi-chevron-down" id="filterToggleIcon"></i>
                    </button>
                </div>
            </div>
            
            <div class="filter-content hidden" id="inlineFilterContent">
                <form id="inlineFilterForm">
                    @csrf
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-calendar me-1"></i>Date From
                            </label>
                            <input type="date" class="form-control" id="inline_date_from" name="date_from">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-calendar me-1"></i>Date To
                            </label>
                            <input type="date" class="form-control" id="inline_date_to" name="date_to">
                        </div>
                    </div>
                    
                    <div class="filter-row">
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-search me-1"></i>Search
                            </label>
                            <input type="text" class="form-control" id="inline_search" name="search" placeholder="Search tasks...">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">
                                <i class="bi bi-flag me-1"></i>Status
                            </label>
                            <select class="form-control" id="inline_status" name="status">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="stopped">Stopped</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="filter-actions">
                        <button type="button" class="btn btn-secondary" onclick="clearInlineFilters()">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear
                        </button>
                        <button type="button" class="btn btn-primary" onclick="applyInlineFilters()">
                            <i class="bi bi-check-circle me-1"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>
        </section>
        

        <!-- Task List Section -->
        <section class="task-list-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-clipboard-data"></i>
                    <span>My Tasks</span>
                </h2>
                <button type="button" class="btn btn-small btn-secondary" onclick="refreshTasks()">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh</span>
                </button>
            </div>
            
            <div id="taskContainer">
                @php
                    // Helper function to get date group label
                    function getDateGroupLabel($taskDate) {
                        $today = now()->startOfDay();
                        $task = \Carbon\Carbon::parse($taskDate)->startOfDay();
                        $yesterday = $today->copy()->subDay();
                        $daysDiff = $today->diffInDays($task);

                        if ($task->eq($today)) {
                            return 'Today';
                        } elseif ($task->eq($yesterday)) {
                            return 'Yesterday';
                                                } else {
                            // Return formatted date for older tasks (e.g., 17-4-2026)
                            return $task->format('d-m-Y');
                        }
                    }

                    // Group tasks by date
                    $groupedTasks = [];
                    if(isset($tasks)) {
                        foreach($tasks as $task) {
                            $dateLabel = getDateGroupLabel($task->task_date);
                            if (!isset($groupedTasks[$dateLabel])) {
                                $groupedTasks[$dateLabel] = [];
                            }
                            $groupedTasks[$dateLabel][] = $task;
                        }
                    }

                    // Sort groups: Today, Yesterday, then by date (newest first)
                    $priority = ['Today' => 0, 'Yesterday' => 1];
                    if (!empty($groupedTasks)) {
                        uksort($groupedTasks, function($a, $b) use ($priority) {
                        $aPriority = isset($priority[$a]) ? $priority[$a] : 999;
                        $bPriority = isset($priority[$b]) ? $priority[$b] : 999;

                        if ($aPriority !== $bPriority) {
                            return $aPriority - $bPriority;
                        }

                        // For non-priority groups, sort by actual date
                        if (!isset($groupedTasks[$a][0]) || !isset($groupedTasks[$b][0])) {
                            return 0;
                        }
                        $aDate = $groupedTasks[$a][0]->task_date;
                        $bDate = $groupedTasks[$b][0]->task_date;
                        return strtotime($bDate) - strtotime($aDate);
                        });
                    }
                @endphp
                
                @if(isset($groupedTasks) && count($groupedTasks) > 0)
                    @php
                        $delayCounter = 100;
                    @endphp
                    @foreach($groupedTasks as $groupLabel => $tasksInGroup)
                        @php
                            $headerClass = $groupLabel === 'Today' ? 'today' : ($groupLabel === 'Yesterday' ? 'yesterday' : '');
                        @endphp

                        <!-- Date Group Header -->
                        <div class="date-group-header {{ $headerClass }}" data-aos="fade-up" data-aos-delay="{{ $delayCounter }}">
                            <div class="date-group-info">
                                <h3 class="date-group-title">{{ $groupLabel }}</h3>
                                <span class="date-group-count">{{ count($tasksInGroup) }} task{{ count($tasksInGroup) !== 1 ? 's' : '' }}</span>
                            </div>
                            <button class="btn btn-sm btn-outline-primary send-daily-tasks-mail ms-2" data-date="{{ $groupLabel }}" data-tasks="{{ json_encode(collect($tasksInGroup)->map(function($task) { return ['id' => $task->id, 'task_number' => $task->task_number, 'task_description' => $task->task_description, 'client_project_name' => $task->client_project_name, 'status' => $task->status, 'task_date' => $task->task_date->format('Y-m-d H:i:s')]; })->toArray()) }}" title="Send daily tasks by mail">
                                <i class="bi bi-envelope"></i>
                            </button>
                            <div class="date-group-line"></div>
                        </div>

                        @php($delayCounter += 50)@endphp

                        <!-- Tasks in this group -->
                        @foreach($tasksInGroup as $task)
                            <div class="task-card" data-task-id="{{ $task->id }}" data-aos="fade-up" data-aos-delay="{{ $delayCounter }}">
                                <div class="task-header">
                                    <span class="task-number">Task #{{ $task->task_number }}</span>
                                    <div class="task-date">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($task->task_date)->format('d-m-Y|h:i A') }}</span>
                                    </div>
                                </div>
                                
                                <div class="task-section">
                                    <strong><i class="bi bi-briefcase"></i> Client/Project:</strong>
                                    <span>{{ $task->client_project_name }}</span>
                                </div>
                                
                                <div class="task-section">
                                    <strong><i class="bi bi-text-left"></i> Description:</strong>
                                    <span>{{ $task->task_description }}</span>
                                </div>
                                
                                @if(isset($task->status))
                                <div class="task-actions">
                                    <div class="status-badge status-{{ $task->status }}">
                                        {{ str_replace('_', ' ', ucfirst($task->status)) }}
                                    </div>
                                    <div class="task-buttons">
                                        <button type="button" class="btn btn-small btn-edit" onclick="editTask({{ $task->id }})">
                                            <i class="bi bi-pencil"></i>
                                            <span>Edit</span>
                                        </button>
                                        <button type="button" class="btn btn-small btn-delete" onclick="deleteTask({{ $task->id }})">
                                            <i class="bi bi-trash"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @php($delayCounter += 50)@endphp
                        @endforeach
                    @endforeach
                @else
                    <div class="empty-state" data-aos="fade-up" data-aos-delay="600">
                        <div class="empty-icon">
                            <i class="bi bi-clipboard"></i>
                        </div>
                        <h3>No Tasks Yet</h3>
                        <p>Start by creating your first task above!</p>
                    </div>
                @endif
            </div>
        </section>

       

        <div class="loading" id="loadingSpinner">
            <div class="spinner"></div>
            <p>Loading...</p>
        </div>
    </main>

    <!-- Bottom Navigation Bar (Mobile App Style) -->
    <nav class="bottom-nav">
        <div class="bottom-nav-item active" data-page="dashboard">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </div>
        <div class="bottom-nav-item" data-page="tasks">
            <i class="bi bi-clipboard-data"></i>
            <span>Tasks</span>
        </div>
        <div class="bottom-nav-item" data-page="add">
            <i class="bi bi-plus-circle"></i>
            <span>Add</span>
        </div>
        <div class="bottom-nav-item" data-page="reports">
            <i class="bi bi-graph-up"></i>
            <span>Reports</span>
        </div>
        <div class="bottom-nav-item" data-page="profile">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </div>
    </nav>

    <!-- Floating Action Button (Premium Mobile App Style) -->
    <button class="fab-main" id="fabMain">
        <i class="bi bi-plus"></i>
    </button>
    
    <div class="fab-menu" id="fabMenu">
        <button class="fab-item" onclick="scrollToTaskForm()">
            <i class="bi bi-plus-circle"></i>
            <span>New Task</span>
        </button>
        <button class="fab-item" onclick="refreshTasks()">
            <i class="bi bi-arrow-clockwise"></i>
            <span>Refresh</span>
        </button>
        <button class="fab-item" onclick="showFilterModal()">
            <i class="bi bi-funnel"></i>
            <span>Filter</span>
        </button>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil me-2"></i>Edit Task
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editTaskForm">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_task_id" name="task_id">
                        <div class="mb-3">
                            <label for="edit_task_date" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Date & Time
                            </label>
                            <input type="datetime-local" class="form-control" id="edit_task_date" name="task_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_client_project_name" class="form-label">
                                <i class="bi bi-briefcase me-1"></i>Client/Project Name
                            </label>
                            <input type="text" class="form-control" id="edit_client_project_name" name="client_project_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_task_description" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>Task Description
                            </label>
                            <textarea class="form-control" id="edit_task_description" name="task_description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">
                                <i class="bi bi-flag me-1"></i>Status
                            </label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="stopped">Stopped</option>
                                <option value="on_hold">On Hold</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true,
                offset: 50,
                disable: window.innerWidth < 768 && 'mobile'
            });
        });

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        mobileMenuBtn.addEventListener('click', function() {
            mobileMenuBtn.classList.toggle('active');
            mobileSidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', function() {
            mobileMenuBtn.classList.remove('active');
            mobileSidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // Header Scroll Effect
        const mobileHeader = document.querySelector('.mobile-header');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                mobileHeader.classList.add('scrolled');
            } else {
                mobileHeader.classList.remove('scrolled');
            }
        });

        // Show/Hide Loading
        function showLoading() {
            const spinner = document.getElementById('loadingSpinner');
            const container = document.getElementById('taskContainer');
            
            if (spinner) spinner.style.display = 'block';
            if (container) container.style.display = 'none';
        }

        function hideLoading() {
            const spinner = document.getElementById('loadingSpinner');
            const container = document.getElementById('taskContainer');
            
            if (spinner) spinner.style.display = 'none';
            if (container) {
                container.style.display = 'block';
                container.style.visibility = 'visible';
                container.style.opacity = '1';
                
                // Small delay to ensure DOM is updated before AOS refresh
                setTimeout(() => {
                    AOS.refresh();
                }, 100);
            }
        }

        // Scroll to Task Form
        function scrollToTaskForm() {
            const taskFormSection = document.getElementById('taskFormSection');
            if (taskFormSection) {
                taskFormSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // Reset Task Form
        function resetTaskForm() {
            const taskForm = document.getElementById('taskForm');
            if (taskForm) {
                taskForm.reset();
                // Set default date to current datetime
                const now = new Date();
                const offset = now.getTimezoneOffset();
                const localISOTime = new Date(now.getTime() - (offset * 60000)).toISOString().slice(0, 16);
                document.getElementById('task_date').value = localISOTime;
            }
        }

        // Create Task - Enhanced for mobile
        const taskForm = document.getElementById('taskForm');
        if (taskForm) {
            taskForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Prevent double submission
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && submitBtn.disabled) {
                    return;
                }
                
                try {
                    showLoading();
                    
                    // Disable submit button to prevent double clicks
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Creating...</span>';
                    }
                    
                    const formData = new FormData(this);
                    
                    const response = await fetch('{{ route("employee.task.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        showSuccess('Task created successfully!');
                        resetTaskForm();
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showError('Error: ' + (data.message || 'Unknown error'));
                    }
                } catch (error) {
                    console.error('Create task error:', error);
                    showError('An error occurred while creating the task. Please try again.');
                } finally {
                    hideLoading();
                    // Re-enable submit button
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-check-circle"></i><span>Create Task</span>';
                    }
                }
            });
        }
        
        // Mobile form field focus enhancements
        document.addEventListener('DOMContentLoaded', function() {
            const formFields = document.querySelectorAll('.form-control, .form-select, .form-textarea');
            
            formFields.forEach(field => {
                // Ensure field is clickable on mobile
                field.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.focus();
                });
                
                // Add touch feedback
                field.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                });
                
                field.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
                
                // iOS date picker fix
                if (field.type === 'datetime-local') {
                    field.addEventListener('focus', function() {
                        // Force iOS to show native date picker
                        this.showPicker?.();
                    });
                }
            });
        });

        // Edit Task
        async function editTask(taskId) {
            try {
                showLoading();
                
                const response = await fetch(`{{ route("employee.task.edit", ":id") }}`.replace(':id', taskId));
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    const taskIdInput = document.getElementById('edit_task_id');
                    const taskDateInput = document.getElementById('edit_task_date');
                    const clientInput = document.getElementById('edit_client_project_name');
                    const taskDescInput = document.getElementById('edit_task_description');
                    const statusInput = document.getElementById('edit_status');
                    
                    if (taskIdInput) taskIdInput.value = data.task.id;
                    
                    const taskDate = new Date(data.task.task_date);
                    const formattedDate = taskDate.toISOString().slice(0, 16);
                    
                    if (taskDateInput) taskDateInput.value = formattedDate;
                    if (clientInput) clientInput.value = data.task.client_project_name;
                    if (taskDescInput) taskDescInput.value = data.task.task_description;
                    if (statusInput) statusInput.value = data.task.status;
                    
                    const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                    modal.show();
                } else {
                    showError('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Edit task error:', error);
                showError('An error occurred while loading the task. Please try again.');
            } finally {
                hideLoading();
            }
        }

        // Edit Task Form Submission
        document.getElementById('editTaskForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                showLoading();
                
                const taskIdInput = document.getElementById('edit_task_id');
                const taskId = taskIdInput?.value;
                
                if (!taskId) {
                    throw new Error('Task ID not found');
                }
                
                const formData = new FormData(this);
                
                const response = await fetch(`{{ route("employee.task.update", ":id") }}`.replace(':id', taskId), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
                    if (modal) modal.hide();
                    
                    showSuccess('Task updated successfully!');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showError('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Update task error:', error);
                showError('An error occurred while updating the task. Please try again.');
            } finally {
                hideLoading();
            }
        });

        // Delete Task
        async function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                try {
                    showLoading();
                    
                    const response = await fetch(`{{ route("employee.task.delete", ":id") }}`.replace(':id', taskId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        showSuccess('Task deleted successfully!');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showError('Error: ' + data.message);
                    }
                } catch (error) {
                    console.error('Delete task error:', error);
                    showError('An error occurred while deleting the task. Please try again.');
                } finally {
                    hideLoading();
                }
            }
        }

        // Refresh Tasks
        function refreshTasks() {
            location.reload();
        }

        // Show Error Message
        function showError(message) {
            const toast = document.createElement('div');
            toast.className = 'error-toast';
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--gradient-danger);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: var(--shadow-lg);
                z-index: 9999;
                animation: slideInRight 0.3s ease-out;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Format Task DateTime
        function formatTaskDateTime(taskDate) {
            const date = new Date(taskDate);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = date.getHours();
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHours = hours % 12 || 12;
            
            return `${day}-${month}-${year}|${formattedHours}:${minutes} ${ampm}`;
        }

        // Show Success Message
        function showSuccess(message) {
            const toast = document.createElement('div');
            toast.className = 'success-toast';
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--gradient-success);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: var(--shadow-lg);
                z-index: 9999;
                animation: slideInRight 0.3s ease-out;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    const instance = bootstrap.Modal.getInstance(modal);
                    if (instance) instance.hide();
                });
                
                // Close mobile sidebar
                mobileMenuBtn.classList.remove('active');
                mobileSidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            }
        });

        // Set default date on page load
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const offset = now.getTimezoneOffset();
            const localISOTime = new Date(now.getTime() - (offset * 60000)).toISOString().slice(0, 16);
            const taskDateInput = document.getElementById('task_date');
            if (taskDateInput) {
                taskDateInput.value = localISOTime;
            }
        });

        // Mobile App Navigation Functionality
        const fabMain = document.getElementById('fabMain');
        const fabMenu = document.getElementById('fabMenu');
        const bottomNavItems = document.querySelectorAll('.bottom-nav-item');
        
        // FAB Menu Toggle
        if (fabMain && fabMenu) {
            let fabOpen = false;
            
            fabMain.addEventListener('click', function() {
                fabOpen = !fabOpen;
                
                if (fabOpen) {
                    fabMain.classList.add('active');
                    fabMenu.classList.remove('hide');
                    fabMenu.classList.add('show');
                    fabMenu.style.display = 'block';
                } else {
                    fabMain.classList.remove('active');
                    fabMenu.classList.remove('show');
                    fabMenu.classList.add('hide');
                    setTimeout(() => {
                        if (!fabOpen) {
                            fabMenu.style.display = 'none';
                        }
                    }, 300);
                }
            });
            
            // Close FAB menu when clicking outside
            document.addEventListener('click', function(e) {
                if (fabOpen && !fabMain.contains(e.target) && !fabMenu.contains(e.target)) {
                    fabOpen = false;
                    fabMain.classList.remove('active');
                    fabMenu.classList.remove('show');
                    fabMenu.classList.add('hide');
                    setTimeout(() => {
                        fabMenu.style.display = 'none';
                    }, 300);
                }
            });
        }
        
        // Bottom Navigation
        bottomNavItems.forEach(item => {
            item.addEventListener('click', function() {
                const page = this.dataset.page;
                
                // Remove active class from all items
                bottomNavItems.forEach(navItem => {
                    navItem.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Handle navigation
                switch(page) {
                    case 'dashboard':
                        scrollToTop();
                        break;
                    case 'tasks':
                        scrollToTaskList();
                        break;
                    case 'add':
                        scrollToTaskForm();
                        break;
                    case 'reports':
                        showSuccess('Reports feature coming soon!');
                        break;
                    case 'profile':
                        showSuccess('Profile feature coming soon!');
                        break;
                }
            });
        });
        
        // Mobile Navigation Functions
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        function scrollToTaskList() {
            const taskListSection = document.querySelector('.task-list-section');
            if (taskListSection) {
                taskListSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
        
        function showFilterModal() {
            const filterModal = document.getElementById('filterModal');
            filterModal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Add vibration on mobile
            if ('ontouchstart' in window) {
                vibrate(25);
            }
        }

        function hideFilterModal() {
            const filterModal = document.getElementById('filterModal');
            filterModal.classList.remove('show');
            document.body.style.overflow = '';
            
            // Add vibration on mobile
            if ('ontouchstart' in window) {
                vibrate(15);
            }
        }

        function clearFilters() {
            // Reset form
            const filterForm = document.getElementById('filterForm');
            filterForm.reset();
            
            // Check all status checkboxes
            const statusCheckboxes = filterForm.querySelectorAll('input[name="status[]"]');
            statusCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            
            showSuccess('Filters cleared!');
        }

        function applyFilters() {
            const filterForm = document.getElementById('filterForm');
            const formData = new FormData(filterForm);
            
            // Collect filter data
            const filters = {
                date_from: formData.get('date_from'),
                date_to: formData.get('date_to'),
                status: formData.getAll('status[]'),
                search: formData.get('search'),
                client: formData.get('client')
            };
            
            // Show loading
            showLoading();
            
            // Hide filter modal
            hideFilterModal();
            
            // Send filter request to server
            fetch('/employee/tasks/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(filters)
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    // Update task list with filtered results
                    updateTaskList(data.tasks);
                    showSuccess(`Found ${data.tasks.length} tasks matching your filters`);
                } else {
                    showError(data.message || 'Error filtering tasks');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Filter error:', error);
                console.error('Error details:', error.message);
                console.error('Error stack:', error.stack);
                
                // Restore button state on error
                if (applyBtn) {
                    applyBtn.disabled = false;
                    applyBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Apply Filters';
                    applyBtn.style.opacity = '1';
                }
                
                showError('Error applying filters. Please try again.');
            });
        }

        function updateTaskList(tasks) {
            const taskContainer = document.getElementById('taskContainer');
            
            // Debug: Log tasks and container info
            console.log('Updating task list with tasks:', tasks);
            console.log('Task container found:', !!taskContainer);
            console.log('Container current display:', taskContainer.style.display);
            console.log('Container current visibility:', taskContainer.style.visibility);
            console.log('Container current opacity:', taskContainer.style.opacity);
            console.log('Container current content:', taskContainer.innerHTML.substring(0, 200));
            
            if (tasks.length === 0) {
                console.log('No tasks found, showing empty state');
                taskContainer.innerHTML = `
                    <div class="empty-state" data-aos="fade-up">
                        <div class="empty-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3>No Tasks Found</h3>
                        <p>No tasks match your current filters. Try adjusting your criteria.</p>
                        <button class="btn btn-primary mt-3" onclick="clearInlineFilters(); applyInlineFilters();">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                        </button>
                    </div>
                `;
                return;
            }
            
            // Group tasks by date
            const groupedTasks = {};
            tasks.forEach(task => {
                const date = new Date(task.task_date).toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                if (!groupedTasks[date]) {
                    groupedTasks[date] = [];
                }
                groupedTasks[date].push(task);
            });
            
            // Generate HTML for filtered tasks (matching Blade structure)
            let html = '';
            let delayCounter = 100;
            
            Object.keys(groupedTasks).forEach(date => {
                const headerClass = date === 'Today' ? 'today' : (date === 'Yesterday' ? 'yesterday' : '');
                
                html += `
                    <!-- Date Group Header -->
                    <div class="date-group-header ${headerClass}" data-aos="fade-up" data-aos-delay="${delayCounter}">
                        <div class="date-group-info">
                            <h3 class="date-group-title">${date}</h3>
                            <span class="date-group-count">${groupedTasks[date].length} task${groupedTasks[date].length !== 1 ? 's' : ''}</span>
                        </div>
                        <div class="date-group-line"></div>
                    </div>
                `;
                
                groupedTasks[date].forEach(task => {
                    const statusClass = task.status.replace('_', '-');
                    const statusLabel = task.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                    
                    html += `
                        <div class="task-card" data-task-id="${task.id}" data-aos="fade-up" data-aos-delay="${delayCounter + 100}">
                            <div class="task-header">
                                <span class="task-number">Task #${task.task_number}</span>
                                <div class="task-date">
                                    <i class="bi bi-calendar"></i>
                                    <span>${formatTaskDateTime(task.task_date)}</span>
                                </div>
                            </div>
                            
                            <div class="task-section">
                                <strong><i class="bi bi-briefcase"></i> Client/Project:</strong>
                                <span>${task.client_project_name}</span>
                            </div>
                            
                            <div class="task-section">
                                <strong><i class="bi bi-text-left"></i> Description:</strong>
                                <span>${task.task_description}</span>
                            </div>
                            
                            <div class="task-actions">
                                <div class="status-badge status-${statusClass}">
                                    ${statusLabel}
                                </div>
                                <div class="task-buttons">
                                    <button type="button" class="btn btn-small btn-edit" onclick="editTask(${task.id})">
                                        <i class="bi bi-pencil"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-small btn-delete" onclick="deleteTask(${task.id})">
                                        <i class="bi bi-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    delayCounter += 50;
                });
            });
            
            // Trim whitespace and set HTML
            taskContainer.innerHTML = html.trim();
            
            // Debug: Log final HTML
            console.log('Task container updated with HTML length:', html.length);
            console.log('Final container content preview:', taskContainer.innerHTML.substring(0, 200));
            
            // Force mobile visibility
            if (window.innerWidth <= 768) {
                const taskCards = taskContainer.querySelectorAll('.task-card');
                const taskGroups = taskContainer.querySelectorAll('.task-group');
                
                taskCards.forEach(card => {
                    card.style.display = 'block';
                    card.style.visibility = 'visible';
                    card.style.opacity = '1';
                });
                
                taskGroups.forEach(group => {
                    group.style.display = 'block';
                    group.style.visibility = 'visible';
                    group.style.opacity = '1';
                });
            }
            
            // Debug: Log final HTML
            console.log('Task container updated with HTML length:', html.length);
            console.log('Final container content preview:', taskContainer.innerHTML.substring(0, 200));
            
            // Reinitialize AOS for new elements
            AOS.refresh();
        }

        // Close filter modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const filterModal = document.getElementById('filterModal');
                if (filterModal.classList.contains('show')) {
                    hideFilterModal();
                }
            }
        });

        // Inline Filter Toggle Functions
        function toggleInlineFilter() {
            const filterContent = document.getElementById('inlineFilterContent');
            const filterIcon = document.getElementById('filterToggleIcon');
            
            if (filterContent.classList.contains('hidden')) {
                // Show filter
                filterContent.classList.remove('hidden');
                filterIcon.classList.remove('bi-chevron-down');
                filterIcon.classList.add('bi-chevron-up');
                
                // Add vibration on mobile
                if ('ontouchstart' in window) {
                    vibrate(25);
                }
            } else {
                // Hide filter
                filterContent.classList.add('hidden');
                filterIcon.classList.remove('bi-chevron-up');
                filterIcon.classList.add('bi-chevron-down');
                
                // Add vibration on mobile
                if ('ontouchstart' in window) {
                    vibrate(15);
                }
            }
        }

        function clearInlineFilters() {
            // Reset inline filter form
            const inlineForm = document.getElementById('inlineFilterForm');
            inlineForm.reset();
            
            // Show loading
            showLoading();
            
            // Send request to get all tasks (no filters)
            fetch('/employee/tasks/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    date_from: '',
                    date_to: '',
                    status: '',
                    search: ''
                })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                console.log('Clear filter response:', data);
                
                if (data.success) {
                    updateTaskList(data.tasks);
                    showSuccess('Filters cleared! Showing all tasks');
                } else {
                    showError('Error loading all tasks');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Clear filter error:', error);
                showError('Error clearing filters');
            });
        }

        function applyInlineFilters() {
            const inlineForm = document.getElementById('inlineFilterForm');
            const applyBtn = inlineForm.querySelector('.btn-primary');
            
            // Collect filter data with fallbacks for mobile
            const dateFromInput = inlineForm.querySelector('#inline_date_from') || inlineForm.querySelector('input[name="date_from"]');
            const dateToInput = inlineForm.querySelector('#inline_date_to') || inlineForm.querySelector('input[name="date_to"]');
            const searchInput = inlineForm.querySelector('#inline_search') || inlineForm.querySelector('input[name="search"]');
            const statusInput = inlineForm.querySelector('#inline_status') || inlineForm.querySelector('select[name="status"]');
            
            const filters = {
                date_from: dateFromInput ? dateFromInput.value : '',
                date_to: dateToInput ? dateToInput.value : '',
                status: statusInput ? statusInput.value : '',
                search: searchInput ? searchInput.value : ''
            };
            
            // Debug: Log input elements found
            console.log('Date from input found:', !!dateFromInput);
            console.log('Date to input found:', !!dateToInput);
            console.log('Search input found:', !!searchInput);
            console.log('Status input found:', !!statusInput);
            
            // Debug: Log filter data
            console.log('Applying filters:', filters);
            console.log('Mobile device:', /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
            console.log('Selected status:', filters.status);
            
            // Show loading and disable button
            showLoading();
            if (applyBtn) {
                applyBtn.disabled = true;
                applyBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Applying...';
                applyBtn.style.opacity = '0.7';
            }
            
            // Send filter request to server
            fetch('/employee/tasks/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(filters)
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                console.log('Filter response:', data);
                
                // Restore button state
                if (applyBtn) {
                    applyBtn.disabled = false;
                    applyBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Apply Filters';
                    applyBtn.style.opacity = '1';
                }
                
                if (data.success) {
                    console.log('Filter success! Tasks received:', data.tasks.length);
                    console.log('Tasks data:', data.tasks);
                    
                    // Update task list with filtered results
                    updateTaskList(data.tasks);
                    showSuccess(`Found ${data.tasks.length} tasks matching your filters`);
                    
                    // Debug: Check if container is visible after update
                    setTimeout(() => {
                        const container = document.getElementById('taskContainer');
                        console.log('Container after update - display:', container.style.display);
                        console.log('Container after update - visibility:', container.style.visibility);
                        console.log('Container after update - opacity:', container.style.opacity);
                        console.log('Container after update - content length:', container.innerHTML.length);
                        console.log('Container after update - has children:', container.children.length);
                    }, 500);
                } else {
                    console.log('Filter failed:', data.message);
                    showError(data.message || 'Error filtering tasks');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Inline filter error:', error);
                
                // Restore button state on error
                if (applyBtn) {
                    applyBtn.disabled = false;
                    applyBtn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Apply Filters';
                    applyBtn.style.opacity = '1';
                }
                
                showError('Error applying filters. Please try again.');
            });
        }
        
        // Mobile Swipe Gestures
        let touchStartX = 0;
        let touchEndX = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - could be used for navigation
                    console.log('Swipe left detected');
                } else {
                    // Swipe right - could be used for navigation
                    console.log('Swipe right detected');
                }
            }
        }
        
        // Mobile App Status Bar Handling
        function updateStatusBar() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            
            if (isIOS) {
                // Handle iOS status bar
                document.documentElement.style.setProperty('--safe-area-top', 'env(safe-area-inset-top)');
            }
            
            if (isAndroid) {
                // Handle Android navigation bar
                document.documentElement.style.setProperty('--safe-area-bottom', 'env(safe-area-inset-bottom)');
            }
        }
        
        updateStatusBar();
        
        // Mobile App Vibration Feedback
        function vibrate(duration = 50) {
            if ('vibrate' in navigator) {
                navigator.vibrate(duration);
            }
        }
        
        // Add vibration to button clicks on mobile
        if ('ontouchstart' in window) {
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn') || 
                    e.target.classList.contains('bottom-nav-item') || 
                    e.target.classList.contains('fab-main') ||
                    e.target.classList.contains('fab-item')) {
                    vibrate(25);
                }
            });
        }
        
        // Mobile App Fullscreen Support
        function requestFullscreen() {
            const elem = document.documentElement;
            
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        }
        
        // Add long press for fullscreen on mobile
        let longPressTimer;
        
        document.addEventListener('touchstart', function(e) {
            if (e.target.classList.contains('welcome-section')) {
                longPressTimer = setTimeout(() => {
                    if (confirm('Enter fullscreen mode?')) {
                        requestFullscreen();
                    }
                }, 1000);
            }
        });
        
        document.addEventListener('touchend', function() {
            clearTimeout(longPressTimer);
        });
        
        document.addEventListener('touchmove', function() {
            clearTimeout(longPressTimer);
        });
        
        // Mobile App Orientation Handling
        function handleOrientationChange() {
            setTimeout(() => {
                // Refresh AOS animations after orientation change
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
            }, 300);
        }
        
        window.addEventListener('orientationchange', handleOrientationChange);
        window.addEventListener('resize', handleOrientationChange);

        // Simple Alert Popup Functions - Enhanced
        function showLogoutAlert() {
            console.log('showLogoutAlert called'); // Debug
            const alert = document.getElementById('logoutAlert');
            if (alert) {
                console.log('Alert element found:', alert); // Debug
                alert.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                // Add vibration on mobile
                if ('vibrate' in navigator) {
                    navigator.vibrate(30);
                    console.log('Vibration triggered'); // Debug
                }
            } else {
                console.log('Alert element not found'); // Debug
            }
        }
        
        function hideLogoutAlert() {
            console.log('hideLogoutAlert called'); // Debug
            const alert = document.getElementById('logoutAlert');
            if (alert) {
                console.log('Alert element found for hide'); // Debug
                alert.classList.remove('show');
                document.body.style.overflow = '';
                
                // Add vibration on mobile
                if ('vibrate' in navigator) {
                    navigator.vibrate(15);
                    console.log('Hide vibration triggered'); // Debug
                }
            } else {
                console.log('Alert element not found for hide'); // Debug
            }
        }

        // Send Daily Tasks Email Function
        document.addEventListener('click', function(e) {
            if (e.target.closest('.send-daily-tasks-mail')) {
                const button = e.target.closest('.send-daily-tasks-mail');
                const dateLabel = button.dataset.date;
                const tasks = JSON.parse(button.dataset.tasks);
                
                if (!tasks || tasks.length === 0) {
                    showError('No tasks found for this date.');
                    return;
                }
                
                // Confirm before sending
                if (confirm(`Send ${tasks.length} task(s) from ${dateLabel} via email?`)) {
                    sendDailyTasksEmail(dateLabel, tasks);
                }
            }
        });

        async function sendDailyTasksEmail(dateLabel, tasks) {
            try {
                showLoading();
                
                const response = await fetch('/employee/send-daily-tasks-email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        date_label: dateLabel,
                        tasks: tasks
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showSuccess(`Email sent successfully! ${tasks.length} task(s) from ${dateLabel} have been delivered.`);
                } else {
                    showError('Error: ' + (data.message || 'Failed to send email'));
                }
            } catch (error) {
                console.error('Send daily tasks email error:', error);
                showError('An error occurred while sending the email. Please try again.');
            } finally {
                hideLoading();
            }
        }
    </script>

    <!-- Simple Mobile Alert Popup -->
    <div class="simple-alert" id="logoutAlert">
        <div class="alert-backdrop" onclick="hideLogoutAlert()"></div>
        <div class="alert-content">
            <div class="alert-icon">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <div class="alert-message">
                <h4>Confirm Logout</h4>
                <p>Are you sure you want to logout?</p>
            </div>
            <div class="alert-actions">
                <button type="button" class="btn btn-cancel" onclick="hideLogoutAlert()">Cancel</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout">Logout</button>
                </form>
            </div>
        </div>
    </div>

    </body>
</html>
