<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Peminjaman</h1>
        <a href="<?= base_url('admin/borrowings') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Peminjaman Buku</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/borrowings/add') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="user_id">Peminjam</label>
                    <select class="form-control select2" id="user_id" name="user_id" required>
                        <option value="">Pilih Peminjam</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                <?= $user['fullname'] ?> (<?= $user['username'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="book_id">Buku</label>
                    <select class="form-control select2" id="book_id" name="book_id" required>
                        <option value="">Pilih Buku</option>
                        <?php foreach ($books as $book): ?>
                            <option value="<?= $book['id'] ?>" <?= old('book_id') == $book['id'] ? 'selected' : '' ?>>
                                <?= $book['title'] ?> (Stok: <?= $book['stock'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="borrow_date">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="borrow_date" name="borrow_date" 
                           value="<?= old('borrow_date', date('Y-m-d')) ?>" required>
                </div>

                <div class="form-group">
                    <label for="due_date">Batas Waktu Pengembalian</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" 
                           value="<?= old('due_date', date('Y-m-d', strtotime('+7 days'))) ?>" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/borrowings') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Set minimum date for borrow_date
    $('#borrow_date').attr('min', '<?= date('Y-m-d') ?>');

    // Update due_date when borrow_date changes
    $('#borrow_date').change(function() {
        var borrowDate = new Date($(this).val());
        var dueDate = new Date(borrowDate);
        dueDate.setDate(dueDate.getDate() + 7);
        
        var dueDateString = dueDate.toISOString().split('T')[0];
        $('#due_date').val(dueDateString);
        $('#due_date').attr('min', $(this).val());
    });

    // Set minimum date for due_date
    $('#due_date').attr('min', $('#borrow_date').val());
});
</script>
<?= $this->endSection() ?> 