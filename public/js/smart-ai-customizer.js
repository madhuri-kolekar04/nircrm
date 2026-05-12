/**
 * Smart AI Page Customizer - Menu Controller Integration
 * Automatically applies menu controller visibility settings based on user role
 * No manual coding required - AI reads menu settings and applies them!
 */

class SmartAICustomizer {
    constructor() {
        this.userRole = null;
        this.userId = null;
        this.userPosition = null;
        this.menuSettings = {};
        this.currentMenu = '';
        this.init();
    }

    async init() {
        // Get current user info
        await this.loadUserInfo();
        
        // Load menu controller settings
        await this.loadMenuSettings();
        
        // Apply customizations to current page
        this.applyMenuCustomizations();
        
        // Add AI control panel
        this.addSmartAIPanel();
    }

    async loadUserInfo() {
        try {
            const response = await fetch('/api/current-user');
            const data = await response.json();
            
            this.userRole = data.role;
            this.userId = data.id;
            this.userPosition = data.position || data.designation;
            
            console.log('🤖 Smart AI User Info from API:', {
                role: this.userRole,
                id: this.userId,
                position: this.userPosition
            });
        } catch (error) {
            console.log('🤖 Smart AI: API failed, detecting from page');
            this.detectUserFromPage();
        }
    }

    detectUserFromPage() {
        // Try multiple methods to detect user info
        
        // Method 1: Look for role in sidebar/user info
        const roleSelectors = [
            '.user-role',
            '.role-name',
            '[data-role]',
            '.sidebar .user-info .role',
            '.navbar .role',
            '.user-menu .role'
        ];
        
        for (const selector of roleSelectors) {
            const element = document.querySelector(selector);
            if (element) {
                const roleText = element.textContent || element.innerText || '';
                console.log('🤖 Smart AI: Found role element:', selector, roleText);
                
                // Map role names to IDs
                if (roleText.toLowerCase().includes('admin')) {
                    this.userRole = 1;
                    console.log('🤖 Smart AI: Detected Admin role');
                    return;
                } else if (roleText.toLowerCase().includes('employee')) {
                    this.userRole = 2;
                    console.log('🤖 Smart AI: Detected Employee role');
                    return;
                } else if (roleText.toLowerCase().includes('customer')) {
                    this.userRole = 3;
                    console.log('🤖 Smart AI: Detected Customer role');
                    return;
                }
            }
        }
        
        // Method 2: Look for role in page content
        const pageText = document.body.textContent || document.body.innerText || '';
        
        if (pageText.includes('EMPLOYEE') && pageText.includes('Help Desk')) {
            this.userRole = 2;
            console.log('🤖 Smart AI: Detected Employee from page content');
            return;
        }
        
        if (pageText.includes('ADMIN') || pageText.includes('Admin')) {
            this.userRole = 1;
            console.log('🤖 Smart AI: Detected Admin from page content');
            return;
        }
        
        // Method 3: Look for user info in common locations
        const userInfoSelectors = [
            '.user-info',
            '.navbar .dropdown-toggle',
            '.profile-info',
            '.user-profile',
            '.sidebar-user',
            '.current-user'
        ];
        
        for (const selector of userInfoSelectors) {
            const element = document.querySelector(selector);
            if (element) {
                const text = element.textContent || element.innerText || '';
                console.log('🤖 Smart AI: Found user info:', selector, text);
                
                // Extract role from text patterns
                if (text.includes('EMPLOYEE') || text.includes('Employee')) {
                    this.userRole = 2;
                    console.log('🤖 Smart AI: Detected Employee from user info');
                    return;
                }
                if (text.includes('ADMIN') || text.includes('Admin')) {
                    this.userRole = 1;
                    console.log('🤖 Smart AI: Detected Admin from user info');
                    return;
                }
                if (text.includes('CUSTOMER') || text.includes('Customer')) {
                    this.userRole = 3;
                    console.log('🤖 Smart AI: Detected Customer from user info');
                    return;
                }
            }
        }
        
        // Method 4: Check URL patterns or page titles
        const url = window.location.href;
        const title = document.title;
        
        if (url.includes('employee') || title.includes('Employee')) {
            this.userRole = 2;
            console.log('🤖 Smart AI: Detected Employee from URL/Title');
            return;
        }
        
        console.log('🤖 Smart AI: Could not detect role, defaulting to Employee');
        this.userRole = 2; // Default to Employee for this system
    }

    async loadMenuSettings() {
        try {
            const response = await fetch('/api/menu-controller-settings');
            const data = await response.json();
            
            this.menuSettings = data.settings || {};
            this.currentMenu = this.detectCurrentMenu();
            
            console.log('🤖 Smart AI Menu Settings Loaded:', {
                settings: this.menuSettings,
                currentMenu: this.currentMenu,
                userRole: this.userRole,
                totalSettings: Object.keys(this.menuSettings).length
            });
            
            // Debug: Check if we have settings for current menu
            if (this.menuSettings[this.currentMenu]) {
                console.log('🤖 Smart AI: Found settings for', this.currentMenu, ':', this.menuSettings[this.currentMenu]);
            } else {
                console.log('🤖 Smart AI: No settings found for', this.currentMenu);
                console.log('🤖 Smart AI: Available menus:', Object.keys(this.menuSettings));
            }
            
        } catch (error) {
            console.log('🤖 Smart AI: Could not load menu settings', error);
        }
    }

    detectCurrentMenu() {
        const path = window.location.pathname;
        const title = document.title;
        
        // Map URLs to menu names
        const urlToMenu = {
            '/employees': 'Employees',
            '/Employee': 'Employees',
            '/leads': 'Leads',
            '/customers': 'Customers',
            '/menu-controller': 'Menu Controller',
            '/employee-menu-controller': 'Employee Menu Controller'
        };
        
        // Check URL first
        for (const [url, menu] of Object.entries(urlToMenu)) {
            if (path.includes(url)) return menu;
        }
        
        // Check title
        if (title.includes('Employees')) return 'Employees';
        if (title.includes('Leads')) return 'Leads';
        if (title.includes('Customers')) return 'Customers';
        
        return 'Unknown';
    }

    applyMenuCustomizations() {
        console.log('🤖 Smart AI Applying Customizations:', {
            currentMenu: this.currentMenu,
            hasSettings: !!this.menuSettings[this.currentMenu],
            userRole: this.userRole
        });

        // If no settings exist for this menu, show everything (default behavior)
        if (!this.menuSettings[this.currentMenu]) {
            console.log('🤖 Smart AI: No settings found for', this.currentMenu, '- showing everything');
            return;
        }

        const menuSetting = this.menuSettings[this.currentMenu];
        const isVisible = menuSetting.is_visible;
        
        console.log('🤖 Smart AI Menu Status:', {
            menu: this.currentMenu,
            visible: isVisible,
            userRole: this.userRole
        });

        // If menu is hidden for this user's role, hide entire page content
        if (!isVisible) {
            this.hideEntirePage();
            return;
        }

        // If menu is visible, apply element-level customizations
        this.applyElementCustomizations(menuSetting);
    }

    hideEntirePage() {
        // Hide main content areas
        const contentSelectors = [
            '.content',
            '.box',
            '.table-responsive',
            'table',
            '.btn',
            'main',
            '[class*="content"]'
        ];
        
        contentSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.display = 'none';
                element.setAttribute('data-ai-hidden', 'menu-hidden');
            });
        });
        
        // Show access denied message
        this.showAccessDeniedMessage();
    }

    showAccessDeniedMessage() {
        const message = document.createElement('div');
        message.innerHTML = `
            <div style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
                color: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 20px 40px rgba(0,0,0,0.3);
                text-align: center;
                z-index: 10000;
                font-family: 'Segoe UI', sans-serif;
            ">
                <div style="font-size: 48px; margin-bottom: 15px;">🚫</div>
                <h3 style="margin: 0 0 10px 0;">Access Restricted</h3>
                <p style="margin: 0; opacity: 0.9;">You don't have permission to view this page.</p>
                <p style="margin: 10px 0 0 0; font-size: 14px; opacity: 0.7;">
                    Menu: ${this.currentMenu} | Role: ${this.getRoleName(this.userRole)}
                </p>
            </div>
        `;
        
        document.body.appendChild(message);
    }

    applyElementCustomizations(menuSetting) {
        // Apply page-specific customizations if they exist
        if (menuSetting.page_customizations && menuSetting.page_customizations.length > 0) {
            console.log('🤖 Smart AI: Applying element customizations:', menuSetting.page_customizations.length);
            
            menuSetting.page_customizations.forEach(customization => {
                // Only hide if is_visible is 0 (false)
                if (customization.is_visible === 0 || customization.is_visible === false) {
                    console.log('🤖 Smart AI: Hiding element:', customization.element_identifier);
                    this.hideElement(customization.element_identifier);
                }
            });
        } else {
            console.log('🤖 Smart AI: No element customizations found');
        }
    }

    hideElement(elementId) {
        const selectors = {
            'employees-table': 'table, .box, .table-responsive',
            'add-employee-btn': 'a[href*="Employee/add"], .btn-info:contains("Add"), .glyphicon-plus',
            'employees-table.ID': 'th:contains("ID"), td:first-child',
            'employees-table.Name': 'th:contains("Name"), td:nth-child(2)',
            'employees-table.Email': 'th:contains("Email"), td:contains("@")',
            'employees-table.Controls': 'th:contains("Controls"), td:last-child',
            'edit-link': 'a[href*="edit"], .btn-info:contains("Edit")',
            'delete-link': 'a[href*="delete"], .btn-danger:contains("Delete")'
        };
        
        const selector = selectors[elementId];
        if (selector) {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.display = 'none';
                element.setAttribute('data-ai-hidden', elementId);
            });
        }
    }

    getRoleName(roleId) {
        const roles = {
            1: 'Admin',
            2: 'Employee', 
            3: 'Customer'
        };
        return roles[roleId] || 'Unknown';
    }

    addSmartAIPanel() {
        const aiPanel = document.createElement('div');
        aiPanel.innerHTML = `
            <div id="smart-ai-panel" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
                color: white;
                padding: 15px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                z-index: 9999;
                font-family: 'Segoe UI', sans-serif;
                min-width: 280px;
                cursor: pointer;
                transition: all 0.3s ease;
            ">
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div style="
                        width: 40px;
                        height: 40px;
                        background: white;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 12px;
                        font-size: 20px;
                    ">🤖</div>
                    <div>
                        <div style="font-weight: bold; font-size: 14px;">Smart AI Customizer</div>
                        <div style="font-size: 11px; opacity: 0.9;">${this.currentMenu} • ${this.getRoleName(this.userRole)}</div>
                    </div>
                </div>
                <div id="ai-panel-details" style="display: none;">
                    <div style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 10px; margin-top: 10px;">
                        <div style="font-size: 12px; margin-bottom: 6px;">👤 Role: ${this.getRoleName(this.userRole)}</div>
                        <div style="font-size: 12px; margin-bottom: 6px;">💼 Position: ${this.userPosition || 'N/A'}</div>
                        <div style="font-size: 12px; margin-bottom: 6px;">📋 Menu: ${this.currentMenu}</div>
                        <div style="font-size: 12px; margin-bottom: 12px;">⚙️ Status: ${this.menuSettings[this.currentMenu]?.is_visible ? '✅ Visible' : '🚫 Hidden'}</div>
                        <button onclick="smartAI.showHiddenElements()" style="
                            background: white;
                            color: #4CAF50;
                            border: none;
                            padding: 6px 10px;
                            border-radius: 4px;
                            font-size: 10px;
                            cursor: pointer;
                            margin-right: 5px;
                        ">Show Hidden</button>
                        <button onclick="smartAI.openMenuSettings()" style="
                            background: rgba(255,255,255,0.2);
                            color: white;
                            border: 1px solid rgba(255,255,255,0.3);
                            padding: 6px 10px;
                            border-radius: 4px;
                            font-size: 10px;
                            cursor: pointer;
                        ">Menu Settings</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(aiPanel);
        
        // Add click handler
        document.getElementById('smart-ai-panel').addEventListener('click', () => {
            const details = document.getElementById('ai-panel-details');
            details.style.display = details.style.display === 'none' ? 'block' : 'none';
        });
    }

    showHiddenElements() {
        const hiddenElements = document.querySelectorAll('[data-ai-hidden]');
        hiddenElements.forEach(element => {
            element.style.display = '';
            element.style.border = '2px dashed #ff6b6b';
            element.style.backgroundColor = 'rgba(255, 107, 107, 0.1)';
        });
        
        setTimeout(() => {
            hiddenElements.forEach(element => {
                element.style.display = 'none';
                element.style.border = '';
                element.style.backgroundColor = '';
            });
        }, 3000);
    }

    openMenuSettings() {
        window.open('/menu-controller', '_blank');
    }
}

// Initialize Smart AI Customizer
document.addEventListener('DOMContentLoaded', () => {
    window.smartAI = new SmartAICustomizer();
});

// Also initialize immediately if DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.smartAI = new SmartAICustomizer();
    });
} else {
    window.smartAI = new SmartAICustomizer();
}
