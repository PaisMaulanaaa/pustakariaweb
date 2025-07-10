<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?> - Perpustakaan</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Fallback CSS for Icons -->
    <style>
        /* Enhanced icon fallback system */
        .fas, .fa {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome", sans-serif !important;
            font-weight: 900 !important;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }

        /* Specific icon fallbacks with better Unicode support */
        .fa-book-reader::before { content: "\f5da"; }
        .fa-home::before { content: "\f015"; }
        .fa-book::before { content: "\f02d"; }
        .fa-clipboard-list::before { content: "\f46d"; }
        .fa-user::before { content: "\f007"; }
        .fa-sign-out-alt::before { content: "\f2f5"; }
        .fa-search::before { content: "\f002"; }
        .fa-heart::before { content: "\f004"; }
        .fa-star::before { content: "\f005"; }
        .fa-calendar::before { content: "\f073"; }
        .fa-info-circle::before { content: "\f05a"; }

        /* Emoji fallbacks if Font Awesome completely fails */
        .icon-fallback .fa-book-reader::before { content: "📚" !important; }
        .icon-fallback .fa-home::before { content: "🏠" !important; }
        .icon-fallback .fa-book::before { content: "📖" !important; }
        .icon-fallback .fa-clipboard-list::before { content: "📋" !important; }
        .icon-fallback .fa-user::before { content: "👤" !important; }
        .icon-fallback .fa-sign-out-alt::before { content: "🚪" !important; }

        /* Smooth page transitions */
        .navbar, .container, .footer {
            transition: all 0.3s ease;
        }
    </style>

    <!-- Blue Theme CSS -->
    <link href="<?= base_url('css/blue-theme.css') ?>" rel="stylesheet">

    <!-- Notification System CSS -->
    <link href="<?= base_url('assets/css/notifications.css') ?>" rel="stylesheet">

    <!-- Custom Dialog CSS -->
    <link href="<?= base_url('assets/css/custom-dialogs.css') ?>" rel="stylesheet">

    <!-- Inline micro-improvements for faster loading -->
    <style>
        /* Toast Styles */
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 1055; }
        .toast { min-width: 300px; }



        /* Form Validation */
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { display: block; color: #dc3545; font-size: 0.875rem; margin-top: 0.25rem; }

        /* Animations */
        .fade-in { animation: fadeIn 0.3s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Table Theme */
        .table-hover tbody tr:hover { background-color: rgba(30, 58, 138, 0.05); }
    </style>

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-dark-blue: #1e3a8a;
            --secondary-dark-blue: #1e40af;
            --deep-blue: #1d4ed8;
            --navy-blue: #0f172a;
            --slate-blue: #334155;
            --light-slate: #64748b;
            --cream-dark: #f1f5f9;
            --text-dark-blue: #0f172a;
            --text-light: #ffffff;
            --accent-success: #10b981;
            --accent-warning: #f59e0b;
            --accent-danger: #ef4444;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, var(--cream-dark) 0%, #ffffff 100%);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: linear-gradient(135deg, var(--navy-blue), var(--primary-dark-blue));
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.3);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(100, 116, 139, 0.2);
        }

        .navbar-brand {
            color: var(--text-light) !important;
            font-weight: 700;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--cream-dark) !important;
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .nav-link {
            color: var(--text-light) !important;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--cream-dark) !important;
            background-color: rgba(100, 116, 139, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.25);
            border-radius: 12px;
            background-color: var(--cream-dark);
            border: 1px solid rgba(51, 65, 85, 0.1);
        }

        .dropdown-item:hover {
            background-color: var(--slate-blue);
            color: var(--text-light);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            margin-bottom: 1.5rem;
            background-color: #fff;
            transition: all var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.2);
        }

        .card-header {
            background: linear-gradient(135deg, var(--slate-blue), var(--light-slate));
            border-bottom: 1px solid rgba(51, 65, 85, 0.2);
            padding: 1rem;
            color: var(--text-light);
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
        }

        .footer {
            background-color: #fff;
            padding: 1.5rem 0;
            border-top: 1px solid var(--cream-dark);
            margin-top: auto;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-dark-blue), var(--navy-blue));
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: var(--text-light);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--navy-blue), #0c1426);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.4);
            color: var(--text-light);
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Alert Styles - Override with Blue Theme */
        .alert {
            border-radius: 0.75rem;
            border: none;
            border-left: 4px solid;
            font-weight: 500;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #059669, #047857);
            color: #ffffff;
            border-left-color: #10b981;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #ffffff;
            border-left-color: #ef4444;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .alert-warning {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: #ffffff;
            border-left-color: #f59e0b;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .alert-info {
            background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
            color: #ffffff;
            border-left-color: var(--blue-300);
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* Form Controls */
        .form-control:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

        /* Modal Styles */
        .modal-header {
            background: linear-gradient(135deg, var(--cream-blue), #ffffff);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            color: var(--text-blue);
        }

        .modal-footer {
            border-top: 1px solid rgba(37, 99, 235, 0.1);
        }

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(45deg, var(--navy-blue), var(--primary-dark-blue));
            color: var(--text-light);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all var(--transition-speed);
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.25);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.35);
        }

        /* Welcome card dengan gradient Dark Blue */
        .stats-card.bg-gradient {
            background: linear-gradient(45deg, var(--navy-blue), var(--slate-blue)) !important;
            border: none;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
            border: 1px solid rgba(100, 116, 139, 0.2);
        }

        .stats-card .text-white-50 {
            color: rgba(241, 245, 249, 0.8) !important;
        }

        .stats-card h4 {
            color: var(--text-light) !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .stats-card-icon {
            background: rgba(100, 116, 139, 0.2);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-right: 1rem;
            border: 1px solid rgba(100, 116, 139, 0.3);
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body>



        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('user') ?>">
                <i class="fas fa-book-reader me-2"></i>Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('user') ? 'active' : '' ?>" href="<?= base_url('user') ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('user/books*') ? 'active' : '' ?>" href="<?= base_url('user/books') ?>">
                            <i class="fas fa-book me-1"></i>Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('user/borrowings*') ? 'active' : '' ?>" href="<?= base_url('user/borrowings') ?>">
                            <i class="fas fa-clipboard-list me-1"></i>Peminjaman
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name=<?= session()->get('fullname') ?>&background=random" 
                                 alt="Profile" class="profile-img me-2">
                            <span><?= session()->get('fullname') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('user/profile') ?>">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-4">
        <!-- Flash Notifications -->
        <?php
        // Load notification helper if not already loaded
        if (!function_exists('render_flash_notifications')) {
            helper('notification');
        }
        ?>
        <?= render_flash_notifications('alert') ?>

        <?= $this->renderSection('content') ?>
    </div>

    <!-- Data Attribute Notifications for JavaScript -->
    <?php
    if (function_exists('render_flash_notifications')) {
        echo render_flash_notifications('data-attribute');
    }
    ?>

        <!-- Footer -->
        <footer class="footer mt-auto">
            <div class="container">
                <div class="text-center">
                    <span class="text-muted">Copyright &copy; Perpustakaan <?= date('Y') ?></span>
                </div>
            </div>
        </footer>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin keluar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 for advanced dialogs -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Notification System JS -->
    <script src="<?= base_url('assets/js/notifications.js') ?>"></script>
    <script src="<?= base_url('assets/js/animations.js') ?>"></script>

    <!-- User layout initialization (consistent with admin) -->
    <script>
        // User layout initialization
        document.addEventListener('DOMContentLoaded', function() {
            console.log('User layout loaded');

                // Show flash messages as toasts instead of alerts
            <?php if(session()->getFlashdata('message')): ?>
                const type = '<?= session()->getFlashdata('type') ?>';
                const message = '<?= addslashes(session()->getFlashdata('message')) ?>';

                // Convert alert types to toast types
                let toastType = type;
                if (type === 'danger') toastType = 'error';
                if (type === 'primary' || type === 'info') toastType = 'info';
                if (type === 'warning') toastType = 'warning';
                if (type === 'success') toastType = 'success';

                showToast(message, toastType);
            <?php endif; ?>

            // Font Awesome fallback check
            // Check if Font Awesome loaded properly
            setTimeout(() => {
                const testIcon = document.createElement('i');
                testIcon.className = 'fas fa-home';
                testIcon.style.position = 'absolute';
                testIcon.style.left = '-9999px';
                document.body.appendChild(testIcon);

                const computedStyle = window.getComputedStyle(testIcon, '::before');
                const content = computedStyle.getPropertyValue('content');

                // If Font Awesome didn't load properly, add fallback class
                if (!content || content === 'none' || content === '""') {
                    document.body.classList.add('icon-fallback');
                    console.warn('Font Awesome not loaded properly, using emoji fallbacks');
                }

                document.body.removeChild(testIcon);
            }, 100);

            // Basic form handling with loading states (same as admin)
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';

                        // Reset button if form validation fails
                        setTimeout(() => {
                            if (submitBtn.disabled) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        }, 5000);
                    }
                });
            });

            // Add loading state to navigation links (same as admin)
            const navLinks = document.querySelectorAll('.nav-link:not([data-bs-toggle]), .navbar-brand');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const icon = this.querySelector('i');
                    if (icon && !icon.classList.contains('fa-spinner')) {
                        const originalClass = icon.className;
                        icon.className = 'fas fa-spinner fa-spin me-2';

                        // Reset icon if navigation fails
                        setTimeout(() => {
                            icon.className = originalClass;
                        }, 3000);
                    }
                });
            });
        });
    });

    // Final cleanup when everything is loaded (same as admin)
    window.addEventListener('load', function() {
        console.log('All resources loaded');
    });
    </script>

    <!-- Custom Dialog System -->
    <script src="<?= base_url('assets/js/custom-dialogs.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>