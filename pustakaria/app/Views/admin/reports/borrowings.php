<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('admin/reports') ?>">Laporan</a></li>
        <li class="breadcrumb-item active"><?= $title ?></li>
    </ol>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total Peminjaman</div>
                            <div class="fs-4"><?= $statistics['total'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-book-reader"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Dikembalikan</div>
                            <div class="fs-4"><?= $statistics['returned'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Terlambat</div>
                            <div class="fs-4"><?= $statistics['overdue'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-exclamation-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Filter Laporan
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $startDate ?>">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $endDate ?>">
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua</option>
                        <option value="borrowed" <?= $status === 'borrowed' ? 'selected' : '' ?>>Dipinjam</option>
                        <option value="returned" <?= $status === 'returned' ? 'selected' : '' ?>>Dikembalikan</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="<?= base_url('admin/reports/exportBorrowings?' . http_build_query($_GET)) ?>" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Peminjaman
        </div>
        <div class="card-body">
            <table id="borrowingsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Keterlambatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowings as $index => $borrowing): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $borrowing['user_name'] ?></td>
                        <td><?= $borrowing['book_title'] ?></td>
                        <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                        <td>
                            <?php if ($borrowing['status'] === 'borrowed'): ?>
                                <span class="badge bg-primary">Dipinjam</span>
                            <?php else: ?>
                                <span class="badge bg-success">Dikembalikan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                            $overdueDays = 0;
                            if ($borrowing['status'] === 'borrowed' && strtotime($borrowing['due_date']) < strtotime('today')) {
                                $overdueDays = ceil((strtotime('today') - strtotime($borrowing['due_date'])) / (60 * 60 * 24));
                                echo '<span class="text-danger">' . $overdueDays . ' hari</span>';
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#borrowingsTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?> 