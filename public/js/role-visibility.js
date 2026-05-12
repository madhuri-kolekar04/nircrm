/**
 * Role-Based Element Visibility System
 * Automatically applies role-based visibility settings to page elements
 */

class RoleVisibilityManager {
    constructor() {
        this.pageUrl = window.location.pathname + window.location.search;
        this.currentRoleId = this.getCurrentUserRole();
        this.visibilitySettings = {};
        this.init();
    }

    init() {
        if (!this.currentRoleId) {
            console.log('No user role found, skipping visibility management');
            return;
        }

        console.log(`Initializing role visibility for role ${this.currentRoleId} on ${this.pageUrl}`);
        this.loadVisibilitySettings();
    }

    getCurrentUserRole() {
        // Try to get user role from various sources
        const roleElements = [
            document.querySelector('meta[name="user-role"]'),
            document.querySelector('[data-user-role]'),
            document.querySelector('.user-role')
        ];

        for (let element of roleElements) {
            if (element) {
                const role = element.getAttribute('content') || element.getAttribute('data-user-role') || element.textContent;
                if (role) {
                    return parseInt(role);
                }
            }
        }

        // Fallback: try to get from global variable if set by Laravel
        if (window.currentUserRole) {
            return parseInt(window.currentUserRole);
        }

        return null;
    }

    async loadVisibilitySettings() {
        try {
            const response = await fetch(`/role-element-visibility/get?page_url=${encodeURIComponent(this.pageUrl)}&role_id=${this.currentRoleId}`);
            const data = await response.json();
            
            if (data.success) {
                this.visibilitySettings = data.data;
                this.applyVisibilitySettings();
                console.log('Visibility settings loaded and applied:', this.visibilitySettings);
            }
        } catch (error) {
            console.error('Error loading visibility settings:', error);
        }
    }

    applyVisibilitySettings() {
        console.log('Applying visibility settings:', this.visibilitySettings);
        
        // Apply visibility to tables
        this.applyToElements('table', this.visibilitySettings);
        
        // Apply visibility to forms
        this.applyToElements('form', this.visibilitySettings);
        
        // Apply visibility to buttons
        this.applyToElements('button', this.visibilitySettings);
        
        // Apply visibility to input fields
        this.applyToElements('input', this.visibilitySettings);
        
        // Apply visibility to select elements
        this.applyToElements('select', this.visibilitySettings);
        
        // Apply visibility to textareas
        this.applyToElements('textarea', this.visibilitySettings);
        
        // Special handling for test elements
        this.applyTestElementVisibility();
    }

    applyToElements(tagName, settings) {
        const elements = document.querySelectorAll(tagName);
        
        elements.forEach(element => {
            const elementId = this.getElementIdentifier(element);
            const setting = settings[elementId];
            
            if (setting && !setting.is_visible) {
                this.hideElement(element, setting);
            } else if (setting && setting.is_visible) {
                this.showElement(element, setting);
            }
        });
    }

    applyTestElementVisibility() {
        console.log('Applying visibility settings for role:', this.currentRoleId);
        console.log('Visibility settings:', this.visibilitySettings);
        
        // Apply visibility to all actual elements on the page
        Object.keys(this.visibilitySettings).forEach(elementId => {
            const setting = this.visibilitySettings[elementId];
            if (!setting.is_visible) {
                console.log(`Hiding element: ${elementId}`);
                this.hideElementById(elementId);
                this.hideElementsByText(elementId, setting.element_name);
            }
        });
        
        // Special handling for common element types
        this.applyCommonElementVisibility();
    }

    applyCommonElementVisibility() {
        // Hide tables based on visibility settings
        const tables = document.querySelectorAll('table');
        tables.forEach(table => {
            const tableId = this.getElementIdentifier(table);
            const setting = this.visibilitySettings[tableId];
            if (setting && !setting.is_visible) {
                console.log(`Hiding table: ${tableId}`);
                this.hideElement(table, setting);
            }
        });

        // Hide forms based on visibility settings
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const formId = this.getElementIdentifier(form);
            const setting = this.visibilitySettings[formId];
            if (setting && !setting.is_visible) {
                console.log(`Hiding form: ${formId}`);
                this.hideElement(form, setting);
            }
        });

        // Hide buttons based on visibility settings
        const buttons = document.querySelectorAll('button, input[type="button"], input[type="submit"], .btn');
        buttons.forEach(button => {
            const buttonId = this.getElementIdentifier(button);
            const setting = this.visibilitySettings[buttonId];
            if (setting && !setting.is_visible) {
                console.log(`Hiding button: ${buttonId}`);
                this.hideElement(button, setting);
            }
        });

        // Hide inputs based on visibility settings
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            const inputId = this.getElementIdentifier(input);
            const setting = this.visibilitySettings[inputId];
            if (setting && !setting.is_visible) {
                console.log(`Hiding input: ${inputId}`);
                this.hideElement(input, setting);
            }
        });
    }

    hideElementsByText(elementId, elementName) {
        // Try to hide elements by text content if ID doesn't work
        if (!elementName) return;
        
        // Look for elements containing the element name
        const allElements = document.querySelectorAll('*');
        allElements.forEach(element => {
            if (element.textContent && element.textContent.includes(elementName)) {
                // Only hide if it's a table, form, button, or input
                const tagName = element.tagName.toLowerCase();
                if (['table', 'form', 'button', 'input', 'select', 'textarea'].includes(tagName)) {
                    console.log(`Hiding element by text: ${elementName}`);
                    this.hideElement(element, { is_visible: false });
                }
            }
        });
    }

    hideElementById(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            this.hideElement(element, { is_visible: false });
        } else {
            console.log(`Element with ID "${elementId}" not found in DOM`);
        }
    }

    hideElementsBySelector(selector) {
        try {
            // Handle special :contains() selectors
            if (selector.includes(':contains(')) {
                const match = selector.match(/:contains\("([^"]+)"\)/);
                if (match) {
                    const text = match[1];
                    const baseSelector = selector.split(':contains(')[0];
                    const elements = document.querySelectorAll(baseSelector);
                    elements.forEach(element => {
                        if (element.textContent && element.textContent.includes(text)) {
                            this.hideElement(element, { is_visible: false });
                        }
                    });
                    return;
                }
            }
            
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                this.hideElement(element, { is_visible: false });
            });
        } catch (error) {
            console.log(`Invalid selector: ${selector}`, error);
        }
    }

    getElementIdentifier(element) {
        // Try multiple ways to identify the element
        // This needs to match how elements are identified in the AI assistant
        
        let identifier = null;
        
        // First try ID (most reliable)
        if (element.id) {
            identifier = element.id;
        }
        // Then try name attribute
        else if (element.name) {
            identifier = element.name;
        }
        // Then try data-element-id
        else if (element.getAttribute('data-element-id')) {
            identifier = element.getAttribute('data-element-id');
        }
        // Then try aria-label
        else if (element.getAttribute('aria-label')) {
            identifier = element.getAttribute('aria-label');
        }
        // Then try class name (first class)
        else if (element.className) {
            const classes = element.className.split(' ');
            identifier = classes[0]; // Use first class
        }
        // Finally try text content (for buttons, etc.)
        else if (element.textContent) {
            const text = element.textContent.trim();
            if (text.length > 0 && text.length < 50) {
                identifier = text;
            }
        }
        
        // Fallback to unknown
        if (!identifier) {
            identifier = 'unknown-element';
        }
        
        console.log(`Element identifier for ${element.tagName}: ${identifier}`);
        return identifier;
    }

    hideElement(element, setting) {
        // Store original state for potential restoration
        if (!element.hasAttribute('data-original-display')) {
            element.setAttribute('data-original-display', element.style.display || '');
        }
        
        element.style.display = 'none';
        element.setAttribute('data-visibility-hidden', 'true');
        element.setAttribute('data-visibility-role', setting.role_id);
        
        // Add a visual indicator for debugging (optional)
        if (window.debugVisibility) {
            this.addDebugIndicator(element, 'HIDDEN', '#dc3545');
        }
    }

    showElement(element, setting) {
        // Restore original display if it was hidden
        if (element.hasAttribute('data-original-display')) {
            element.style.display = element.getAttribute('data-original-display');
            element.removeAttribute('data-original-display');
        } else {
            element.style.display = '';
        }
        
        element.removeAttribute('data-visibility-hidden');
        element.removeAttribute('data-visibility-role');
        
        // Remove debug indicator if present
        const debugIndicator = element.querySelector('.visibility-debug-indicator');
        if (debugIndicator) {
            debugIndicator.remove();
        }
    }

    addDebugIndicator(element, text, color) {
        const indicator = document.createElement('div');
        indicator.className = 'visibility-debug-indicator';
        indicator.style.cssText = `
            position: absolute;
            top: -5px;
            right: -5px;
            background: ${color};
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            z-index: 9999;
            pointer-events: none;
        `;
        indicator.textContent = text;
        
        // Make parent relative if not already
        if (getComputedStyle(element).position === 'static') {
            element.style.position = 'relative';
        }
        
        element.appendChild(indicator);
    }

    // Public method to manually refresh visibility
    refresh() {
        console.log('Manually refreshing visibility settings...');
        this.loadVisibilitySettings();
    }

    // Public method to force apply visibility (for testing)
    forceApplyVisibility() {
        console.log('Force applying visibility settings...');
        console.log('Current role:', this.currentRoleId);
        console.log('Current page:', this.pageUrl);
        console.log('Visibility settings:', this.visibilitySettings);
        
        this.applyVisibilitySettings();
    }

    // Public method to show all elements (for admin override)
    showAll() {
        const hiddenElements = document.querySelectorAll('[data-visibility-hidden="true"]');
        hiddenElements.forEach(element => {
            this.showElement(element, { is_visible: true });
        });
    }

    // Public method to get current visibility settings
    getVisibilitySettings() {
        return this.visibilitySettings;
    }

    // Debug method to show current status
    debugStatus() {
        console.log('=== Role Visibility Debug Info ===');
        console.log('Current Role ID:', this.currentRoleId);
        console.log('Page URL:', this.pageUrl);
        console.log('Visibility Settings:', this.visibilitySettings);
        console.log('Hidden Elements:', document.querySelectorAll('[data-visibility-hidden="true"]').length);
        console.log('Tables on page:', document.querySelectorAll('table').length);
        console.log('Forms on page:', document.querySelectorAll('form').length);
        console.log('Buttons on page:', document.querySelectorAll('button, input[type="button"], input[type="submit"], .btn').length);
        console.log('Inputs on page:', document.querySelectorAll('input, select, textarea').length);
        console.log('=====================================');
    }
}

// Initialize the visibility manager when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Make it globally accessible
    window.roleVisibilityManager = new RoleVisibilityManager();
    
    // Add keyboard shortcuts for debugging
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.key === 'V') {
            e.preventDefault();
            window.debugVisibility = !window.debugVisibility;
            console.log('Debug visibility mode:', window.debugVisibility ? 'ON' : 'OFF');
            window.roleVisibilityManager.refresh();
        }
        
        if (e.ctrlKey && e.shiftKey && e.key === 'D') {
            e.preventDefault();
            window.roleVisibilityManager.debugStatus();
        }
        
        if (e.ctrlKey && e.shiftKey && e.key === 'R') {
            e.preventDefault();
            window.roleVisibilityManager.refresh();
        }
        
        if (e.ctrlKey && e.shiftKey && e.key === 'S') {
            e.preventDefault();
            window.roleVisibilityManager.showAll();
        }
    });
    
    // Auto-refresh after a short delay to ensure all elements are loaded
    setTimeout(() => {
        if (window.roleVisibilityManager) {
            console.log('Auto-refreshing visibility settings...');
            window.roleVisibilityManager.refresh();
        }
    }, 1000);
});

// Also initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        window.roleVisibilityManager = new RoleVisibilityManager();
    });
} else {
    window.roleVisibilityManager = new RoleVisibilityManager();
}
