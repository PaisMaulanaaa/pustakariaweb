<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1 text-gray-800">Dashboard Administrator</h1>
                <p class="mb-0 text-muted">Selamat datang di sistem perpustakaan digital</p>
            </div>
            <div class="text-muted small">
                <i class="fas fa-calendar-alt me-1"></i>
                <?= date('d F Y') ?>
            </div>
        </div>
    </div>



    <!-- Statistics Cards -->
    <div class="row statistics-row">
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4 stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Total Buku</div>
                            <div class="fs-4 fw-bold"><?= $totalBooks ?? 0 ?></div>
                            <div class="small text-success mt-1">
                                <i class="fas fa-arrow-up me-1"></i>
                                <span>+12% bulan ini</span>
                            </div>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4 stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Total Anggota</div>
                            <div class="fs-4 fw-bold"><?= $totalUsers ?? 0 ?></div>
                            <div class="small text-success mt-1">
                                <i class="fas fa-arrow-up me-1"></i>
                                <span>+8% bulan ini</span>
                            </div>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4 stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Total Peminjaman</div>
                            <div class="fs-4 fw-bold"><?= $totalBorrowings ?? 0 ?></div>
                            <div class="small text-info mt-1">
                                <i class="fas fa-chart-line me-1"></i>
                                <span>Aktif hari ini</span>
                            </div>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mb-4 stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Sedang Dipinjam</div>
                            <div class="fs-4 fw-bold"><?= $activeBorrowings ?? 0 ?></div>
                            <div class="small text-warning mt-1">
                                <i class="fas fa-clock me-1"></i>
                                <span>Perlu perhatian</span>
                            </div>
                        </div>
                        <div class="fs-1 text-danger">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tools me-1"></i>
                    Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/books') ?>" class="btn btn-primary w-100">
                                <i class="fas fa-book me-2"></i>Kelola Buku
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-success w-100">
                                <i class="fas fa-users me-2"></i>Kelola Anggota
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/borrowings') ?>" class="btn btn-warning w-100">
                                <i class="fas fa-book-reader me-2"></i>Kelola Peminjaman
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/reports') ?>" class="btn btn-info w-100">
                                <i class="fas fa-chart-bar me-2"></i>Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informasi Sistem
                </div>
                <div class="card-body">
                    <p><strong>Sistem Perpustakaan Web</strong></p>
                    <p>Versi: 1.0.0</p>
                    <p>Login sebagai: <strong><?= session()->get('fullname') ?></strong></p>
                    <p>Role: <strong><?= session()->get('role') ?></strong></p>
                    <p>Waktu Login: <strong><?= date('d/m/Y H:i:s') ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
console.log('Simple admin dashboard loaded successfully');
console.log('Session data:', {
    user_id: '<?= session()->get('user_id') ?>',
    username: '<?= session()->get('username') ?>',
    role: '<?= session()->get('role') ?>'
});
</script>
<?= $this->endSection() ?>
