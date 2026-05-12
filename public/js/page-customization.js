/**
 * Page Customization Frontend Script
 * Handles dynamic show/hide of page elements based on user, role, and menu customizations
 */

$(document).ready(function() {
    // Apply customizations when page loads
    applyCustomizations();
    
    // Re-apply customizations when DOM changes
    const observer = new MutationObserver(function(mutations) {
        setTimeout(applyCustomizations, 500);
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

/**
 * Apply customizations to current page
 */
function applyCustomizations() {
    const currentPath = window.location.pathname;
    
    $.get('/page-customization/apply-customizations', {
        current_path: currentPath
    }, function(response) {
        if (response.hiddenElements && response.hiddenElements.length > 0) {
            // Hide elements based on customizations
            response.hiddenElements.forEach(function(elementId) {
                hideElement(elementId);
            });
        }
    }).fail(function() {
        console.error('Error applying customizations');
    });
}

/**
 * Hide a specific element
 */
function hideElement(elementId) {
    // Try multiple selectors to find the element
    const selectors = [
        `#${elementId}`,
        `[data-element-id="${elementId}"]`,
        `[data-customization="${elementId}"]`,
        `[data-field="${elementId}"]`,
        `[data-column="${elementId}"]`,
        `[data-button="${elementId}"]`,
        `[data-section="${elementId}"]`,
        `.${elementId}`,
        `[class*="${elementId}"]`,
        `[id*="${elementId}"]`,
        `[class*="${elementId.replace('_', '-')}"]`
    ];
    
    let element = null;
    for (const selector of selectors) {
        element = $(selector).first();
        if (element.length > 0) {
            break;
        }
    }
    
    if (element) {
        // Hide the element using multiple methods for maximum compatibility
        element.hide();
        element.addClass('customization-hidden');
        element.attr('data-customization-hidden', 'true');
        element.css('display', 'none');
        element.prop('disabled', true);
        
        // Also hide parent containers if they contain only this element
        const parent = element.parent();
        if (parent.children().length === 1) {
            parent.hide();
            parent.addClass('customization-hidden');
        }
        
        console.log(`Hidden element: ${elementId}`);
    } else {
        console.warn(`Element not found: ${elementId}`);
    }
}

/**
 * Show a specific element (for preview mode)
 */
function showElement(elementId) {
    const selectors = [
        `#${elementId}`,
        `[data-element-id="${elementId}"]`,
        `[data-customization="${elementId}"]`,
        `[data-field="${elementId}"]`,
        `[data-column="${elementId}"]`,
        `[data-button="${elementId}"]`,
        `[data-section="${elementId}"]`,
        `.${elementId}`,
        `[class*="${elementId}"]`,
        `[id*="${elementId}"]`,
        `[class*="${elementId.replace('_', '-')}"]`
    ];
    
    let element = null;
    for (const selector of selectors) {
        element = $(selector).first();
        if (element.length > 0) {
            break;
        }
    }
    
    if (element) {
        element.show();
        element.removeClass('customization-hidden');
        element.removeAttr('data-customization-hidden');
        element.css('display', '');
        element.prop('disabled', false);
        
        // Also show parent containers
        const parent = element.parent();
        if (parent.children().length === 1) {
            parent.show();
            parent.removeClass('customization-hidden');
        }
        
        console.log(`Shown element: ${elementId}`);
    }
}

/**
 * Toggle preview mode
 */
function togglePreviewMode() {
    $('body').toggleClass('customization-preview-mode');
    
    if ($('body').hasClass('customization-preview-mode')) {
        // Show all hidden elements
        $('.customization-hidden').each(function() {
            const elementId = $(this).attr('data-element-id') || $(this).attr('id');
            if (elementId) {
                showElement(elementId);
            }
        });
        
        // Add preview indicator
        if (!$('#customization-preview-indicator').length) {
            $('body').append(`
                <div id="customization-preview-indicator" style="
                    position: fixed;
                    top: 10px;
                    right: 10px;
                    background: #28a745;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 4px;
                    z-index: 9999;
                    font-size: 12px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                ">
                    <i class="fas fa-eye"></i> Preview Mode ON
                </div>
            `);
        }
    } else {
        // Hide elements again
        applyCustomizations();
        $('#customization-preview-indicator').remove();
    }
}

/**
 * Add preview mode toggle to pages
 */
$(document).ready(function() {
    // Add preview mode toggle button to admin pages
    if (window.location.pathname.startsWith('/admin/') || 
        window.location.pathname.startsWith('/employees') || 
        window.location.pathname.startsWith('/customers') ||
        window.location.pathname.startsWith('/leads') ||
        window.location.pathname.startsWith('/categories')) {
        
        if (!$('#customization-preview-toggle').length) {
            $('body').append(`
                <button id="customization-preview-toggle" 
                        onclick="togglePreviewMode()" 
                        style="
                            position: fixed;
                            bottom: 20px;
                            right: 20px;
                            background: #007bff;
                            color: white;
                            border: none;
                            padding: 10px 15px;
                            border-radius: 4px;
                            cursor: pointer;
                            z-index: 9999;
                            font-size: 12px;
                            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                        ">
                    <i class="fas fa-eye"></i> Preview
                </button>
            `);
        }
    }
});
