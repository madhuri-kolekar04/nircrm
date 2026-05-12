@extends('admin.admin_master')

@section('title', 'WhatsApp Dashboard - NIRCRM')

@section('styles')
<style>
/* NIRCRM Theme Colors - Matching existing design */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
    --card-bg: white;
    --border-color: #e5e7eb;
    --text-primary: #374151;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
    --background: #f3f4f6;
    --surface: #ffffff;
    --surface-light: #f8f9fa;
    --hover: #f8f9fa;
    
    /* Mobile breakpoints */
    --mobile-breakpoint: 768px;
    --tablet-breakpoint: 1024px;
}

/* NIRCRM WhatsApp Container */
.whatsapp-container {
    height: calc(100vh - 120px);
    background: var(--background);
    display: flex;
    overflow: hidden;
    position: relative;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--border-color);
}

/* Responsive Layout */
@media (max-width: 768px) {
    .whatsapp-container {
        height: calc(100vh - 80px);
        border-radius: 0;
        border: none;
    }
}

/* NIRCRM Stats Grid - Matching existing dashboard */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    padding: 0;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
}

@media (max-width: 480px) {
    .stats-container {
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
}

/* NIRCRM Stat Cards - Matching existing design */
.stat-card {
    background: var(--primary-gradient);
    color: white;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: none;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255, 255, 255, 0.1);
    transform: rotate(45deg);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.stat-card:hover::before {
    top: -100%;
    right: -100%;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    margin-bottom: 1rem;
    background: rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
    line-height: 1;
    position: relative;
    z-index: 1;
}

.stat-label {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    position: relative;
    z-index: 1;
}

.stat-trend {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 10px;
    background: rgba(16, 185, 129, 0.3);
    color: #10b981;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.stat-trend.negative {
    background: rgba(239, 68, 68, 0.3);
    color: #ef4444;
}

/* NIRCRM Quick Actions - Matching existing button style */
.quick-actions {
    display: flex;
    gap: 0.75rem;
    padding: 0;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .quick-actions {
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
}

.quick-action-btn {
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.quick-action-btn i {
    font-size: 14px;
}

.quick-action-btn span {
    font-size: 0.875rem;
    font-weight: 500;
}

/* NIRCRM Sidebar - Matching existing design */
.whatsapp-sidebar {
    width: 400px;
    background: var(--surface);
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    position: relative;
}

@media (max-width: 768px) {
    .whatsapp-sidebar {
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1000;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .whatsapp-sidebar.mobile-open {
        transform: translateX(0);
    }
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--primary-gradient);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 72px;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sidebar-logo i {
    font-size: 24px;
    color: white;
}

.sidebar-title {
    color: white;
    font-size: 1.125rem;
    font-weight: 600;
}

.sidebar-actions {
    display: flex;
    gap: 8px;
}

.sidebar-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

/* Client List */
.client-list-container {
    flex: 1;
    overflow-y: auto;
    background: white;
}

.search-container {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--surface-light);
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--surface);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    outline: none;
    font-size: 0.875rem;
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.search-input::placeholder {
    color: var(--text-muted);
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.client-list {
    overflow-y: auto;
    background: var(--surface);
}

.client-item {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.client-item:hover {
    background: var(--hover);
}

.client-item.active {
    background: var(--surface-light);
}

.client-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--primary-gradient);
}

.client-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
}

.client-item:hover .client-avatar {
    border-color: #667eea;
}

.client-info {
    flex: 1;
    min-width: 0;
}

.client-name {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 4px;
    font-size: 0.9375rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.client-last-message {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 4px;
}

.client-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 6px;
}

.client-time {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.unread-badge {
    background: var(--primary-gradient);
    color: white;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6875rem;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
}

.service-badge {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info-color);
    border-radius: 12px;
    padding: 2px 6px;
    font-size: 0.625rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* NIRCRM Chat Area - Matching existing design */
.whatsapp-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: var(--surface);
    position: relative;
}

@media (max-width: 768px) {
    .whatsapp-main {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .whatsapp-main.mobile-hidden {
        display: none;
    }
}

.chat-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: space-between;
    min-height: 72px;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.chat-header-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border-color);
}

.chat-header-details h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.chat-header-details p {
    margin: 4px 0 0 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.chat-header-actions {
    display: flex;
    gap: 0.5rem;
}

.chat-action-btn {
    background: var(--surface-light);
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chat-action-btn:hover {
    background: var(--hover);
    color: var(--text-primary);
    border-color: #667eea;
}

.chat-header-info {
    flex: 1;
}

.chat-header-name {
    font-weight: 600;
    color: var(--wa-text-dark);
    margin-bottom: 2px;
}

.chat-header-details {
    font-size: 13px;
    color: var(--wa-text-light);
}

.chat-actions {
    display: flex;
    gap: 10px;
}

.chat-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: transparent;
    color: var(--wa-text-light);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.chat-action-btn:hover {
    background: #f0f0f0;
    color: var(--wa-text-dark);
}

/* NIRCRM Messages Area - Matching existing design */
.messages-container {
    flex: 1;
    overflow-y: auto;
    padding: 1.5rem;
    background: var(--surface-light);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.messages-container::-webkit-scrollbar {
    width: 6px;
}

.messages-container::-webkit-scrollbar-track {
    background: transparent;
}

.messages-container::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 3px;
}

.message {
    display: flex;
    align-items: flex-end;
    gap: 0.75rem;
    max-width: 80%;
    animation: messageSlide 0.3s ease-out;
}

@keyframes messageSlide {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.message.incoming {
    align-self: flex-start;
}

.message.outgoing {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message-bubble {
    padding: 0.75rem 1rem;
    border-radius: 12px;
    word-wrap: break-word;
    position: relative;
    max-width: 100%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color);
}

.message.incoming .message-bubble {
    background: var(--surface);
    color: var(--text-primary);
    border-bottom-left-radius: 4px;
}

.message.outgoing .message-bubble {
    background: var(--primary-gradient);
    color: white;
    border-bottom-right-radius: 4px;
    border-color: transparent;
}

.message-content {
    font-size: 0.875rem;
    line-height: 1.4;
}

.message-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

.message-time {
    opacity: 0.8;
}

.message-status {
    display: flex;
    align-items: center;
    gap: 2px;
}

.check-icon {
    width: 12px;
    height: 12px;
}

/* NIRCRM Message Input - Matching existing design */
.message-input-container {
    background: var(--surface);
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    align-items: flex-end;
    gap: 0.75rem;
}

.message-input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    outline: none;
    font-size: 0.875rem;
    color: var(--text-primary);
    resize: none;
    max-height: 120px;
    background: var(--surface-light);
}

.message-input::placeholder {
    color: var(--text-muted);
}

.message-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

.input-actions {
    display: flex;
    gap: 0.5rem;
}

.input-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--surface-light);
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.input-btn:hover {
    background: var(--hover);
    color: var(--text-primary);
    border-color: #667eea;
}

.send-btn {
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    padding: 0.75rem;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
}

.send-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.send-btn:active {
    transform: translateY(0);
}

/* Stats Cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-info {
    flex: 1;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--wa-text-dark);
    margin-bottom: 2px;
}

.stat-label {
    font-size: 13px;
    color: var(--wa-text-light);
}

/* Empty State */
.empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--wa-text-light);
    text-align: center;
    padding: 40px;
}

.empty-state-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}

.empty-state-text {
    font-size: 14px;
    max-width: 300px;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 8px 12px;
}

.typing-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--wa-text-light);
    animation: pulse 1.4s infinite ease-in-out;
}

.typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

/* Responsive */
@media (max-width: 768px) {
    .whatsapp-sidebar {
        position: absolute;
        left: -100%;
        z-index: 1000;
        height: 100%;
        transition: left 0.3s ease;
    }
    
    .whatsapp-sidebar.mobile-open {
        left: 0;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
}

/* Loading Spinner */
.loading-spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid var(--wa-green);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endsection

@section('admin')
<div class="container-fluid">
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMobileSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Enhanced Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total_clients'] }}</div>
                <div class="stat-label">Total Clients</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $stats['total_clients'] > 0 ? '+' . number_format($stats['total_clients_change'] / abs($stats['total_clients_change']) * 100, 1) . '%' : '0%' }}</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['unread_messages'] }}</div>
                <div class="stat-label">Unread Messages</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $stats['unread_messages'] > 0 ? '± ' . $stats['unread_messages_change'] : 'No new' }}</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['my_clients'] }}</div>
                <div class="stat-label">My Clients</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $stats['my_clients'] > 0 ? '+' . number_format($stats['my_clients_change'] / abs($stats['my_clients_change']) * 100, 1) . '%' : '0%' }}</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['active_conversations'] }}</div>
                <div class="stat-label">Active Conversations</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>{{ $stats['active_conversations'] > 0 ? '± ' . number_format($stats['active_conversations_change'] / abs($stats['active_conversations_change']) * 100, 1) . '%' : '0%' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <button class="quick-action-btn" onclick="showAddClientModal()">
            <i class="fas fa-plus"></i>
            <span>Add Client</span>
        </button>
        <button class="quick-action-btn" onclick="showBroadcastModal()">
            <i class="fas fa-broadcast-tower"></i>
            <span>Broadcast Message</span>
        </button>
        <button class="quick-action-btn" onclick="showTemplatesModal()">
            <i class="fas fa-file-alt"></i>
            <span>Templates</span>
        </button>
    </div>

    <!-- WhatsApp Container -->
    <div class="whatsapp-container">
        <!-- Sidebar -->
        <div class="whatsapp-sidebar" id="whatsappSidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fab fa-whatsapp"></i>
                    <span class="sidebar-title">WhatsApp</span>
                </div>
                <div class="sidebar-actions">
                    <button class="sidebar-btn" onclick="showAddClientModal()">
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <button class="sidebar-btn" onclick="showBroadcastModal()">
                        <i class="fas fa-broadcast-tower"></i>
                    </button>
                </div>
            </div>
            
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search clients..." id="searchInput" onkeyup="searchClients()">
            </div>
            
            <div class="client-list-container">
                <div class="client-list" id="clientList">
                    @foreach($clients as $client)
                    <div class="client-item {{ $loop->first ? 'active' : '' }}" data-client-id="{{ $client->id }}" onclick="selectClient({{ $client->id }})">
                        <img src="{{ $client->profile_picture_url }}" alt="{{ $client->display_name }}" class="client-avatar">
                        <div class="client-info">
                            <div class="client-name">{{ $client->display_name }}</div>
                            <div class="client-last-message">
                                @if($client->lastMessage && $client->lastMessage->message)
                                    {{ Str::limit($client->lastMessage->message, 40) }}
                                @else
                                    No messages yet
                                @endif
                            </div>
                        </div>
                        <div class="client-meta">
                            <div class="client-time">
                                @if($client->lastMessage && $client->lastMessage->formatted_time)
                                    {{ $client->lastMessage->formatted_time }}
                                @endif
                            </div>
                            <div class="client-badges">
                                @if($client->unread_count > 0)
                                <span class="unread-badge">{{ $client->unread_count }}</span>
                                @endif
                                @if($client->serviceCategory)
                                <span class="service-badge">{{ $client->serviceCategory->service_category_name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Main Chat Area -->
        <div class="whatsapp-main" id="whatsappMain">
            <div class="chat-header">
                <button class="mobile-back-btn" onclick="goBackToClientList()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="chat-header-info">
                    <img src="https://ui-avatars.com/api/?name=Sample+Client&background=random" alt="Client" class="chat-header-avatar" id="chatHeaderAvatar">
                    <div class="chat-header-details">
                        <h3 id="chatClientName">Sample Client</h3>
                        <p id="chatClientStatus">Active now</p>
                    </div>
                </div>
                <div class="chat-header-actions">
                    <button class="chat-action-btn" onclick="showClientInfo()">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <button class="chat-action-btn" onclick="showTemplatesModal()">
                        <i class="fas fa-file-alt"></i>
                    </button>
                    <button class="chat-action-btn" onclick="showMoreOptions()">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            
            <div class="messages-container" id="messagesContainer">
                <!-- Messages will be loaded here -->
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h3>No messages yet</h3>
                    <p>Start a conversation with this client</p>
                </div>
            </div>
            
            <div class="message-input-container">
                <div class="input-actions">
                    <button class="input-btn" onclick="attachFile()">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <button class="input-btn" onclick="showEmojiPicker()">
                        <i class="fas fa-smile"></i>
                    </button>
                </div>
                <div class="message-input-wrapper">
                    <textarea class="message-input" id="messageInput" placeholder="Type a message..." onkeypress="handleKeyPress(event)"></textarea>
                </div>
                <button class="send-btn" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Team Assignment Modal -->
<div class="modal fade" id="assignmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Team Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="assignmentForm">
                    <input type="hidden" id="assignmentClientId">
                    
                    <div class="mb-3">
                        <label class="form-label">Team Member</label>
                        <select class="form-select" id="assignmentUserId" required>
                            <option value="">Select Team Member</option>
                            @foreach($teamMembers as $member)
                            <option value="{{ $member->id }}">{{ $member->name }} - {{ $member->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="assignmentRole" required>
                            <option value="secondary">Secondary</option>
                            <option value="primary">Primary</option>
                            <option value="backup">Backup</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="assignmentNotes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveAssignment()">Assign</button>
            </div>
        </div>
    </div>
</div>

<!-- Message Templates Modal -->
<div class="modal fade" id="templatesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Message Templates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <select class="form-select" id="templateCategory" onchange="loadTemplates()">
                        <option value="">All Categories</option>
                        <option value="greeting">Greeting</option>
                        <option value="followup">Follow-up</option>
                        <option value="appointment">Appointment</option>
                        <option value="support">Support</option>
                        <option value="sales">Sales</option>
                        <option value="feedback">Feedback</option>
                    </select>
                </div>
                
                <div id="templatesList">
                    <!-- Templates will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentClientId = null;
let currentClient = null;

// Select client and load messages
function selectClient(clientId) {
    console.log('Selecting client:', clientId);
    
    // Remove active class from all clients
    document.querySelectorAll('.client-item').forEach(item => {
        item.classList.remove('active');
    });
    
    // Add active class to selected client
    const selectedItem = document.querySelector(`[data-client-id="${clientId}"]`);
    if (selectedItem) {
        selectedItem.classList.add('active');
    }
    
    currentClientId = clientId;
    currentClient = null;
    
    // Show loading state
    const emptyState = document.getElementById('emptyState');
    const chatContent = document.getElementById('chatContent');
    const messagesContainer = document.getElementById('messagesContainer');
    
    if (emptyState) emptyState.style.display = 'none';
    if (chatContent) chatContent.style.display = 'flex';
    if (messagesContainer) messagesContainer.innerHTML = '<div style="text-align: center; padding: 40px;"><div class="loading-spinner"></div></div>';
    
    loadMessages(clientId);
}

// Load messages for client
function loadMessages(clientId) {
    console.log('Loading messages for client:', clientId);
    
    fetch(`/mywhatsapp/messages/${clientId}`)
        .then(response => {
            console.log('Response received:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Messages data:', data);
            currentClient = data.client;
            renderChatHeader(data.client);
            renderMessages(data.messages);
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            const messagesContainer = document.getElementById('messagesContainer');
            if (messagesContainer) {
                messagesContainer.innerHTML = '<div class="empty-state"><div class="empty-state-icon"><i class="fas fa-exclamation-triangle"></i></div><div class="empty-state-title">Error Loading Messages</div><div class="empty-state-text">Please check the console for more details.</div></div>';
            }
        });
}

// Render chat header
function renderChatHeader(client) {
    console.log('Rendering chat header for client:', client);
    
    const headerHtml = `
        <img src="${client.profile_picture_url}" alt="${client.display_name}" class="client-avatar">
        <div class="chat-header-info">
            <div class="chat-header-name">${client.display_name}</div>
            <div class="chat-header-details">
                ${client.phone_number}
                ${client.service_category ? ` • ${client.service_category.service_category_name}` : ''}
                ${client.assigned_user ? ` • Assigned to ${client.assigned_user.name}` : ''}
            </div>
        </div>
        <div class="chat-actions">
            <button class="chat-action-btn" onclick="showAssignmentModal()" title="Assign Team Member">
                <i class="fas fa-user-plus"></i>
            </button>
            <button class="chat-action-btn" onclick="viewClientInfo()" title="Client Info">
                <i class="fas fa-info-circle"></i>
            </button>
            <button class="chat-action-btn" onclick="refreshMessages()" title="Refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    `;
    
    document.getElementById('chatHeader').innerHTML = headerHtml;
}

// Render messages
function renderMessages(messages) {
    const container = document.getElementById('messagesContainer');
    
    if (messages.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-title">No Messages Yet</div>
                <div class="empty-state-text">Start the conversation with a message below.</div>
            </div>
        `;
        return;
    }
    
    let html = '';
    let lastDate = null;
    
    messages.forEach(message => {
        const messageDate = new Date(message.whatsapp_timestamp || message.created_at).toDateString();
        
        // Add date separator if needed
        if (messageDate !== lastDate) {
            html += `
                <div style="text-align: center; margin: 20px 0;">
                    <span style="background: rgba(0,0,0,0.1); padding: 4px 12px; border-radius: 12px; font-size: 12px; color: var(--wa-text-light);">
                        ${messageDate}
                    </span>
                </div>
            `;
            lastDate = messageDate;
        }
        
        const isOutgoing = message.direction === 'outgoing';
        const statusIcon = getMessageStatusIcon(message.status);
        
        html += `
            <div class="message-bubble ${isOutgoing ? 'outgoing' : 'incoming'}">
                <div class="message-text">${message.message}</div>
                <div class="message-meta">
                    <span class="message-time">${message.formatted_time}</span>
                    ${isOutgoing ? `<div class="message-status">${statusIcon}</div>` : ''}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    container.scrollTop = container.scrollHeight;
}

// Get message status icon
function getMessageStatusIcon(status) {
    switch (status) {
        case 'sent':
            return '<i class="fas fa-check check-icon"></i>';
        case 'delivered':
            return '<i class="fas fa-check-double check-icon"></i>';
        case 'read':
            return '<i class="fas fa-check-double check-icon" style="color: #4fc3f7;"></i>';
        case 'failed':
            return '<i class="fas fa-exclamation-triangle check-icon" style="color: #f44336;"></i>';
        default:
            return '<i class="fas fa-clock check-icon"></i>';
    }
}

// Send message
function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message || !currentClientId) return;
    
    // Show loading state
    input.value = '';
    
    fetch('/mywhatsapp/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            client_id: currentClientId,
            message: message,
            message_type: 'text'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add message to chat immediately for better UX
            addMessageToChat(data.message);
        } else {
            console.error('Error sending message:', data.errors);
            input.value = message; // Restore message on error
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        input.value = message; // Restore message on error
    });
}

// Add message to chat immediately
function addMessageToChat(message) {
    const container = document.getElementById('messagesContainer');
    const messageHtml = `
        <div class="message-bubble outgoing">
            <div class="message-text">${message.message}</div>
            <div class="message-meta">
                <span class="message-time">${message.formatted_time}</span>
                <div class="message-status">${getMessageStatusIcon(message.status)}</div>
            </div>
        </div>
    `;
    
    container.innerHTML += messageHtml;
    container.scrollTop = container.scrollHeight;
}

// Handle keyboard events
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

// Show assignment modal
function showAssignmentModal() {
    if (!currentClientId) return;
    
    document.getElementById('assignmentClientId').value = currentClientId;
    new bootstrap.Modal(document.getElementById('assignmentModal')).show();
}

// Save assignment
function saveAssignment() {
    const form = document.getElementById('assignmentForm');
    const formData = new FormData(form);
    
    fetch('/mywhatsapp/assign', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            client_id: formData.get('client_id'),
            user_id: formData.get('user_id'),
            role: formData.get('role'),
            notes: formData.get('notes')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('assignmentModal')).hide();
            refreshMessages();
            showNotification('Team member assigned successfully', 'success');
        } else {
            console.error('Error assigning team member:', data.errors);
            showNotification('Error assigning team member', 'error');
        }
    })
    .catch(error => {
        console.error('Error assigning team member:', error);
        showNotification('Error assigning team member', 'error');
    });
}

// Show templates modal
function showTemplates() {
    loadTemplates();
    new bootstrap.Modal(document.getElementById('templatesModal')).show();
}

// Load templates
function loadTemplates() {
    const category = document.getElementById('templateCategory').value;
    
    fetch(`/mywhatsapp/templates${category ? '?category=' + category : ''}`)
        .then(response => response.json())
        .then(templates => {
            renderTemplates(templates);
        })
        .catch(error => {
            console.error('Error loading templates:', error);
        });
}

// Render templates
function renderTemplates(templates) {
    const container = document.getElementById('templatesList');
    
    if (templates.length === 0) {
        container.innerHTML = '<p class="text-muted">No templates found</p>';
        return;
    }
    
    let html = '<div class="row">';
    templates.forEach(template => {
        html += `
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-title">${template.name}</h6>
                        <p class="card-text small text-muted">${template.category}</p>
                        <p class="card-text">${template.content.substring(0, 100)}${template.content.length > 100 ? '...' : ''}</p>
                        <button class="btn btn-sm btn-primary" onclick="useTemplate(${template.id})">Use Template</button>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    container.innerHTML = html;
}

// Use template
function useTemplate(templateId) {
    if (!currentClientId) return;
    
    fetch('/mywhatsapp/use-template', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            template_id: templateId,
            client_id: currentClientId,
            variables: {} // TODO: Add variables input if needed
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('templatesModal')).hide();
            addMessageToChat(data.message);
            showNotification('Template sent successfully', 'success');
        } else {
            console.error('Error using template:', data.errors);
            showNotification('Error using template', 'error');
        }
    })
    .catch(error => {
        console.error('Error using template:', error);
        showNotification('Error using template', 'error');
    });
}

// Refresh messages
function refreshMessages() {
    if (currentClientId) {
        loadMessages(currentClientId);
    }
}

// View client info
function viewClientInfo() {
    if (!currentClient) return;
    
    // TODO: Show client info modal or sidebar
    console.log('Client info:', currentClient);
}

// Attach file
function attachFile() {
    // TODO: Implement file attachment
    console.log('Attach file clicked');
}

// Show notification
function showNotification(message, type = 'info') {
    // Simple notification - you can replace with a better notification system
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Search functionality
document.getElementById('clientSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    
    document.querySelectorAll('.client-item').forEach(item => {
        const name = item.querySelector('.client-name').textContent.toLowerCase();
        const message = item.querySelector('.client-last-message').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || message.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});

// Filter functionality
document.getElementById('serviceFilter').addEventListener('change', function(e) {
    const categoryId = e.target.value;
    
    document.querySelectorAll('.client-item').forEach(item => {
        // TODO: Implement server-side filtering
        console.log('Filter by service category:', categoryId);
    });
});

document.getElementById('assignedFilter').addEventListener('change', function(e) {
    const userId = e.target.value;
    
    document.querySelectorAll('.client-item').forEach(item => {
        // TODO: Implement server-side filtering
        console.log('Filter by assigned user:', userId);
    });
});

// Auto-refresh messages every 30 seconds
setInterval(() => {
    if (currentClientId) {
        refreshMessages();
    }
}, 30000);

// Mobile Responsive Functions
function toggleMobileSidebar() {
    const sidebar = document.getElementById('whatsappSidebar');
    const main = document.getElementById('whatsappMain');
    
    sidebar.classList.toggle('mobile-open');
    main.classList.toggle('mobile-hidden');
}

function goBackToClientList() {
    const sidebar = document.getElementById('whatsappSidebar');
    const main = document.getElementById('whatsappMain');
    
    sidebar.classList.remove('mobile-open');
    main.classList.add('mobile-hidden');
}

// Check if mobile and hide main chat area initially
function checkMobileView() {
    if (window.innerWidth <= 768) {
        const main = document.getElementById('whatsappMain');
        if (main) {
            main.classList.add('mobile-hidden');
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Enhanced WhatsApp Dashboard initialized');
    
    // Check mobile view
    checkMobileView();
    
    // Add resize listener
    window.addEventListener('resize', checkMobileView);
    
    // Check if clients data is available
    const clientList = document.getElementById('clientList');
    const clientsData = @json($clients);
    console.log('Clients data from server:', clientsData);
    console.log('Number of clients:', clientsData ? clientsData.length : 0);
    
    // Auto-select first client if available (only on desktop)
    if (window.innerWidth > 768 && clientsData && clientsData.length > 0) {
        const firstClient = document.querySelector('.client-item');
        if (firstClient) {
            console.log('Auto-selecting first client:', firstClient.dataset.clientId);
            selectClient(firstClient.dataset.clientId);
        }
    } else {
        console.log('No clients found or mobile view, showing empty state');
    }
});

// Show Add Client Modal
function showAddClientModal() {
    const modal = new bootstrap.Modal(document.getElementById('addClientModal'));
    modal.show();
}

// Add New Client
function addNewClient() {
    const phone = document.getElementById('newClientPhone').value;
    const name = document.getElementById('newClientName').value;
    const email = document.getElementById('newClientEmail').value;
    const serviceCategory = document.getElementById('newClientServiceCategory').value;
    const assignedUser = document.getElementById('newClientAssignedUser').value;
    const notes = document.getElementById('newClientNotes').value;
    
    if (!phone) {
        alert('Please enter a phone number');
        return;
    }
    
    // Show loading
    const modal = bootstrap.Modal.getInstance(document.getElementById('addClientModal'));
    const submitBtn = modal._element.querySelector('.btn-primary');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border spinner-border-sm"></span> Adding...';
    
    fetch('/mywhatsapp/add-client', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            phone_number: phone,
            name: name,
            email: email,
            service_category_id: serviceCategory,
            assigned_user_id: assignedUser,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal and refresh client list
            bootstrap.Modal.getInstance(document.getElementById('addClientModal')).hide();
            
            // Show success message
            showToast('Client added successfully!', 'success');
            
            // Refresh client list
            loadClients();
        } else {
            alert('Error adding client: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error adding client:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Add Client';
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
}

// Show Broadcast Modal
function showBroadcastModal() {
    const modal = new bootstrap.Modal(document.getElementById('broadcastModal'));
    modal.show();
}

// Send Broadcast Message
function sendBroadcast() {
    const message = document.getElementById('broadcastMessage').value;
    const recipients = document.getElementById('broadcastRecipients').value;
    const saveTemplate = document.getElementById('broadcastSaveTemplate').checked;
    
    if (!message.trim()) {
        alert('Please enter a message');
        return;
    }
    
    // Show loading
    const modal = bootstrap.Modal.getInstance(document.getElementById('broadcastModal'));
    const submitBtn = modal._element.querySelector('.btn-primary');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border spinner-border-sm"></span> Sending...';
    
    const formData = {
        message: message,
        recipients: recipients,
        save_as_template: saveTemplate
    };
    
    fetch('/mywhatsapp/send-broadcast', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('broadcastModal')).hide();
            
            // Show success message
            showToast('Broadcast message sent successfully!', 'success');
        } else {
            alert('Error sending broadcast: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error sending broadcast:', error);
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Send Broadcast';
    });
}

// Enhanced Toast Notification
function showToast(message, type = 'info') {
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    // Create toast container if it doesn't exist
    let toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toastContainer';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.innerHTML = toastHtml;
    
    // Show toast
    const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
    toast.show();
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        toast.hide();
    }, 5000);
}
</script>
@endsection
