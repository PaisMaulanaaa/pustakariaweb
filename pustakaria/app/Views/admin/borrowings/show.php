<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Peminjaman</h6>
                    <div>
                        <?php if ($borrowing['status'] !== 'returned') : ?>
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="confirmReturn(<?= $borrowing['id'] ?>)">
                                <i class="fas fa-undo"></i> Proses Pengembalian
                            </button>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/borrowings') ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th style="width: 150px;">Status</th>
                                    <td>
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
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Jatuh Tempo</th>
                                    <td><?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td>
                                        <?php if ($borrowing['return_date']) : ?>
                                            <?= date('d/m/Y', strtotime($borrowing['return_date'])) ?>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if ($borrowing['notes']) : ?>
                                    <tr>
                                        <th>Catatan</th>
                                        <td><?= nl2br(esc($borrowing['notes'])) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th style="width: 150px;">Peminjam</th>
                                    <td><?= esc($borrowing['user_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= esc($borrowing['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>Judul Buku</th>
                                    <td><?= esc($borrowing['book_title']) ?></td>
                                </tr>
                                <tr>
                                    <th>Penulis</th>
                                    <td><?= esc($borrowing['author']) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cover Buku</h6>
                </div>
                <div class="card-body text-center">
                    <?php if ($borrowing['cover_image'] && file_exists('uploads/covers/' . $borrowing['cover_image'])) : ?>
                        <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>" 
                             alt="Cover <?= esc($borrowing['book_title']) ?>" 
                             class="img-fluid">
                    <?php else : ?>
                        <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                             alt="No Cover" 
                             class="img-fluid">
                    <?php endif; ?>
                </div>
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
function confirmReturn(id) {
    $('#returnForm').attr('action', '<?= base_url('admin/borrowings/return/') ?>' + id);
    $('#returnModal').modal('show');
}
</script>
<?= $this->endSection() ?> 