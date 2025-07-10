<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Perpustakaan' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/dark-mode.css" rel="stylesheet">

    <!-- Blue Theme CSS -->
    <link href="<?= base_url('css/blue-theme.css') ?>" rel="stylesheet">

    <!-- Micro-improvements CSS -->
    <link href="<?= base_url('assets/css/toast.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/loading.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/validation.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/animations.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/table-theme.css') ?>" rel="stylesheet">

    <!-- Additional Styles Section -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-book-reader me-2"></i>
                Perpustakaan
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5 page-content" data-animate="fade-in-up">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Micro-improvements JS -->
    <script src="<?= base_url('assets/js/toast.js') ?>"></script>
    <script src="<?= base_url('assets/js/loading.js') ?>"></script>
    <script src="<?= base_url('assets/js/validation.js') ?>"></script>
    <script src="<?= base_url('assets/js/animations.js') ?>"></script>

    <!-- Custom JS - Safe Version -->
    <script src="/js/script-safe.js"></script>

    <!-- Initialize micro-improvements -->
    <script>
        // Show flash messages as toasts instead of alerts
        <?php if(session()->getFlashdata('message')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const type = '<?= session()->getFlashdata('type') ?>';
                const message = '<?= addslashes(session()->getFlashdata('message')) ?>';

                // Convert alert types to toast types
                let toastType = type;
                if (type === 'danger') toastType = 'error';
                if (type === 'primary' || type === 'info') toastType = 'info';
                if (type === 'warning') toastType = 'warning';
                if (type === 'success') toastType = 'success';

                showToast(message, toastType);
            });
        <?php endif; ?>
    </script>

    <!-- Additional Scripts Section -->
    <?= $this->renderSection('scripts') ?>

</body>
</html>