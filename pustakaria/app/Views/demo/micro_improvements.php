<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4" data-animate="fade-in-down">
        <div>
            <h1 class="h3 mb-0 text-gray-800">🎨 Micro-Improvements Demo</h1>
            <p class="mb-0 text-muted">Demonstrasi fitur-fitur enhancement yang telah ditambahkan</p>
        </div>
    </div>

    <div class="row">
        <!-- Toast Notifications Demo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100" data-animate="fade-in-left" data-animate-delay="100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Toast Notifications</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Notifikasi modern yang muncul di pojok kanan atas</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-animate" onclick="showSuccess('Operasi berhasil dilakukan!')">
                            <i class="fas fa-check me-2"></i>Success Toast
                        </button>
                        <button class="btn btn-danger btn-animate" onclick="showError('Terjadi kesalahan pada sistem!')">
                            <i class="fas fa-times me-2"></i>Error Toast
                        </button>
                        <button class="btn btn-warning btn-animate" onclick="showWarning('Perhatian! Data akan dihapus.')">
                            <i class="fas fa-exclamation-triangle me-2"></i>Warning Toast
                        </button>
                        <button class="btn btn-info btn-animate" onclick="showInfo('Informasi: Update tersedia.')">
                            <i class="fas fa-info-circle me-2"></i>Info Toast
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading States Demo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100" data-animate="fade-in-right" data-animate-delay="200">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-spinner me-2"></i>Loading States</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Loading states untuk berbagai komponen</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-animate" onclick="demoButtonLoading(this)">
                            <i class="fas fa-download me-2"></i>Button Loading
                        </button>
                        <button class="btn btn-secondary btn-animate" onclick="demoGlobalLoading()">
                            <i class="fas fa-globe me-2"></i>Global Loading
                        </button>
                        <button class="btn btn-outline-primary btn-animate" onclick="demoElementLoading()">
                            <i class="fas fa-box me-2"></i>Element Loading
                        </button>
                        <div id="demo-element" class="mt-3 p-3 border rounded">
                            <h6>Demo Element</h6>
                            <p class="mb-0">Konten yang akan di-loading</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Validation Demo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100" data-animate="fade-in-left" data-animate-delay="300">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Form Validation</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Validasi form real-time dengan feedback visual</p>
                    <form data-validate class="demo-form">
                        <div class="form-group mb-3">
                            <label for="demo-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="demo-email" name="demo-email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="demo-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="demo-password" name="demo-password" required minlength="6">
                        </div>
                        <div class="form-group mb-3">
                            <label for="demo-phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="demo-phone" name="demo-phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-animate">
                            <i class="fas fa-paper-plane me-2"></i>Submit Demo
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Animations Demo -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100" data-animate="fade-in-right" data-animate-delay="400">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-magic me-2"></i>Animations</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Berbagai animasi smooth dan modern</p>
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-success hover-lift" onclick="demoAnimation('bounce')">
                            <i class="fas fa-arrow-up me-2"></i>Bounce Animation
                        </button>
                        <button class="btn btn-outline-info hover-scale" onclick="demoAnimation('pulse')">
                            <i class="fas fa-heart me-2"></i>Pulse Animation
                        </button>
                        <button class="btn btn-outline-warning hover-glow" onclick="demoAnimation('wobble')">
                            <i class="fas fa-wave-square me-2"></i>Wobble Animation
                        </button>
                        <div id="animation-demo" class="mt-3 p-3 bg-light rounded text-center">
                            <i class="fas fa-star fa-2x text-warning"></i>
                            <p class="mt-2 mb-0">Demo Animation Target</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Skeleton Loading Demo -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm" data-animate="fade-in-up" data-animate-delay="500">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-th-list me-2"></i>Skeleton Loading</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Loading placeholder untuk konten yang sedang dimuat</p>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-animate mb-3" onclick="demoSkeleton()">
                                <i class="fas fa-play me-2"></i>Show Skeleton Loading
                            </button>
                            <div id="skeleton-demo">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">Sample Content 1</h6>
                                        <p class="card-text">Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">Sample Content 2</h6>
                                        <p class="card-text">Adipiscing elit sed do eiusmod tempor.</p>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Sample Content 3</h6>
                                        <p class="card-text">Incididunt ut labore et dolore magna.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Features Included:</h6>
                            <ul class="list-unstyled">
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Toast Notifications</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Loading States</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Form Validation</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Smooth Animations</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Skeleton Loading</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Ripple Effects</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Hover Animations</li>
                                <li class="stagger-item"><i class="fas fa-check text-success me-2"></i>Page Transitions</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Demo Functions
function demoButtonLoading(button) {
    buttonLoading(button, 'Downloading...');
    setTimeout(() => {
        buttonLoaded(button);
        showSuccess('Download completed!');
    }, 3000);
}

function demoGlobalLoading() {
    showLoading('Processing data...');
    setTimeout(() => {
        hideLoading();
        showInfo('Global loading completed!');
    }, 2000);
}

function demoElementLoading() {
    const element = document.getElementById('demo-element');
    elementLoading(element, 'Loading content...');
    setTimeout(() => {
        elementLoaded(element);
        showSuccess('Element loading completed!');
    }, 2500);
}

function demoAnimation(type) {
    const target = document.getElementById('animation-demo');
    target.classList.remove('bounce', 'pulse', 'wobble');
    setTimeout(() => {
        target.classList.add(type);
    }, 100);
    
    setTimeout(() => {
        target.classList.remove(type);
    }, 2000);
}

function demoSkeleton() {
    const container = document.getElementById('skeleton-demo');
    showSkeleton(container, 3);
    
    setTimeout(() => {
        container.innerHTML = `
            <div class="card mb-3 fade-in">
                <div class="card-body">
                    <h6 class="card-title">Loaded Content 1</h6>
                    <p class="card-text">Content has been successfully loaded!</p>
                </div>
            </div>
            <div class="card mb-3 fade-in">
                <div class="card-body">
                    <h6 class="card-title">Loaded Content 2</h6>
                    <p class="card-text">All data is now available.</p>
                </div>
            </div>
            <div class="card fade-in">
                <div class="card-body">
                    <h6 class="card-title">Loaded Content 3</h6>
                    <p class="card-text">Loading process completed successfully.</p>
                </div>
            </div>
        `;
        showSuccess('Skeleton loading demo completed!');
    }, 3000);
}

// Prevent demo form submission
document.addEventListener('DOMContentLoaded', function() {
    const demoForm = document.querySelector('.demo-form');
    if (demoForm) {
        demoForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showSuccess('Form validation demo completed! All fields are valid.');
        });
    }
});
</script>

<?= $this->endSection() ?>
