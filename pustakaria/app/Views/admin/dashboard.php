<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
            <p class="mb-0 text-muted">Selamat datang di sistem perpustakaan</p>
        </div>
        <div class="text-muted small">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= date('d F Y') ?>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Buku</div>
                            <div class="fs-4 fw-bold"><?= $totalBooks ?></div>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Anggota</div>
                            <div class="fs-4 fw-bold"><?= $totalUsers ?></div>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total Peminjaman</div>
                            <div class="fs-4 fw-bold"><?= $totalBorrowings ?></div>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Sedang Dipinjam</div>
                            <div class="fs-4 fw-bold"><?= $activeBorrowings ?></div>
                        </div>
                        <div class="fs-1 text-danger">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bolt me-1"></i>
                    Aksi Cepat
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/books') ?>" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-book me-2"></i>Kelola Buku
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-success w-100 py-3">
                                <i class="fas fa-users me-2"></i>Kelola Anggota
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/borrowings') ?>" class="btn btn-warning w-100 py-3">
                                <i class="fas fa-handshake me-2"></i>Kelola Peminjaman
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/reports') ?>" class="btn btn-info w-100 py-3">
                                <i class="fas fa-chart-bar me-2"></i>Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Monthly Statistics -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Statistik Peminjaman 6 Bulan Terakhir
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th class="text-center">Total Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($monthlyStats as $stat): ?>
                                <tr>
                                    <td><?= date('F Y', strtotime($stat['month'] . '-01')) ?></td>
                                    <td class="text-center"><?= $stat['total'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Most Borrowed Books -->
        <div class="col-xl-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Buku Terpopuler
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th class="text-center">Total Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mostBorrowedBooks as $book): ?>
                                <tr>
                                    <td><?= esc($book['title']) ?></td>
                                    <td><?= esc($book['author']) ?></td>
                                    <td class="text-center"><?= $book['borrow_count'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Latest Borrowings -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i>
                    Peminjaman Terbaru
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestBorrowings as $borrowing): ?>
                                <tr>
                                    <td><?= esc($borrowing['user_name']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($borrowing['cover_image'] && file_exists('uploads/covers/' . $borrowing['cover_image'])): ?>
                                                <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>"
                                                     alt="<?= esc($borrowing['book_title']) ?>"
                                                     class="img-thumbnail me-2"
                                                     style="width: 40px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="d-flex align-items-center justify-content-center me-2 bg-light border rounded"
                                                     style="width: 40px; height: 50px; font-size: 12px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <span><?= esc($borrowing['book_title']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                                    <td>
                                        <?php if ($borrowing['status'] === 'borrowed'): ?>
                                            <span class="badge bg-primary">Dipinjam</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Dikembalikan</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
console.log('Admin dashboard loaded successfully');
</script>
<?= $this->endSection() ?>