<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>

    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card mb-4 shadow-sm border-0 report-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h5 mb-0 font-weight-bold">Laporan Peminjaman</div>
                            <div class="text-muted mb-3">Laporan aktivitas peminjaman buku</div>
                            <a href="<?= base_url('admin/reports/borrowings') ?>" class="btn btn-primary">
                                <i class="fas fa-file-alt me-1"></i> Lihat Laporan
                            </a>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6">
            <div class="card mb-4 shadow-sm border-0 report-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h5 mb-0 font-weight-bold">Laporan Buku</div>
                            <div class="text-muted mb-3">Laporan data dan stok buku</div>
                            <a href="<?= base_url('admin/reports/books') ?>" class="btn btn-primary">
                                <i class="fas fa-file-alt me-1"></i> Lihat Laporan
                            </a>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('styles') ?>
<style>
.report-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.report-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(30, 58, 138, 0.15) !important;
}

.report-card .card-body {
    padding: 2rem;
    background: linear-gradient(135deg, var(--table-primary-dark-blue) 0%, var(--table-navy-blue) 100%);
}

.report-card .h5 {
    color: #ffffff;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.report-card .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
}

.report-card .btn-primary {
    background: linear-gradient(135deg, #ffffff, #f1f5f9);
    color: var(--table-primary-dark-blue);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.report-card .btn-primary:hover {
    background: #ffffff;
    color: var(--table-navy-blue);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    border-color: #ffffff;
}

.report-card .fs-1 {
    color: rgba(255, 255, 255, 0.9);
    opacity: 0.8;
    transition: all 0.3s ease;
}

.report-card:hover .fs-1 {
    opacity: 1;
    color: #ffffff;
    transform: scale(1.1);
}
</style>
<?= $this->endSection() ?>

<?= $this->endSection() ?>