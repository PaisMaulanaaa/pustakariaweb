<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Borrowed -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Peminjaman</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_borrowed'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-reader fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Currently Borrowed -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sedang Dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['currently_borrowed'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overdue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Terlambat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['overdue'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Returned -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Dikembalikan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['returned'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Active Borrowings -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku yang Sedang Dipinjam</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($active_borrowings)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($active_borrowings as $borrowing): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($borrowing['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $borrowing['cover_image'])): ?>
                                                <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>"
                                                     alt="<?= esc($borrowing['book_title']) ?>" class="img-thumbnail mr-3" style="width: 50px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="d-flex align-items-center justify-content-center mr-3 bg-light border rounded"
                                                     style="width: 50px; height: 60px; font-size: 12px;">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div><?= esc($borrowing['book_title']) ?></div>
                                        </div>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                                    <td>
                                        <?php
                                        $today = strtotime('today');
                                        $dueDate = strtotime($borrowing['due_date']);
                                        $daysLeft = ceil(($dueDate - $today) / (60 * 60 * 24));
                                        
                                        if ($daysLeft > 0) {
                                            echo "<span class='badge badge-success'>Sisa {$daysLeft} hari</span>";
                                        } else {
                                            echo "<span class='badge badge-danger'>Terlambat " . abs($daysLeft) . " hari</span>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <img src="<?= base_url('assets/img/undraw_empty.svg') ?>" style="width: 200px; margin-bottom: 20px;">
                        <p class="text-muted">Tidak ada buku yang sedang dipinjam</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Available Books -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buku yang Tersedia</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($available_books as $book): ?>
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= base_url('uploads/covers/' . ($book['cover_image'] ?: 'default.jpg')) ?>" 
                             alt="<?= $book['title'] ?>" class="img-thumbnail mr-3" style="width: 60px;">
                        <div>
                            <h6 class="mb-0"><?= $book['title'] ?></h6>
                            <small class="text-muted">Stok: <?= $book['stock'] ?></small>
                            <br>
                            <a href="<?= base_url('user/books/' . $book['id']) ?>" class="btn btn-sm btn-primary mt-1">
                                <i class="fas fa-info-circle"></i> Detail
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <div class="text-center mt-3">
                        <a href="<?= base_url('user/books') ?>" class="btn btn-link">Lihat Semua Buku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Borrowings -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Peminjaman Terakhir</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_borrowings)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_borrowings as $borrowing): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($borrowing['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $borrowing['cover_image'])): ?>
                                        <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>"
                                             alt="<?= esc($borrowing['book_title']) ?>" class="img-thumbnail mr-3" style="width: 50px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center mr-3 bg-light border rounded"
                                             style="width: 50px; height: 60px; font-size: 12px;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div><?= esc($borrowing['book_title']) ?></div>
                                </div>
                            </td>
                            <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                            <td>
                                <?= $borrowing['return_date'] ? date('d/m/Y', strtotime($borrowing['return_date'])) : '-' ?>
                            </td>
                            <td>
                                <?php
                                $badgeClass = 'primary';
                                $status = 'Dipinjam';
                                
                                if ($borrowing['status'] == 'returned') {
                                    $badgeClass = 'success';
                                    $status = 'Dikembalikan';
                                } elseif ($borrowing['status'] == 'overdue' || 
                                        (strtotime($borrowing['due_date']) < strtotime('today') && 
                                         $borrowing['status'] == 'borrowed')) {
                                    $badgeClass = 'danger';
                                    $status = 'Terlambat';
                                }
                                ?>
                                <span class="badge badge-<?= $badgeClass ?>"><?= $status ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-3">
                <a href="<?= base_url('user/borrowings') ?>" class="btn btn-link">Lihat Semua Riwayat</a>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <img src="<?= base_url('assets/img/undraw_empty.svg') ?>" style="width: 200px; margin-bottom: 20px;">
                <p class="text-muted">Belum ada riwayat peminjaman</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 