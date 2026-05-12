@extends('layouts.app-whatsapp')

@section('title', 'WhatsApp CRM Management')

@push('styles')
<style>
:root {
    --wa-green: #25d366;
    --wa-dark-green: #128c7e;
    --wa-light-bg: #f0f2f5;
    --wa-sidebar: #ffffff;
    --wa-hover: #f0f2f5;
    --wa-border: #e9edef;
    --wa-text-dark: #111b21;
    --wa-text-light: #8696a0;
    --wa-bubble-in: #ffffff;
    --wa-bubble-out: #dcf8c6;
    --wa-msg-bg-dark: #0a0e27;
    --wa-sidebar-dark: #1f2c34;
    --wa-hover-dark: #2a3942;
    --wa-border-dark: #2a3942;
    --wa-dark-bg: #0b141a;
}

.w-sidebar { width: 76px; }
.w-sidebar-expanded { width: 280px; }
.max-w-msg { max-width: 70%; }

/* Enhanced Animations */
.sidebar-container {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.sidebar-item {
    transition: all 0.2s ease;
}

.sidebar-item:hover {
    transform: translateX(2px);
}

/* Card Enhancements */
.crm-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
}

.crm-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

/* Lead Item Styling */
.lead-item {
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
}

.lead-item:hover {
    background: linear-gradient(90deg, #f0f2f5 0%, #ffffff 100%);
    border-left-color: var(--wa-green);
}

.lead-item.selected {
    background: linear-gradient(90deg, #dcf8c6 0%, #ffffff 100%);
    border-left-color: var(--wa-dark-green);
}

/* Status Badges */
.status-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-online { background: #d4edda; color: #155724; }
.status-offline { background: #f8d7da; color: #721c24; }
.status-hot { background: #f8d7da; color: #721c24; }
.status-warm { background: #fff3cd; color: #856404; }
.status-cold { background: #d1ecf1; color: #0c5460; }

/* Message Composer */
.message-composer {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 12px;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
}

/* Button Enhancements */
.btn-wa {
    background: linear-gradient(135deg, var(--wa-green) 0%, var(--wa-dark-green) 100%);
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-wa:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}

/* Search Bar */
.search-enhanced {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: 2px solid transparent;
    transition: all 0.2s ease;
}

.search-enhanced:focus {
    border-color: var(--wa-green);
    box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.1);
}

/* Stats Cards */
.stats-card {
    background: linear-gradient(135deg, var(--wa-green) 0%, var(--wa-dark-green) 100%);
    border-radius: 16px;
    color: white;
    position: relative;
    overflow: hidden;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

/* Loading Animation */
.loading-spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid var(--wa-green);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .w-sidebar { width: 60px; }
    .w-sidebar-expanded { width: 240px; }
    .max-w-msg { max-width: 85%; }
}
</style>
@endpush

@section('content')
<div class="flex h-screen bg-white dark:bg-wa-dark-bg overflow-hidden">
    <!-- Enhanced Sidebar -->
    <div id="sidebar" class="sidebar-container w-sidebar hover:w-sidebar-expanded transition-all duration-300 ease-out bg-wa-sidebar dark:bg-wa-sidebar-dark border-r border-wa-border dark:border-wa-border-dark flex flex-col h-screen group">
        <!-- Logo Section -->
        <div class="flex items-center justify-center h-16 border-b border-wa-border dark:border-wa-border-dark flex-shrink-0">
            <div class="flex items-center gap-3 px-4 w-full">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-lg">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="hidden group-hover:block opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <h1 class="font-bold text-wa-text-dark dark:text-white text-sm whitespace-nowrap">WhatsApp CRM</h1>
                    <p class="text-xs text-wa-text-light dark:text-gray-400">Niranjan Systems</p>
                </div>
            </div>
        </div>

        <!-- Navigation Items -->
        <nav class="flex-1 overflow-y-auto py-4 space-y-2 px-2">
            <!-- WhatsApp Status -->
            <button onclick="checkWhatsAppStatus()" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Check Status">
                <i class="fas fa-check-circle w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Check Status</span>
            </button>

            <!-- Templates -->
            <button onclick="showTemplates()" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Templates">
                <i class="fas fa-file-alt w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Templates</span>
            </button>

            <div class="hidden group-hover:block my-4 border-t border-wa-border dark:border-wa-border-dark"></div>

            <!-- Menu Items -->
            <div class="hidden group-hover:block">
                <p class="px-3 py-2 text-xs font-semibold text-wa-text-light dark:text-gray-400 uppercase tracking-wider">CRM Menu</p>
            </div>

            <a href="{{ route('leads.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Leads Management">
                <i class="fas fa-users w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Leads</span>
            </a>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Dashboard">
                <i class="fas fa-chart-line w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Dashboard</span>
            </a>
        </nav>

        <!-- Bottom Section -->
        <div class="border-t border-wa-border dark:border-wa-border-dark pt-4 pb-4 px-2 space-y-2">
            <!-- Theme Toggle -->
            <button id="themeToggle" class="sidebar-item w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Toggle Theme">
                <i class="fas fa-moon w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Dark Mode</span>
            </button>

            <!-- Settings -->
            <a href="#" class="sidebar-item flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark transition-all duration-200 text-wa-text-dark dark:text-white" title="Settings">
                <i class="fas fa-cog w-6 text-center text-lg"></i>
                <span class="hidden group-hover:inline text-sm font-medium whitespace-nowrap">Settings</span>
            </a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header with Stats -->
        <div class="bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark">
            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-4 p-4">
                <div class="stats-card p-4 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $leads->total() }}</h3>
                            <p class="text-sm opacity-90">Total Leads</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-xl" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $leads->whereNotNull('phone')->count() }}</h3>
                            <p class="text-sm opacity-90">With Phones</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-xl" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold" id="sentCount">0</h3>
                            <p class="text-sm opacity-90">Messages Sent</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-paper-plane text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="stats-card p-4 rounded-xl" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">4</h3>
                            <p class="text-sm opacity-90">Templates</p>
                        </div>
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-hidden flex">
            <!-- Leads List Panel -->
            <div class="w-1/3 border-r border-wa-border dark:border-wa-border-dark bg-wa-sidebar dark:bg-wa-sidebar-dark overflow-y-auto">
                <!-- Search Bar -->
                <div class="sticky top-0 p-4 bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark z-10">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-3 text-wa-text-light dark:text-gray-400"></i>
                        <input type="text" id="searchLead" placeholder="Search leads..." 
                               class="search-enhanced w-full pl-10 pr-4 py-3 rounded-xl text-wa-text-dark dark:text-white placeholder-wa-text-light dark:placeholder-gray-400 focus:outline-none">
                    </div>
                    
                    <!-- Filter Dropdown -->
                    <select id="statusFilter" class="mt-3 w-full px-4 py-2 rounded-lg bg-wa-hover dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white focus:outline-none focus:border-wa-green">
                        <option value="">All Status</option>
                        <option value="hot">Hot Leads</option>
                        <option value="warm">Warm Leads</option>
                        <option value="cold">Cold Leads</option>
                        <option value="qualified">Qualified</option>
                    </select>
                </div>

                <!-- Leads List -->
                <div id="leadsList" class="divide-y divide-wa-border dark:divide-wa-border-dark">
                    @forelse($leads as $lead)
                        <div class="lead-item p-4 cursor-pointer transition-all duration-200" 
                             data-lead-id="{{ $lead->id }}"
                             data-lead-name="{{ $lead->name }}"
                             data-lead-phone="{{ $lead->phone ?? '' }}"
                             onclick="selectLead({{ $lead->id }}, '{{ $lead->name }}', '{{ $lead->phone ?? '' }}')">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold flex-shrink-0 shadow-md">
                                    {{ substr($lead->name, 0, 2) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-wa-text-dark dark:text-white truncate">{{ $lead->name }}</h4>
                                    <p class="text-sm text-wa-text-light dark:text-gray-400 truncate">{{ $lead->email ?? 'No email' }}</p>
                                    @if($lead->phone)
                                        <p class="text-xs text-wa-green dark:text-green-400">{{ $lead->phone }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="status-badge status-{{ $lead->lead_status ?? 'cold' }}">
                                        {{ ucfirst($lead->lead_status ?? 'cold') }}
                                    </span>
                                    @if($lead->phone)
                                        <button onclick="event.stopPropagation(); quickSendMessage({{ $lead->id }}, '{{ $lead->name }}', '{{ $lead->phone }}')" 
                                                class="p-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg transition-all duration-200">
                                            <i class="fab fa-whatsapp text-sm"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-users text-4xl text-wa-text-light dark:text-gray-400 mb-3"></i>
                            <p class="text-wa-text-light dark:text-gray-400">No leads found</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Message Composer Panel -->
            <div class="flex-1 flex flex-col bg-wa-light-bg dark:bg-wa-msg-bg-dark">
                <!-- Chat Header -->
                <div id="chatHeader" class="h-16 bg-wa-sidebar dark:bg-wa-sidebar-dark border-b border-wa-border dark:border-wa-border-dark flex items-center justify-between px-6 flex-shrink-0">
                    <div class="flex items-center gap-4">
                        <div id="selectedAvatar" class="w-10 h-10 rounded-full bg-gradient-to-br from-wa-green to-wa-dark-green flex items-center justify-center text-white font-bold">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 id="selectedName" class="font-semibold text-wa-text-dark dark:text-white">Select a lead</h3>
                            <p id="selectedPhone" class="text-sm text-wa-text-light dark:text-gray-400">No phone number</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="showTemplates()" class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-all duration-200">
                            <i class="fas fa-file-alt text-wa-green text-lg"></i>
                        </button>
                        <button onclick="checkWhatsAppStatus()" class="p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded-lg transition-all duration-200">
                            <i class="fas fa-check-circle text-wa-green text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Messages Area -->
                <div id="messagesContainer" class="flex-1 overflow-y-auto p-6">
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-wa-green to-wa-dark-green rounded-full flex items-center justify-center text-white">
                            <i class="fab fa-whatsapp text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-wa-text-dark dark:text-white mb-2">WhatsApp CRM</h3>
                        <p class="text-wa-text-light dark:text-gray-400 mb-4">Select a lead to start messaging</p>
                        
                        <!-- Quick Actions -->
                        <div class="grid grid-cols-2 gap-3 max-w-md mx-auto">
                            <button onclick="loadBulkMessaging()" class="p-3 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-bullhorn mr-2"></i>Bulk Message
                            </button>
                            <button onclick="showTemplates()" class="p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-file-alt mr-2"></i>Templates
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Message Input Area -->
                <div id="messageInputArea" class="message-composer border-t border-wa-border dark:border-wa-border-dark p-4 hidden">
                    <form id="messageForm">
                        <input type="hidden" id="leadId" name="lead_id">
                        
                        <!-- Template Selection -->
                        <div class="mb-3">
                            <select id="templateSelect" class="w-full px-4 py-2 rounded-lg bg-wa-hover dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white focus:outline-none focus:border-wa-green">
                                <option value="">Choose a template...</option>
                                <option value="follow_up">Follow Up</option>
                                <option value="quotation_sent">Quotation Sent</option>
                                <option value="appointment_reminder">Appointment Reminder</option>
                                <option value="welcome">Welcome Message</option>
                            </select>
                        </div>

                        <!-- Message Input -->
                        <div class="mb-3">
                            <textarea id="message" name="message" rows="3" 
                                      placeholder="Type your message here..." 
                                      class="w-full px-4 py-3 rounded-lg bg-white dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white placeholder-wa-text-light dark:placeholder-gray-400 focus:outline-none focus:border-wa-green resize-none"
                                      maxlength="1000" required></textarea>
                            <div class="text-right mt-1">
                                <span id="charCount" class="text-xs text-wa-text-light dark:text-gray-400">0/1000</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="clearMessage()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-200">
                                <i class="fas fa-eraser mr-2"></i>Clear
                            </button>
                            <button type="submit" id="sendBtn" class="flex-1 btn-wa px-6 py-2 rounded-lg font-medium">
                                <i class="fas fa-paper-plane mr-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-wa-sidebar-dark rounded-xl p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-wa-text-dark dark:text-white mb-4">WhatsApp API Status</h3>
        <div id="statusContent" class="text-wa-text-light dark:text-gray-400">
            <div class="text-center py-4">
                <div class="loading-spinner mx-auto mb-3"></div>
                <p>Checking status...</p>
            </div>
        </div>
        <button onclick="closeStatusModal()" class="mt-4 w-full px-4 py-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg font-medium transition-all duration-200">
            Close
        </button>
    </div>
</div>

<!-- Templates Modal -->
<div id="templatesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-wa-sidebar-dark rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-wa-text-dark dark:text-white mb-4">Message Templates</h3>
        <div id="templatesList" class="grid grid-cols-2 gap-4">
            <!-- Templates will be loaded here -->
        </div>
        <button onclick="closeTemplatesModal()" class="mt-4 w-full px-4 py-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg font-medium transition-all duration-200">
            Close
        </button>
    </div>
</div>

<!-- Bulk Messaging Modal -->
<div id="bulkModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-wa-sidebar-dark rounded-xl p-6 max-w-lg w-full mx-4">
        <h3 class="text-lg font-semibold text-wa-text-dark dark:text-white mb-4">Bulk Messaging</h3>
        <div class="mb-4">
            <label class="block text-sm font-medium text-wa-text-dark dark:text-white mb-2">Select Leads</label>
            <div id="bulkLeadsList" class="max-h-40 overflow-y-auto border border-wa-border dark:border-wa-border-dark rounded-lg p-2">
                <!-- Lead checkboxes will be loaded here -->
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-wa-text-dark dark:text-white mb-2">Message</label>
            <textarea id="bulkMessage" rows="4" 
                      class="w-full px-4 py-2 rounded-lg bg-wa-hover dark:bg-wa-hover-dark border border-wa-border dark:border-wa-border-dark text-wa-text-dark dark:text-white placeholder-wa-text-light dark:placeholder-gray-400 focus:outline-none focus:border-wa-green resize-none"
                      placeholder="Type your bulk message here..."></textarea>
        </div>
        <div class="flex gap-3">
            <button onclick="closeBulkModal()" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all duration-200">
                Cancel
            </button>
            <button onclick="sendBulkMessage()" class="flex-1 btn-wa px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-paper-plane mr-2"></i>Send Bulk
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedLeadId = null;
let selectedLeadName = null;
let selectedLeadPhone = null;
let sentMessagesCount = 0;

// Theme Toggle
const themeToggle = document.getElementById('themeToggle');
const html = document.documentElement;

const currentTheme = localStorage.getItem('theme') || 'light';
if (currentTheme === 'dark') {
    html.classList.add('dark');
}

themeToggle.addEventListener('click', () => {
    html.classList.toggle('dark');
    const isDark = html.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
});

// Select Lead
function selectLead(leadId, leadName, leadPhone) {
    selectedLeadId = leadId;
    selectedLeadName = leadName;
    selectedLeadPhone = leadPhone;
    
    // Update UI
    document.getElementById('selectedName').textContent = leadName;
    document.getElementById('selectedPhone').textContent = leadPhone || 'No phone number';
    document.getElementById('selectedAvatar').innerHTML = leadName.substring(0, 2).toUpperCase();
    document.getElementById('leadId').value = leadId;
    
    // Show message input area
    document.getElementById('messageInputArea').classList.remove('hidden');
    
    // Update selected state
    document.querySelectorAll('.lead-item').forEach(item => {
        item.classList.remove('selected');
    });
    document.querySelector(`[data-lead-id="${leadId}"]`).classList.add('selected');
    
    // Clear previous message
    document.getElementById('message').value = '';
    updateCharCount();
}

// Quick Send Message
function quickSendMessage(leadId, leadName, leadPhone) {
    selectLead(leadId, leadName, leadPhone);
    document.getElementById('message').focus();
}

// Send Message
document.getElementById('messageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!selectedLeadId || !selectedLeadPhone) {
        alert('Please select a lead with a phone number');
        return;
    }
    
    const message = document.getElementById('message').value.trim();
    if (!message) {
        alert('Please enter a message');
        return;
    }
    
    const sendBtn = document.getElementById('sendBtn');
    sendBtn.innerHTML = '<div class="loading-spinner inline-block mr-2"></div>Sending...';
    sendBtn.disabled = true;
    
    const formData = new FormData();
    formData.append('lead_id', selectedLeadId);
    formData.append('message', message);
    formData.append('message_type', 'text');
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('/whatsapp/send', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sentMessagesCount++;
            document.getElementById('sentCount').textContent = sentMessagesCount;
            
            // Show success message
            showNotification('Message sent successfully!', 'success');
            
            // Clear form
            document.getElementById('message').value = '';
            updateCharCount();
            
            // Add to messages area
            addMessageToChat(message, 'sent');
        } else {
            showNotification('Failed to send message: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error sending message', 'error');
    })
    .finally(() => {
        sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Send Message';
        sendBtn.disabled = false;
    });
});

// Template Selection
document.getElementById('templateSelect').addEventListener('change', function() {
    const templates = {
        'follow_up': 'Hello {name}, this is a follow-up regarding your inquiry. We would love to discuss how we can help you. Please let us know a convenient time to connect.',
        'quotation_sent': 'Dear {name}, we have sent you the quotation. Please review it and let us know if you have any questions. Looking forward to your response.',
        'appointment_reminder': 'Hi {name}, this is a reminder about your appointment. We look forward to meeting you.',
        'welcome': 'Welcome {name}! Thank you for your interest in our services. We will get back to you shortly.'
    };
    
    const template = templates[this.value];
    if (template) {
        let message = template.replace('{name}', selectedLeadName || 'there');
        document.getElementById('message').value = message;
        updateCharCount();
    }
});

// Character Counter
function updateCharCount() {
    const length = document.getElementById('message').value.length;
    document.getElementById('charCount').textContent = `${length}/1000`;
}

document.getElementById('message').addEventListener('input', updateCharCount);

// Clear Message
function clearMessage() {
    document.getElementById('message').value = '';
    document.getElementById('templateSelect').value = '';
    updateCharCount();
}

// Check WhatsApp Status
function checkWhatsAppStatus() {
    document.getElementById('statusModal').classList.remove('hidden');
    
    fetch('/whatsapp/status')
        .then(response => response.json())
        .then(data => {
            const statusContent = document.getElementById('statusContent');
            if (data.success) {
                statusContent.innerHTML = `
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-wa-text-dark dark:text-white mb-2">Connected</h4>
                        <p class="text-wa-text-light dark:text-gray-400">${data.message}</p>
                    </div>
                `;
            } else {
                statusContent.innerHTML = `
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                        </div>
                        <h4 class="font-semibold text-wa-text-dark dark:text-white mb-2">Not Connected</h4>
                        <p class="text-wa-text-light dark:text-gray-400">${data.message}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('statusContent').innerHTML = `
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                    <h4 class="font-semibold text-wa-text-dark dark:text-white mb-2">Error</h4>
                    <p class="text-wa-text-light dark:text-gray-400">Failed to check status</p>
                </div>
            `;
        });
}

// Show Templates
function showTemplates() {
    document.getElementById('templatesModal').classList.remove('hidden');
    
    fetch('/whatsapp/templates')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const templatesList = document.getElementById('templatesList');
                templatesList.innerHTML = data.templates.map(template => `
                    <div class="p-4 border border-wa-border dark:border-wa-border-dark rounded-lg hover:bg-wa-hover dark:hover:bg-wa-hover-dark cursor-pointer transition-all duration-200"
                         onclick="useTemplate('${template.message.replace(/'/g, "\\'")}')">
                        <h4 class="font-semibold text-wa-text-dark dark:text-white mb-2">${template.name}</h4>
                        <p class="text-sm text-wa-text-light dark:text-gray-400">${template.message}</p>
                        <div class="mt-2">
                            <span class="text-xs text-wa-green dark:text-green-400">Variables: ${template.variables.join(', ')}</span>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Error loading templates:', error);
        });
}

// Use Template
function useTemplate(template) {
    let message = template.replace('{name}', selectedLeadName || 'there');
    document.getElementById('message').value = message;
    updateCharCount();
    closeTemplatesModal();
}

// Load Bulk Messaging
function loadBulkMessaging() {
    document.getElementById('bulkModal').classList.remove('hidden');
    
    const bulkLeadsList = document.getElementById('bulkLeadsList');
    const leads = document.querySelectorAll('.lead-item');
    
    bulkLeadsList.innerHTML = Array.from(leads).map(lead => {
        const leadId = lead.dataset.leadId;
        const leadName = lead.dataset.leadName;
        const leadPhone = lead.dataset.leadPhone;
        
        if (!leadPhone) return '';
        
        return `
            <label class="flex items-center gap-2 p-2 hover:bg-wa-hover dark:hover:bg-wa-hover-dark rounded cursor-pointer">
                <input type="checkbox" value="${leadId}" class="bulk-lead-checkbox">
                <span class="text-sm text-wa-text-dark dark:text-white">${leadName}</span>
            </label>
        `;
    }).join('');
}

// Send Bulk Message
function sendBulkMessage() {
    const selectedLeads = Array.from(document.querySelectorAll('.bulk-lead-checkbox:checked')).map(cb => cb.value);
    const message = document.getElementById('bulkMessage').value.trim();
    
    if (selectedLeads.length === 0) {
        alert('Please select at least one lead');
        return;
    }
    
    if (!message) {
        alert('Please enter a message');
        return;
    }
    
    fetch('/whatsapp/bulk-send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            lead_ids: selectedLeads,
            message: message,
            message_type: 'text'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sentMessagesCount += data.summary.success;
            document.getElementById('sentCount').textContent = sentMessagesCount;
            
            showNotification(`Bulk message sent! Success: ${data.summary.success}, Failed: ${data.summary.failed}`, 'success');
            closeBulkModal();
        } else {
            showNotification('Failed to send bulk message', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error sending bulk message', 'error');
    });
}

// Search Functionality
document.getElementById('searchLead').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.lead-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

// Status Filter
document.getElementById('statusFilter').addEventListener('change', function() {
    const status = this.value;
    document.querySelectorAll('.lead-item').forEach(item => {
        if (status === '') {
            item.style.display = 'block';
        } else {
            const itemStatus = item.querySelector('.status-badge').textContent.toLowerCase();
            item.style.display = itemStatus === status.toLowerCase() ? 'block' : 'none';
        }
    });
});

// Modal Functions
function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

function closeTemplatesModal() {
    document.getElementById('templatesModal').classList.add('hidden');
}

function closeBulkModal() {
    document.getElementById('bulkModal').classList.add('hidden');
}

// Notification Function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white font-medium z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Add Message to Chat
function addMessageToChat(message, type) {
    const messagesContainer = document.getElementById('messagesContainer');
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex gap-3 mb-4 ${type === 'sent' ? 'justify-end' : ''}`;
    
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    
    messageDiv.innerHTML = `
        ${type === 'sent' ? '<div class="flex-1"></div>' : ''}
        <div class="max-w-msg">
            <div class="${type === 'sent' ? 'bg-wa-bubble-out' : 'bg-wa-bubble-in dark:bg-wa-hover-dark'} rounded-lg p-3">
                <p class="text-wa-text-dark dark:text-white text-sm">${message}</p>
            </div>
            <div class="flex ${type === 'sent' ? 'justify-end' : 'justify-start'} gap-1 mt-1">
                <p class="text-xs text-wa-text-light dark:text-gray-400">${time}</p>
                ${type === 'sent' ? '<i class="fas fa-check-double text-wa-green text-xs"></i>' : ''}
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Close modals on outside click
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) closeStatusModal();
});

document.getElementById('templatesModal').addEventListener('click', function(e) {
    if (e.target === this) closeTemplatesModal();
});

document.getElementById('bulkModal').addEventListener('click', function(e) {
    if (e.target === this) closeBulkModal();
});
</script>
@endpush
