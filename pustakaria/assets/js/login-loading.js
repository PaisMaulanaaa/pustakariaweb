/**
 * LOGIN LOADING SCREEN
 * Simplified loading screen specifically for login process
 */

class LoginLoading {
    constructor() {
        this.isVisible = false;
        this.loadingElement = null;
        this.progressInterval = null;
        this.typewriterInterval = null;
        this.currentProgress = 0;
        this.messages = [
            'Memverifikasi kredensial...',
            'Mengakses database...',
            'Menyiapkan sesi pengguna...',
            'Memuat preferensi...',
            'Hampir selesai...'
        ];
        this.currentMessageIndex = 0;
    }
    
    show(message = 'Memverifikasi akun...') {
        if (this.isVisible) return;

        // Create loading screen
        this.createLoadingScreen(message);
        this.isVisible = true;

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Start progress animation
        this.startProgressAnimation();

        // Start typewriter effect
        this.startTypewriterEffect();
    }
    
    updateMessage(title, subtitle) {
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
    
    hide() {
        if (!this.isVisible || !this.loadingElement) return;

        // Clear intervals
        if (this.progressInterval) {
            clearInterval(this.progressInterval);
            this.progressInterval = null;
        }

        if (this.typewriterInterval) {
            clearInterval(this.typewriterInterval);
            this.typewriterInterval = null;
        }

        this.loadingElement.classList.add('fade-out');
        this.isVisible = false;

        setTimeout(() => {
            if (this.loadingElement && this.loadingElement.parentNode) {
                this.loadingElement.remove();
                this.loadingElement = null;
            }
            document.body.style.overflow = '';
            this.currentProgress = 0;
            this.currentMessageIndex = 0;
        }, 600);
    }
    
    createLoadingScreen(message) {
        // Remove existing loading screen if any
        const existing = document.getElementById('loginLoading');
        if (existing) {
            existing.remove();
        }
        
        // Create loading screen HTML
        const loadingHTML = `
            <div id="loginLoading" class="library-loading">
                <!-- Floating Particles -->
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>
                <div class="particle"></div>

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

                    <!-- Enhanced Sparkle Effects -->
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                    <div class="sparkle"></div>
                </div>

                <div class="loading-text">
                    <div class="loading-title">Perpustakaan Digital</div>
                    <div class="loading-subtitle">${message}</div>
                    <div class="loading-percentage">0%</div>

                    <!-- Enhanced Progress Section -->
                    <div class="loading-progress">
                        <div class="progress-bar-container">
                            <div class="progress-bar"></div>
                        </div>
                    </div>

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
        this.loadingElement = document.getElementById('loginLoading');
    }

    startProgressAnimation() {
        const progressBar = this.loadingElement?.querySelector('.progress-bar');
        const percentageElement = this.loadingElement?.querySelector('.loading-percentage');

        if (!progressBar || !percentageElement) return;

        this.progressInterval = setInterval(() => {
            this.currentProgress += Math.random() * 15 + 5; // Random increment 5-20%

            if (this.currentProgress >= 100) {
                this.currentProgress = 100;
                clearInterval(this.progressInterval);
                this.progressInterval = null;
            }

            progressBar.style.width = this.currentProgress + '%';
            percentageElement.textContent = Math.floor(this.currentProgress) + '%';
        }, 300);
    }

    startTypewriterEffect() {
        const subtitleElement = this.loadingElement?.querySelector('.loading-subtitle');
        if (!subtitleElement) return;

        let charIndex = 0;
        let currentMessage = this.messages[this.currentMessageIndex];

        const typeChar = () => {
            if (charIndex < currentMessage.length) {
                subtitleElement.textContent = currentMessage.substring(0, charIndex + 1);
                charIndex++;
            } else {
                // Message complete, wait then start next message
                setTimeout(() => {
                    this.currentMessageIndex = (this.currentMessageIndex + 1) % this.messages.length;
                    currentMessage = this.messages[this.currentMessageIndex];
                    charIndex = 0;
                    subtitleElement.textContent = '';
                }, 1000);
            }
        };

        this.typewriterInterval = setInterval(typeChar, 80);
    }
}

// Initialize login loading
const loginLoading = new LoginLoading();

// Global functions for login loading
window.showLoginLoading = function(message) {
    loginLoading.show(message);
};

window.updateLoginLoading = function(title, subtitle) {
    loginLoading.updateMessage(title, subtitle);
};

window.hideLoginLoading = function() {
    loginLoading.hide();
};

// Auto-hide loading on page errors (validation errors, etc.)
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading if there are validation errors
    const hasErrors = document.querySelector('.is-invalid, .alert-danger');
    if (hasErrors) {
        setTimeout(() => {
            hideLoginLoading();
        }, 100);
    }
    
    // Hide loading if page becomes visible (user switched tabs)
    document.addEventListener('visibilitychange', function() {
        if (document.visibilityState === 'visible') {
            setTimeout(() => {
                hideLoginLoading();
            }, 500);
        }
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = LoginLoading;
}
