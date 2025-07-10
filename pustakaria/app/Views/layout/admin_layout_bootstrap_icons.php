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
    
    <!-- Bootstrap Icons (Alternative to Font Awesome) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= base_url('css/custom.css') ?>" rel="stylesheet">

    <style>
        .sb-topnav {
            background-color: #8B4513 !important; /* Brown color */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .sb-topnav .navbar-brand,
        .sb-topnav .nav-link {
            color: #FFF5E6 !important; /* Light cream color */
        }
        .sb-topnav .nav-link:hover {
            color: #FFE4C4 !important; /* Lighter cream color on hover */
            background-color: rgba(255,255,255,0.1);
        }
        .sb-topnav .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            font-weight: bold;
        }
        .dropdown-menu {
            border-color: #8B4513;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Top Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark">
        <!-- Navbar Brand -->
        <a class="navbar-brand ps-3" href="<?= base_url('admin/dashboard') ?>">
            <i class="bi bi-book me-2"></i>Perpustakaan
        </a>

        <!-- Main Navigation -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/dashboard') ?>">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/users') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/users') ?>">
                    <i class="bi bi-people me-2"></i>Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/books') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/books') ?>">
                    <i class="bi bi-book me-2"></i>Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/borrowings') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/borrowings') ?>">
                    <i class="bi bi-arrow-left-right me-2"></i>Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= str_contains(current_url(), 'admin/reports') ? 'active' : '' ?>" 
                   href="<?= base_url('admin/reports') ?>">
                    <i class="bi bi-bar-chart me-2"></i>Laporan
                </a>
            </li>
        </ul>

        <!-- Right Navigation -->
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
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
                        <i class="bi bi-gear me-2"></i>Profile
                    </a></li>
                    <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Admin layout with Bootstrap Icons loaded');
    });
    </script>

    <!-- Page Specific Scripts -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
