/**
 * LIBRARY LOADING SCREEN MANAGER
 * Clean & Modern Animated Loading for Library Website
 */

class LibraryLoading {
    constructor(options = {}) {
        this.options = {
            minDisplayTime: 1200, // Minimum time to show loading (ms)
            fadeOutDuration: 600,  // Fade out animation duration (ms)
            autoHide: true,        // Auto hide when page loads
            showOnNavigation: false, // Show on page navigation
            ...options
        };
        
        this.startTime = Date.now();
        this.isVisible = false;
        this.loadingElement = null;
        
        this.init();
    }
    
    init() {
        this.createLoadingScreen();
        this.bindEvents();
        
        if (this.options.autoHide) {
            this.setupAutoHide();
        }
    }
    
    createLoadingScreen() {
        // Remove existing loading screen if any
        const existing = document.getElementById('libraryLoading');
        if (existing) {
            existing.remove();
        }
        
        // Create loading screen HTML
        const loadingHTML = `
            <div id="libraryLoading" class="library-loading">
                <div class="loading-animation">
                    <!-- Floating Books -->
                    <div class="floating-book"></div>
                    <div class="floating-book"></div>
                    <div class="floating-book"></div>
                    <div class="floating-book"></div>
                    
                    <!-- Main Book Animation -->
                    <div class="book-container">
                        <div class="book">
                            <div class="book-spine"></div>
                            <div class="book-page left"></div>
                            <div class="book-page right"></div>
                        </div>
                    </div>
                    
                    <!-- Bookshelf -->
                    <div class="bookshelf"></div>
                    
                    <!-- Sparkle Effects -->
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                </div>
                
                <div class="loading-text">
                    <div class="loading-title">Perpustakaan Digital</div>
                    <div class="loading-subtitle">Memuat koleksi buku...</div>
                    <div class="loading-dots">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
        `;
        
        // Insert loading screen
        document.body.insertAdjacentHTML('afterbegin', loadingHTML);
        this.loadingElement = document.getElementById('libraryLoading');
        this.isVisible = true;
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
    
    setupAutoHide() {
        // Hide when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.scheduleHide();
            });
        } else {
            this.scheduleHide();
        }
        
        // Ensure hiding when window loads
        window.addEventListener('load', () => {
            this.scheduleHide();
        });
    }
    
    scheduleHide() {
        const elapsedTime = Date.now() - this.startTime;
        const remainingTime = Math.max(0, this.options.minDisplayTime - elapsedTime);
        
        setTimeout(() => {
            this.hide();
        }, remainingTime);
    }
    
    show(customText = null) {
        if (!this.loadingElement) {
            this.createLoadingScreen();
        }
        
        if (customText) {
            const subtitle = this.loadingElement.querySelector('.loading-subtitle');
            if (subtitle) {
                subtitle.textContent = customText;
            }
        }
        
        this.loadingElement.classList.remove('fade-out');
        this.loadingElement.style.display = 'flex';
        this.isVisible = true;
        document.body.style.overflow = 'hidden';
        
        // Reset start time
        this.startTime = Date.now();
    }
    
    hide() {
        if (!this.isVisible || !this.loadingElement) {
            return;
        }
        
        this.loadingElement.classList.add('fade-out');
        this.isVisible = false;
        
        setTimeout(() => {
            if (this.loadingElement && this.loadingElement.parentNode) {
                this.loadingElement.remove();
                this.loadingElement = null;
            }
            document.body.style.overflow = '';
        }, this.options.fadeOutDuration);
    }
    
    updateText(title, subtitle) {
        if (!this.loadingElement) return;
        
        const titleElement = this.loadingElement.querySelector('.loading-title');
        const subtitleElement = this.loadingElement.querySelector('.loading-subtitle');
        
        if (titleElement && title) {
            titleElement.textContent = title;
        }
        
        if (subtitleElement && subtitle) {
            subtitleElement.textContent = subtitle;
        }
    }
    
    bindEvents() {
        // Handle navigation loading
        if (this.options.showOnNavigation) {
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a[href]');
                if (this.shouldShowOnNavigation(link)) {
                    this.show('Memuat halaman...');
                }
            });
        }
        
        // Handle form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.tagName === 'FORM' && !form.hasAttribute('data-no-loading')) {
                this.show('Memproses data...');
            }
        });
        
        // Handle page visibility
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible' && this.isVisible) {
                // Hide loading if page becomes visible and loading is still showing
                setTimeout(() => this.hide(), 500);
            }
        });
    }
    
    shouldShowOnNavigation(link) {
        if (!link || !link.href) return false;
        
        // Don't show for external links
        if (link.href.indexOf(window.location.origin) !== 0) return false;
        
        // Don't show for hash links
        if (link.href.includes('#')) return false;
        
        // Don't show for download links
        if (link.download) return false;
        
        // Don't show for modal triggers
        if (link.hasAttribute('data-bs-toggle')) return false;
        
        // Don't show for dropdown toggles
        if (link.classList.contains('dropdown-toggle')) return false;
        
        // Don't show for logout links
        if (link.href.includes('logout')) return false;
        
        return true;
    }
    
    destroy() {
        this.hide();
        
        // Remove event listeners if needed
        // (In this simple implementation, we rely on page reload to clean up)
    }
}

// Initialize loading screen (manual control only)
let libraryLoading;

// Initialize but don't auto-show
document.addEventListener('DOMContentLoaded', function() {
    libraryLoading = new LibraryLoading({
        minDisplayTime: 1200,
        autoHide: false,  // Manual control only
        showOnNavigation: false
    });
});

// Global functions for manual control
window.showLibraryLoading = function(text) {
    if (libraryLoading) {
        libraryLoading.show(text);
    }
};

window.hideLibraryLoading = function() {
    if (libraryLoading) {
        libraryLoading.hide();
    }
};

window.updateLibraryLoadingText = function(title, subtitle) {
    if (libraryLoading) {
        libraryLoading.updateText(title, subtitle);
    }
};

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LibraryLoading;
}

// Usage Examples:
/*
// Manual control
showLibraryLoading('Mengunduh file...');
setTimeout(() => hideLibraryLoading(), 3000);

// Update text
updateLibraryLoadingText('Perpustakaan Digital', 'Menyinkronkan data...');

// Custom initialization
const customLoading = new LibraryLoading({
    minDisplayTime: 2000,
    autoHide: false,
    showOnNavigation: true
});

// Show with custom text
customLoading.show('Memuat katalog buku...');

// Hide manually
setTimeout(() => customLoading.hide(), 5000);
*/
