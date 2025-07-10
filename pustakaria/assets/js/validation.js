/**
 * Modern Form Validation System
 * Consistent with dark blue theme
 */

class FormValidator {
    constructor(form, options = {}) {
        this.form = form;
        this.options = {
            validateOnInput: false,  // Disabled by default for gentler UX
            validateOnBlur: false,   // Disabled by default for gentler UX
            showSuccessIcons: false, // Disabled by default for cleaner look
            realTimeValidation: false, // Disabled by default
            ...options
        };
        this.rules = {};
        this.errors = {};
        this.init();
    }

    init() {
        if (!this.form) return;

        this.setupEventListeners();
        this.setupDefaultRules();
    }

    setupEventListeners() {
        // Form submit validation
        this.form.addEventListener('submit', (e) => {
            if (!this.validateAll()) {
                e.preventDefault();
                this.focusFirstError();
            }
        });

        // Very gentle real-time validation - only on specific conditions
        if (this.options.validateOnInput) {
            this.form.addEventListener('input', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    // Only validate if field was previously invalid (to clear errors)
                    if (e.target.classList.contains('is-invalid')) {
                        this.validateField(e.target);
                    }
                }
            });
        }

        // Only validate on blur if field has substantial content
        if (this.options.validateOnBlur) {
            this.form.addEventListener('blur', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    const value = e.target.value.trim();
                    // Mark field as touched only if it has content
                    if (value !== '') {
                        e.target.dataset.touched = 'true';
                        // Only validate if field has substantial content (more than 2 chars for most fields)
                        if (value.length > 2 || e.target.type === 'email' && value.includes('@')) {
                            this.validateField(e.target);
                        }
                    }
                }
            }, true);
        }

        // Clear any validation state when user focuses on field
        this.form.addEventListener('focus', (e) => {
            if (e.target.matches('input, textarea, select')) {
                // Clear validation state for fresh interaction
                if (e.target.dataset.touched !== 'true') {
                    this.clearFieldState(e.target);
                }
            }
        }, true);
    }

    setupDefaultRules() {
        // Auto-detect validation rules from HTML attributes
        const fields = this.form.querySelectorAll('input, textarea, select');
        fields.forEach(field => {
            const rules = [];

            if (field.hasAttribute('required')) {
                rules.push('required');
            }

            if (field.type === 'email') {
                rules.push('email');
            }

            if (field.type === 'tel' || field.name === 'phone') {
                rules.push('phone');
            }

            if (field.type === 'password') {
                // Only add basic password rule (minimum length)
                rules.push('minLength:6');
            }

            if (field.hasAttribute('minlength')) {
                rules.push(`minLength:${field.getAttribute('minlength')}`);
            }

            if (field.hasAttribute('maxlength')) {
                rules.push(`maxLength:${field.getAttribute('maxlength')}`);
            }

            if (field.hasAttribute('min')) {
                rules.push(`min:${field.getAttribute('min')}`);
            }

            if (field.hasAttribute('max')) {
                rules.push(`max:${field.getAttribute('max')}`);
            }

            if (rules.length > 0) {
                this.addRule(field.name || field.id, rules);
            }
        });
    }

    addRule(fieldName, rules) {
        this.rules[fieldName] = Array.isArray(rules) ? rules : [rules];
        return this;
    }

    validateField(field) {
        const fieldName = field.name || field.id;
        const rules = this.rules[fieldName];

        if (!rules) return true;

        const value = field.value.trim();
        const errors = [];
        const isTouched = field.dataset.touched === 'true';
        const isFormSubmission = field.closest('form')?.dataset.submitting === 'true';

        // Only validate in these specific cases:
        // 1. During form submission
        // 2. Field was previously invalid (to clear errors)
        // 3. Field has substantial content and is touched

        const shouldValidate = isFormSubmission ||
                              field.classList.contains('is-invalid') ||
                              (isTouched && value.length > 0);

        if (!shouldValidate) {
            this.clearFieldState(field);
            delete this.errors[fieldName];
            return true;
        }

        for (const rule of rules) {
            const [ruleName] = rule.split(':');

            // Special handling for required rule - only during form submission or if field was invalid
            if (ruleName === 'required') {
                if ((isFormSubmission || field.classList.contains('is-invalid')) && value === '') {
                    const error = this.applyRule(value, rule, field);
                    if (error) {
                        errors.push(error);
                        break;
                    }
                }
            } else {
                // For other rules, only validate if field has substantial content
                if (value !== '') {
                    const error = this.applyRule(value, rule, field);
                    if (error) {
                        errors.push(error);
                        break;
                    }
                }
            }
        }

        if (errors.length > 0) {
            this.showFieldError(field, errors[0]);
            this.errors[fieldName] = errors;
            return false;
        } else {
            // Only show success state during form submission or if field was previously invalid
            if (isFormSubmission || field.classList.contains('is-invalid')) {
                if (value !== '') {
                    this.showFieldSuccess(field);
                } else {
                    this.clearFieldState(field);
                }
            } else {
                this.clearFieldState(field);
            }
            delete this.errors[fieldName];
            return true;
        }
    }

    applyRule(value, rule, field) {
        const [ruleName, ruleValue] = rule.split(':');

        switch (ruleName) {
            case 'required':
                return value === '' ? 'Field ini wajib diisi' : null;

            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return value && !emailRegex.test(value) ? 'Format email tidak valid' : null;

            case 'phone':
                const phoneRegex = /^(\+62|62|0)[0-9]{9,13}$/;
                return value && !phoneRegex.test(value) ? 'Format nomor telepon tidak valid' : null;

            case 'password':
                if (value.length < 6) return 'Password minimal 6 karakter';
                // Removed strict password requirements for better UX
                return null;

            case 'minLength':
                return value.length < parseInt(ruleValue) ? `Minimal ${ruleValue} karakter` : null;

            case 'maxLength':
                return value.length > parseInt(ruleValue) ? `Maksimal ${ruleValue} karakter` : null;

            case 'min':
                return parseFloat(value) < parseFloat(ruleValue) ? `Nilai minimal ${ruleValue}` : null;

            case 'max':
                return parseFloat(value) > parseFloat(ruleValue) ? `Nilai maksimal ${ruleValue}` : null;

            case 'match':
                const matchField = this.form.querySelector(`[name="${ruleValue}"]`);
                return matchField && value !== matchField.value ? 'Password tidak cocok' : null;

            case 'unique':
                // This would typically check against server
                return null;

            default:
                return null;
        }
    }

    showFieldError(field, message) {
        this.clearFieldState(field);
        
        field.classList.add('is-invalid');
        
        const errorElement = this.createErrorElement(message);
        this.insertErrorElement(field, errorElement);
    }

    showFieldSuccess(field) {
        this.clearFieldState(field);
        
        if (this.options.showSuccessIcons && field.value.trim() !== '') {
            field.classList.add('is-valid');
        }
    }

    clearFieldState(field) {
        field.classList.remove('is-invalid', 'is-valid');
        
        const existingError = this.getErrorElement(field);
        if (existingError) {
            existingError.remove();
        }
    }

    createErrorElement(message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback';
        errorElement.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i>${message}`;
        return errorElement;
    }

    insertErrorElement(field, errorElement) {
        const container = field.closest('.form-group') || field.parentNode;
        container.appendChild(errorElement);
    }

    getErrorElement(field) {
        const container = field.closest('.form-group') || field.parentNode;
        return container.querySelector('.invalid-feedback');
    }

    validateAll() {
        const fields = this.form.querySelectorAll('input, textarea, select');
        let isValid = true;

        // Mark form as being submitted
        this.form.dataset.submitting = 'true';

        fields.forEach(field => {
            // Mark all fields as touched during form submission
            field.dataset.touched = 'true';
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        // Remove submitting flag after validation
        setTimeout(() => {
            delete this.form.dataset.submitting;
        }, 100);

        return isValid;
    }

    focusFirstError() {
        const firstErrorField = this.form.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.focus();
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    getErrors() {
        return this.errors;
    }

    hasErrors() {
        return Object.keys(this.errors).length > 0;
    }

    reset() {
        const fields = this.form.querySelectorAll('input, textarea, select');
        fields.forEach(field => {
            this.clearFieldState(field);
            delete field.dataset.touched;
        });
        this.errors = {};
    }
}

// Auto-initialize forms with validation
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        new FormValidator(form);
    });
});

// Global helper function
window.FormValidator = FormValidator;
