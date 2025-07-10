<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Buku Baru</h1>
        <a href="<?= base_url('admin/books') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Buku</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/books/add') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Judul Buku</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" class="form-control" id="author" name="author" value="<?= old('author') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="publisher">Penerbit</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" value="<?= old('publisher') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="year">Tahun Terbit</label>
                            <input type="number" class="form-control" id="year" name="year" value="<?= old('year') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= old('isbn') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Fiksi" <?= old('category') == 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                                <option value="Non-Fiksi" <?= old('category') == 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                                <option value="Pendidikan" <?= old('category') == 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                                <option value="Teknologi" <?= old('category') == 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                <option value="Seni" <?= old('category') == 'Seni' ? 'selected' : '' ?>>Seni</option>
                                <option value="Sejarah" <?= old('category') == 'Sejarah' ? 'selected' : '' ?>>Sejarah</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_image">Cover Buku</label>
                            <input type="file" class="form-control-file" id="cover_image" name="cover_image" accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG. Ukuran maksimal: 2MB</small>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= base_url('admin/books') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 