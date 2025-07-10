<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-8 col-lg-7">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <div class="auth-icon mb-3">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="auth-title mb-2">Buat Akun Baru</h2>
                    <p class="auth-subtitle">Bergabung dengan Perpustakaan Digital</p>
                </div>



                <form action="<?= base_url('auth/register') ?>" method="post" class="register-form needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="fullname" class="form-label">
                                    <i class="fas fa-user me-2" style="color: #1e3a8a;"></i>Nama Lengkap
                                </label>
                                <input type="text" 
                                       class="form-control <?= (session('errors.fullname')) ? 'is-invalid' : '' ?>" 
                                       id="fullname" 
                                       name="fullname" 
                                       value="<?= old('fullname') ?>"
                                       placeholder="Masukkan nama lengkap"
                                       required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2" style="color: #1e3a8a;"></i>Email
                                </label>
                                <input type="email" 
                                       class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email') ?>"
                                       placeholder="Masukkan email"
                                       required>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2" style="color: #1e3a8a;"></i>Nomor Telepon
                                </label>
                                <input type="tel" 
                                       class="form-control <?= (session('errors.phone')) ? 'is-invalid' : '' ?>" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?= old('phone') ?>"
                                       placeholder="Masukkan nomor telepon"
                                       required>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2" style="color: #1e3a8a;"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?= (session('errors.password')) ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password"
                                           placeholder="Masukkan password"
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                </div>
                                <div id="passwordStrength" class="form-text mt-1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="confirm_password" class="form-label">
                            <i class="fas fa-lock me-2" style="color: #1e3a8a;"></i>Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control <?= (session('errors.confirm_password')) ? 'is-invalid' : '' ?>" 
                                   id="confirm_password" 
                                   name="confirm_password"
                                   placeholder="Konfirmasi password"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>

                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input <?= (session('errors.terms')) ? 'is-invalid' : '' ?>" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="/terms" class="fw-semibold" style="color: #1e3a8a;">Syarat dan Ketentuan</a>
                        </label>
                        <div class="invalid-feedback">
                            <?= session('errors.terms') ?? 'Anda harus menyetujui syarat dan ketentuan' ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                    </button>

                    <div class="text-center">
                        <p class="mb-0">Sudah punya akun?
                            <a href="/auth/login" class="text-decoration-none fw-semibold" style="color: #1e3a8a;">
                                Masuk disini
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Social Register Buttons -->
            <div class="auth-card mt-3 text-center">
                <p class="text-muted mb-3">Atau daftar dengan</p>
                <div class="d-flex justify-content-center gap-3">
                    <button class="btn btn-outline-dark flex-grow-1">
                        <i class="fab fa-google me-2"></i>Google
                    </button>
                    <button class="btn btn-outline-dark flex-grow-1">
                        <i class="fab fa-facebook me-2"></i>Facebook
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Toggle Confirm Password Visibility
document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPassword = document.getElementById('confirm_password');
    const icon = this.querySelector('i');
    
    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Form Validation
(function () {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Password Strength Checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthMeter = document.getElementById('passwordStrength');
    
    // Define strength criteria
    const hasLength = password.length >= 8;
    const hasUpper = /[A-Z]/.test(password);
    const hasLower = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[^A-Za-z0-9]/.test(password);
    
    // Calculate strength
    const strength = [hasLength, hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;
    
    // Update strength meter
    let strengthText = '';
    let strengthColor = '';
    
    if (password.length === 0) {
        strengthText = '';
    } else if (strength <= 2) {
        strengthText = 'Lemah';
        strengthColor = '#dc3545';
    } else if (strength <= 4) {
        strengthText = 'Sedang';
        strengthColor = '#ffc107';
    } else {
        strengthText = 'Kuat';
        strengthColor = '#198754';
    }
    
    strengthMeter.textContent = strengthText ? `Kekuatan Password: ${strengthText}` : '';
    strengthMeter.style.color = strengthColor;
});

// Confirm Password Validator
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Password tidak cocok');
    } else {
        this.setCustomValidity('');
    }
});

// Add floating label effect
document.querySelectorAll('.form-control').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.classList.add('focused');
    });

    input.addEventListener('blur', () => {
        if (!input.value) {
            input.parentElement.classList.remove('focused');
        }
    });
});

// Show error messages as toast notifications
<?php if(session()->getFlashdata('error')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof showError === 'function') {
            showError('<?= addslashes(session()->getFlashdata('error')) ?>');
        }
    });
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof showSuccess === 'function') {
            showSuccess('<?= addslashes(session()->getFlashdata('success')) ?>');
        }
    });
<?php endif; ?>
</script>

<style>
/* Dark Blue Theme Variables */
:root {
    --primary-dark-blue: #1e3a8a;
    --navy-blue: #0f172a;
    --slate-blue: #334155;
    --cream-dark: #f1f5f9;
    --primary-blue: #2563eb;
    --cream-blue: #eff6ff;
    --text-dark: #1e293b;
}

.min-vh-75 {
    min-height: 75vh;
}

/* Auth Header Styling */
.auth-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-dark-blue), var(--navy-blue));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
}

.auth-icon i {
    font-size: 2rem;
    color: #ffffff;
}

.auth-title {
    color: var(--navy-blue);
    font-weight: 700;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
}

.auth-subtitle {
    color: var(--slate-blue);
    font-size: 1rem;
    margin-bottom: 0;
}

.auth-card {
    background: var(--cream-dark);
    border-radius: 15px;
    padding: 2.5rem;
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.15);
    transition: all 0.3s ease;
    border: 1px solid rgba(51, 65, 85, 0.2);
    position: relative;
    overflow: hidden;
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, var(--primary-dark-blue), var(--navy-blue));
}

.auth-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(15, 23, 42, 0.25);
}

.form-control {
    border: 2px solid rgba(51, 65, 85, 0.3);
    padding: 0.875rem 1rem;
    transition: all 0.3s ease;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    font-size: 0.95rem;
}

.form-control:focus {
    border-color: var(--primary-dark-blue);
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
    background-color: #fff;
}

.form-control.is-invalid {
    border-color: #dc3545;
    background-image: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-dark-blue), var(--navy-blue));
    border: none;
    padding: 0.875rem 1.5rem;
    transition: all 0.3s ease;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--navy-blue), #0c1426);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.4);
    color: white;
}

.btn-outline-dark {
    border-color: rgba(30, 58, 138, 0.3);
    color: var(--primary-dark-blue);
    transition: all 0.3s ease;
    border-radius: 8px;
    font-weight: 500;
}

.btn-outline-dark:hover {
    background: var(--cream-blue);
    border-color: var(--primary-dark-blue);
    color: var(--primary-dark-blue);
    transform: translateY(-2px);
}

.form-check-input:checked {
    background-color: var(--primary-dark-blue);
    border-color: var(--primary-dark-blue);
}

.form-label {
    color: var(--text-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.register-form {
    animation: slideUp 0.5s ease forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-label {
    color: var(--navy-blue);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-group .btn-outline-secondary {
    border-color: rgba(51, 65, 85, 0.3);
    color: var(--primary-dark-blue);
    z-index: 0;
    border-radius: 0 8px 8px 0;
}

.input-group .btn-outline-secondary:hover {
    background-color: var(--cream-dark);
    color: var(--primary-dark-blue);
    border-color: var(--primary-dark-blue);
}

.alert {
    border-radius: 10px;
    border: none;
    background-color: rgba(255, 255, 255, 0.9);
}

.form-check-label {
    color: var(--navy-blue);
}

/* Custom Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    animation: fadeIn 0.5s ease forwards;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .auth-card {
        padding: 1.5rem;
    }
    
    .btn-primary, .btn-outline-dark {
        padding: 0.5rem 1rem;
    }
    
    .row {
        margin-right: -8px;
        margin-left: -8px;
    }
    
    .col-md-6 {
        padding-right: 8px;
        padding-left: 8px;
    }
}
</style>
<?= $this->endSection() ?> 