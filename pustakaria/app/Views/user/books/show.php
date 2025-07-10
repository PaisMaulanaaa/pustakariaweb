<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('user/dashboard') ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('user/books') ?>">Katalog Buku</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <?= esc($title) ?>
            </li>
        </ol>
    </nav>

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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <?php if ($book['cover_image'] && file_exists('uploads/covers/' . $book['cover_image'])) : ?>
                                <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>" 
                                     alt="Cover <?= esc($book['title']) ?>" 
                                     class="img-fluid rounded shadow">
                            <?php else : ?>
                                <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                                     alt="No Cover" 
                                     class="img-fluid rounded shadow">
                            <?php endif; ?>

                            <?php if ($can_borrow) : ?>
                                <div class="mt-4">
                                    <form action="<?= base_url('user/books/borrow/' . $book['id']) ?>" method="POST" id="borrowFormShow">
                                        <?= csrf_field() ?>
                                        <button type="button" class="btn btn-primary btn-block" id="borrowBtnShow">
                                            <i class="fas fa-book-reader"></i> Pinjam Buku
                                        </button>
                                    </form>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-warning mt-4">
                                    <?php if ($book['stock'] <= 0) : ?>
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Stok buku sedang kosong
                                    <?php else : ?>
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        Anda telah mencapai batas maksimal peminjaman (3 buku)
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <h1 class="h3 mb-4 text-gray-800"><?= esc($book['title']) ?></h1>
                            
                            <div class="mb-4">
                                <span class="badge badge-primary"><?= esc($book['category']) ?></span>
                                <span class="badge badge-<?= $book['stock'] > 0 ? 'success' : 'danger' ?>">
                                    <?= $book['stock'] > 0 ? 'Tersedia: ' . $book['stock'] : 'Stok Habis' ?>
                                </span>
                            </div>

                            <table class="table">
                                <tr>
                                    <th style="width: 150px;">Penulis</th>
                                    <td><?= esc($book['author']) ?></td>
                                </tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <td><?= esc($book['publisher']) ?></td>
                                </tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td><?= esc($book['year']) ?></td>
                                </tr>
                                <tr>
                                    <th>ISBN</th>
                                    <td><?= esc($book['isbn']) ?></td>
                                </tr>
                            </table>

                            <h5 class="mt-4 mb-3">Deskripsi</h5>
                            <p class="text-justify"><?= esc($book['description']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <?php if (!empty($similar_books)) : ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Buku Serupa</h6>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php foreach ($similar_books as $similar) : ?>
                                <a href="<?= base_url('user/books/' . $similar['id']) ?>" 
                                   class="list-group-item list-group-item-action">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto mr-3">
                                            <?php if ($similar['cover_image'] && file_exists('uploads/covers/' . $similar['cover_image'])) : ?>
                                                <img src="<?= base_url('uploads/covers/' . $similar['cover_image']) ?>" 
                                                     alt="Cover <?= esc($similar['title']) ?>" 
                                                     style="width: 50px;">
                                            <?php else : ?>
                                                <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                                                     alt="No Cover" 
                                                     style="width: 50px;">
                                            <?php endif; ?>
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-1"><?= esc($similar['title']) ?></h6>
                                            <small class="text-muted"><?= esc($similar['author']) ?></small>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Peminjaman</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Syarat Peminjaman:</h6>
                        <ul class="mb-0">
                            <li>Maksimal 3 buku</li>
                            <li>Durasi 7 hari</li>
                            <li>Denda keterlambatan Rp 1.000/hari</li>
                        </ul>
                    </div>
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Status Peminjaman Anda:</h6>
                        <ul class="mb-0">
                            <li>Buku yang sedang dipinjam: <?= $active_borrowings_count ?></li>
                            <li>Sisa kuota: <?= 3 - $active_borrowings_count ?> buku</li>
                        </ul>
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
    const borrowBtn = document.getElementById('borrowBtnShow');
    const borrowForm = document.getElementById('borrowFormShow');

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