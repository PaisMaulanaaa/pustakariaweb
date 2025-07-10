<?= $this->extend('layout/user_layout') ?>

<?= $this->section('styles') ?>
<style>
/* Enhanced Book Cards with Blue Theme */
.book-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 1rem;
    overflow: hidden;
    background: #ffffff;
    height: 100%;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.1);
    position: relative;
}

.book-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--blue-500), var(--blue-600));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.book-card:hover::before {
    opacity: 1;
}

.book-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
    border-color: var(--blue-300);
}

.book-card .cover-container {
    position: relative;
    height: 240px;
    overflow: hidden;
    background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
    display: flex;
    align-items: center;
    justify-content: center;
}

.book-card .cover-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.book-card:hover .cover-container img {
    transform: scale(1.08);
}

.book-card .no-cover {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: var(--blue-400);
    font-size: 0.9rem;
    text-align: center;
    padding: 1rem;
}

.book-card .no-cover i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
    opacity: 0.6;
}

.book-card .card-body {
    padding: 1.5rem;
    background: #ffffff;
}

.book-card .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    color: var(--blue-900);
}

.book-card .card-title a {
    color: var(--blue-900);
    text-decoration: none;
    transition: color 0.3s ease;
}

.book-card .card-title a:hover {
    color: var(--blue-600);
}

.book-card .author {
    color: var(--blue-600);
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.book-card .author i {
    margin-right: 0.5rem;
    font-size: 0.8rem;
}

.book-card .description {
    font-size: 0.9rem;
    color: var(--blue-700);
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.6;
}

.book-card .card-footer {
    padding: 1.25rem;
    background: var(--blue-50);
    border-top: 1px solid var(--blue-100);
}

.book-card .badge {
    padding: 0.5rem 1rem;
    font-weight: 600;
    border-radius: 2rem;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.book-card .badge.bg-success {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.book-card .badge.bg-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.book-card .btn {
    border-radius: 0.75rem !important;
    padding: 0.875rem 1.25rem;
    font-weight: 600;
    font-size: 0.9rem;
    min-height: 48px;
    letter-spacing: 0.3px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    text-transform: uppercase;
    position: relative;
    overflow: hidden;
}

.book-card .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.book-card .btn:hover::before {
    left: 100%;
}

.book-card .btn i {
    margin-right: 0.5rem;
    font-size: 0.9rem;
}

.book-card .btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.book-card .btn-success:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

.book-card .btn-primary {
    background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.book-card .btn-primary:hover {
    background: linear-gradient(135deg, var(--blue-600), var(--blue-700));
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.book-card .btn-primary:hover {
    background-color: var(--brown-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.book-card .btn-primary:active {
    transform: translateY(0);
}

.book-card .btn-secondary {
    background-color: #F3F4F6;
    color: #6B7280;
    border: 1px solid #E5E7EB;
}

.book-card .btn-secondary:hover {
    background-color: #E5E7EB;
    color: #4B5563;
}

.book-card .btn:disabled {
    background-color: #F3F4F6 !important;
    color: #9CA3AF !important;
    border: 1px solid #E5E7EB !important;
    cursor: not-allowed;
    transform: none !important;
}

/* Ensure consistent button sizing */
.book-card .row.g-2 {
    margin-top: 1rem;
}

.book-card form {
    margin: 0;
    height: 100%;
}

.book-card form .btn {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: none !important;
}

/* Force consistent button dimensions */
.book-card .col-6 .btn {
    width: 100% !important;
    min-height: 48px !important;
    max-height: 48px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
}

/* Search and Filter Styles */
.search-card {
    border-radius: 1rem;
    margin-bottom: 2rem;
    background: #ffffff;
    border: 1px solid var(--blue-100);
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.08);
}

.search-card .form-control,
.search-card .form-select {
    padding: 0.875rem 1.25rem;
    border-radius: 0.75rem;
    border: 1px solid var(--blue-200);
    background-color: var(--blue-50);
    transition: all 0.3s ease;
}

.search-card .input-group-text {
    border-radius: 0.75rem 0 0 0.75rem;
    border: 1px solid var(--blue-200);
    border-right: none;
    background-color: var(--blue-100);
    color: var(--blue-600);
}

.search-card .form-control:focus,
.search-card .form-select:focus {
    border-color: var(--blue-400);
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.15);
    background-color: #ffffff;
}

/* Enhanced Catalog Banner - Same as Dashboard */
.catalog-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 50%, #1e293b 100%);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    margin: -1rem -15px 2rem -15px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(30, 58, 138, 0.15);
}

.catalog-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.6;
}

.catalog-content {
    position: relative;
    z-index: 2;
}

.catalog-title {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.catalog-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.catalog-stats {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-width: 120px;
}

.stat-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #ffffff;
}

.stat-info h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
}

.stat-info p {
    margin: 0;
    opacity: 0.8;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.8);
}

.catalog-illustration {
    position: absolute;
    right: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.1;
    font-size: 4rem;
    color: #ffffff;
}

/* Alert Enhancements */
.alert {
    border-radius: 0.75rem;
    border: none;
    padding: 1rem 1.25rem;
}

.alert-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
}

.alert-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.alert-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
}

/* Pagination Styles */
.pagination-wrapper .pagination {
    background: #ffffff;
    border-radius: 0.75rem;
    padding: 0.5rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
    border: 1px solid var(--blue-100);
}

.pagination-wrapper .page-link {
    border: none;
    color: var(--blue-600);
    padding: 0.75rem 1rem;
    margin: 0 0.25rem;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
    font-weight: 500;
}

.pagination-wrapper .page-link:hover {
    background: var(--blue-100);
    color: var(--blue-700);
    transform: translateY(-1px);
}

.pagination-wrapper .page-item.active .page-link {
    background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: var(--blue-50);
    border-radius: 1rem;
    margin: 2rem 0;
}

.empty-state img {
    max-width: 200px;
    opacity: 0.7;
    margin-bottom: 1.5rem;
}

.empty-state h5 {
    color: var(--blue-600);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--blue-500);
    margin: 0;
}

/* Responsive Improvements */
@media (max-width: 768px) {
    .catalog-banner {
        margin: -1rem -15px 2rem -15px;
        padding: 1.5rem 1rem;
    }

    .catalog-title {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .catalog-subtitle {
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .catalog-stats {
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .stat-item {
        padding: 0.5rem 0.75rem;
        gap: 0.4rem;
        min-width: 100px;
    }

    .stat-icon {
        width: 2rem;
        height: 2rem;
        font-size: 0.9rem;
    }

    .stat-info h4 {
        font-size: 1rem;
    }

    .stat-info p {
        font-size: 0.7rem;
    }

    .catalog-illustration {
        display: none;
    }

    .book-card .card-body {
        padding: 1.25rem;
    }

    .book-card .btn {
        padding: 0.75rem;
        font-size: 0.85rem;
        min-height: 44px;
    }

    .book-card .col-6 .btn {
        min-height: 44px !important;
        max-height: 44px !important;
        font-size: 0.85rem !important;
    }

    .search-card .form-control,
    .search-card .form-select {
        padding: 0.75rem 1rem;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Enhanced Catalog Banner -->
    <div class="catalog-banner">
        <div class="catalog-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="catalog-title">
                        <i class="fas fa-book-open me-3"></i>
                        <?= $title ?>
                    </h2>
                    <p class="catalog-subtitle">
                        Jelajahi koleksi lengkap perpustakaan digital kami dan temukan buku favorit Anda
                    </p>
                    <div class="catalog-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-info">
                                <h4><?= count($books) ?></h4>
                                <p>Buku Tersedia</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-info">
                                <h4><?= count($categories) ?></h4>
                                <p>Kategori</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="stat-info">
                                <h4><?= $active_borrowings_count ?></h4>
                                <p>Dipinjam Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 position-relative">
                    <div class="catalog-illustration">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($active_borrowings_count >= 3): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    Anda telah mencapai batas maksimal peminjaman (3 buku). 
                    <a href="<?= base_url('user/borrowings') ?>" class="alert-link">Kembalikan buku</a> terlebih dahulu untuk dapat meminjam buku lain.
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Search and Filter -->
    <div class="card border-0 shadow-sm mb-4 search-card">
        <div class="card-body">
            <form action="<?= base_url('user/books') ?>" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0 ps-0" 
                                   name="keyword" 
                                   value="<?= $keyword ?>" 
                                   placeholder="Cari judul, penulis, penerbit, atau ISBN...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="category" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= $cat ?>" <?= $category == $cat ? 'selected' : '' ?>>
                                    <?= $cat ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if ($keyword || $category) : ?>
                        <div class="col-md-2">
                            <a href="<?= base_url('user/books') ?>" class="btn btn-light w-100">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Books Grid -->
    <?php if (empty($books)) : ?>
        <div class="text-center py-5">
            <img src="<?= base_url('assets/img/empty.svg') ?>" alt="Empty" class="img-fluid mb-3" style="max-width: 200px;">
            <h5 class="text-muted mb-0">
                <?php if ($keyword || $category) : ?>
                    Tidak ada buku yang sesuai dengan pencarian Anda
                <?php else : ?>
                    Belum ada buku yang tersedia
                <?php endif; ?>
            </h5>
        </div>
    <?php else : ?>
        <div class="row">
            <?php foreach ($books as $book) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="book-card">
                        <div class="cover-container">
                            <?php if ($book['cover_image'] && file_exists('uploads/covers/' . $book['cover_image'])) : ?>
                                <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>"
                                     alt="Cover <?= esc($book['title']) ?>">
                            <?php else : ?>
                                <div class="no-cover">
                                    <i class="fas fa-book"></i>
                                    <div class="fw-semibold"><?= esc($book['title']) ?></div>
                                    <small class="text-muted">No Cover Available</small>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= base_url('user/books/' . $book['id']) ?>">
                                    <?= esc($book['title']) ?>
                                </a>
                            </h5>
                            <p class="author">
                                <i class="fas fa-user me-1"></i> <?= esc($book['author']) ?>
                            </p>
                            <p class="description">
                                <?= substr(esc($book['description']), 0, 150) ?>...
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-column">
                                <span class="badge bg-<?= $book['stock'] > 0 ? 'success' : 'danger' ?>">
                                    <?php if ($book['stock'] > 0): ?>
                                        <i class="fas fa-check-circle me-1"></i> <?= $book['stock'] ?> Buku Tersedia
                                    <?php else: ?>
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis
                                    <?php endif; ?>
                                </span>
                                <div class="row g-2">
                                    <?php if ($book['stock'] > 0): ?>
                                        <?php if ($active_borrowings_count >= 3): ?>
                                            <div class="col-6">
                                                <button class="btn btn-secondary w-100" disabled title="Anda telah mencapai batas maksimal peminjaman">
                                                    <i class="fas fa-book-reader"></i> Pinjam
                                                </button>
                                            </div>
                                        <?php elseif ($book['has_active_borrowing']): ?>
                                            <div class="col-6">
                                                <button class="btn btn-secondary w-100" disabled title="Anda masih memiliki peminjaman aktif untuk buku ini">
                                                    <i class="fas fa-clock"></i> Dipinjam
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-6">
                                                <form action="<?= base_url('user/books/borrow/' . $book['id']) ?>" method="POST" class="w-100 borrow-form">
                                                    <?= csrf_field() ?>
                                                    <button type="button" class="btn btn-success w-100 borrow-btn">
                                                        <i class="fas fa-book-reader"></i> Pinjam
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="col-6">
                                        <a href="<?= base_url('user/books/' . $book['id']) ?>"
                                           class="btn btn-primary w-100">
                                            <i class="fas fa-info-circle"></i> Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($pager) : ?>
            <div class="d-flex justify-content-center mt-5">
                <div class="pagination-wrapper">
                    <?= $pager->links('books', 'bootstrap_pagination') ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    </div> <!-- Close container -->
</div> <!-- Close container-fluid -->
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle borrow buttons in book cards
    const borrowBtns = document.querySelectorAll('.borrow-btn');

    borrowBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('.borrow-form');
            if (form) {
                confirmBorrow('Apakah Anda yakin ingin meminjam buku ini?').then(result => {
                    if (result) {
                        form.submit();
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
