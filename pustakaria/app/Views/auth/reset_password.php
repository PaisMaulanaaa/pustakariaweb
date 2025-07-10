<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-6">
            <div class="auth-card">
                <div class="text-center mb-4">
                    <i class="fas fa-key fa-3x mb-3" style="color: var(--primary-brown);"></i>
                    <h2 class="mb-1" style="color: var(--primary-brown);">Reset Password</h2>
                    <p class="text-muted">Masukkan email Anda untuk mereset password</p>
                </div>

                <?php if(session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= session()->get('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if(session()->has('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?= session()->get('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('auth/reset-password') ?>" method="post" class="needs-validation" novalidate>
                    <?= csrf_field() ?>
                    <div class="form-group mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2" style="color: var(--primary-brown);"></i>Email
                        </label>
                        <input type="email" 
                               class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>" 
                               id="email" 
                               name="email" 
                               value="<?= old('email') ?>"
                               placeholder="Masukkan email Anda"
                               required>
                        <?php if(session('errors.email')): ?>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        <i class="fas fa-paper-plane me-2"></i>Reset Password
                    </button>

                    <div class="text-center">
                        <p class="mb-0">Kembali ke 
                            <a href="<?= base_url('auth/login') ?>" class="text-decoration-none" style="color: var(--primary-brown);">
                                halaman login
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?> 