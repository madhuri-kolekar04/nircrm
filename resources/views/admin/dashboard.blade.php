<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - NIRCRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            /* Modern Color Palette */
            --primary-50: #f0f4ff;
            --primary-100: #e0e7ff;
            --primary-200: #c7d2fe;
            --primary-500: #667eea;
            --primary-600: #5a67d8;
            --primary-700: #4c51bf;
            --primary-800: #434190;
            --primary-900: #3c366b;
            
            --success-50: #ecfdf5;
            --success-100: #d1fae5;
            --success-500: #10b981;
            --success-600: #059669;
            --success-700: #047857;
            
            --warning-50: #fffbeb;
            --warning-100: #fef3c7;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --warning-700: #b45309;
            
            --danger-50: #fef2f2;
            --danger-100: #fee2e2;
            --danger-500: #ef4444;
            --danger-600: #dc2626;
            --danger-700: #b91c1c;
            
            --info-50: #eff6ff;
            --info-100: #dbeafe;
            --info-500: #3b82f6;
            --info-600: #2563eb;
            --info-700: #1d4ed8;
            
            /* Gradients */
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #fc4a1a 0%, #f7b733 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            
            /* Semantic Colors */
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            
            /* Neutral Colors */
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            --white: #ffffff;
            --black: #000000;
            
            /* Typography */
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --text-inverse: #ffffff;
            
            /* Background */
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-tertiary: #f3f4f6;
            
            /* Borders */
            --border-color: #e5e7eb;
            --border-color-light: #f3f4f6;
            
            /* Shadows */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            
            /* Spacing */
            --space-xs: 0.25rem;
            --space-sm: 0.5rem;
            --space-md: 1rem;
            --space-lg: 1.5rem;
            --space-xl: 2rem;
            --space-2xl: 3rem;
            
            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* CSS Reset and Base Styles */
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
            color: var(--text-primary);
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(102, 126, 234, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
                url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23667eea" fill-opacity="0.05"><circle cx="7" cy="7" r="1"/><circle cx="53" cy="7" r="1"/><circle cx="30" cy="7" r="1"/><circle cx="7" cy="30" r="1"/><circle cx="53" cy="30" r="1"/><circle cx="30" cy="30" r="1"/><circle cx="7" cy="53" r="1"/><circle cx="53" cy="53" r="1"/><circle cx="30" cy="53" r="1"/></g></g></svg>');
            background-size: auto, auto, 60px 60px;
            background-position: 0 0, 0 0, 0 0;
            z-index: -1;
            pointer-events: none;
        }

        /* Header Styles */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color-light);
            padding: clamp(0.75rem, 2vw, 1.25rem) 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-lg);
        }

        .header .user-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: clamp(0.5rem, 2vw, 1.5rem);
            padding: 0 clamp(0.75rem, 3vw, 1.5rem);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: clamp(0.5rem, 2vw, 1rem);
            flex: 1;
            min-width: 0;
        }

        .user-avatar {
            width: clamp(40px, 5vw, 56px);
            height: clamp(40px, 5vw, 56px);
            border-radius: var(--radius-full);
            background: var(--primary-gradient);
            color: var(--text-inverse);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: clamp(0.875rem, 2vw, 1.25rem);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            transition: all var(--transition-normal);
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .user-details {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: clamp(0.875rem, 2.5vw, 1.25rem);
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            color: var(--text-secondary);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            opacity: 0.8;
        }

        .admin-badge {
            background: var(--danger-gradient);
            color: var(--text-inverse);
            padding: clamp(0.125rem, 1vw, 0.25rem) clamp(0.5rem, 2vw, 0.75rem);
            border-radius: var(--radius-full);
            font-size: clamp(0.625rem, 1.5vw, 0.75rem);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: clamp(0.25rem, 1vw, 0.5rem);
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .logout-btn {
            background: var(--danger-gradient);
            color: var(--text-inverse);
            border: none;
            padding: clamp(0.5rem, 2vw, 0.75rem) clamp(0.75rem, 2.5vw, 1.25rem);
            border-radius: var(--radius-lg);
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-inverse);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        /* Main Container */
        .main-container {
            padding: clamp(1rem, 4vw, 2rem) clamp(0.75rem, 3vw, 1.5rem);
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr));
            gap: clamp(1rem, 3vw, 1.5rem);
            margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            padding: clamp(1rem, 3vw, 1.75rem);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color-light);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transform: translateY(0);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            transition: height var(--transition-normal);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity var(--transition-normal);
            pointer-events: none;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
            border-color: var(--primary-200);
        }

        .stat-card:hover::before {
            height: 6px;
        }

        .stat-card:hover::after {
            opacity: 1;
        }

        .stat-card:active {
            transform: translateY(-4px) scale(1.01);
            transition: all var(--transition-fast);
        }

        .stat-card.success::before { background: var(--success-gradient); }
        .stat-card.warning::before { background: var(--warning-gradient); }
        .stat-card.danger::before { background: var(--danger-gradient); }
        .stat-card.info::before { background: var(--info-gradient); }

        .stat-icon {
            width: clamp(48px, 8vw, 72px);
            height: clamp(48px, 8vw, 72px);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.25rem, 3vw, 2rem);
            margin-bottom: clamp(0.75rem, 2vw, 1.25rem);
            color: var(--text-inverse);
            position: relative;
            transition: all var(--transition-normal);
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: inherit;
            background: inherit;
            filter: blur(8px);
            opacity: 0.3;
            z-index: -1;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-icon.primary { background: var(--primary-gradient); }
        .stat-icon.success { background: var(--success-gradient); }
        .stat-icon.warning { background: var(--warning-gradient); }
        .stat-icon.danger { background: var(--danger-gradient); }
        .stat-icon.info { background: var(--info-gradient); }

        .stat-content {
            position: relative;
            z-index: 1;
        }

        .stat-value {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
            line-height: 1;
            transition: all var(--transition-normal);
        }

        .stat-card:hover .stat-value {
            transform: scale(1.05);
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 2vw, 0.9375rem);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        .stat-trend {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 24px;
            height: 24px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            opacity: 0;
            transform: scale(0.8);
            transition: all var(--transition-normal);
        }

        .stat-card:hover .stat-trend {
            opacity: 1;
            transform: scale(1);
        }

        /* Filter Section */
        .filter-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            padding: clamp(1rem, 3vw, 2rem);
            margin-bottom: clamp(1.5rem, 4vw, 2.5rem);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color-light);
            position: relative;
            overflow: hidden;
        }

        .filter-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--info-gradient);
            opacity: 0.8;
        }

        .filter-section h5 {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-section .row {
            gap: clamp(0.75rem, 2vw, 1rem);
        }

        .filter-section .col-md-3 {
            flex: 0 0 calc(50% - clamp(0.375rem, 1vw, 0.5rem));
            max-width: calc(50% - clamp(0.375rem, 1vw, 0.5rem));
        }

        /* Modern Buttons */
        .btn-custom {
            border: none;
            border-radius: var(--radius-lg);
            padding: clamp(0.75rem, 2vw, 1rem) clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 600;
            font-size: clamp(0.875rem, 2vw, 1rem);
            transition: all var(--transition-normal);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            white-space: nowrap;
            min-height: 44px;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: var(--radius-full);
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s var(--transition-normal), height 0.6s var(--transition-normal);
        }

        .btn-custom:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-custom:active {
            transform: scale(0.98);
            transition: all var(--transition-fast);
        }

        .btn-filter {
            background: var(--info-gradient);
            color: var(--text-inverse);
            box-shadow: var(--shadow-md);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: var(--text-inverse);
        }

        .btn-reset {
            background: var(--secondary-gradient);
            color: var(--text-inverse);
            box-shadow: var(--shadow-md);
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: var(--text-inverse);
        }

        /* Form Controls */
        .form-label {
            font-size: clamp(0.875rem, 2vw, 1rem);
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .form-select {
            font-size: clamp(0.875rem, 2vw, 1rem);
            padding: clamp(0.75rem, 2vw, 1rem);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-lg);
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all var(--transition-normal);
            min-height: 44px;
            width: 100%;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-control:hover, .form-select:hover {
            border-color: var(--primary-200);
        }

        /* Task Cards */
        .task-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            padding: clamp(1rem, 3vw, 1.75rem);
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color-light);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .task-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }

        .task-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            opacity: 0;
            transition: opacity var(--transition-normal);
            pointer-events: none;
        }

        .task-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-200);
        }

        .task-card:hover::before {
            opacity: 1;
        }

        .task-card:hover::after {
            opacity: 1;
        }

        .task-card:active {
            transform: translateY(-3px) scale(1.005);
            transition: all var(--transition-fast);
        }

        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: clamp(0.75rem, 2vw, 1.25rem);
            flex-wrap: wrap;
            gap: clamp(0.5rem, 1.5vw, 0.75rem);
        }

        .task-number {
            background: var(--primary-gradient);
            color: var(--text-inverse);
            padding: clamp(0.375rem, 1vw, 0.5rem) clamp(0.75rem, 2vw, 1rem);
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .task-date {
            color: var(--text-secondary);
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            opacity: 0.8;
        }

        .task-description {
            margin-bottom: clamp(0.75rem, 2vw, 1.25rem);
            line-height: 1.6;
            color: var(--text-primary);
            font-weight: 500;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .task-client {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: clamp(0.75rem, 2vw, 1rem);
            border-radius: var(--radius-lg);
            margin-bottom: clamp(0.75rem, 2vw, 1.25rem);
            border-left: 4px solid var(--primary-color);
            font-weight: 500;
            font-size: clamp(0.875rem, 2vw, 1rem);
            transition: all var(--transition-normal);
        }

        .task-client:hover {
            background: linear-gradient(135deg, var(--primary-50) 0%, var(--primary-100) 100%);
            transform: translateX(4px);
        }

        .task-employee {
            background: linear-gradient(135deg, var(--info-50) 0%, var(--info-100) 100%);
            padding: clamp(0.5rem, 1.5vw, 0.75rem) clamp(0.75rem, 2vw, 1rem);
            border-radius: var(--radius-lg);
            margin-bottom: clamp(0.75rem, 2vw, 1.25rem);
            border-left: 4px solid var(--info-color);
            font-weight: 500;
            color: var(--text-primary);
            font-size: clamp(0.875rem, 2vw, 1rem);
            transition: all var(--transition-normal);
        }

        .task-employee:hover {
            background: linear-gradient(135deg, var(--info-50) 0%, var(--info-100) 100%);
            transform: translateX(4px);
        }

        .task-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: clamp(0.75rem, 2vw, 1rem);
        }

        .btn-edit, .btn-delete {
            padding: clamp(0.5rem, 1.5vw, 0.75rem) clamp(0.75rem, 2vw, 1rem);
            border: none;
            border-radius: var(--radius-lg);
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            font-weight: 600;
            transition: all var(--transition-normal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            min-height: 40px;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-edit {
            background: var(--info-gradient);
            color: var(--text-inverse);
            box-shadow: var(--shadow-sm);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-inverse);
        }

        .btn-delete {
            background: var(--danger-gradient);
            color: var(--text-inverse);
            box-shadow: var(--shadow-sm);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--text-inverse);
        }

        .btn-edit:active, .btn-delete:active {
            transform: translateY(0);
        }

        /* Status Badges */
        .status-badge {
            padding: clamp(0.375rem, 1vw, 0.5rem) clamp(0.75rem, 2vw, 1rem);
            border-radius: var(--radius-full);
            font-size: clamp(0.625rem, 1.5vw, 0.75rem);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s var(--transition-normal);
        }

        .status-badge:hover::before {
            left: 100%;
        }

        .status-pending {
            background: var(--warning-gradient);
            color: var(--text-inverse);
        }

        .status-in_progress {
            background: var(--info-gradient);
            color: var(--text-inverse);
        }

        .status-completed {
            background: var(--success-gradient);
            color: var(--text-inverse);
        }

        .status-stopped {
            background: var(--secondary-gradient);
            color: var(--text-inverse);
        }

        .status-on_hold {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: var(--text-inverse);
        }

        .loading {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .spinner-border {
            color: var(--primary-color);
            width: 3rem;
            height: 3rem;
        }

        /* Modern Mobile-First Responsive Design */
        
        /* Large Desktops (1200px and up) */
        @media (min-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
            
            .filter-section .col-md-3 {
                flex: 0 0 25%;
                max-width: 25%;
            }
        }
        
        /* Desktops (992px - 1199px) */
        @media (max-width: 1199px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.25rem;
            }
        }
        
        /* Large Tablets (768px - 991px) */
        @media (max-width: 991px) {
            .main-container {
                padding: clamp(1rem, 3vw, 1.5rem) clamp(0.75rem, 2vw, 1rem);
            }
            
            .header .user-info {
                padding: 0 clamp(0.75rem, 2vw, 1rem);
            }
            
            .filter-section .row {
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .filter-section .col-md-3 {
                flex: 0 0 calc(50% - clamp(0.25rem, 0.75vw, 0.375rem));
                max-width: calc(50% - clamp(0.25rem, 0.75vw, 0.375rem));
            }
        }
        
        /* Tablets (576px - 767px) */
        @media (max-width: 767px) {
            html {
                font-size: 15px;
            }
            
            .main-container {
                padding: clamp(0.875rem, 2.5vw, 1.25rem) clamp(0.5rem, 2vw, 0.75rem);
            }

            .header {
                padding: clamp(0.625rem, 2vw, 0.875rem) 0;
            }
            
            .header .user-info {
                padding: 0 clamp(0.5rem, 2vw, 0.75rem);
                justify-content: space-between;
                text-align: left;
                flex-direction: row;
                flex-wrap: wrap;
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .user-profile {
                flex: 1;
                min-width: 200px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: clamp(0.625rem, 2vw, 1rem);
                margin-bottom: clamp(1.25rem, 3vw, 1.75rem);
            }

            .stat-card {
                padding: clamp(1rem, 2.5vw, 1.25rem);
                border-radius: var(--radius-xl);
            }
            
            .stat-icon {
                width: clamp(44px, 6vw, 56px);
                height: clamp(44px, 6vw, 56px);
                font-size: clamp(1.125rem, 2.5vw, 1.5rem);
                margin-bottom: clamp(0.625rem, 1.5vw, 1rem);
            }

            .stat-value {
                font-size: clamp(1.375rem, 3.5vw, 1.75rem);
            }

            .stat-label {
                font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            }

            .filter-section {
                padding: clamp(1rem, 2.5vw, 1.25rem);
                border-radius: var(--radius-xl);
                margin-bottom: clamp(1.25rem, 3vw, 1.75rem);
            }
            
            .filter-section h5 {
                font-size: clamp(0.9375rem, 2.25vw, 1.125rem);
                margin-bottom: clamp(0.75rem, 2vw, 1rem);
            }
            
            .filter-section .row {
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .filter-section .col-md-3 {
                flex: 0 0 calc(50% - clamp(0.25rem, 0.75vw, 0.375rem));
                max-width: calc(50% - clamp(0.25rem, 0.75vw, 0.375rem));
            }
            
            .filter-section .col-12 {
                margin-top: clamp(0.75rem, 2vw, 1rem);
            }

            .task-card {
                padding: clamp(1rem, 2.5vw, 1.25rem);
                border-radius: var(--radius-xl);
                margin-bottom: clamp(0.75rem, 2vw, 1rem);
            }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
                gap: clamp(0.375rem, 1vw, 0.5rem);
                margin-bottom: clamp(0.625rem, 1.5vw, 1rem);
            }
            
            .task-number {
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
                padding: clamp(0.3125rem, 0.75vw, 0.4375rem) clamp(0.625rem, 1.5vw, 0.8125rem);
            }
            
            .task-date {
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
            }

            .task-description {
                font-size: clamp(0.8125rem, 2vw, 0.9375rem);
                margin-bottom: clamp(0.625rem, 1.5vw, 1rem);
                line-height: 1.5;
            }
            
            .task-client, .task-employee {
                padding: clamp(0.625rem, 1.5vw, 0.8125rem);
                border-radius: var(--radius-md);
                margin-bottom: clamp(0.625rem, 1.5vw, 1rem);
                font-size: clamp(0.75rem, 1.75vw, 0.875rem);
            }

            .task-actions {
                flex-direction: column;
                align-items: stretch;
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .task-actions > div:first-child {
                order: 2;
            }
            
            .task-actions > div:last-child {
                order: 1;
                display: flex;
                gap: clamp(0.375rem, 1vw, 0.5rem);
            }

            .btn-edit, .btn-delete {
                flex: 1;
                padding: clamp(0.5625rem, 1.25vw, 0.6875rem) clamp(0.5rem, 1vw, 0.625rem);
                font-size: clamp(0.75rem, 1.75vw, 0.875rem);
                justify-content: center;
                border-radius: var(--radius-md);
                min-height: 40px;
            }
            
            .status-badge {
                text-align: center;
                padding: clamp(0.4375rem, 1vw, 0.5625rem) clamp(0.6875rem, 1.5vw, 0.875rem);
                font-size: clamp(0.625rem, 1.5vw, 0.75rem);
                border-radius: var(--radius-full);
            }
            
            .btn-custom {
                padding: clamp(0.5625rem, 1.25vw, 0.6875rem) clamp(1rem, 2.5vw, 1.25rem);
                font-size: clamp(0.75rem, 1.75vw, 0.875rem);
                border-radius: var(--radius-md);
            }
            
            .user-avatar {
                width: clamp(36px, 4.5vw, 44px);
                height: clamp(36px, 4.5vw, 44px);
                font-size: clamp(0.875rem, 2vw, 1.125rem);
            }
            
            .user-name {
                font-size: clamp(0.9375rem, 2.25vw, 1.125rem);
            }
            
            .user-email {
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
            }
            
            .admin-badge {
                font-size: clamp(0.5625rem, 1.25vw, 0.6875rem);
                padding: clamp(0.125rem, 0.5vw, 0.1875rem) clamp(0.375rem, 1vw, 0.5rem);
            }
            
            .logout-btn {
                padding: clamp(0.4375rem, 1vw, 0.5625rem) clamp(0.625rem, 1.75vw, 0.875rem);
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
            }
        }
        
        /* Mobile Phones (575px and down) */
        @media (max-width: 575px) {
            html {
                font-size: 14px;
            }
            
            .main-container {
                padding: clamp(0.75rem, 3vw, 1rem) clamp(0.375rem, 2vw, 0.5rem);
            }
            
            .header .user-info {
                padding: 0 clamp(0.375rem, 2vw, 0.5rem);
                flex-direction: column;
                text-align: center;
                gap: clamp(0.75rem, 2vw, 1rem);
            }
            
            .user-profile {
                min-width: auto;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: clamp(0.625rem, 2vw, 0.875rem);
            }

            .stat-card {
                padding: clamp(0.875rem, 2.5vw, 1.125rem);
                border-radius: var(--radius-lg);
            }
            
            .stat-icon {
                width: clamp(40px, 6vw, 48px);
                height: clamp(40px, 6vw, 48px);
                font-size: clamp(1rem, 2.5vw, 1.25rem);
            }

            .stat-value {
                font-size: clamp(1.25rem, 3.5vw, 1.5rem);
            }

            .stat-label {
                font-size: clamp(0.6875rem, 1.5vw, 0.8125rem);
            }

            .filter-section {
                padding: clamp(0.875rem, 2.5vw, 1.125rem);
                border-radius: var(--radius-lg);
            }
            
            .filter-section .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .filter-section .col-12 {
                margin-top: clamp(0.625rem, 2vw, 0.875rem);
            }
            
            .btn-custom {
                width: 100%;
                margin-bottom: clamp(0.375rem, 1vw, 0.5rem);
            }
            
            .btn-custom:last-child {
                margin-bottom: 0;
            }

            .task-card {
                padding: clamp(0.875rem, 2.5vw, 1.125rem);
                border-radius: var(--radius-lg);
            }
            
            .task-header {
                margin-bottom: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .task-number {
                font-size: clamp(0.625rem, 1.75vw, 0.75rem);
                padding: clamp(0.3125rem, 0.75vw, 0.375rem) clamp(0.5625rem, 1.25vw, 0.6875rem);
            }
            
            .task-date {
                font-size: clamp(0.625rem, 1.75vw, 0.75rem);
            }

            .task-description {
                font-size: clamp(0.75rem, 2vw, 0.875rem);
                margin-bottom: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .task-client, .task-employee {
                padding: clamp(0.5rem, 1.5vw, 0.625rem);
                border-radius: var(--radius-sm);
                margin-bottom: clamp(0.5rem, 1.5vw, 0.75rem);
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
            }

            .task-actions {
                gap: clamp(0.375rem, 1vw, 0.5rem);
            }
            
            .task-actions > div:last-child {
                flex-direction: column;
                gap: clamp(0.375rem, 1vw, 0.5rem);
            }

            .btn-edit, .btn-delete {
                padding: clamp(0.5rem, 1.25vw, 0.625rem) clamp(0.5625rem, 1vw, 0.6875rem);
                font-size: clamp(0.6875rem, 1.75vw, 0.8125rem);
            }
            
            .status-badge {
                padding: clamp(0.375rem, 1vw, 0.5rem) clamp(0.5625rem, 1.25vw, 0.6875rem);
                font-size: clamp(0.5625rem, 1.25vw, 0.6875rem);
            }
            
            .user-avatar {
                width: clamp(32px, 4.5vw, 40px);
                height: clamp(32px, 4.5vw, 40px);
                font-size: clamp(0.75rem, 2vw, 1rem);
            }
            
            .user-name {
                font-size: clamp(0.875rem, 2.25vw, 1rem);
            }
            
            .user-email {
                font-size: clamp(0.625rem, 1.75vw, 0.75rem);
            }
            
            .admin-badge {
                font-size: clamp(0.5rem, 1.25vw, 0.625rem);
                padding: clamp(0.0625rem, 0.5vw, 0.125rem) clamp(0.25rem, 1vw, 0.375rem);
            }
            
            .logout-btn {
                padding: clamp(0.375rem, 1vw, 0.5rem) clamp(0.5rem, 1.75vw, 0.75rem);
                font-size: clamp(0.625rem, 1.75vw, 0.75rem);
            }
        }
        
        /* Small Mobile Phones (400px and down) */
        @media (max-width: 400px) {
            html {
                font-size: 13px;
            }
            
            .main-container {
                padding: clamp(0.5rem, 2.5vw, 0.75rem) clamp(0.25rem, 2vw, 0.375rem);
            }
            
            .header .user-info {
                padding: 0 clamp(0.25rem, 2vw, 0.375rem);
            }
            
            .stat-card {
                padding: clamp(0.625rem, 2.5vw, 0.875rem);
            }
            
            .stat-icon {
                width: clamp(36px, 6vw, 42px);
                height: clamp(36px, 6vw, 42px);
                font-size: clamp(0.875rem, 2.5vw, 1.125rem);
            }
            
            .stat-value {
                font-size: clamp(1.125rem, 3.5vw, 1.375rem);
            }
            
            .filter-section {
                padding: clamp(0.625rem, 2.5vw, 0.875rem);
            }
            
            .task-card {
                padding: clamp(0.625rem, 2.5vw, 0.875rem);
            }
            
            .btn-edit, .btn-delete {
                padding: clamp(0.4375rem, 1.25vw, 0.5625rem) clamp(0.5rem, 1vw, 0.625rem);
                font-size: clamp(0.625rem, 1.75vw, 0.75rem);
            }
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .btn-custom, .btn-edit, .btn-delete, .logout-btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .stat-card, .task-card, .filter-section {
                transform: none !important;
            }
            
            .stat-card:hover, .task-card:hover {
                transform: none;
                box-shadow: var(--shadow-md);
            }
            
            .btn-custom:hover, .btn-edit:hover, .btn-delete:hover {
                transform: none;
            }
        }

        /* Landscape mobile optimizations */
        @media (max-width: 767px) and (orientation: landscape) {
            .main-container {
                padding: clamp(0.5rem, 2vw, 0.75rem) clamp(0.375rem, 1.5vw, 0.5rem);
            }
            
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: clamp(0.375rem, 1vw, 0.5rem);
                margin-bottom: clamp(0.75rem, 2vw, 1rem);
            }
            
            .stat-card {
                padding: clamp(0.625rem, 1.5vw, 0.875rem);
            }
            
            .stat-icon {
                width: clamp(32px, 4vw, 40px);
                height: clamp(32px, 4vw, 40px);
                font-size: clamp(0.875rem, 2vw, 1.125rem);
                margin-bottom: clamp(0.375rem, 1vw, 0.5rem);
            }
            
            .stat-value {
                font-size: clamp(1.125rem, 2.5vw, 1.375rem);
            }
            
            .stat-label {
                font-size: clamp(0.625rem, 1.25vw, 0.75rem);
            }
            
            .filter-section {
                padding: clamp(0.625rem, 1.5vw, 0.875rem);
                margin-bottom: clamp(0.75rem, 2vw, 1rem);
            }
            
            .filter-section .col-md-3 {
                flex: 0 0 calc(25% - clamp(0.25rem, 0.75vw, 0.375rem));
                max-width: calc(25% - clamp(0.25rem, 0.75vw, 0.375rem));
            }
            
            .task-card {
                padding: clamp(0.625rem, 1.5vw, 0.875rem);
                margin-bottom: clamp(0.5rem, 1.5vw, 0.75rem);
            }
        }

        /* Mobile Modal Improvements */
        @media (max-width: 767px) {
            .modal-dialog {
                margin: clamp(0.5rem, 2vw, 1rem);
                max-width: calc(100% - clamp(1rem, 4vw, 2rem));
            }
            
            .modal-content {
                border-radius: var(--radius-xl);
                border: none;
                box-shadow: var(--shadow-2xl);
            }
            
            .modal-header {
                padding: clamp(1rem, 2.5vw, 1.25rem);
                border-bottom: 1px solid var(--border-color-light);
            }
            
            .modal-title {
                font-size: clamp(1rem, 2.5vw, 1.125rem);
                font-weight: 700;
            }
            
            .modal-body {
                padding: clamp(1.25rem, 3vw, 1.5rem);
            }
            
            .modal-footer {
                padding: clamp(1rem, 2.5vw, 1.25rem);
                border-top: 1px solid var(--border-color-light);
                flex-direction: column;
                gap: clamp(0.5rem, 1.5vw, 0.75rem);
            }
            
            .modal-footer .btn {
                width: 100%;
                margin: 0;
                min-height: 44px;
            }
            
            .form-label {
                font-size: clamp(0.8125rem, 2vw, 0.9375rem);
                font-weight: 600;
                margin-bottom: clamp(0.375rem, 1vw, 0.5rem);
            }
            
            .form-control, .form-select {
                font-size: clamp(0.875rem, 2vw, 1rem);
                padding: clamp(0.625rem, 1.5vw, 0.875rem);
                border-radius: var(--radius-md);
                border: 2px solid var(--border-color);
                min-height: 44px;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
            
            textarea.form-control {
                min-height: 100px;
                resize: vertical;
            }
        }

        @media (max-width: 575px) {
            .modal-dialog {
                margin: clamp(0.25rem, 1.5vw, 0.5rem);
                max-width: calc(100% - clamp(0.5rem, 3vw, 1rem));
            }
            
            .modal-header {
                padding: clamp(0.75rem, 2vw, 1rem);
            }
            
            .modal-title {
                font-size: clamp(0.9375rem, 2.25vw, 1.0625rem);
            }
            
            .modal-body {
                padding: clamp(1rem, 2.5vw, 1.25rem);
            }
            
            .modal-footer {
                padding: clamp(0.75rem, 2vw, 1rem);
            }
            
            .form-label {
                font-size: clamp(0.75rem, 1.75vw, 0.875rem);
            }
            
            .form-control, .form-select {
                font-size: clamp(0.8125rem, 1.75vw, 0.9375rem);
                padding: clamp(0.5rem, 1.25vw, 0.75rem);
            }
        }

        /* Improved form controls */
        .form-control, .form-select {
            transition: all var(--transition-normal);
            background-color: var(--bg-primary);
        }

        .form-control:hover, .form-select:hover {
            border-color: var(--primary-200);
        }

        /* Better focus states for accessibility */
        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Mobile-friendly button states */
        .btn-custom:active, .btn-edit:active, .btn-delete:active, .logout-btn:active {
            transform: scale(0.98);
        }

        /* Simple Mobile Alert Popup */
        .simple-alert {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
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
        }
        
        .alert-icon {
            width: 60px;
            height: 60px;
            background: var(--danger-gradient);
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
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
        }
        
        .alert-message p {
            font-size: 1rem;
            color: var(--text-secondary);
            margin: 0 0 1.5rem 0;
        }
        
        .alert-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        .btn-cancel {
            background: var(--gray-100);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
        }
        
        .btn-cancel:hover {
            background: var(--gray-200);
            transform: translateY(-1px);
        }
        
        .btn-logout {
            background: var(--danger-gradient);
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
        
        .logout-modal-header {
            text-align: center;
            padding: 2.5rem 2rem 1.5rem;
            background: var(--bg-secondary);
            border-radius: 24px 24px 0 0;
            position: relative;
        }
        
        .logout-modal-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--danger-gradient);
            border-radius: 2px;
        }
        
        .logout-modal-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--danger-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            animation: pulse 2s infinite;
        }
        
        .logout-modal-icon::before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 50%;
            background: var(--danger-gradient);
            opacity: 0.3;
            z-index: -1;
            animation: pulse 2s infinite;
        }
        
        .logout-modal-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.025em;
        }
        
        .logout-modal-subtitle {
            font-size: 1rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.5;
        }
        
        .logout-modal-body {
            padding: 2rem;
        }
        
        .logout-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .logout-feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--bg-tertiary);
            border-radius: 16px;
            border: 1px solid var(--border-color-light);
            transition: all var(--transition-normal);
        }
        
        .logout-feature:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-color);
        }
        
        .logout-feature i {
            width: 40px;
            height: 40px;
            background: var(--success-gradient);
            color: var(--white);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            flex-shrink: 0;
        }
        
        .logout-feature span {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
        }
        
        .logout-modal-footer {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
            background: var(--bg-secondary);
            border-radius: 0 0 24px 24px;
            border-top: 1px solid var(--border-color-light);
        }
        
        .logout-modal-footer .btn {
            min-width: 120px;
            border-radius: 16px;
            font-weight: 700;
            padding: 1rem 2rem;
            transition: all var(--transition-normal);
        }
        
        .logout-modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .logout-modal-footer .btn:active {
            transform: translateY(0);
        }
        
        /* Add missing pulse animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.6;
                transform: scale(1.05);
            }
        }
        
        /* Mobile Responsive Modal */
        @media (max-width: 768px) {
            .logout-modal {
                z-index: 99999;
            }
            
            .logout-modal-content {
                width: 95%;
                max-width: none;
                max-height: calc(100vh - 2rem);
                margin: 0;
            }
            
            .logout-modal-header {
                padding: 2rem 1.5rem 1rem;
            }
            
            .logout-modal-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .logout-modal-title {
                font-size: 1.5rem;
            }
            
            .logout-modal-subtitle {
                font-size: 0.875rem;
            }
            
            .logout-features {
                gap: 0.75rem;
            }
            
            .logout-feature {
                padding: 0.75rem;
                gap: 0.75rem;
            }
            
            .logout-feature i {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .logout-feature span {
                font-size: 0.75rem;
            }
            
            .logout-modal-footer {
                padding: 1.5rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .logout-modal-footer .btn {
                width: 100%;
                min-width: auto;
            }
        }
        
        /* Extra mobile fixes */
        @media (max-width: 480px) {
            .logout-modal-content {
                width: 98%;
                padding: 0;
            }
            
            .logout-modal-header {
                padding: 1.5rem 1rem 0.75rem;
            }
            
            .logout-modal-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }
        
        /* Force modal display */
        .logout-modal.show .logout-modal-backdrop,
        .logout-modal.show .logout-modal-content,
        .logout-modal.show .logout-modal-header,
        .logout-modal.show .logout-modal-body,
        .logout-modal.show .logout-modal-footer {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
            
            .logout-modal-header {
                padding: 2rem 1.5rem 1rem;
            }
            
            .logout-modal-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .logout-modal-title {
                font-size: 1.5rem;
            }
            
            .logout-modal-subtitle {
                font-size: 0.875rem;
            }
            
            .logout-features {
                gap: 0.75rem;
            }
            
            .logout-feature {
                padding: 0.75rem;
                gap: 0.75rem;
            }
            
            .logout-feature i {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .logout-feature span {
                font-size: 0.75rem;
            }
            
            .logout-modal-footer {
                padding: 1.5rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .logout-modal-footer .btn {
                width: 100%;
                min-width: auto;
            }
        }
            
            .logout-modal-header {
                padding: 2rem 1.5rem 1rem;
            }
            
            .logout-modal-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .logout-modal-title {
                font-size: 1.5rem;
            }
            
            .logout-modal-subtitle {
                font-size: 0.875rem;
            }
            
            .logout-features {
                gap: 0.75rem;
            }
            
            .logout-feature {
                padding: 0.75rem;
                gap: 0.75rem;
            }
            
            .logout-feature i {
                width: 32px;
                height: 32px;
                font-size: 1rem;
            }
            
            .logout-feature span {
                font-size: 0.75rem;
            }
            
            .logout-modal-footer {
                padding: 1.5rem;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .logout-modal-footer .btn {
                width: 100%;
                min-width: auto;
            }
        }
        
        /* Modal Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }
        
        /* Add AOS zoom-in animation */
        [data-aos="zoom-in"] {
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.8);
            transition: all 0.3s ease-out;
        }
        
        [data-aos="zoom-in"].aos-animate {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Improved loading spinner for mobile */
        @media (max-width: 767px) {
            .loading {
                padding: clamp(1.25rem, 3vw, 1.5rem);
            }
            
            .spinner-border {
                width: clamp(2rem, 4vw, 2.5rem);
                height: clamp(2rem, 4vw, 2.5rem);
            }
            
            .loading p {
                font-size: clamp(0.8125rem, 2vw, 0.9375rem);
                margin-top: clamp(0.5rem, 1.5vw, 0.75rem);
            }
        }

        /* Better scrollbar for mobile */
        @media (max-width: 767px) {
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            
            ::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.2);
                border-radius: 3px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: rgba(0, 0, 0, 0.3);
            }
        }

        /* Animations */
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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .task-card {
            animation: fadeInUp 0.5s ease-out;
        }

        .stat-card {
            animation: slideInLeft 0.6s ease-out;
        }

        .stat-card:nth-child(2) {
            animation: slideInLeft 0.7s ease-out;
        }

        .stat-card:nth-child(3) {
            animation: slideInLeft 0.8s ease-out;
        }

        .stat-card:nth-child(4) {
            animation: slideInLeft 0.9s ease-out;
        }

        .filter-section {
            animation: slideInRight 0.6s ease-out;
        }

        /* Performance optimizations */
        .stat-card,
        .task-card,
        .btn-custom,
        .btn-edit,
        .btn-delete {
            will-change: transform;
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .stat-card,
            .task-card,
            .filter-section {
                border: 2px solid var(--text-primary);
            }
            
            .btn-custom,
            .btn-edit,
            .btn-delete {
                border: 2px solid var(--text-primary);
            }
        }

        /* Mobile Modal Improvements */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .modal-content {
                border-radius: 16px;
                border: none;
            }
            
            .modal-header {
                padding: 1rem 1.25rem;
                border-bottom: 1px solid var(--border-color);
            }
            
            .modal-title {
                font-size: 1.1rem;
                font-weight: 600;
            }
            
            .modal-body {
                padding: 1.25rem;
            }
            
            .modal-footer {
                padding: 1rem 1.25rem;
                border-top: 1px solid var(--border-color);
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .modal-footer .btn {
                width: 100%;
                margin: 0;
            }
            
            .form-label {
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            
            .form-control, .form-select {
                font-size: 0.9rem;
                padding: 0.75rem;
                border-radius: 8px;
                border: 1px solid var(--border-color);
                min-height: 44px;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }
            
            textarea.form-control {
                min-height: 100px;
                resize: vertical;
            }
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.25rem;
                max-width: calc(100% - 0.5rem);
            }
            
            .modal-header {
                padding: 0.75rem 1rem;
            }
            
            .modal-title {
                font-size: 1rem;
            }
            
            .modal-body {
                padding: 1rem;
            }
            
            .modal-footer {
                padding: 0.75rem 1rem;
            }
            
            .form-label {
                font-size: 0.8rem;
            }
            
            .form-control, .form-select {
                font-size: 0.85rem;
                padding: 0.6rem;
            }
        }

        /* Improved form controls for mobile */
        .form-control, .form-select {
            transition: all 0.2s ease;
            background-color: var(--white);
        }

        .form-control:hover, .form-select:hover {
            border-color: var(--primary-color);
        }

        /* Better focus states for accessibility */
        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        /* Mobile-friendly button states */
        .btn-custom:active, .btn-edit:active, .btn-delete:active {
            transform: scale(0.98);
        }

        /* Improved loading spinner for mobile */
        @media (max-width: 768px) {
            .loading {
                padding: 1.5rem;
            }
            
            .spinner-border {
                width: 2.5rem;
                height: 2.5rem;
            }
            
            .loading p {
                font-size: 0.9rem;
                margin-top: 0.75rem;
            }
        }

        /* Better scrollbar for mobile */
        @media (max-width: 768px) {
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            
            ::-webkit-scrollbar-track {
                background: transparent;
            }
            
            ::-webkit-scrollbar-thumb {
                background: rgba(0, 0, 0, 0.2);
                border-radius: 3px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: rgba(0, 0, 0, 0.3);
            }
        }

        /* Animations */
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

        /* Empty State Styles */
        .empty-state {
            text-align: center;
            padding: clamp(3rem, 8vw, 5rem);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-2xl);
            border: 1px solid var(--border-color-light);
            box-shadow: var(--shadow-md);
        }

        .empty-icon {
            width: clamp(60px, 10vw, 80px);
            height: clamp(60px, 10vw, 80px);
            margin: 0 auto clamp(1rem, 3vw, 2rem);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(2.5rem, 6vw, 4rem);
            color: var(--text-tertiary);
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: clamp(0.5rem, 1.5vw, 1rem);
        }

        .empty-state p {
            font-size: clamp(0.875rem, 2vw, 1.125rem);
            color: var(--text-secondary);
            margin: 0;
            opacity: 0.8;
        }

        /* Filter Actions */
        .filter-actions {
            display: flex;
            gap: clamp(0.75rem, 2vw, 1rem);
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        /* Task Buttons */
        .task-buttons {
            display: flex;
            gap: clamp(0.375rem, 1vw, 0.5rem);
        }

        .task-card {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Loading State */
        .loading {
            display: none;
            text-align: center;
            padding: clamp(2rem, 5vw, 3rem);
        }
        
        /* Mobile visibility fix */
        @media (max-width: 767px) {
            #taskContainer,
            #taskContainer [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                visibility: visible !important;
            }
        }

        .spinner-border {
            color: var(--primary-color);
            width: clamp(2rem, 4vw, 3rem);
            height: clamp(2rem, 4vw, 3rem);
        }

        .loading p {
            margin-top: clamp(0.75rem, 2vw, 1rem);
            font-size: clamp(0.875rem, 2vw, 1.125rem);
            color: var(--text-secondary);
        }

        /* Responsive Empty State */
        @media (max-width: 767px) {
            .empty-state {
                padding: clamp(2rem, 6vw, 3rem);
            }
            
            .empty-icon {
                width: clamp(48px, 8vw, 64px);
                height: clamp(48px, 8vw, 64px);
                font-size: clamp(2rem, 5vw, 3rem);
            }
            
            .empty-state h3 {
                font-size: clamp(1.125rem, 2.5vw, 1.5rem);
            }
            
            .empty-state p {
                font-size: clamp(0.75rem, 1.75vw, 1rem);
            }
        }

        @media (max-width: 575px) {
            .filter-actions {
                justify-content: stretch;
            }
            
            .filter-actions .btn-custom {
                flex: 1;
            }
        }

        /* Date Group Headers */
        .date-group-header {
            display: flex;
            align-items: center;
            margin: clamp(2rem, 5vw, 3rem) 0 clamp(1rem, 3vw, 2rem) 0;
            position: relative;
        }

        .date-group-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            min-width: 0;
            flex-shrink: 0;
        }

        .date-group-title {
            font-size: clamp(1.25rem, 3vw, 1.75rem);
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
            line-height: 1;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .date-group-count {
            font-size: clamp(0.75rem, 2vw, 0.9375rem);
            color: var(--text-secondary);
            font-weight: 600;
            opacity: 0.8;
        }

        .date-group-line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-200) 0%, transparent 100%);
            margin-left: clamp(1rem, 3vw, 2rem);
            position: relative;
        }

        .date-group-line::before {
            content: '';
            position: absolute;
            left: 0;
            top: -2px;
            width: 8px;
            height: 6px;
            background: var(--primary-color);
            border-radius: 50%;
            box-shadow: 0 0 0 2px var(--primary-100);
        }

        /* Special styling for Today and Yesterday */
        .date-group-header:has(.date-group-title:contains("Today")) .date-group-title {
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .date-group-header:has(.date-group-title:contains("Yesterday")) .date-group-title {
            background: var(--warning-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Alternative for browsers that don't support :has() */
        .date-group-header.today .date-group-title {
            background: var(--success-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .date-group-header.yesterday .date-group-title {
            background: var(--warning-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsive Date Group Headers */
        @media (max-width: 767px) {
            .date-group-header {
                margin: clamp(1.5rem, 4vw, 2.5rem) 0 clamp(0.75rem, 2vw, 1.5rem) 0;
            }
            
            .date-group-title {
                font-size: clamp(1.125rem, 2.5vw, 1.5rem);
            }
            
            .date-group-count {
                font-size: clamp(0.6875rem, 1.75vw, 0.875rem);
            }
            
            .date-group-line {
                margin-left: clamp(0.75rem, 2vw, 1.5rem);
            }
        }

        @media (max-width: 575px) {
            .date-group-header {
                flex-direction: column;
                align-items: flex-start;
                margin: clamp(1.25rem, 3vw, 2rem) 0 clamp(0.5rem, 2vw, 1rem) 0;
            }
            
            .date-group-info {
                margin-bottom: 0.5rem;
            }
            
            .date-group-line {
                width: 100%;
                margin-left: 0;
                margin-top: 0.5rem;
            }
        }

        /* Animation for date groups */
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .date-group-header {
            animation: slideInFromLeft 0.6s ease-out;
        }

        /* Pulse animation for today/yesterday */
        @keyframes subtle-pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }

        .date-group-header.today .date-group-title,
        .date-group-header.yesterday .date-group-title {
            animation: subtle-pulse 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <header class="header" role="banner">
        <div class="container-fluid">
            <div class="user-info">
                <div class="user-profile">
                    <div class="user-avatar" role="img" aria-label="User avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <h1 class="user-name">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->role === 1)
                                <span class="admin-badge">Admin</span>
                            @else
                                <span class="admin-badge" style="background: var(--info-gradient);">Employee</span>
                            @endif
                        </h1>
                        <p class="user-email">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <button type="button" class="logout-btn" onclick="showLogoutAlert()" aria-label="Logout from admin dashboard">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </div>
        </div>
    </header>

    <main class="main-container" role="main">
        <!-- Statistics Cards -->
        <section class="stats-grid" aria-label="Task Statistics">
            <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-trend">
                    <i class="bi bi-arrow-up"></i>
                </div>
                <div class="stat-icon primary" role="img" aria-label="Total tasks icon">
                    <i class="bi bi-list-task"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalTasks }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
            </div>
            <div class="stat-card success" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-trend">
                    <i class="bi bi-arrow-up"></i>
                </div>
                <div class="stat-icon success" role="img" aria-label="Completed tasks icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $completedTasks }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
            <div class="stat-card warning" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-trend">
                    <i class="bi bi-dash"></i>
                </div>
                <div class="stat-icon warning" role="img" aria-label="Pending tasks icon">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pendingTasks }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="stat-card info" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-trend">
                    <i class="bi bi-arrow-up"></i>
                </div>
                <div class="stat-icon info" role="img" aria-label="In progress tasks icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $inProgressTasks }}</div>
                    <div class="stat-label">In Progress</div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="filter-section" data-aos="fade-up" data-aos-delay="500" aria-label="Task Filters">
            <h2>
                <i class="bi bi-funnel"></i>
                <span>Filter Tasks</span>
            </h2>
            <form class="filter-form" onsubmit="return false;">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="filter_employee" class="form-label">
                            <i class="bi bi-person"></i>
                            <span>Employee</span>
                        </label>
                        <select id="filter_employee" class="form-select" aria-label="Filter by employee">
                            <option value="">All Employees</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_status" class="form-label">
                            <i class="bi bi-flag"></i>
                            <span>Status</span>
                        </label>
                        <select id="filter_status" class="form-select" aria-label="Filter by status">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="stopped">Stopped</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_date_from" class="form-label">
                            <i class="bi bi-calendar"></i>
                            <span>From Date</span>
                        </label>
                        <input type="date" id="filter_date_from" class="form-control" aria-label="Filter start date">
                    </div>
                    <div class="col-md-3">
                        <label for="filter_date_to" class="form-label">
                            <i class="bi bi-calendar"></i>
                            <span>To Date</span>
                        </label>
                        <input type="date" id="filter_date_to" class="form-control" aria-label="Filter end date">
                    </div>
                    <div class="col-12">
                        <div class="filter-actions">
                            <button type="button" class="btn btn-custom btn-filter" onclick="applyFilters()" aria-label="Apply filters">
                                <i class="bi bi-search"></i>
                                <span>Apply Filters</span>
                            </button>
                            <button type="button" class="btn btn-custom btn-reset" onclick="resetFilters()" aria-label="Reset filters">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span>Reset</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <!-- Tasks Container -->
        <section id="taskContainer" class="tasks-container" aria-label="Task List">
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
                        // Return formatted date for older tasks
                        return $task->format('d-m-Y');
                    }
                }
                
                // Group tasks by date
                $groupedTasks = [];
                foreach($allTasks as $task) {
                    $dateLabel = getDateGroupLabel($task->task_date);
                    if (!isset($groupedTasks[$dateLabel])) {
                        $groupedTasks[$dateLabel] = [];
                    }
                    $groupedTasks[$dateLabel][] = $task;
                }
                
                // Sort groups: Today, Yesterday, then by date (newest first)
                $priority = ['Today' => 0, 'Yesterday' => 1];
                uksort($groupedTasks, function($a, $b) use ($priority, $groupedTasks) {
                    $aPriority = isset($priority[$a]) ? $priority[$a] : 999;
                    $bPriority = isset($priority[$b]) ? $priority[$b] : 999;
                    
                    if ($aPriority !== $bPriority) {
                        return $aPriority - $bPriority;
                    }
                    
                    // For non-priority groups, sort by actual date
                    $aDate = $groupedTasks[$a][0]->task_date;
                    $bDate = $groupedTasks[$b][0]->task_date;
                    return strtotime($bDate) - strtotime($aDate);
                });
            @endphp
            
            @if($allTasks->count() > 0)
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
                        <div class="date-group-line"></div>
                    </div>
                    
                    @php($delayCounter += 50)@endphp
                    
                    <!-- Tasks in this group -->
                    @foreach($tasksInGroup as $task)
                        <article class="task-card" data-task-id="{{ $task->id }}" data-aos="fade-up" data-aos-delay="{{ $delayCounter }}">
                            <header class="task-header">
                                <span class="task-number" role="status" aria-label="Task number">Task {{ $task->task_number }}</span>
                                <time class="task-date" datetime="{{ $task->task_date->format('Y-m-d H:i') }}" aria-label="Task date">
                                    <i class="bi bi-calendar" aria-hidden="true"></i>
                                    <span>{{ $task->task_date->format('d-m-Y|h:i A') }}</span>
                                </time>
                            </header>
                            
                            <div class="task-employee">
                                <i class="bi bi-person" aria-hidden="true"></i>
                                <strong>Employee:</strong>
                                <span>{{ $task->user->name }}</span>
                            </div>
                            
                            <div class="task-description">
                                <p>{{ $task->task_description }}</p>
                            </div>
                            
                            <div class="task-client">
                                <i class="bi bi-briefcase" aria-hidden="true"></i>
                                <strong>Client/Project:</strong>
                                <span>{{ $task->client_project_name }}</span>
                            </div>
                            
                            <footer class="task-actions">
                                <div class="status-badge status-{{ $task->status }}" role="status" aria-label="Task status">
                                    <i class="bi bi-circle-fill" aria-hidden="true"></i>
                                    <span>{{ str_replace('_', ' ', $task->status) }}</span>
                                </div>
                                <div class="task-buttons">
                                    <button type="button" class="btn btn-edit" onclick="editTask({{ $task->id }})" aria-label="Edit task {{ $task->task_number }}">
                                        <i class="bi bi-pencil" aria-hidden="true"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-delete" onclick="deleteTask({{ $task->id }})" aria-label="Delete task {{ $task->task_number }}">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </footer>
                        </article>
                        @php($delayCounter += 50)@endphp
                    @endforeach
                @endforeach
            @else
                <div class="empty-state" data-aos="fade-up" data-aos-delay="600">
                    <div class="empty-icon">
                        <i class="bi bi-clipboard" aria-hidden="true"></i>
                    </div>
                    <h3>No Tasks Found</h3>
                    <p>No tasks have been created yet.</p>
                </div>
            @endif
        </section>

        <div class="loading" id="loadingSpinner">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading...</p>
        </div>
    </main>

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
                            <label for="edit_task_description" class="form-label">
                                <i class="bi bi-text-paragraph me-1"></i>Task Description
                            </label>
                            <textarea class="form-control" id="edit_task_description" name="task_description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_client_project_name" class="form-label">
                                <i class="bi bi-briefcase me-1"></i>Client/Project Name
                            </label>
                            <input type="text" class="form-control" id="edit_client_project_name" name="client_project_name" required>
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
                <button type="button" class="btn btn-cancel" onclick="hideLogoutAlert()">
                    Cancel
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS (Animate On Scroll)
        document.addEventListener('DOMContentLoaded', function() {
            const isMobile = /Mobile|Android|iPhone|iPad/.test(navigator.userAgent);
            
            AOS.init({
                duration: isMobile ? 0 : 800, // Disable animations on mobile
                easing: 'ease-in-out',
                once: true,
                offset: 100,
                mirror: false,
                disable: isMobile ? 'mobile' : false // Disable AOS completely on mobile
            });
            
            // Force visibility on mobile after AOS init
            if (isMobile) {
                setTimeout(() => {
                    const elements = document.querySelectorAll('[data-aos]');
                    elements.forEach(el => {
                        el.style.opacity = '1';
                        el.style.transform = 'none';
                    });
                }, 100);
            }
        });

        // Simple Alert Popup Functions
        function showLogoutAlert() {
            const alert = document.getElementById('logoutAlert');
            if (alert) {
                alert.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                // Add vibration on mobile
                if ('vibrate' in navigator) {
                    navigator.vibrate(30);
                }
            }
        }
        
        function hideLogoutAlert() {
            const alert = document.getElementById('logoutAlert');
            if (alert) {
                alert.classList.remove('show');
                document.body.style.overflow = '';
                
                // Add vibration on mobile
                if ('vibrate' in navigator) {
                    navigator.vibrate(15);
                }
            }
        }
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideLogoutModal();
            }
        });
        
        // Close modal on backdrop click (already handled in HTML)
        // Prevent modal content clicks from closing modal
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('logoutModal');
            if (modal && modal.classList.contains('show')) {
                const modalContent = modal.querySelector('.logout-modal-content');
                if (modalContent && !modalContent.contains(e.target)) {
                    // This will be handled by backdrop click
                }
            }
        });
        
        // Mobile touch enhancements for modal
        if ('ontouchstart' in window) {
            const modal = document.getElementById('logoutModal');
            if (modal) {
                modal.addEventListener('touchmove', function(e) {
                    // Prevent body scroll when modal is open on mobile
                    if (modal.classList.contains('show')) {
                        e.preventDefault();
                    }
                }, { passive: false });
            }
        }

        // Modern loading states
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
                // Reinitialize AOS for new content
                AOS.refresh();
            }
        }

        // Apply filters with modern async/await
        async function applyFilters() {
            try {
                showLoading();
                
                const filters = {
                    employee_id: document.getElementById('filter_employee')?.value || '',
                    status: document.getElementById('filter_status')?.value || '',
                    date_from: document.getElementById('filter_date_from')?.value || '',
                    date_to: document.getElementById('filter_date_to')?.value || ''
                };

                const response = await fetch('/admin/tasks/filter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify(filters)
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.tasks) {
                    renderTasks(data.tasks);
                } else {
                    showError('Error: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Filter error:', error);
                showError('An error occurred while filtering tasks. Please try again.');
            } finally {
                hideLoading();
            }
        }

        // Reset filters
        function resetFilters() {
            const employeeSelect = document.getElementById('filter_employee');
            const statusSelect = document.getElementById('filter_status');
            const dateFromInput = document.getElementById('filter_date_from');
            const dateToInput = document.getElementById('filter_date_to');
            
            if (employeeSelect) employeeSelect.value = '';
            if (statusSelect) statusSelect.value = '';
            if (dateFromInput) dateFromInput.value = '';
            if (dateToInput) dateToInput.value = '';
            
            location.reload();
        }

        // Modern error handling
        function showError(message) {
            // Create a toast notification instead of alert
            const toast = document.createElement('div');
            toast.className = 'error-toast';
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--danger-gradient);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: var(--radius-lg);
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

        // Helper function to get date group label
        function getDateGroupLabel(taskDate) {
            const today = new Date();
            const task = new Date(taskDate);
            
            // Reset time to compare dates only
            const todayStart = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            const taskStart = new Date(task.getFullYear(), task.getMonth(), task.getDate());
            
            const yesterdayStart = new Date(todayStart);
            yesterdayStart.setDate(yesterdayStart.getDate() - 1);
            
            // Calculate days difference
            const daysDiff = Math.floor((todayStart - taskStart) / (1000 * 60 * 60 * 24));
            
            if (taskStart.getTime() === todayStart.getTime()) {
                return 'Today';
            } else if (taskStart.getTime() === yesterdayStart.getTime()) {
                return 'Yesterday';
            } else {
                // Return formatted date for older tasks
                const day = String(task.getDate()).padStart(2, '0');
                const month = String(task.getMonth() + 1).padStart(2, '0');
                const year = task.getFullYear();
                return `${day}-${month}-${year}`;
            }
        }

        // Render tasks with date grouping
        function renderTasks(tasks) {
            const container = document.getElementById('taskContainer');
            
            if (!container) return;
            
            if (tasks.length === 0) {
                container.innerHTML = `
                    <div class="empty-state" data-aos="fade-up">
                        <div class="empty-icon">
                            <i class="bi bi-clipboard" aria-hidden="true"></i>
                        </div>
                        <h3>No Tasks Found</h3>
                        <p>No tasks found matching your filters.</p>
                    </div>
                `;
                AOS.refresh();
                return;
            }

            // Group tasks by date
            const groupedTasks = {};
            tasks.forEach(task => {
                const dateLabel = getDateGroupLabel(task.task_date);
                if (!groupedTasks[dateLabel]) {
                    groupedTasks[dateLabel] = [];
                }
                groupedTasks[dateLabel].push(task);
            });

            // Sort groups: Today, Yesterday, then by date (newest first)
            const sortedGroups = Object.keys(groupedTasks).sort((a, b) => {
                const priority = { 'Today': 0, 'Yesterday': 1 };
                const aPriority = priority[a] !== undefined ? priority[a] : 999;
                const bPriority = priority[b] !== undefined ? priority[b] : 999;
                
                if (aPriority !== bPriority) {
                    return aPriority - bPriority;
                }
                
                // For non-priority groups, sort by actual date
                const aDate = groupedTasks[a][0].task_date;
                const bDate = groupedTasks[b][0].task_date;
                return new Date(bDate) - new Date(aDate);
            });

            let html = '';
            let delayCounter = 100;

            sortedGroups.forEach((groupLabel, groupIndex) => {
                const tasksInGroup = groupedTasks[groupLabel];
                
                // Add appropriate CSS class for Today and Yesterday
                const headerClass = groupLabel === 'Today' ? 'today' : groupLabel === 'Yesterday' ? 'yesterday' : '';
                
                // Add date header
                html += `
                    <div class="date-group-header ${headerClass}" data-aos="fade-up" data-aos-delay="${delayCounter}">
                        <div class="date-group-info">
                            <h3 class="date-group-title">${groupLabel}</h3>
                            <span class="date-group-count">${tasksInGroup.length} task${tasksInGroup.length !== 1 ? 's' : ''}</span>
                        </div>
                        <div class="date-group-line"></div>
                    </div>
                `;
                delayCounter += 50;

                // Add tasks in this group
                tasksInGroup.forEach((task, taskIndex) => {
                    html += `
                        <article class="task-card" data-task-id="${task.id}" data-aos="fade-up" data-aos-delay="${delayCounter}">
                            <header class="task-header">
                                <span class="task-number" role="status">Task ${task.task_number}</span>
                                <time class="task-date" datetime="${new Date(task.task_date).toISOString()}">
                                    <i class="bi bi-calendar" aria-hidden="true"></i>
                                    <span>${formatTaskDateTime(task.task_date)}</span>
                                </time>
                            </header>
                            
                            <div class="task-employee">
                                <i class="bi bi-person" aria-hidden="true"></i>
                                <strong>Employee:</strong>
                                <span>${task.user?.name || 'Unknown'}</span>
                            </div>
                            
                            <div class="task-description">
                                <p>${task.task_description}</p>
                            </div>
                            
                            <div class="task-client">
                                <i class="bi bi-briefcase" aria-hidden="true"></i>
                                <strong>Client/Project:</strong>
                                <span>${task.client_project_name}</span>
                            </div>
                            
                            <footer class="task-actions">
                                <div class="status-badge status-${task.status}" role="status">
                                    <i class="bi bi-circle-fill" aria-hidden="true"></i>
                                    <span>${task.status.replace('_', ' ')}</span>
                                </div>
                                <div class="task-buttons">
                                    <button type="button" class="btn btn-edit" onclick="editTask(${task.id})" aria-label="Edit task ${task.task_number}">
                                        <i class="bi bi-pencil" aria-hidden="true"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-delete" onclick="deleteTask(${task.id})" aria-label="Delete task ${task.task_number}">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </footer>
                        </article>
                    `;
                    delayCounter += 50;
                });
            });
            
            container.innerHTML = html;
            AOS.refresh();
            
            // Force visibility on mobile after rendering
            const isMobile = /Mobile|Android|iPhone|iPad/.test(navigator.userAgent);
            if (isMobile) {
                setTimeout(() => {
                    const elements = container.querySelectorAll('[data-aos]');
                    elements.forEach(el => {
                        el.style.opacity = '1';
                        el.style.transform = 'none';
                        el.classList.add('aos-animate');
                    });
                }, 50);
            }
        }

        // Edit Task with modern async/await
        async function editTask(taskId) {
            try {
                showLoading();
                
                const response = await fetch(`/admin/task/${taskId}/edit`);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    const taskIdInput = document.getElementById('edit_task_id');
                    const taskDateInput = document.getElementById('edit_task_date');
                    const taskDescInput = document.getElementById('edit_task_description');
                    const clientInput = document.getElementById('edit_client_project_name');
                    const statusInput = document.getElementById('edit_status');
                    
                    if (taskIdInput) taskIdInput.value = data.task.id;
                    
                    // Format the date for datetime-local input
                    const taskDate = new Date(data.task.task_date);
                    const formattedDate = taskDate.toISOString().slice(0, 16);
                    
                    if (taskDateInput) taskDateInput.value = formattedDate;
                    if (taskDescInput) taskDescInput.value = data.task.task_description;
                    if (clientInput) clientInput.value = data.task.client_project_name;
                    if (statusInput) statusInput.value = data.task.status;
                    
                    const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                    modal.show();
                } else {
                    showError('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Edit task error:', error);
                showError('An error occurred while loading task. Please try again.');
            } finally {
                hideLoading();
            }
        }

        // Edit Task Form Submission with modern event handling
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('editTaskForm');
            
            if (editForm) {
                editForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    try {
                        showLoading();
                        
                        const taskIdInput = document.getElementById('edit_task_id');
                        const taskId = taskIdInput?.value;
                        
                        if (!taskId) {
                            throw new Error('Task ID not found');
                        }
                        
                        const formData = new FormData(this);
                        
                        const response = await fetch(`/admin/task/${taskId}/update`, {
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
                            
                            // Show success message
                            showSuccess('Task updated successfully!');
                            
                            // Reload after a short delay
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showError('Error: ' + data.message);
                        }
                    } catch (error) {
                        console.error('Update task error:', error);
                        showError('An error occurred while updating task. Please try again.');
                    } finally {
                        hideLoading();
                    }
                });
            }
        });

        // Delete Task with modern confirmation
        async function deleteTask(taskId) {
            if (confirm('Are you sure you want to delete this task? This action cannot be undone.')) {
                try {
                    showLoading();
                    
                    const response = await fetch(`/admin/task/${taskId}/delete`, {
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
                    showError('An error occurred while deleting task. Please try again.');
                } finally {
                    hideLoading();
                }
            }
        }

        // Success message function
        function showSuccess(message) {
            const toast = document.createElement('div');
            toast.className = 'success-toast';
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--success-gradient);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: var(--radius-lg);
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

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // ESC key to close modals
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    const instance = bootstrap.Modal.getInstance(modal);
                    if (instance) instance.hide();
                });
            }
        });

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
