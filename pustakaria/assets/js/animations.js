/**
 * Modern Animation Controller
 * Handles smooth animations and transitions
 */

class AnimationController {
    constructor() {
        this.observers = [];
        this.init();
    }

    init() {
        this.setupIntersectionObserver();
        this.setupPageTransitions();
        this.setupHoverAnimations();
        this.setupScrollAnimations();
    }

    // Intersection Observer for scroll animations
    setupIntersectionObserver() {
        if (!window.IntersectionObserver) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe elements with animation classes
        const animatedElements = document.querySelectorAll('[data-animate]');
        animatedElements.forEach(el => {
            observer.observe(el);
        });

        this.observers.push(observer);
    }

    // Animate element based on data attribute
    animateElement(element) {
        const animationType = element.dataset.animate;
        const delay = element.dataset.animateDelay || 0;

        setTimeout(() => {
            element.classList.add(animationType);
        }, delay);
    }

    // Page transition animations
    setupPageTransitions() {
        // Animate page content on load
        document.addEventListener('DOMContentLoaded', () => {
            const pageContent = document.querySelector('.page-content, main, .container-fluid');
            if (pageContent) {
                pageContent.classList.add('page-transition');
            }

            // Stagger animate cards/items
            this.staggerAnimate('.card, .book-card, .borrowing-card');
        });
    }

    // Stagger animation for multiple elements
    staggerAnimate(selector, delay = 100) {
        const elements = document.querySelectorAll(selector);
        elements.forEach((element, index) => {
            element.style.animationDelay = `${index * delay}ms`;
            element.classList.add('stagger-item');
        });
    }

    // Setup hover animations
    setupHoverAnimations() {
        // Auto-add hover animations to interactive elements
        const interactiveElements = document.querySelectorAll('.btn, .card, .book-card');
        interactiveElements.forEach(element => {
            if (!element.classList.contains('no-hover')) {
                element.classList.add('hover-lift');
            }
        });

        // Add glow effect to primary buttons
        const primaryButtons = document.querySelectorAll('.btn-primary, .btn-success');
        primaryButtons.forEach(button => {
            button.classList.add('hover-glow');
        });
    }

    // Scroll-based animations
    setupScrollAnimations() {
        let ticking = false;

        const updateScrollAnimations = () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;

            // Parallax effect for banners
            const banners = document.querySelectorAll('.welcome-banner, .catalog-banner');
            banners.forEach(banner => {
                banner.style.transform = `translateY(${rate}px)`;
            });

            ticking = false;
        };

        const requestScrollUpdate = () => {
            if (!ticking) {
                requestAnimationFrame(updateScrollAnimations);
                ticking = true;
            }
        };

        window.addEventListener('scroll', requestScrollUpdate);
    }

    // Utility methods
    fadeIn(element, duration = 300) {
        if (!element) return;

        element.style.opacity = '0';
        element.style.display = 'block';

        const start = performance.now();

        const animate = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);

            element.style.opacity = progress;

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    }

    fadeOut(element, duration = 300) {
        if (!element) return;

        const start = performance.now();
        const startOpacity = parseFloat(getComputedStyle(element).opacity);

        const animate = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);

            element.style.opacity = startOpacity * (1 - progress);

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.style.display = 'none';
            }
        };

        requestAnimationFrame(animate);
    }

    slideUp(element, duration = 300) {
        if (!element) return;

        const height = element.offsetHeight;
        element.style.height = height + 'px';
        element.style.overflow = 'hidden';

        const start = performance.now();

        const animate = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);

            element.style.height = (height * (1 - progress)) + 'px';

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.style.display = 'none';
                element.style.height = '';
                element.style.overflow = '';
            }
        };

        requestAnimationFrame(animate);
    }

    slideDown(element, duration = 300) {
        if (!element) return;

        element.style.display = 'block';
        const height = element.scrollHeight;
        element.style.height = '0px';
        element.style.overflow = 'hidden';

        const start = performance.now();

        const animate = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);

            element.style.height = (height * progress) + 'px';

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                element.style.height = '';
                element.style.overflow = '';
            }
        };

        requestAnimationFrame(animate);
    }

    // Animate number counting
    countUp(element, target, duration = 1000) {
        if (!element) return;

        const start = performance.now();
        const startValue = 0;

        const animate = (currentTime) => {
            const elapsed = currentTime - start;
            const progress = Math.min(elapsed / duration, 1);

            const currentValue = Math.floor(startValue + (target - startValue) * progress);
            element.textContent = currentValue;

            if (progress < 1) {
                requestAnimationFrame(animate);
            }
        };

        requestAnimationFrame(animate);
    }

    // Add ripple effect to buttons
    addRippleEffect(button) {
        button.addEventListener('click', (e) => {
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            button.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    }

    // Cleanup observers
    destroy() {
        this.observers.forEach(observer => {
            observer.disconnect();
        });
        this.observers = [];
    }
}

// Initialize animation controller
window.animationController = new AnimationController();

// Global helper functions
window.fadeIn = (element, duration) => window.animationController.fadeIn(element, duration);
window.fadeOut = (element, duration) => window.animationController.fadeOut(element, duration);
window.slideUp = (element, duration) => window.animationController.slideUp(element, duration);
window.slideDown = (element, duration) => window.animationController.slideDown(element, duration);
window.countUp = (element, target, duration) => window.animationController.countUp(element, target, duration);

// Auto-add ripple effect to buttons
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn:not(.no-ripple)');
    buttons.forEach(button => {
        window.animationController.addRippleEffect(button);
    });
});
