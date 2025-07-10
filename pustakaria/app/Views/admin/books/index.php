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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
            <a href="<?= base_url('admin/books/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Buku
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="booksTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>ISBN</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($books as $book) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td class="text-center">
                                    <?php if ($book['cover_image'] && file_exists('uploads/covers/' . $book['cover_image'])) : ?>
                                        <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" 
                                             alt="Cover <?= $book['title'] ?>" 
                                             class="img-thumbnail"
                                             style="max-width: 50px;">
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                                             alt="No Cover" 
                                             class="img-thumbnail"
                                             style="max-width: 50px;">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $book['title'] ?>
                                    <div class="small text-muted">
                                        <?= $book['publisher'] ?> (<?= $book['year'] ?>)
                                    </div>
                                </td>
                                <td><?= $book['author'] ?></td>
                                <td><?= $book['isbn'] ?></td>
                                <td><?= $book['category'] ?></td>
                                <td class="text-center">
                                    <?php if ($book['stock'] > 0) : ?>
                                        <span class="badge badge-success"><?= $book['stock'] ?></span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/books/edit/' . $book['id']) ?>" 
                                           class="btn btn-sm btn-info" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                onclick="confirmDelete(<?= $book['id'] ?>, '<?= addslashes($book['title']) ?>')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
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

<!-- Delete Confirmation Modal - Bootstrap 5 Compatible -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus buku:</p>
                <strong id="bookTitle"></strong>
                <p class="text-muted mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#booksTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });
});

function confirmDelete(id, title) {
    // Set book title in modal
    document.getElementById('bookTitle').textContent = title;

    // Set delete URL
    document.getElementById('confirmDeleteBtn').href = '<?= base_url('admin/books/delete/') ?>' + id;

    // Show modal using Bootstrap 5
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
<?= $this->endSection() ?>
