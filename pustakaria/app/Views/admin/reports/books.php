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
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Total Buku</div>
                            <div class="fs-4"><?= $statistics['total'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-book"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Kategori</div>
                            <div class="fs-4"><?= $statistics['categories'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-tags"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Stok Menipis</div>
                            <div class="fs-4"><?= $statistics['lowStock'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small">Stok Habis</div>
                            <div class="fs-4"><?= $statistics['outOfStock'] ?></div>
                        </div>
                        <div class="fs-1"><i class="fas fa-times-circle"></i></div>
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
                <div class="col-md-6">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Semua Kategori</option>
                        <?php
                        $categories = array_unique(array_column($books, 'category'));
                        foreach ($categories as $cat):
                        ?>
                        <option value="<?= $cat ?>" <?= $category === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="stock" class="form-label">Status Stok</label>
                    <select class="form-select" id="stock" name="stock">
                        <option value="">Semua</option>
                        <option value="low" <?= $stock === 'low' ? 'selected' : '' ?>>Stok Menipis (<5)</option>
                        <option value="out" <?= $stock === 'out' ? 'selected' : '' ?>>Stok Habis</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="<?= base_url('admin/reports/exportBooks?' . http_build_query($_GET)) ?>" class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Data Buku
        </div>
        <div class="card-body">
            <table id="booksTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>ISBN</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Total Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $index => $book): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['publisher'] ?></td>
                        <td><?= $book['isbn'] ?></td>
                        <td><?= $book['category'] ?></td>
                        <td>
                            <?php if ($book['stock'] === '0'): ?>
                                <span class="badge bg-danger">Habis</span>
                            <?php elseif ($book['stock'] < 5): ?>
                                <span class="badge bg-warning text-dark"><?= $book['stock'] ?></span>
                            <?php else: ?>
                                <span class="badge bg-success"><?= $book['stock'] ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?= $book['borrow_count'] ?></td>
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
        $('#booksTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?> 