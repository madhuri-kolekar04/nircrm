/**
 * WhatsApp CRM - JavaScript Interactivity
 * Handles all dynamic functionality and animations
 */

// ============================================
// Theme Management
// ============================================

class ThemeManager {
    constructor() {
        this.html = document.documentElement;
        this.themeToggle = document.getElementById('themeToggle');
        this.init();
    }

    init() {
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            this.html.classList.add('dark');
        }

        if (this.themeToggle) {
            this.themeToggle.addEventListener('click', () => this.toggle());
        }
    }

    toggle() {
        this.html.classList.toggle('dark');
        const isDark = this.html.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    isDark() {
        return this.html.classList.contains('dark');
    }
}

// ============================================
// Sidebar Management
// ============================================

class SidebarManager {
    constructor() {
        this.sidebar = document.getElementById('sidebar');
        this.isExpanded = false;
        this.init();
    }

    init() {
        if (!this.sidebar) return;

        this.sidebar.addEventListener('mouseenter', () => this.expand());
        this.sidebar.addEventListener('mouseleave', () => this.collapse());
    }

    expand() {
        if (!this.isExpanded) {
            this.sidebar.classList.add('w-sidebar-expanded');
            this.sidebar.classList.remove('w-sidebar');
            this.isExpanded = true;
        }
    }

    collapse() {
        if (this.isExpanded) {
            this.sidebar.classList.remove('w-sidebar-expanded');
            this.sidebar.classList.add('w-sidebar');
            this.isExpanded = false;
        }
    }
}

// ============================================
// Chat Management
// ============================================

class ChatManager {
    constructor() {
        this.messagesContainer = document.getElementById('messagesContainer');
        this.messageInput = document.getElementById('messageInput');
        this.sendBtn = document.getElementById('sendBtn');
        this.listContainer = document.getElementById('listContainer');
        this.searchInput = document.getElementById('searchInput');
        this.currentItem = null;
        this.init();
    }

    init() {
        if (this.sendBtn) {
            this.sendBtn.addEventListener('click', () => this.sendMessage());
        }

        if (this.messageInput) {
            this.messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });
        }

        if (this.searchInput) {
            this.searchInput.addEventListener('input', (e) => this.handleSearch(e));
        }
    }

    sendMessage() {
        const content = this.messageInput.value.trim();
        if (!content) return;

        const message = {
            id: Date.now(),
            content: content,
            timestamp: new Date(),
            type: 'outgoing',
            status: 'sent'
        };

        this.addMessageToUI(message);
        this.messageInput.value = '';
        this.messageInput.focus();
        this.scrollToBottom();

        // Simulate response
        setTimeout(() => {
            const response = {
                id: Date.now(),
                content: 'Message received! Thanks for reaching out.',
                timestamp: new Date(),
                type: 'incoming',
                status: 'read'
            };
            this.addMessageToUI(response);
            this.scrollToBottom();
        }, 1000);
    }

    addMessageToUI(message) {
        const messageEl = this.createMessageElement(message);
        this.messagesContainer.appendChild(messageEl);
        messageEl.classList.add('animate-bounce-msg');
    }

    createMessageElement(message) {
        const div = document.createElement('div');
        const isOutgoing = message.type === 'outgoing';
        
        div.className = `flex gap-3 ${isOutgoing ? 'justify-end' : 'justify-start'} animate-fade-in`;
        
        const time = message.timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const statusIcon = message.status === 'read' ? '✓✓' : message.status === 'sent' ? '✓' : '';

        if (isOutgoing) {
            div.innerHTML = `
                <div class="flex-1"></div>
                <div class="flex flex-col items-end max-w-msg">
                    <div class="message-bubble outgoing">
                        ${this.escapeHtml(message.content)}
                    </div>
                    <div class="flex items-center gap-1 mt-1">
                        <span class="text-xs text-wa-text-light dark:text-gray-400">${time}</span>
                        <span class="text-xs text-wa-green">${statusIcon}</span>
                    </div>
                </div>
            `;
        } else {
            div.innerHTML = `
                <div class="flex gap-3">
                    <div class="avatar sm">
                        ${this.currentItem?.avatar || 'U'}
                    </div>
                    <div class="flex flex-col max-w-msg">
                        <div class="message-bubble incoming">
                            ${this.escapeHtml(message.content)}
                        </div>
                        <span class="text-xs text-wa-text-light dark:text-gray-400 mt-1">${time}</span>
                    </div>
                </div>
            `;
        }

        return div;
    }

    scrollToBottom() {
        setTimeout(() => {
            this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
        }, 0);
    }

    handleSearch(e) {
        const query = e.target.value.toLowerCase();
        const items = this.listContainer.querySelectorAll('.list-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? 'block' : 'none';
        });
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    selectItem(item) {
        this.currentItem = item;
        
        // Update chat header
        document.getElementById('chatName').textContent = item.name;
        document.getElementById('chatStatus').textContent = item.email;

        // Clear messages
        this.messagesContainer.innerHTML = '';

        // Add initial message
        const initialMessage = {
            id: 1,
            content: `Hello! This is ${item.name}'s profile information.`,
            timestamp: new Date(),
            type: 'incoming',
            status: 'read'
        };

        this.addMessageToUI(initialMessage);

        // Add details message
        setTimeout(() => {
            const detailsMessage = {
                id: 2,
                content: `Email: ${item.email}`,
                timestamp: new Date(),
                type: 'outgoing',
                status: 'read'
            };
            this.addMessageToUI(detailsMessage);
        }, 500);

        // Add details section
        setTimeout(() => {
            this.addDetailsSection(item);
        }, 1000);

        this.scrollToBottom();
    }

    addDetailsSection(item) {
        const detailsDiv = document.createElement('div');
        detailsDiv.className = 'border-t border-wa-border dark:border-wa-border-dark pt-4 mt-4 animate-fade-in';
        detailsDiv.innerHTML = `
            <h4 class="font-semibold text-wa-text-dark dark:text-white mb-3">Details</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-wa-text-light dark:text-gray-400">ID:</span>
                    <span class="text-wa-text-dark dark:text-white font-medium">${item.id}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-wa-text-light dark:text-gray-400">Name:</span>
                    <span class="text-wa-text-dark dark:text-white font-medium">${item.name}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-wa-text-light dark:text-gray-400">Email:</span>
                    <span class="text-wa-text-dark dark:text-white font-medium">${item.email}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-wa-text-light dark:text-gray-400">Status:</span>
                    <span class="text-wa-text-dark dark:text-white font-medium">${item.status}</span>
                </div>
            </div>
            <div class="flex gap-2 pt-4">
                <button class="flex-1 px-4 py-2 bg-wa-green hover:bg-wa-dark-green text-white rounded-lg font-medium transition-colors duration-200 text-sm">
                    <i class="fas fa-edit mr-2"></i>Edit
                </button>
                <button class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors duration-200 text-sm">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </div>
        `;
        this.messagesContainer.appendChild(detailsDiv);
        this.scrollToBottom();
    }
}

// ============================================
// Data Management
// ============================================

class DataManager {
    constructor() {
        this.mockData = {
            employees: [
                { id: 1, name: 'John Doe', email: 'john@example.com', status: 'Online', avatar: 'JD' },
                { id: 2, name: 'Jane Smith', email: 'jane@example.com', status: 'Offline', avatar: 'JS' },
                { id: 3, name: 'Mike Johnson', email: 'mike@example.com', status: 'Online', avatar: 'MJ' },
                { id: 4, name: 'Sarah Williams', email: 'sarah@example.com', status: 'Online', avatar: 'SW' },
                { id: 5, name: 'Tom Brown', email: 'tom@example.com', status: 'Offline', avatar: 'TB' },
            ],
            customers: [
                { id: 1, name: 'Acme Corp', email: 'contact@acme.com', status: 'Active', avatar: 'AC' },
                { id: 2, name: 'Tech Solutions', email: 'info@tech.com', status: 'Active', avatar: 'TS' },
                { id: 3, name: 'Global Industries', email: 'hello@global.com', status: 'Inactive', avatar: 'GI' },
                { id: 4, name: 'StartUp Inc', email: 'hello@startup.com', status: 'Active', avatar: 'SI' },
            ],
            invoices: [
                { id: 'INV-001', name: 'Invoice #001', email: '$5,000', status: 'Paid', avatar: 'I1' },
                { id: 'INV-002', name: 'Invoice #002', email: '$3,200', status: 'Pending', avatar: 'I2' },
                { id: 'INV-003', name: 'Invoice #003', email: '$7,500', status: 'Overdue', avatar: 'I3' },
                { id: 'INV-004', name: 'Invoice #004', email: '$2,100', status: 'Paid', avatar: 'I4' },
            ],
            projects: [
                { id: 1, name: 'Website Redesign', email: 'In Progress', status: 'Active', avatar: 'WR' },
                { id: 2, name: 'Mobile App Dev', email: 'Planning', status: 'Active', avatar: 'MA' },
                { id: 3, name: 'Cloud Migration', email: 'Completed', status: 'Completed', avatar: 'CM' },
            ],
            leads: [
                { id: 1, name: 'New Lead 1', email: 'lead1@example.com', status: 'New', avatar: 'NL' },
                { id: 2, name: 'Qualified Lead', email: 'qualified@example.com', status: 'Qualified', avatar: 'QL' },
                { id: 3, name: 'Follow-up Lead', email: 'followup@example.com', status: 'Follow-up', avatar: 'FL' },
            ],
            tasks: [
                { id: 1, name: 'Complete Report', email: 'Due Tomorrow', status: 'Pending', avatar: 'CR' },
                { id: 2, name: 'Client Meeting', email: 'Due Today', status: 'Pending', avatar: 'CM' },
                { id: 3, name: 'Code Review', email: 'Due Next Week', status: 'Pending', avatar: 'CR' },
            ],
        };
    }

    getData(section) {
        return this.mockData[section] || [];
    }

    getStatusClass(status) {
        const statusMap = {
            'Online': 'status-badge online',
            'Offline': 'status-badge offline',
            'Active': 'status-badge online',
            'Inactive': 'status-badge offline',
            'Paid': 'status-badge completed',
            'Pending': 'status-badge pending',
            'Overdue': 'status-badge offline',
            'Completed': 'status-badge completed',
            'New': 'status-badge pending',
            'Qualified': 'status-badge online',
            'Follow-up': 'status-badge pending',
        };
        return statusMap[status] || 'status-badge';
    }
}

// ============================================
// UI Renderer
// ============================================

class UIRenderer {
    constructor(chatManager, dataManager) {
        this.chatManager = chatManager;
        this.dataManager = dataManager;
        this.listContainer = document.getElementById('listContainer');
        this.pageTitle = document.getElementById('pageTitle');
    }

    renderSection(section) {
        const data = this.dataManager.getData(section);
        this.pageTitle.textContent = section.charAt(0).toUpperCase() + section.slice(1);
        
        this.listContainer.innerHTML = data.map(item => this.createListItem(item)).join('');
        
        // Add click handlers
        this.listContainer.querySelectorAll('.list-item').forEach(el => {
            el.addEventListener('click', () => {
                this.listContainer.querySelectorAll('.list-item').forEach(e => e.classList.remove('active'));
                el.classList.add('active');
                
                const item = data.find(d => d.id == el.dataset.id);
                this.chatManager.selectItem(item);
            });
        });
    }

    createListItem(item) {
        const statusClass = this.dataManager.getStatusClass(item.status);
        return `
            <div class="list-item" data-id="${item.id}">
                <div class="flex items-center gap-3">
                    <div class="avatar">
                        ${item.avatar}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-wa-text-dark dark:text-white truncate">${item.name}</h4>
                        <p class="text-sm text-wa-text-light dark:text-gray-400 truncate">${item.email}</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="${statusClass}">${item.status}</span>
                    </div>
                </div>
            </div>
        `;
    }
}

// ============================================
// Notifications
// ============================================

class NotificationManager {
    static show(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-${this.getIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('animate-slide-out');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    static getIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle',
        };
        return icons[type] || 'info-circle';
    }
}

// ============================================
// Keyboard Shortcuts
// ============================================

class KeyboardShortcuts {
    constructor(themeManager, chatManager) {
        this.themeManager = themeManager;
        this.chatManager = chatManager;
        this.init();
    }

    init() {
        document.addEventListener('keydown', (e) => {
            // Ctrl/Cmd + K: Focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                const searchInput = document.getElementById('searchInput');
                if (searchInput) searchInput.focus();
            }

            // Ctrl/Cmd + Shift + K: Toggle dark mode
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'K') {
                e.preventDefault();
                this.themeManager.toggle();
            }

            // Escape: Clear search
            if (e.key === 'Escape') {
                const searchInput = document.getElementById('searchInput');
                if (searchInput && searchInput.value) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                }
            }
        });
    }
}

// ============================================
// Initialize Application
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize managers
    const themeManager = new ThemeManager();
    const sidebarManager = new SidebarManager();
    const dataManager = new DataManager();
    const chatManager = new ChatManager();
    const uiRenderer = new UIRenderer(chatManager, dataManager);
    const keyboardShortcuts = new KeyboardShortcuts(themeManager, chatManager);

    // Make loadSection function globally available
    window.loadSection = (section) => {
        uiRenderer.renderSection(section);
    };

    // Make selectItem function globally available
    window.selectItem = (id, name, email) => {
        chatManager.selectItem({ id, name, email, status: 'Active', avatar: name.split(' ').map(n => n[0]).join('') });
    };

    // Load initial section
    uiRenderer.renderSection('employees');

    // Show welcome notification
    setTimeout(() => {
        NotificationManager.show('Welcome to WhatsApp CRM!', 'success', 2000);
    }, 500);
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        ThemeManager,
        SidebarManager,
        ChatManager,
        DataManager,
        UIRenderer,
        NotificationManager,
        KeyboardShortcuts,
    };
}
