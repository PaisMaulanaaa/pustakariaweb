/**
 * Modern Toast Notification System
 * Consistent with dark blue theme
 */

class ToastManager {
    constructor() {
        this.container = null;
        this.toasts = [];
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        if (!document.getElementById('toast-container')) {
            this.container = document.createElement('div');
            this.container.id = 'toast-container';
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        } else {
            this.container = document.getElementById('toast-container');
        }
    }

    show(message, type = 'info', duration = 4000) {
        const toast = this.createToast(message, type, duration);
        this.container.appendChild(toast);
        this.toasts.push(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.add('toast-show');
        }, 10);

        // Auto remove
        setTimeout(() => {
            this.remove(toast);
        }, duration);

        return toast;
    }

    createToast(message, type, duration) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        const icon = this.getIcon(type);
        const progressBar = duration > 0 ? `<div class="toast-progress"></div>` : '';
        
        toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-icon">${icon}</div>
                <div class="toast-message">${message}</div>
                <button class="toast-close" onclick="window.toastManager.remove(this.closest('.toast'))">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            ${progressBar}
        `;

        // Add progress animation
        if (duration > 0) {
            const progressElement = toast.querySelector('.toast-progress');
            if (progressElement) {
                progressElement.style.animationDuration = `${duration}ms`;
            }
        }

        return toast;
    }

    getIcon(type) {
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-exclamation-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };
        return icons[type] || icons.info;
    }

    remove(toast) {
        if (!toast || !toast.parentNode) return;

        toast.classList.add('toast-hide');
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
            
            // Remove from array
            const index = this.toasts.indexOf(toast);
            if (index > -1) {
                this.toasts.splice(index, 1);
            }
        }, 300);
    }

    // Convenience methods
    success(message, duration = 4000) {
        return this.show(message, 'success', duration);
    }

    error(message, duration = 6000) {
        return this.show(message, 'error', duration);
    }

    warning(message, duration = 5000) {
        return this.show(message, 'warning', duration);
    }

    info(message, duration = 4000) {
        return this.show(message, 'info', duration);
    }

    // Clear all toasts
    clear() {
        this.toasts.forEach(toast => this.remove(toast));
    }
}

// Initialize global toast manager
window.toastManager = new ToastManager();

// Global helper functions
window.showToast = (message, type, duration) => window.toastManager.show(message, type, duration);
window.showSuccess = (message, duration) => window.toastManager.success(message, duration);
window.showError = (message, duration) => window.toastManager.error(message, duration);
window.showWarning = (message, duration) => window.toastManager.warning(message, duration);
window.showInfo = (message, duration) => window.toastManager.info(message, duration);
