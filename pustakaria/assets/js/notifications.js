/**
 * NOTIFICATION SYSTEM - PERPUSTAKAAN
 * Comprehensive notification management system
 */

class NotificationManager {
    constructor() {
        this.toastContainer = null;
        this.init();
    }

    init() {
        // Create toast container if it doesn't exist
        this.createToastContainer();
        
        // Auto-dismiss alerts after 5 seconds
        this.autoHideAlerts();
        
        // Initialize SweetAlert2 defaults
        this.initSweetAlert();
    }

    createToastContainer() {
        if (!document.querySelector('.toast-container')) {
            this.toastContainer = document.createElement('div');
            this.toastContainer.className = 'toast-container';
            document.body.appendChild(this.toastContainer);
        } else {
            this.toastContainer = document.querySelector('.toast-container');
        }
    }

    /**
     * Show toast notification
     * @param {string} message - The message to display
     * @param {string} type - Type: success, danger, warning, info, primary
     * @param {object} options - Additional options
     */
    showToast(message, type = 'info', options = {}) {
        const defaults = {
            title: this.getDefaultTitle(type),
            duration: 5000,
            closable: true,
            icon: this.getDefaultIcon(type)
        };

        const config = { ...defaults, ...options };

        const toast = document.createElement('div');
        toast.className = `toast toast-${type} fade-in`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
            <div class="toast-header">
                <i class="toast-icon ${config.icon}"></i>
                <strong class="toast-title">${config.title}</strong>
                ${config.closable ? '<button type="button" class="toast-close" aria-label="Close">&times;</button>' : ''}
            </div>
            <div class="toast-body">${message}</div>
        `;

        // Add close functionality
        if (config.closable) {
            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => this.hideToast(toast));
        }

        // Add to container
        this.toastContainer.appendChild(toast);

        // Auto hide after duration
        if (config.duration > 0) {
            setTimeout(() => this.hideToast(toast), config.duration);
        }

        return toast;
    }

    hideToast(toast) {
        if (toast && toast.parentNode) {
            toast.classList.remove('fade-in');
            toast.classList.add('fade-out');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }

    /**
     * Show alert notification
     * @param {string} message - The message to display
     * @param {string} type - Type: success, danger, warning, info, primary
     * @param {object} options - Additional options
     */
    showAlert(message, type = 'info', options = {}) {
        const defaults = {
            title: null,
            dismissible: true,
            icon: this.getDefaultIcon(type),
            container: document.body,
            duration: 0 // 0 means no auto-hide
        };

        const config = { ...defaults, ...options };

        const alert = document.createElement('div');
        alert.className = `alert alert-${type} fade-in ${config.dismissible ? 'alert-dismissible' : ''}`;
        alert.setAttribute('role', 'alert');

        let content = '';
        if (config.icon || config.title) {
            content = `
                <div class="alert-with-icon">
                    ${config.icon ? `<i class="alert-icon ${config.icon}"></i>` : ''}
                    <div class="alert-content">
                        ${config.title ? `<div class="alert-title">${config.title}</div>` : ''}
                        <div class="alert-message">${message}</div>
                    </div>
                </div>
            `;
        } else {
            content = `<div class="alert-message">${message}</div>`;
        }

        if (config.dismissible) {
            content += '<button type="button" class="btn-close" aria-label="Close">&times;</button>';
        }

        alert.innerHTML = content;

        // Add close functionality
        if (config.dismissible) {
            const closeBtn = alert.querySelector('.btn-close');
            closeBtn.addEventListener('click', () => this.hideAlert(alert));
        }

        // Insert at the beginning of container
        config.container.insertBefore(alert, config.container.firstChild);

        // Auto hide after duration
        if (config.duration > 0) {
            setTimeout(() => this.hideAlert(alert), config.duration);
        }

        return alert;
    }

    hideAlert(alert) {
        if (alert && alert.parentNode) {
            alert.classList.remove('fade-in');
            alert.classList.add('fade-out');
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 300);
        }
    }

    /**
     * Show confirmation dialog using SweetAlert2
     * @param {string} title - Dialog title
     * @param {string} text - Dialog text
     * @param {object} options - Additional options
     */
    confirm(title, text, options = {}) {
        const defaults = {
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        };

        const config = { ...defaults, ...options };

        return Swal.fire({
            title: title,
            text: text,
            ...config
        });
    }

    /**
     * Show success dialog
     */
    success(title, text, options = {}) {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonText: 'OK',
            ...options
        });
    }

    /**
     * Show error dialog
     */
    error(title, text, options = {}) {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonText: 'OK',
            ...options
        });
    }

    /**
     * Show loading overlay
     */
    showLoading(message = 'Memproses...') {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay fade-in';
        overlay.id = 'loadingOverlay';
        overlay.innerHTML = `
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <p class="loading-text">${message}</p>
            </div>
        `;

        document.body.appendChild(overlay);
        return overlay;
    }

    /**
     * Hide loading overlay
     */
    hideLoading() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.classList.remove('fade-in');
            overlay.classList.add('fade-out');
            setTimeout(() => {
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 300);
        }
    }

    // Helper methods
    getDefaultTitle(type) {
        const titles = {
            success: 'Berhasil',
            danger: 'Error',
            warning: 'Peringatan',
            info: 'Informasi',
            primary: 'Notifikasi'
        };
        return titles[type] || 'Notifikasi';
    }

    getDefaultIcon(type) {
        const icons = {
            success: 'fas fa-check-circle',
            danger: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle',
            primary: 'fas fa-bell'
        };
        return icons[type] || 'fas fa-bell';
    }

    autoHideAlerts() {
        // Auto-hide existing alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
        alerts.forEach(alert => {
            setTimeout(() => this.hideAlert(alert), 5000);
        });
    }

    initSweetAlert() {
        // Set default SweetAlert2 configuration
        if (typeof Swal !== 'undefined') {
            Swal.mixin({
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false
            });
        }
    }
}

// Initialize notification manager
const notifications = new NotificationManager();

// Global functions for easy access
window.showToast = (message, type, options) => notifications.showToast(message, type, options);
window.showAlert = (message, type, options) => notifications.showAlert(message, type, options);
window.showConfirm = (title, text, options) => notifications.confirm(title, text, options);
window.showSuccess = (title, text, options) => notifications.success(title, text, options);
window.showError = (title, text, options) => notifications.error(title, text, options);
window.showLoading = (message) => notifications.showLoading(message);
window.hideLoading = () => notifications.hideLoading();

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Handle flash messages from server
    const flashMessages = document.querySelectorAll('[data-flash-message]');
    flashMessages.forEach(element => {
        const message = element.getAttribute('data-flash-message');
        const type = element.getAttribute('data-flash-type') || 'info';
        showToast(message, type);
        element.remove(); // Remove the element after showing toast
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = NotificationManager;
}
