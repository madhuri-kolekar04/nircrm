<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Recordings - NIR CRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.03"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.03"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.02"/><circle cx="10" cy="50" r="0.5" fill="white" opacity="0.02"/><circle cx="90" cy="90" r="0.5" fill="white" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
            z-index: 1;
        }
        
        .main-container {
            position: relative;
            z-index: 2;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .header-gradient {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .recording-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
            position: relative;
            overflow: hidden;
        }
        
        .recording-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .recording-card:hover::before {
            left: 100%;
        }
        
        .recording-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .play-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .play-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .play-button:hover::before {
            width: 100px;
            height: 100px;
        }
        
        .play-button:hover {
            transform: scale(1.15) rotate(5deg);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        .sync-badge {
            animation: pulse 2s infinite;
            position: relative;
            overflow: hidden;
        }
        
        .sync-badge::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.5) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { 
                opacity: 1; 
                transform: scale(1);
            }
            50% { 
                opacity: 0.8; 
                transform: scale(1.05);
            }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .mobile-audio-controls {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .floating-action-btn {
            animation: float 4s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
            }
            25% { 
                transform: translateY(-10px) rotate(-5deg); 
            }
            75% { 
                transform: translateY(-5px) rotate(5deg); 
            }
        }
        
        .stat-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transition: all 0.3s;
        }
        
        .stat-card:hover::before {
            top: -25%;
            right: -25%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .avatar-circle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        .avatar-circle::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
            animation: rotate 3s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .audio-player {
            width: 100%;
            max-width: 100%;
        }
        
        .custom-audio-player {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 12px;
            backdrop-filter: blur(10px);
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 3px;
            width: 0%;
            transition: width 0.1s ease;
            position: relative;
        }
        
        .progress-ball {
            position: absolute;
            right: -8px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            cursor: grab;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .progress-bar:hover .progress-ball {
            opacity: 1;
        }
        
        .progress-bar:active .progress-ball {
            cursor: grabbing;
        }
        
        .time-display {
            font-size: 12px;
            color: #4b5563;
            font-weight: 500;
            min-width: 100px;
            text-align: center;
        }
        
        .audio-controls-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
        }
        
        /* Force mobile layout globally - remove responsive breakpoints */
        
        .main-container {
            padding-bottom: 80px;
        }
        
        .recording-card {
            margin-bottom: 1rem;
            border-radius: 1rem;
            transform: translateZ(0);
        }
        
        .mobile-audio-controls {
            padding: 1.5rem 1rem;
            border-radius: 1.5rem 1.5rem 0 0;
        }
        
        .header-gradient {
            padding: 1rem;
        }
        
        .stat-card {
            margin-bottom: 0.75rem;
        }
        
        .avatar-circle {
            width: 3.5rem;
            height: 3.5rem;
            font-size: 1.25rem;
        }
        
        .play-button {
            width: 3.5rem;
            height: 3.5rem;
        }
        
        .header-gradient h1 {
            font-size: 1.25rem;
        }
        
        .recording-card {
            padding: 1rem;
        }
        
        .avatar-circle {
            width: 3rem;
            height: 3rem;
            font-size: 1rem;
        }
        
        /* Force mobile grid layout */
        .grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }
        
        /* Hide desktop-specific elements */
        .hidden {
            display: none !important;
        }
        
        /* Force mobile text sizes */
        .text-lg {
            font-size: 1.125rem !important;
            line-height: 1.75rem !important;
        }
        
        .text-xl {
            font-size: 1.25rem !important;
            line-height: 1.75rem !important;
        }
        
        /* Force mobile spacing */
        .px-4 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        
        .py-4 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        
        .px-6 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        
        .py-6 {
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        /* Loading animation */
        .shimmer-text {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 25%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.1) 75%);
            background-size: 200% 100%;
            animation: shimmer-text 1.5s infinite;
        }
        
        @keyframes shimmer-text {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header -->
        <header class="header-gradient sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <button onclick="history.back()" class="text-white hover:bg-white/20 p-2 rounded-xl transition-all duration-300 transform hover:scale-110">
                            <i class="fas fa-arrow-left text-base"></i>
                        </button>
                        <div class="flex items-center space-x-2">
                            <div class="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-microphone text-white text-base"></i>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold text-gray-800">Call Recordings</h1>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <!-- Recordings Count -->
                        <div class="text-right">
                            <p class="text-gray-600 text-xs">Total Recordings</p>
                            <p class="text-gray-800 font-bold text-lg">{{ count($recordings) }}</p>
                        </div>
                        
                        <!-- Refresh Button -->
                        <button onclick="refreshPage()" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-xl transition-all duration-300 transform hover:scale-110 hover:rotate-180">
                            <i class="fas fa-sync-alt text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 py-4">
            <!-- Role-based Info -->
            <div class="glass-card rounded-xl p-4 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-500/20 p-2 rounded-xl">
                        <i class="fas fa-info-circle text-blue-300"></i>
                    </div>
                    <div>
                        @if(Auth::user()->role == 1)
                            <p class="text-gray-800 font-medium text-sm">Viewing All Employee Recordings</p>
                            <p class="text-gray-600 text-xs">As Admin, you can see all call recordings from all employees</p>
                        @elseif(Auth::user()->role == 2)
                            <p class="text-gray-800 font-medium text-sm">Viewing Your Recordings Only</p>
                            <p class="text-gray-600 text-xs">As Employee, you can only see your own call recordings</p>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($recordings->count() > 0)
                <!-- Stats Cards -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="glass-card stat-card rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-600 text-xs mb-1">Manual</p>
                                <p class="text-gray-800 text-xl font-bold">{{ $recordings->where('sync_type', 'Manual')->count() }}</p>
                            </div>
                            <div class="bg-green-500/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-hand-pointer text-green-300 text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card stat-card rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-600 text-xs mb-1">Auto</p>
                                <p class="text-gray-800 text-xl font-bold">{{ $recordings->where('sync_type', 'AutoSync')->count() }}</p>
                            </div>
                            <div class="bg-yellow-500/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-robot text-yellow-300 text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card stat-card rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-600 text-xs mb-1">Today</p>
                                <p class="text-gray-800 text-xl font-bold">{{ count($todayRecordings) }}</p>
                            </div>
                            <div class="bg-blue-500/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-calendar-day text-blue-300 text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card stat-card rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-600 text-xs mb-1">Total</p>
                                <p class="text-gray-800 text-xl font-bold">{{ $recordings->count() }}</p>
                            </div>
                            <div class="bg-purple-500/20 p-3 rounded-xl backdrop-blur-sm">
                                <i class="fas fa-microphone text-purple-300 text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Recordings -->
                @if(count($todayRecordings) > 0)
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-500 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                                <i class="fas fa-calendar-day"></i>
                                <span class="font-bold">Today</span>
                                <span class="bg-white/20 px-2 py-1 rounded-full text-xs">{{ count($todayRecordings) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @foreach($todayRecordings as $recording)
                                @include('partials.recording-card', ['recording' => $recording])
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Yesterday's Recordings -->
                @if(count($yesterdayRecordings) > 0)
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-500 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                                <i class="fas fa-calendar"></i>
                                <span class="font-bold">Yesterday</span>
                                <span class="bg-white/20 px-2 py-1 rounded-full text-xs">{{ count($yesterdayRecordings) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @foreach($yesterdayRecordings as $recording)
                                @include('partials.recording-card', ['recording' => $recording])
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Past Recordings -->
                @if(count($pastRecordings) > 0)
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-600 text-white px-4 py-2 rounded-full flex items-center space-x-2">
                                <i class="fas fa-history"></i>
                                <span class="font-bold">Past Recordings</span>
                                <span class="bg-white/20 px-2 py-1 rounded-full text-xs">{{ count($pastRecordings) }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @foreach($pastRecordings as $recording)
                                @include('partials.recording-card', ['recording' => $recording])
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <div class="glass-card w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-microphone-slash text-4xl text-white/60"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">No Recordings Found</h3>
                        <p class="text-gray-600 mb-8">No call recordings have been synced yet. Start making calls to see recordings here.</p>
                        <div class="flex flex-col gap-3 justify-center">
                            <a href="{{ url('/callingapp') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-phone mr-2"></i>
                                Go to Calling App
                            </a>
                            <button onclick="refreshPage()" class="inline-flex items-center justify-center px-6 py-3 glass-card text-white font-bold rounded-xl hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </main>

        <!-- Floating Action Button -->
        <div class="fixed bottom-6 right-6 z-40">
            <a href="{{ url('/callingapp') }}" class="floating-action-btn bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full p-4 transition-all duration-300 hover:scale-110">
                <i class="fas fa-phone text-xl"></i>
            </a>
        </div>

        <!-- Audio Controls (Sticky) -->
        <div class="mobile-audio-controls fixed bottom-0 left-0 right-0 z-30 hidden" id="mobileAudioControls">
            <div class="w-full max-w-lg mx-auto">
                <!-- Gradient Background with Blur -->
                <div class="bg-gradient-to-r from-purple-600/95 via-blue-600/95 to-indigo-600/95 backdrop-blur-xl border-t border-white/20 shadow-2xl rounded-t-3xl">
                    <!-- Handle Bar -->
                    <div class="flex justify-center py-2">
                        <div class="w-12 h-1 bg-white/30 rounded-full"></div>
                    </div>
                    
                    <!-- Header Section -->
                    <div class="px-6 pb-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- Animated Music Icon -->
                                <div class="relative">
                                    <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                    <div class="relative bg-white/30 p-3 rounded-full backdrop-blur-sm">
                                        <i class="fas fa-music text-white text-lg"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-lg" id="mobileCustomerName">Now Playing</h4>
                                    <p class="text-white/70 text-xs" id="mobileCustomerPhone">Call Recording</p>
                                </div>
                            </div>
                            <button onclick="closeMobileAudio()" class="text-white/80 hover:text-white hover:bg-white/20 p-2 rounded-xl transition-all duration-300 transform hover:scale-110">
                                <i class="fas fa-chevron-down text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Custom Audio Player -->
                    <div class="px-6 pb-6">
                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="bg-white/20 rounded-full h-2 relative overflow-hidden cursor-pointer" onclick="seekMobileAudio(event)">
                                <div class="bg-gradient-to-r from-green-400 to-blue-400 h-full rounded-full transition-all duration-300 relative" id="mobileProgressFill" style="width: 0%">
                                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 w-4 h-4 bg-white rounded-full shadow-lg"></div>
                                </div>
                            </div>
                            <div class="flex justify-between mt-2 text-xs text-white/70">
                                <span id="mobileCurrentTime">0:00</span>
                                <span id="mobileTotalTime">0:00</span>
                            </div>
                        </div>
                        
                        <!-- Control Buttons -->
                        <div class="flex items-center justify-center space-x-6">
                            <!-- Previous Button (Disabled) -->
                            <button class="text-white/60 hover:text-white transition-colors" disabled>
                                <i class="fas fa-backward text-xl"></i>
                            </button>
                            
                            <!-- Play/Pause Button -->
                            <button onclick="toggleMobileAudio()" class="bg-white/20 hover:bg-white/30 text-white p-4 rounded-full transition-all duration-300 transform hover:scale-110 shadow-lg">
                                <i class="fas fa-play text-2xl" id="mobilePlayIcon"></i>
                            </button>
                            
                            <!-- Next Button (Disabled) -->
                            <button class="text-white/60 hover:text-white transition-colors" disabled>
                                <i class="fas fa-forward text-xl"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Hidden native audio element -->
                    <audio id="mobileAudioPlayer" class="hidden" preload="metadata">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
        
            </div>

    <script>
        let currentAudio = null;
        let currentPlayIcon = null;
        let currentProgressInterval = null;
        
        // Global audio manager to prevent multiple audio playback
        document.addEventListener('play', function(e) {
            const audios = document.getElementsByTagName('audio');
            const mobilePlayer = document.getElementById('mobileAudioPlayer');
            
            for(let i = 0, len = audios.length; i < len; i++) {
                // Don't pause the mobile player if the main audio is playing (they should sync)
                // and don't pause the main audio if mobile player is playing
                if(audios[i] != e.target && 
                   audios[i] != mobilePlayer && 
                   e.target != mobilePlayer) {
                    audios[i].pause();
                }
            }
        }, true);

        function toggleAudio(audioUrl, recordingId) {
            const audio = document.getElementById(`audio-${recordingId}`);
            const playIcon = document.getElementById(`play-icon-${recordingId}`);
            const controlIcon = document.getElementById(`control-icon-${recordingId}`);
            const customPlayer = document.getElementById(`custom-player-${recordingId}`);
            
            // Stop currently playing audio and sync mobile player
            if (currentAudio && currentAudio !== audio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
                if (currentPlayIcon) {
                    currentPlayIcon.classList.remove('fa-pause');
                    currentPlayIcon.classList.add('fa-play');
                }
                // Hide previous custom player
                const prevCustomPlayer = document.getElementById(`custom-player-${currentAudio.dataset.recordingId}`);
                if (prevCustomPlayer) prevCustomPlayer.style.display = 'none';
                clearInterval(currentProgressInterval);
                
                // Stop mobile player
                const mobilePlayer = document.getElementById('mobileAudioPlayer');
                mobilePlayer.pause();
                mobilePlayer.currentTime = 0;
            }
            
            if (audio.paused) {
                // Set maximum volume for HD voice quality
                audio.volume = 1.0;
                
                // Play the selected audio
                audio.play();
                playIcon.classList.remove('fa-play');
                playIcon.classList.add('fa-pause');
                controlIcon.classList.remove('fa-play');
                controlIcon.classList.add('fa-pause');
                customPlayer.style.display = 'block';
                currentAudio = audio;
                currentPlayIcon = playIcon;
                audio.dataset.recordingId = recordingId;
                
                // Start progress updates
                startProgressUpdate(recordingId);
                
                // Sync and show mobile audio controls
                showMobileAudio(audioUrl);
                
                // Sync mobile player with main audio (but don't play mobile player to prevent echo)
                const mobilePlayer = document.getElementById('mobileAudioPlayer');
                // Mobile player syncs with main audio but doesn't play separately
                mobilePlayer.currentTime = audio.currentTime;
            } else {
                // Pause the audio
                audio.pause();
                playIcon.classList.remove('fa-pause');
                playIcon.classList.add('fa-play');
                controlIcon.classList.remove('fa-pause');
                controlIcon.classList.add('fa-play');
                customPlayer.style.display = 'none';
                currentAudio = null;
                currentPlayIcon = null;
                clearInterval(currentProgressInterval);
                
                // Hide and pause mobile audio controls
                closeMobileAudio();
            }
            
            // Remove existing event listeners to prevent duplicates
            audio.removeEventListener('ended', handleAudioEnd);
            audio.removeEventListener('loadedmetadata', handleLoadedMetadata);
            
            // Add event listeners (defined outside to avoid duplicates)
            audio.addEventListener('ended', handleAudioEnd);
            audio.addEventListener('loadedmetadata', handleLoadedMetadata);
        }
        
        // Define event handlers outside the function to prevent duplicates
        function handleAudioEnd() {
            const recordingId = this.dataset.recordingId;
            const playIcon = document.getElementById(`play-icon-${recordingId}`);
            const controlIcon = document.getElementById(`control-icon-${recordingId}`);
            const customPlayer = document.getElementById(`custom-player-${recordingId}`);
            
            playIcon.classList.remove('fa-pause');
            playIcon.classList.add('fa-play');
            controlIcon.classList.remove('fa-pause');
            controlIcon.classList.add('fa-play');
            customPlayer.style.display = 'none';
            currentAudio = null;
            currentPlayIcon = null;
            clearInterval(currentProgressInterval);
            closeMobileAudio();
            
            // Reset progress
            const progressFill = document.getElementById(`progress-fill-${recordingId}`);
            const timeDisplay = document.getElementById(`time-display-${recordingId}`);
            if (progressFill) progressFill.style.width = '0%';
            if (timeDisplay) timeDisplay.textContent = '0:00 / 0:00';
        }
        
        function handleLoadedMetadata() {
            const recordingId = this.dataset.recordingId;
            updateTimeDisplay(recordingId);
        }
        
        function startProgressUpdate(recordingId) {
            clearInterval(currentProgressInterval);
            currentProgressInterval = setInterval(() => {
                updateProgress(recordingId);
            }, 100);
        }
        
        function updateProgress(recordingId) {
            const audio = document.getElementById(`audio-${recordingId}`);
            const progressFill = document.getElementById(`progress-fill-${recordingId}`);
            const timeDisplay = document.getElementById(`time-display-${recordingId}`);
            
            if (audio && progressFill && timeDisplay) {
                const progress = (audio.currentTime / audio.duration) * 100;
                progressFill.style.width = progress + '%';
                updateTimeDisplay(recordingId);
            }
        }
        
        function updateTimeDisplay(recordingId) {
            const audio = document.getElementById(`audio-${recordingId}`);
            const timeDisplay = document.getElementById(`time-display-${recordingId}`);
            
            if (audio && timeDisplay) {
                const currentMinutes = Math.floor(audio.currentTime / 60);
                const currentSeconds = Math.floor(audio.currentTime % 60);
                const durationMinutes = Math.floor(audio.duration / 60) || 0;
                const durationSeconds = Math.floor(audio.duration % 60) || 0;
                
                const currentTimeStr = `${currentMinutes}:${currentSeconds.toString().padStart(2, '0')}`;
                const durationStr = `${durationMinutes}:${durationSeconds.toString().padStart(2, '0')}`;
                
                timeDisplay.textContent = `${currentTimeStr} / ${durationStr}`;
            }
        }
        
        function seekAudio(event, recordingId) {
            const audio = document.getElementById(`audio-${recordingId}`);
            const progressBar = document.getElementById(`progress-${recordingId}`);
            
            if (audio && progressBar) {
                const rect = progressBar.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const width = rect.width;
                const percentage = x / width;
                const newTime = percentage * audio.duration;
                
                audio.currentTime = newTime;
                updateProgress(recordingId);
            }
        }

        function showMobileAudio(audioUrl) {
            const mobileControls = document.getElementById('mobileAudioControls');
            const mobilePlayer = document.getElementById('mobileAudioPlayer');
            const mobilePlayIcon = document.getElementById('mobilePlayIcon');
            const mobileCustomerName = document.getElementById('mobileCustomerName');
            const mobileCustomerPhone = document.getElementById('mobileCustomerPhone');
            
            mobilePlayer.src = audioUrl;
            mobileControls.classList.remove('hidden');
            
            // Get current recording data and update customer info
            if (currentAudio) {
                const recordingId = currentAudio.dataset.recordingId;
                const recordingCard = currentAudio.closest('.recording-card');
                
                if (recordingCard) {
                    // Extract customer name and phone from the recording card
                    const customerNameEl = recordingCard.querySelector('h3');
                    const customerPhoneEl = recordingCard.querySelector('a[href^="tel:"]');
                    
                    if (customerNameEl) {
                        mobileCustomerName.textContent = customerNameEl.textContent.trim();
                    }
                    
                    if (customerPhoneEl) {
                        mobileCustomerPhone.textContent = customerPhoneEl.textContent.trim();
                    }
                }
                
                mobilePlayer.currentTime = currentAudio.currentTime;
                
                // Update play icon
                if (!currentAudio.paused) {
                    mobilePlayIcon.classList.remove('fa-play');
                    mobilePlayIcon.classList.add('fa-pause');
                }
                
                // Add sync event listeners with conflict prevention
                let isMobileTriggered = false;
                
                mobilePlayer.ontimeupdate = function() {
                    updateMobileProgress();
                    if (!isMobileTriggered && currentAudio && Math.abs(mobilePlayer.currentTime - currentAudio.currentTime) > 0.5) {
                        isMobileTriggered = true;
                        currentAudio.currentTime = mobilePlayer.currentTime;
                        setTimeout(() => isMobileTriggered = false, 100);
                    }
                };
                
                mobilePlayer.onplay = function() {
                    if (!isMobileTriggered) {
                        isMobileTriggered = true;
                        // Immediately pause mobile player to prevent echo
                        this.pause();
                        mobilePlayIcon.classList.remove('fa-play');
                        mobilePlayIcon.classList.add('fa-pause');
                        if (currentAudio && currentAudio.paused) {
                            currentAudio.play().catch(e => console.log('Sync play failed:', e));
                        }
                        setTimeout(() => isMobileTriggered = false, 100);
                    }
                };
                
                mobilePlayer.onpause = function() {
                    if (!isMobileTriggered) {
                        isMobileTriggered = true;
                        mobilePlayIcon.classList.remove('fa-pause');
                        mobilePlayIcon.classList.add('fa-play');
                        if (currentAudio && !currentAudio.paused) {
                            currentAudio.pause();
                        }
                        setTimeout(() => isMobileTriggered = false, 100);
                    }
                };
                
                mobilePlayer.onseeked = function() {
                    if (!isMobileTriggered && currentAudio) {
                        isMobileTriggered = true;
                        currentAudio.currentTime = mobilePlayer.currentTime;
                        setTimeout(() => isMobileTriggered = false, 100);
                    }
                };
                
                mobilePlayer.onloadedmetadata = function() {
                    updateMobileTimeDisplay();
                };
            }
        }
        
        function toggleMobileAudio() {
            const mobilePlayIcon = document.getElementById('mobilePlayIcon');
            
            if (currentAudio) {
                if (currentAudio.paused) {
                    // Play the main audio
                    currentAudio.play().then(() => {
                        mobilePlayIcon.classList.remove('fa-play');
                        mobilePlayIcon.classList.add('fa-pause');
                    }).catch(error => {
                        console.log('Main audio play failed:', error);
                        mobilePlayIcon.classList.remove('fa-pause');
                        mobilePlayIcon.classList.add('fa-play');
                    });
                } else {
                    // Pause the main audio
                    currentAudio.pause();
                    mobilePlayIcon.classList.remove('fa-pause');
                    mobilePlayIcon.classList.add('fa-play');
                }
            }
        }
        
        function seekMobileAudio(event) {
            if (currentAudio) {
                const progressBar = event.currentTarget;
                const rect = progressBar.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const percentage = x / rect.width;
                const newTime = percentage * currentAudio.duration;
                
                currentAudio.currentTime = newTime;
                updateMobileProgress();
            }
        }
        
        function updateMobileProgress() {
            const progressFill = document.getElementById('mobileProgressFill');
            
            if (currentAudio && progressFill && currentAudio.duration) {
                const progress = (currentAudio.currentTime / currentAudio.duration) * 100;
                progressFill.style.width = progress + '%';
                updateMobileTimeDisplay();
            }
        }
        
        function updateMobileTimeDisplay() {
            const currentTimeEl = document.getElementById('mobileCurrentTime');
            const totalTimeEl = document.getElementById('mobileTotalTime');
            
            if (currentAudio && currentTimeEl && totalTimeEl) {
                const currentMinutes = Math.floor(currentAudio.currentTime / 60);
                const currentSeconds = Math.floor(currentAudio.currentTime % 60);
                const durationMinutes = Math.floor(currentAudio.duration / 60) || 0;
                const durationSeconds = Math.floor(currentAudio.duration % 60) || 0;
                
                const currentTimeStr = `${currentMinutes}:${currentSeconds.toString().padStart(2, '0')}`;
                const durationStr = `${durationMinutes}:${durationSeconds.toString().padStart(2, '0')}`;
                
                currentTimeEl.textContent = currentTimeStr;
                totalTimeEl.textContent = durationStr;
            }
        }
        
        // Add drag functionality for progress ball
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-bar');
            
            progressBars.forEach(bar => {
                let isDragging = false;
                const progressBall = bar.querySelector('.progress-ball');
                
                if (progressBall) {
                    progressBall.addEventListener('mousedown', function(e) {
                        isDragging = true;
                        e.preventDefault();
                    });
                    
                    document.addEventListener('mousemove', function(e) {
                        if (isDragging) {
                            const rect = bar.getBoundingClientRect();
                            const x = Math.max(0, Math.min(e.clientX - rect.left, rect.width));
                            const percentage = (x / rect.width) * 100;
                            
                            const recordingId = bar.id.replace('progress-', '');
                            const audio = document.getElementById(`audio-${recordingId}`);
                            const progressFill = document.getElementById(`progress-fill-${recordingId}`);
                            
                            if (audio && progressFill) {
                                progressFill.style.width = percentage + '%';
                                const newTime = (percentage / 100) * audio.duration;
                                audio.currentTime = newTime;
                            }
                        }
                    });
                    
                    document.addEventListener('mouseup', function() {
                        isDragging = false;
                    });
                }
            });
        });

        function closeMobileAudio() {
            const mobileControls = document.getElementById('mobileAudioControls');
            const mobilePlayer = document.getElementById('mobileAudioPlayer');
            const mobilePlayIcon = document.getElementById('mobilePlayIcon');
            const mobileCustomerName = document.getElementById('mobileCustomerName');
            const mobileCustomerPhone = document.getElementById('mobileCustomerPhone');
            
            mobileControls.classList.add('hidden');
            mobilePlayer.pause();
            mobilePlayer.currentTime = 0;
            
            // Reset play icon
            mobilePlayIcon.classList.remove('fa-pause');
            mobilePlayIcon.classList.add('fa-play');
            
            // Reset customer info to default
            mobileCustomerName.textContent = 'Now Playing';
            mobileCustomerPhone.textContent = 'Call Recording';
            
            // Reset progress
            const progressFill = document.getElementById('mobileProgressFill');
            const currentTimeEl = document.getElementById('mobileCurrentTime');
            const totalTimeEl = document.getElementById('mobileTotalTime');
            
            if (progressFill) progressFill.style.width = '0%';
            if (currentTimeEl) currentTimeEl.textContent = '0:00';
            if (totalTimeEl) totalTimeEl.textContent = '0:00';
            
            // Clear mobile player event listeners
            mobilePlayer.ontimeupdate = null;
            mobilePlayer.onplay = null;
            mobilePlayer.onpause = null;
            mobilePlayer.onseeked = null;
            mobilePlayer.onloadedmetadata = null;
        }

        function changeVolume(recordingId, value) {
            const audio = document.getElementById(`audio-${recordingId}`);
            if (audio) {
                audio.volume = value / 100;
            }
        }
        
        function toggleMute(recordingId) {
            const audio = document.getElementById(`audio-${recordingId}`);
            const volumeIcon = document.getElementById(`volume-icon-${recordingId}`);
            const volumeSlider = document.getElementById(`volume-${recordingId}`);
            
            if (audio) {
                if (audio.muted) {
                    audio.muted = false;
                    volumeIcon.classList.remove('fa-volume-mute');
                    volumeIcon.classList.add('fa-volume-up');
                    volumeSlider.value = audio.volume * 100;
                } else {
                    audio.muted = true;
                    volumeIcon.classList.remove('fa-volume-up');
                    volumeIcon.classList.add('fa-volume-mute');
                }
            }
        }
        
       

        // Add keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                history.back();
            }
            if (e.key === 'r' && e.ctrlKey) {
                e.preventDefault();
                refreshPage();
            }
        });

        // Add pull-to-refresh for mobile
        let touchStartY = 0;
        let touchEndY = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartY = e.changedTouches[0].screenY;
        });

        document.addEventListener('touchend', function(e) {
            touchEndY = e.changedTouches[0].screenY;
            handleSwipe();
        });

        function handleSwipe() {
            if (touchEndY < touchStartY - 50) {
                // Swipe up - do nothing
            }
            if (touchEndY > touchStartY + 50) {
                // Swipe down - refresh
                if (window.scrollY === 0) {
                    refreshPage();
                }
            }
        }

        // Add haptic feedback for mobile (if supported)
        if ('vibrate' in navigator) {
            document.querySelectorAll('button').forEach(button => {
                button.addEventListener('click', () => {
                    navigator.vibrate(50);
                });
            });
        }

        // Refresh page function
        function refreshPage() {
            location.reload();
        }
    </script>
</body>
</html>
