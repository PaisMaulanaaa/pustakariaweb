<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?= $title ?> - Perpustakaan</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Notification System CSS -->
    <link href="<?= base_url('assets/css/notifications.css') ?>" rel="stylesheet">

    <!-- Fallback CSS for Icons -->
    <style>
        /* Fallback for missing icons */
        .fas::before, .fa::before {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
            font-weight: 900 !important;
        }

        /* Specific icon fallbacks */
        .fa-book-reader::before { content: "📚"; }
        .fa-tachometer-alt::before { content: "📊"; }
        .fa-users::before { content: "👥"; }
        .fa-book::before { content: "📖"; }
        .fa-handshake::before { content: "🤝"; }
        .fa-chart-bar::before { content: "📈"; }
        .fa-user-circle::before { content: "👤"; }
        .fa-user-cog::before { content: "⚙️"; }
        .fa-sign-out-alt::before { content: "🚪"; }


    </style>
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/custom.css') ?>" rel="stylesheet">

    <!-- Blue Theme CSS -->
    <link href="<?= base_url('css/blue-theme.css') ?>" rel="stylesheet">

    <!-- Table Theme CSS -->
    <link href="<?= base_url('assets/css/table-theme.css') ?>" rel="stylesheet">

    <!-- Custom Dialog CSS -->
    <link href="<?= base_url('assets/css/custom-dialogs.css') ?>" rel="stylesheet">

    <style>
        /* Dark Blue Theme Variables */
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
        }

        .sb-topnav {
            background: linear-gradient(135deg, var(--navy-blue), var(--primary-dark-blue)) !important;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.3);
            border-bottom: 1px solid rgba(100, 116, 139, 0.2);
        }

        .sb-topnav .navbar-brand,
        .sb-topnav .nav-link {
            color: var(--text-light) !important;
            transition: all 0.3s ease;
        }

        .sb-topnav .navbar-brand:hover {
            color: var(--cream-dark) !important;
            transform: scale(1.05);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .sb-topnav .nav-link:hover {
            color: var(--cream-dark) !important;
            background-color: rgba(100, 116, 139, 0.2);
            border-radius: 8px;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .sb-topnav .nav-link.active {
            background-color: rgba(100, 116, 139, 0.3);
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(100, 116, 139, 0.3);
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

        /* Card Enhancements */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.2);
        }

        .card-header {
            background: linear-gradient(135deg, var(--slate-blue), var(--light-slate));
            border-bottom: 1px solid rgba(51, 65, 85, 0.2);
            color: var(--text-light);
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
        }

        /* Button Styles */
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

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--slate-blue), var(--navy-blue));
            border-top: 1px solid rgba(51, 65, 85, 0.2);
            color: var(--text-light);
        }
    </style>

</head>

<body class="sb-nav-fixed">


    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="<?= base_url('admin/dashboard') ?>">
            <i class="fas fa-book-reader me-2"></i>Perpustakaan
        </a>

        <!-- Main Navigation -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/dashboard') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/users') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/users') ?>">
                    <i class="fas fa-users me-2"></i>Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/books') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/books') ?>">
                    <i class="fas fa-book me-2"></i>Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/borrowings') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/borrowings') ?>">
                    <i class="fas fa-handshake me-2"></i>Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/reports') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/reports') ?>">
                    <i class="fas fa-chart-bar me-2"></i>Laporan
                </a>
            </li>
        </ul>

        <!-- Right Navigation -->
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <div class="dropdown-item text-muted small">
                            Logged in as:<br>
                            <strong><?= session()->get('fullname') ?></strong>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile') ?>">
                        <i class="fas fa-user-cog me-2"></i>Profile
                    </a></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
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
        </main>

        <!-- Footer -->
        <footer class="py-4 mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">
                        Copyright &copy; Perpustakaan <?= date('Y') ?>
                    </div>
                    <div>
                        <a href="#" class="text-decoration-none">Privacy Policy</a>
                        &middot;
                        <a href="#" class="text-decoration-none">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Data Attribute Notifications for JavaScript -->
    <?php
    if (function_exists('render_flash_notifications')) {
        echo render_flash_notifications('data-attribute');
    }
    ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

    <!-- Notification System JS -->
    <script src="<?= base_url('assets/js/notifications.js') ?>"></script>

    <!-- Custom Scripts -->
    <script>
    // Admin layout initialization
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin layout loaded');

        // Basic form handling with loading states
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

        // Add loading state to navigation links
        const navLinks = document.querySelectorAll('a[href*="admin/"]:not([data-bs-toggle])');
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

    // Final cleanup when everything is loaded
    window.addEventListener('load', function() {
        console.log('All resources loaded');
    });
    </script>

    <!-- Custom Dialog System -->
    <script src="<?= base_url('assets/js/custom-dialogs.js') ?>"></script>

    <!-- Page Specific Scripts -->
    <?= $this->renderSection('scripts') ?>

</body>
</html>
