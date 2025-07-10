/**
 * Custom Dialog System - Perpustakaan Digital
 * Menggantikan dialog browser default dengan dialog custom yang konsisten
 */

class CustomDialog {
    constructor() {
        this.overlay = null;
        this.currentDialog = null;
        this.init();
    }

    init() {
        // Override window.confirm
        window.confirm = (message) => {
            return this.showConfirm('Konfirmasi', message);
        };

        // Create overlay element
        this.createOverlay();
        
        // Handle ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.overlay && this.overlay.classList.contains('show')) {
                this.hide();
            }
        });
    }

    createOverlay() {
        this.overlay = document.createElement('div');
        this.overlay.className = 'custom-confirm-overlay';
        this.overlay.addEventListener('click', (e) => {
            if (e.target === this.overlay) {
                this.hide();
            }
        });
        document.body.appendChild(this.overlay);
    }

    showConfirm(title, message, options = {}) {
        return new Promise((resolve) => {
            const config = {
                title: title || 'Konfirmasi',
                message: message || 'Apakah Anda yakin?',
                confirmText: options.confirmText || 'OK',
                cancelText: options.cancelText || 'Batal',
                confirmClass: options.confirmClass || 'custom-confirm-btn-primary',
                cancelClass: options.cancelClass || 'custom-confirm-btn-secondary',
                icon: options.icon || '?',
                ...options
            };

            this.createDialog(config, resolve);
            this.show();
        });
    }

    showAlert(title, message, options = {}) {
        return new Promise((resolve) => {
            const config = {
                title: title || 'Informasi',
                message: message || '',
                confirmText: options.confirmText || 'OK',
                confirmClass: options.confirmClass || 'custom-confirm-btn-primary',
                icon: options.icon || 'i',
                showCancel: false,
                ...options
            };

            this.createDialog(config, resolve);
            this.show();
        });
    }

    showSuccess(title, message, options = {}) {
        return this.showAlert(title, message, {
            confirmClass: 'custom-confirm-btn-success',
            icon: '✓',
            ...options
        });
    }

    showError(title, message, options = {}) {
        return this.showAlert(title, message, {
            confirmClass: 'custom-confirm-btn-danger',
            icon: '!',
            ...options
        });
    }

    showWarning(title, message, options = {}) {
        return this.showAlert(title, message, {
            confirmClass: 'custom-confirm-btn-warning',
            icon: '⚠',
            ...options
        });
    }

    createDialog(config, resolve) {
        const dialog = document.createElement('div');
        dialog.className = 'custom-confirm-dialog';
        
        dialog.innerHTML = `
            <div class="custom-confirm-header">
                <h5 class="custom-confirm-title">
                    <span class="custom-confirm-icon">${config.icon}</span>
                    ${config.title}
                </h5>
            </div>
            <div class="custom-confirm-body">
                <p class="custom-confirm-message">${config.message}</p>
            </div>
            <div class="custom-confirm-footer">
                ${config.showCancel !== false ? `
                    <button type="button" class="custom-confirm-btn ${config.cancelClass}" data-action="cancel">
                        ${config.cancelText}
                    </button>
                ` : ''}
                <button type="button" class="custom-confirm-btn ${config.confirmClass}" data-action="confirm">
                    ${config.confirmText}
                </button>
            </div>
        `;

        // Add event listeners
        const buttons = dialog.querySelectorAll('.custom-confirm-btn');
        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                const action = e.target.getAttribute('data-action');
                this.hide();
                resolve(action === 'confirm');
            });
        });

        // Clear previous dialog
        if (this.currentDialog) {
            this.overlay.removeChild(this.currentDialog);
        }

        this.currentDialog = dialog;
        this.overlay.appendChild(dialog);
    }

    show() {
        if (this.overlay) {
            this.overlay.classList.add('show');
            // Focus on confirm button
            setTimeout(() => {
                const confirmBtn = this.overlay.querySelector('[data-action="confirm"]');
                if (confirmBtn) {
                    confirmBtn.focus();
                }
            }, 100);
        }
    }

    hide() {
        if (this.overlay) {
            this.overlay.classList.remove('show');
        }
    }
}

// Enhanced confirm functions with specific styling
window.confirmDelete = function(title, message) {
    return customDialog.showConfirm(
        title || 'Konfirmasi Hapus',
        message || 'Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.',
        {
            confirmText: 'Ya, Hapus',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-danger',
            icon: '🗑️'
        }
    );
};

window.confirmReturn = function(message) {
    return customDialog.showConfirm(
        'Konfirmasi Pengembalian',
        message || 'Apakah Anda yakin ingin mengembalikan buku ini?',
        {
            confirmText: 'Ya, Kembalikan',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-success',
            icon: '↩️'
        }
    );
};

window.confirmExtend = function(message) {
    return customDialog.showConfirm(
        'Konfirmasi Perpanjangan',
        message || 'Apakah Anda yakin ingin memperpanjang peminjaman ini?',
        {
            confirmText: 'Ya, Perpanjang',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-warning',
            icon: '📅'
        }
    );
};

window.confirmBorrow = function(message) {
    return customDialog.showConfirm(
        'Konfirmasi Peminjaman',
        message || 'Apakah Anda yakin ingin meminjam buku ini?',
        {
            confirmText: 'Ya, Pinjam',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-primary',
            icon: '📚'
        }
    );
};

window.confirmActivate = function(message) {
    return customDialog.showConfirm(
        'Konfirmasi Aktivasi',
        message || 'Apakah Anda yakin ingin mengaktifkan user ini?',
        {
            confirmText: 'Ya, Aktifkan',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-success',
            icon: '✅'
        }
    );
};

window.confirmDeactivate = function(message) {
    return customDialog.showConfirm(
        'Konfirmasi Nonaktifkan',
        message || 'Apakah Anda yakin ingin menonaktifkan user ini?',
        {
            confirmText: 'Ya, Nonaktifkan',
            cancelText: 'Batal',
            confirmClass: 'custom-confirm-btn-warning',
            icon: '⚠️'
        }
    );
};

// Success/Error/Warning alerts
window.showSuccessAlert = function(title, message) {
    return customDialog.showSuccess(title, message);
};

window.showErrorAlert = function(title, message) {
    return customDialog.showError(title, message);
};

window.showWarningAlert = function(title, message) {
    return customDialog.showWarning(title, message);
};

window.showInfoAlert = function(title, message) {
    return customDialog.showAlert(title, message);
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    window.customDialog = new CustomDialog();
    
    // Replace existing onclick confirm calls (exclude custom confirm functions to avoid conflicts)
    document.querySelectorAll('[onclick*="confirm("]').forEach(element => {
        const onclick = element.getAttribute('onclick');
        if (onclick && onclick.includes('confirm(') &&
            !onclick.includes('confirmBorrow') &&
            !onclick.includes('confirmReturn') &&
            !onclick.includes('confirmExtend')) {
            element.addEventListener('click', function(e) {
                e.preventDefault();

                // Extract confirm message
                const match = onclick.match(/confirm\(['"]([^'"]*)['"]\)/);
                const message = match ? match[1] : 'Apakah Anda yakin?';

                // Determine action type based on element classes or text
                let confirmFunction = window.confirm;

                if (element.classList.contains('btn-danger') || onclick.includes('delete') || onclick.includes('hapus')) {
                    confirmFunction = window.confirmDelete;
                } else if (onclick.includes('return') || onclick.includes('kembalikan')) {
                    confirmFunction = window.confirmReturn;
                } else if (onclick.includes('extend') || onclick.includes('perpanjang')) {
                    confirmFunction = window.confirmExtend;
                } else if (onclick.includes('activate') || onclick.includes('aktifkan')) {
                    confirmFunction = window.confirmActivate;
                } else if (onclick.includes('deactivate') || onclick.includes('nonaktifkan')) {
                    confirmFunction = window.confirmDeactivate;
                }

                confirmFunction('', message).then(result => {
                    if (result) {
                        // Execute the original action
                        const href = element.getAttribute('href');
                        if (href && href !== '#') {
                            window.location.href = href;
                        } else {
                            // Try to submit parent form
                            const form = element.closest('form');
                            if (form) {
                                form.submit();
                            }
                        }
                    }
                });
            });

            // Remove the original onclick
            element.removeAttribute('onclick');
        }
    });
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = CustomDialog;
}
