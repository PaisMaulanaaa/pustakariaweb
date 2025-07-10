<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <?php if ($book['cover_image'] && file_exists('uploads/covers/' . $book['cover_image'])) : ?>
                        <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" 
                             alt="Cover <?= $book['title'] ?>" 
                             class="img-fluid mb-3" 
                             style="max-height: 300px;">
                    <?php else : ?>
                        <img src="<?= base_url('img/no-cover.png') ?>" 
                             alt="No Cover" 
                             class="img-fluid mb-3" 
                             style="max-height: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Buku</h6>
                </div>
                <div class="card-body">
                    <h4 class="font-weight-bold mb-3"><?= esc($book['title']) ?></h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Penulis</div>
                        <div class="col-md-9"><?= esc($book['author']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Penerbit</div>
                        <div class="col-md-9"><?= esc($book['publisher']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Tahun Terbit</div>
                        <div class="col-md-9"><?= esc($book['year']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">ISBN</div>
                        <div class="col-md-9"><?= esc($book['isbn']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Kategori</div>
                        <div class="col-md-9"><?= esc($book['category']) ?></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 font-weight-bold">Stok Tersedia</div>
                        <div class="col-md-9">
                            <?php if ($book['stock'] > 0) : ?>
                                <span class="text-success"><?= $book['stock'] ?> buku</span>
                            <?php else : ?>
                                <span class="text-danger">Stok habis</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3 font-weight-bold">Deskripsi</div>
                        <div class="col-md-9"><?= nl2br(esc($book['description'])) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if ($book['stock'] > 0) : ?>
                                <?php if (!$has_active_borrowing) : ?>
                                    <form action="<?= base_url('user/books/borrow/' . $book['id']) ?>" method="POST" style="display: inline;" id="borrowForm">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-primary" id="borrowBtn">
                                            <i class="fas fa-book-reader mr-2"></i>Pinjam Buku
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Anda masih memiliki peminjaman aktif untuk buku ini
                                    </div>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Maaf, stok buku sedang tidak tersedia
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const borrowBtn = document.getElementById('borrowBtn');
    const borrowForm = document.getElementById('borrowForm');

    if (borrowBtn && borrowForm) {
        borrowBtn.addEventListener('click', function(e) {
            e.preventDefault();

            confirmBorrow('Apakah Anda yakin ingin meminjam buku ini?').then(result => {
                if (result) {
                    borrowForm.submit();
                }
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
