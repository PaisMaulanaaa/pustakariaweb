<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

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

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
            <div>
                <a href="<?= base_url('admin/borrowings/overdue') ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-clock"></i> Terlambat
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="borrowingsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($borrowings as $borrowing) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($borrowing['user_name']) ?></td>
                                <td><?= esc($borrowing['book_title']) ?></td>
                                <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                                <td>
                                    <?php if ($borrowing['return_date']) : ?>
                                        <?= date('d/m/Y', strtotime($borrowing['return_date'])) ?>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $badgeClass = 'secondary';
                                    switch ($borrowing['status']) {
                                        case 'pending':
                                            $badgeClass = 'info';
                                            break;
                                        case 'borrowed':
                                            $badgeClass = 'primary';
                                            break;
                                        case 'returned':
                                            $badgeClass = 'success';
                                            break;
                                        case 'overdue':
                                            $badgeClass = 'danger';
                                            break;
                                    }
                                    ?>
                                    <span class="badge badge-<?= $badgeClass ?>">
                                        <?= ucfirst($borrowing['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/borrowings/show/' . $borrowing['id']) ?>" 
                                           class="btn btn-sm btn-info" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($borrowing['status'] !== 'returned') : ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    onclick="confirmReturn(<?= $borrowing['id'] ?>)"
                                                    title="Kembalikan">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Return Confirmation Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Konfirmasi Pengembalian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin memproses pengembalian buku ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="returnForm" action="" method="POST" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success">Proses Pengembalian</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#borrowingsTable').DataTable({
        "order": [[3, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});

function confirmReturn(id) {
    $('#returnForm').attr('action', '<?= base_url('admin/borrowings/return/') ?>' + id);
    $('#returnModal').modal('show');
}
</script>
<?= $this->endSection() ?> 