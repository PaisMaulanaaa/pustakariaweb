<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Peminjaman</h1>
        <a href="<?= base_url('admin/borrowings/add') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Peminjaman
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('warning') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Batas Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrowings as $borrowing): ?>
                        <tr>
                            <td><?= $borrowing['user_name'] ?></td>
                            <td><?= $borrowing['book_title'] ?></td>
                            <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                            <td>
                                <?= $borrowing['return_date'] ? date('d/m/Y', strtotime($borrowing['return_date'])) : '-' ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                            <td class="text-center">
                                <?php
                                $status_class = 'warning';
                                $status_text = 'Dipinjam';
                                
                                if ($borrowing['status'] === 'returned') {
                                    $status_class = 'success';
                                    $status_text = 'Dikembalikan';
                                } elseif (strtotime($borrowing['due_date']) < strtotime(date('Y-m-d'))) {
                                    $status_class = 'danger';
                                    $status_text = 'Terlambat';
                                }
                                ?>
                                <span class="badge badge-<?= $status_class ?>"><?= $status_text ?></span>
                            </td>
                            <td>
                                <?php if ($borrowing['status'] === 'borrowed'): ?>
                                    <a href="<?= base_url('admin/borrowings/return/' . $borrowing['id']) ?>" 
                                       class="btn btn-success btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">
                                        <i class="fas fa-check"></i> Kembalikan
                                    </a>
                                    <a href="<?= base_url('admin/borrowings/cancel/' . $borrowing['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?')">
                                        <i class="fas fa-times"></i> Batalkan
                                    </a>
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

<!-- Page level plugins -->
<script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<!-- Page level custom scripts -->
<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<?= $this->endSection() ?> 