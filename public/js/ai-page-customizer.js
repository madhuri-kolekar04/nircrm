/**
 * AI Page Customization System
 * Automatically detects and controls page elements based on user permissions
 * No manual coding required - works on any page!
 */

class AIPageCustomizer {
    constructor() {
        this.hiddenElements = [];
        this.currentMenu = '';
        this.userRole = null;
        this.userId = null;
        this.init();
    }

    async init() {
        // Load user permissions from API
        await this.loadPermissions();
        
        // Apply customizations to current page
        this.applyCustomizations();
        
        // Add AI control panel to page
        this.addAIControlPanel();
    }

    async loadPermissions() {
        try {
            // Get current page info
            const currentPath = window.location.pathname;
            const currentMenu = this.detectCurrentMenu(currentPath);
            
            // Fetch user permissions from API
            const response = await fetch(`/api/page-customizations?menu=${encodeURIComponent(currentMenu)}&path=${encodeURIComponent(currentPath)}`);
            const data = await response.json();
            
            this.hiddenElements = data.hiddenElements || [];
            this.currentMenu = currentMenu;
            this.userRole = data.userRole;
            this.userId = data.userId;
            
            console.log('🤖 AI Customizer Loaded:', {
                menu: this.currentMenu,
                hiddenElements: this.hiddenElements.length,
                userRole: this.userRole
            });
        } catch (error) {
            console.log('🤖 AI Customizer: Using fallback mode');
        }
    }

    detectCurrentMenu(path) {
        const pathToMenu = {
            '/employees': 'Employees',
            '/Employee': 'Employees', 
            '/leads': 'Leads',
            '/customers': 'Customers',
            '/menu-controller': 'Menu Controller',
            '/employee-menu-controller': 'Employee Menu Controller'
        };
        
        for (const [pathPattern, menuName] of Object.entries(pathToMenu)) {
            if (path.includes(pathPattern)) {
                return menuName;
            }
        }
        
        return 'Unknown';
    }

    applyCustomizations() {
        if (this.hiddenElements.length === 0) return;
        
        console.log('🤖 AI hiding elements:', this.hiddenElements);
        
        // Hide entire table
        if (this.hiddenElements.includes('employees-table')) {
            this.hideElementsBySelector('table, .box, .table-responsive');
        }
        
        // Hide Add Employee button
        if (this.hiddenElements.includes('add-employee-btn')) {
            this.hideElementsBySelector('a[href*="Employee/add"], .btn-info:contains("Add"), .glyphicon-plus');
        }
        
        // Hide table columns
        const columnSelectors = {
            'employees-table.ID': 'th:contains("ID"), td:first-child',
            'employees-table.Name': 'th:contains("Name"), td:nth-child(2)',
            'employees-table.Email': 'th:contains("Email"), td:contains("@")',
            'employees-table.Phone': 'th:contains("Phone"), td:contains(/^\d/)',
            'employees-table.Department': 'th:contains("Department"), td:contains(department => department && !department.includes("@"))',
            'employees-table.Controls': 'th:contains("Controls"), td:last-child',
            'edit-link': 'a[href*="edit"], .btn-info:contains("Edit")',
            'delete-link': 'a[href*="delete"], .btn-danger:contains("Delete")'
        };
        
        Object.entries(columnSelectors).forEach(([elementId, selector]) => {
            if (this.hiddenElements.includes(elementId)) {
                this.hideElementsBySelector(selector);
            }
        });
    }

    hideElementsBySelector(selector) {
        try {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.display = 'none';
                element.setAttribute('data-ai-hidden', 'true');
            });
            console.log(`🤖 Hidden ${elements.length} elements with selector: ${selector}`);
        } catch (error) {
            console.log(`🤖 Error hiding elements: ${error.message}`);
        }
    }

    addAIControlPanel() {
        // Add AI control button to page
        const aiButton = document.createElement('div');
        aiButton.innerHTML = `
            <div id="ai-customizer-panel" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 15px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                z-index: 9999;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                min-width: 300px;
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
                        <div style="font-weight: bold; font-size: 14px;">AI Page Customizer</div>
                        <div style="font-size: 11px; opacity: 0.9;">${this.currentMenu} • ${this.hiddenElements.length} hidden</div>
                    </div>
                </div>
                <div id="ai-panel-content" style="display: none;">
                    <div style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 10px; margin-top: 10px;">
                        <div style="font-size: 12px; margin-bottom: 8px;">🎯 Current Page: ${this.currentMenu}</div>
                        <div style="font-size: 12px; margin-bottom: 8px;">👤 User Role: ${this.userRole || 'Guest'}</div>
                        <div style="font-size: 12px; margin-bottom: 12px;">🔒 Hidden Elements: ${this.hiddenElements.length}</div>
                        <button onclick="aiCustomizer.showHiddenElements()" style="
                            background: white;
                            color: #667eea;
                            border: none;
                            padding: 8px 12px;
                            border-radius: 6px;
                            font-size: 11px;
                            cursor: pointer;
                            margin-right: 5px;
                        ">Show Hidden</button>
                        <button onclick="aiCustomizer.openSettings()" style="
                            background: rgba(255,255,255,0.2);
                            color: white;
                            border: 1px solid rgba(255,255,255,0.3);
                            padding: 8px 12px;
                            border-radius: 6px;
                            font-size: 11px;
                            cursor: pointer;
                        ">Settings</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(aiButton);
        
        // Add click handler
        document.getElementById('ai-customizer-panel').addEventListener('click', () => {
            const content = document.getElementById('ai-panel-content');
            content.style.display = content.style.display === 'none' ? 'block' : 'none';
        });
    }

    showHiddenElements() {
        // Temporarily show hidden elements
        const hiddenElements = document.querySelectorAll('[data-ai-hidden="true"]');
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

    openSettings() {
        // Open customization settings
        window.open(`/page-customization?menu=${encodeURIComponent(this.currentMenu)}&role=${this.userRole}`, '_blank');
    }
}

// Initialize AI Customizer when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.aiCustomizer = new AIPageCustomizer();
});

// Also initialize immediately if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.aiCustomizer = new AIPageCustomizer();
    });
} else {
    window.aiCustomizer = new AIPageCustomizer();
}
