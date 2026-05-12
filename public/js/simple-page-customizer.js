/**
 * Simple Page Customizer - Direct Implementation
 * Reads page customization settings and applies them directly
 * No complex logic - just applies what you set!
 */

class SimplePageCustomizer {
    constructor() {
        this.userRole = null;
        this.userId = null;
        this.currentMenu = '';
        this.customizations = [];
        
        console.log('🔧 Simple Customizer: Constructor called');
        this.init();
    }

    async init() {
        console.log('🔧 Simple Customizer: Starting initialization');
        
        // Get current user info
        await this.loadUserInfo();
        
        // Detect current menu
        this.currentMenu = this.detectCurrentMenu();
        console.log('🔧 Simple Customizer: Detected menu:', this.currentMenu);
        
        // Load customizations for this user and menu
        await this.loadCustomizations();
        
        // Apply customizations immediately
        this.applyCustomizations();
        
        // Add simple status indicator
        this.addStatusIndicator();
    }

    async loadUserInfo() {
        try {
            console.log('🔧 Simple Customizer: Loading user info...');
            const response = await fetch('/api/current-user');
            const data = await response.json();
            
            this.userRole = data.role;
            this.userId = data.id;
            
            console.log('🔧 Simple Customizer - User:', {
                role: this.userRole,
                id: this.userId
            });
        } catch (error) {
            console.log('🔧 Simple Customizer: API failed, using page detection');
            // Try to detect from page
            const pageText = document.body.textContent || '';
            if (pageText.includes('EMPLOYEE')) {
                this.userRole = 2; // Employee
            } else if (pageText.includes('ADMIN')) {
                this.userRole = 1; // Admin
            }
        }
    }

    detectCurrentMenu() {
        const path = window.location.pathname;
        console.log('🔧 Simple Customizer: Current path:', path);
        
        if (path.includes('/employees') || path.includes('/Employee')) {
            return 'Employees';
        }
        if (path.includes('/leads')) {
            return 'Leads';
        }
        if (path.includes('/customers')) {
            return 'Customers';
        }
        
        return 'Unknown';
    }

    async loadCustomizations() {
        try {
            console.log('🔧 Simple Customizer: Loading customizations...');
            const url = `/api/page-customizations?menu=${encodeURIComponent(this.currentMenu)}&role=${this.userRole}`;
            console.log('🔧 Simple Customizer: Fetching from:', url);
            
            const response = await fetch(url);
            const data = await response.json();
            
            this.customizations = data.hiddenElements || [];
            
            console.log('🔧 Simple Customizer - Loaded:', {
                menu: this.currentMenu,
                role: this.userRole,
                customizations: this.customizations,
                response: data
            });
        } catch (error) {
            console.log('🔧 Simple Customizer: Could not load customizations', error);
        }
    }

    applyCustomizations() {
        console.log('🔧 Simple Customizer - Applying:', this.customizations.length, 'items');
        console.log('🔧 Simple Customizer - Items to hide:', this.customizations);
        
        this.customizations.forEach(elementId => {
            this.hideElement(elementId);
        });
    }

    hideElement(elementId) {
        console.log('🔧 Simple Customizer: Hiding element:', elementId);
        
        const selectors = {
            'employees-table': 'table, .box, .table-responsive',
            'add-employee-btn': 'a[href*="Employee/add"], .btn-info:contains("Add"), .glyphicon-plus',
            'employees-table.ID': 'th:contains("ID"), td:first-child',
            'employees-table.Name': 'th:contains("Name"), td:nth-child(2)',
            'employees-table.Emp_ID': 'th:contains("Emp_ID"), td:nth-child(3)',
            'employees-table.Designation': 'th:contains("Designation"), td:nth-child(4)',
            'employees-table.Profile_Pics': 'th:contains("Profile"), td:nth-child(5)',
            'employees-table.Contact_Number': 'th:contains("Contact"), td:nth-child(6)',
            'employees-table.Email': 'th:contains("Email"), td:nth-child(7)',
            'employees-table.Department': 'th:contains("Department"), td:nth-child(8)',
            'employees-table.Online_Offline': 'th:contains("Online"), td:nth-child(9)',
            'employees-table.Controls': 'th:contains("Controls"), td:last-child',
            'edit-link': 'a[href*="edit"], .btn-info:contains("Edit")',
            'delete-link': 'a[href*="delete"], .btn-danger:contains("Delete")'
        };
        
        const selector = selectors[elementId];
        if (selector) {
            const elements = document.querySelectorAll(selector);
            console.log(`🔧 Found ${elements.length} elements for: ${elementId} with selector: ${selector}`);
            
            elements.forEach(element => {
                element.style.display = 'none';
                element.setAttribute('data-customizer-hidden', elementId);
            });
            
            console.log(`🔧 Hidden ${elements.length} elements for: ${elementId}`);
        } else {
            console.log(`🔧 No selector found for: ${elementId}`);
        }
    }

    addStatusIndicator() {
        const indicator = document.createElement('div');
        indicator.innerHTML = `
            <div style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: #2196F3;
                color: white;
                padding: 10px 15px;
                border-radius: 8px;
                font-family: Arial, sans-serif;
                font-size: 12px;
                z-index: 9999;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                cursor: pointer;
            ">
                <div style="display: flex; align-items: center;">
                    <span style="margin-right: 8px;">🔧</span>
                    <div>
                        <div style="font-weight: bold;">Page Customizer</div>
                        <div style="font-size: 10px; opacity: 0.9;">
                            ${this.currentMenu} • ${this.customizations.length} hidden
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(indicator);
        
        // Click to show details
        indicator.addEventListener('click', () => {
            alert(`Page: ${this.currentMenu}\nRole: ${this.userRole}\nHidden Elements: ${this.customizations.length}\n\nHidden: ${this.customizations.join(', ')}`);
        });
    }
}

// Initialize Simple Page Customizer
console.log('🔧 Simple Customizer: Script loaded');

document.addEventListener('DOMContentLoaded', () => {
    console.log('🔧 Simple Customizer: DOM loaded, initializing...');
    window.simpleCustomizer = new SimplePageCustomizer();
});

// Also initialize immediately if DOM is ready
if (document.readyState === 'loading') {
    console.log('🔧 Simple Customizer: DOM still loading, waiting...');
    document.addEventListener('DOMContentLoaded', () => {
        console.log('🔧 Simple Customizer: DOM loaded event fired');
        window.simpleCustomizer = new SimplePageCustomizer();
    });
} else {
    console.log('🔧 Simple Customizer: DOM already loaded, initializing immediately');
    window.simpleCustomizer = new SimplePageCustomizer();
}
