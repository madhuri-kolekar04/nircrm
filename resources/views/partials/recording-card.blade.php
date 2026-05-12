<div class="glass-card recording-card rounded-2xl overflow-hidden">
    <!-- Employee Name Header -->
    <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-3 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                    <i class="fas fa-user-tie text-sm"></i>
                </div>
                <div>
                    <p class="text-xs opacity-80">Uploaded by</p>
                    <p class="font-bold text-sm">{{ $recording->employee_name ?? 'Unknown Employee' }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="sync-badge px-2 py-1 text-xs font-bold rounded-full flex-shrink-0 relative z-10
                    {{ $recording->sync_type == 'AutoSync' ? 'bg-yellow-500/30 text-yellow-200' : 'bg-green-500/30 text-green-200' }}">
                    <i class="fas {{ $recording->sync_type == 'AutoSync' ? 'fa-robot' : 'fa-hand-pointer' }} mr-1 relative z-10"></i>
                    {{ $recording->sync_type }}
                </span>
            </div>
        </div>
    </div>

    <!-- Customer Info Section -->
    <div class="p-4">
        <div class="flex items-center space-x-3 mb-4">
            <div class="avatar-circle text-white w-14 h-14 rounded-full flex items-center justify-center font-bold relative z-10 flex-shrink-0">
                {{ substr($recording->customer_full_name ?: $recording->customer_name ?: 'U', 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-gray-800 text-lg truncate">
                    {{ $recording->customer_full_name ?: $recording->customer_name ?: 'Unknown Customer' }}
                </h3>
                <div class="flex items-center space-x-2 mt-1">
                    <a href="tel:{{ $recording->customer_phone }}" class="text-green-600 hover:text-green-700 flex items-center text-sm">
                        <i class="fas fa-phone mr-1"></i>
                        <span>{{ $recording->customer_phone }}</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Audio Player Section -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <button onclick="toggleAudio('{{ $recording->file_url }}', '{{ $recording->id }}')" class="play-button bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl hover:from-green-600 hover:to-green-700 relative z-10 shadow-lg">
                    <i class="fas fa-play text-lg" id="play-icon-{{ $recording->id }}"></i>
                </button>
                <div class="text-right text-sm text-gray-700 min-w-0">
                    <p class="font-medium">{{ \Carbon\Carbon::parse($recording->created_at)->format('M j, Y') }}</p>
                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($recording->created_at)->format('g:i A') }}</p>
                </div>
            </div>
            
            <!-- Custom Audio Player -->
            <div class="custom-audio-player" id="custom-player-{{ $recording->id }}" style="display: none;">
                <div class="progress-bar" id="progress-{{ $recording->id }}" onclick="seekAudio(event, '{{ $recording->id }}')">
                    <div class="progress-fill" id="progress-fill-{{ $recording->id }}">
                        <div class="progress-ball"></div>
                    </div>
                </div>
                <div class="audio-controls-row">
                    <button onclick="toggleAudio('{{ $recording->file_url }}', '{{ $recording->id }}')" class="text-white bg-green-500 hover:bg-green-600 p-2 rounded-lg transition-colors">
                        <i class="fas fa-play" id="control-icon-{{ $recording->id }}"></i>
                    </button>
                    <span class="time-display" id="time-display-{{ $recording->id }}">0:00 / 0:00</span>
                    <button onclick="toggleMute('{{ $recording->id }}')" class="text-gray-600 hover:text-gray-800 p-2 rounded-lg transition-colors ml-2">
                        <i class="fas fa-volume-up" id="volume-icon-{{ $recording->id }}"></i>
                    </button>
                </div>
                <div class="mt-3">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-volume-down text-gray-500 text-sm"></i>
                        <input type="range" id="volume-{{ $recording->id }}" min="0" max="100" value="100" class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer volume-slider" onchange="changeVolume('{{ $recording->id }}', this.value)" oninput="changeVolume('{{ $recording->id }}', this.value)">
                        <i class="fas fa-volume-up text-gray-500 text-sm"></i>
                    </div>
                </div>
                
                <style>
                    .volume-slider::-webkit-slider-thumb {
                        appearance: none;
                        width: 16px;
                        height: 16px;
                        background: #10b981;
                        border-radius: 50%;
                        cursor: pointer;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                        transition: all 0.2s;
                    }
                    
                    .volume-slider::-webkit-slider-thumb:hover {
                        background: #059669;
                        transform: scale(1.1);
                    }
                    
                    .volume-slider::-moz-range-thumb {
                        width: 16px;
                        height: 16px;
                        background: #10b981;
                        border-radius: 50%;
                        cursor: pointer;
                        border: none;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                        transition: all 0.2s;
                    }
                    
                    .volume-slider::-moz-range-thumb:hover {
                        background: #059669;
                        transform: scale(1.1);
                    }
                </style>
            </div>
            
            <audio id="audio-{{ $recording->id }}" class="audio-player" style="display: none;" preload="metadata">
                <source src="{{ $recording->file_url }}" type="audio/mpeg">
                <source src="{{ $recording->file_url }}" type="audio/wav">
                <source src="{{ $recording->file_url }}" type="audio/mp3">
                <source src="{{ $recording->file_url }}">
                Your browser does not support the audio element.
            </audio>
        </div>
        
        <!-- Footer Info -->
        <div class="flex justify-between items-center mt-4 text-xs text-gray-500">
            <span class="flex items-center">
                <i class="fas fa-hashtag mr-1"></i>
                ID: {{ $recording->id }}
            </span>
            <span class="flex items-center truncate ml-2">
                <i class="fas fa-file-audio mr-1 flex-shrink-0"></i>
                <span class="truncate">{{ $recording->file_name }}</span>
            </span>
        </div>
    </div>
</div>
