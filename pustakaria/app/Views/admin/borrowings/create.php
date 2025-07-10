<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Peminjaman</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/borrowings/store') ?>" method="POST">
                        <?= csrf_field() ?>

                        <?php if (session()->has('errors')) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (session()->get('errors') as $error) : ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
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

                        <div class="form-group">
                            <label for="user_id">Peminjam <span class="text-danger">*</span></label>
                            <select class="form-control select2 <?= session('errors.user_id') ? 'is-invalid' : '' ?>" 
                                    id="user_id" 
                                    name="user_id" 
                                    required>
                                <option value="">Pilih Peminjam</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                        <?= esc($user['fullname']) ?> (<?= esc($user['email']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.user_id')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.user_id') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="book_id">Buku <span class="text-danger">*</span></label>
                            <select class="form-control select2 <?= session('errors.book_id') ? 'is-invalid' : '' ?>" 
                                    id="book_id" 
                                    name="book_id" 
                                    required>
                                <option value="">Pilih Buku</option>
                                <?php foreach ($books as $book) : ?>
                                    <option value="<?= $book['id'] ?>" <?= old('book_id') == $book['id'] ? 'selected' : '' ?>>
                                        <?= esc($book['title']) ?> - <?= esc($book['author']) ?> 
                                        (Stok: <?= $book['stock'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.book_id')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.book_id') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="borrow_date">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control <?= session('errors.borrow_date') ? 'is-invalid' : '' ?>" 
                                           id="borrow_date" 
                                           name="borrow_date" 
                                           value="<?= old('borrow_date', date('Y-m-d')) ?>" 
                                           required>
                                    <?php if (session('errors.borrow_date')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.borrow_date') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Tanggal Kembali <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control <?= session('errors.due_date') ? 'is-invalid' : '' ?>" 
                                           id="due_date" 
                                           name="due_date" 
                                           value="<?= old('due_date', date('Y-m-d', strtotime('+7 days'))) ?>" 
                                           required>
                                    <?php if (session('errors.due_date')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.due_date') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control" 
                                      id="notes" 
                                      name="notes" 
                                      rows="3"><?= old('notes') ?></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="<?= base_url('admin/borrowings') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Set minimum date for borrow_date
    $('#borrow_date').attr('min', '<?= date('Y-m-d') ?>');

    // Update due_date when borrow_date changes
    $('#borrow_date').change(function() {
        let borrowDate = new Date($(this).val());
        let dueDate = new Date(borrowDate);
        dueDate.setDate(dueDate.getDate() + 7);
        
        let dueDateString = dueDate.toISOString().split('T')[0];
        $('#due_date').val(dueDateString);
        $('#due_date').attr('min', $(this).val());
    });

    // Set minimum date for due_date
    $('#due_date').attr('min', $('#borrow_date').val());
});
</script>
<?= $this->endSection() ?> 