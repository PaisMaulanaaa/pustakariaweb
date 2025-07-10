/**
 * Modern Loading States System
 * Consistent with dark blue theme
 */

class LoadingManager {
    constructor() {
        this.overlay = null;
        this.activeLoaders = new Set();
        this.init();
    }

    init() {
        // Create global loading overlay
        this.createOverlay();
    }

    createOverlay() {
        if (document.getElementById('global-loading-overlay')) return;

        this.overlay = document.createElement('div');
        this.overlay.id = 'global-loading-overlay';
        this.overlay.className = 'loading-overlay';
        this.overlay.innerHTML = `
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="loading-text">Memuat...</div>
            </div>
        `;
        document.body.appendChild(this.overlay);
    }

    // Global loading overlay
    show(text = 'Memuat...') {
        if (this.overlay) {
            const textElement = this.overlay.querySelector('.loading-text');
            if (textElement) {
                textElement.textContent = text;
            }
            this.overlay.classList.add('loading-show');
            document.body.style.overflow = 'hidden';
        }
    }

    hide() {
        if (this.overlay) {
            this.overlay.classList.remove('loading-show');
            document.body.style.overflow = '';
        }
    }

    // Button loading state
    buttonLoading(button, text = 'Memuat...') {
        if (!button) return;

        // Store original content
        if (!button.dataset.originalContent) {
            button.dataset.originalContent = button.innerHTML;
        }

        button.disabled = true;
        button.classList.add('btn-loading');
        button.innerHTML = `
            <span class="btn-spinner"></span>
            <span class="btn-loading-text">${text}</span>
        `;

        this.activeLoaders.add(button);
    }

    buttonLoaded(button) {
        if (!button) return;

        button.disabled = false;
        button.classList.remove('btn-loading');
        
        if (button.dataset.originalContent) {
            button.innerHTML = button.dataset.originalContent;
            delete button.dataset.originalContent;
        }

        this.activeLoaders.delete(button);
    }

    // Form loading state
    formLoading(form, text = 'Menyimpan...') {
        if (!form) return;

        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            this.buttonLoading(submitBtn, text);
        }

        // Disable all form inputs
        const inputs = form.querySelectorAll('input, select, textarea, button');
        inputs.forEach(input => {
            if (input !== submitBtn) {
                input.disabled = true;
                input.classList.add('form-loading');
            }
        });

        form.classList.add('form-loading');
    }

    formLoaded(form) {
        if (!form) return;

        const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
        if (submitBtn) {
            this.buttonLoaded(submitBtn);
        }

        // Re-enable all form inputs
        const inputs = form.querySelectorAll('input, select, textarea, button');
        inputs.forEach(input => {
            input.disabled = false;
            input.classList.remove('form-loading');
        });

        form.classList.remove('form-loading');
    }

    // Element loading state
    elementLoading(element, text = 'Memuat...') {
        if (!element) return;

        if (!element.dataset.originalContent) {
            element.dataset.originalContent = element.innerHTML;
        }

        element.classList.add('element-loading');
        element.innerHTML = `
            <div class="element-loading-content">
                <div class="element-spinner"></div>
                <span class="element-loading-text">${text}</span>
            </div>
        `;

        this.activeLoaders.add(element);
    }

    elementLoaded(element) {
        if (!element) return;

        element.classList.remove('element-loading');
        
        if (element.dataset.originalContent) {
            element.innerHTML = element.dataset.originalContent;
            delete element.dataset.originalContent;
        }

        this.activeLoaders.delete(element);
    }

    // Skeleton loading for cards/lists
    showSkeleton(container, count = 3) {
        if (!container) return;

        container.innerHTML = '';
        container.classList.add('skeleton-container');

        for (let i = 0; i < count; i++) {
            const skeleton = document.createElement('div');
            skeleton.className = 'skeleton-item';
            skeleton.innerHTML = `
                <div class="skeleton-line skeleton-title"></div>
                <div class="skeleton-line skeleton-text"></div>
                <div class="skeleton-line skeleton-text short"></div>
            `;
            container.appendChild(skeleton);
        }
    }

    hideSkeleton(container) {
        if (!container) return;
        container.classList.remove('skeleton-container');
    }

    // Clean up all loading states
    cleanup() {
        this.hide();
        this.activeLoaders.forEach(element => {
            if (element.tagName === 'BUTTON') {
                this.buttonLoaded(element);
            } else if (element.tagName === 'FORM') {
                this.formLoaded(element);
            } else {
                this.elementLoaded(element);
            }
        });
        this.activeLoaders.clear();
    }
}

// Initialize global loading manager
window.loadingManager = new LoadingManager();

// Global helper functions
window.showLoading = (text) => window.loadingManager.show(text);
window.hideLoading = () => window.loadingManager.hide();
window.buttonLoading = (button, text) => window.loadingManager.buttonLoading(button, text);
window.buttonLoaded = (button) => window.loadingManager.buttonLoaded(button);
window.formLoading = (form, text) => window.loadingManager.formLoading(form, text);
window.formLoaded = (form) => window.loadingManager.formLoaded(form);
window.elementLoading = (element, text) => window.loadingManager.elementLoading(element, text);
window.elementLoaded = (element) => window.loadingManager.elementLoaded(element);
window.showSkeleton = (container, count) => window.loadingManager.showSkeleton(container, count);
window.hideSkeleton = (container) => window.loadingManager.hideSkeleton(container);
