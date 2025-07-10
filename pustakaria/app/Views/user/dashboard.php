<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Enhanced Welcome Banner -->
    <div class="welcome-banner mb-5">
        <div class="welcome-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="welcome-text">
                        <h2 class="welcome-title">
                            <i class="fas fa-book-reader me-3"></i>
                            Selamat Datang, <?= session()->get('fullname') ?>!
                        </h2>
                        <p class="welcome-subtitle">
                            Jelajahi koleksi buku digital kami dan temukan pengetahuan baru untuk memperkaya wawasan Anda
                        </p>
                        <div class="welcome-actions mt-4">
                            <a href="<?= base_url('user/books') ?>" class="btn btn-welcome-primary me-3">
                                <i class="fas fa-search me-2"></i>Jelajahi Buku
                            </a>
                            <a href="<?= base_url('user/borrowings') ?>" class="btn btn-welcome-secondary">
                                <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="welcome-illustration">
                        <div class="floating-books">
                            <i class="fas fa-book book-1"></i>
                            <i class="fas fa-book-open book-2"></i>
                            <i class="fas fa-graduation-cap book-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="welcome-overlay"></div>
    </div>

    <div class="container py-4">

    <!-- Statistics Cards -->
    <div class="row statistics-row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Total Buku Dipinjam</div>
                            <div class="fs-4 fw-bold"><?= $total_borrowed ?></div>
                            <div class="small text-success mt-1">
                                <i class="fas fa-chart-line me-1"></i>
                                <span>Riwayat lengkap</span>
                            </div>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Sedang Dipinjam</div>
                            <div class="fs-4 fw-bold"><?= $current_borrowed ?></div>
                            <div class="small text-warning mt-1">
                                <i class="fas fa-clock me-1"></i>
                                <span>Aktif sekarang</span>
                            </div>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="fas fa-book-reader"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card-enhanced">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small fw-semibold">Sisa Kuota Peminjaman</div>
                            <div class="fs-4 fw-bold"><?= 3 - $current_borrowed ?></div>
                            <div class="small text-info mt-1">
                                <i class="fas fa-layer-group me-1"></i>
                                <span>Dari 3 maksimal</span>
                            </div>
                        </div>
                        <div class="fs-1 text-info">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Borrowings -->
    <?php if (!empty($active_borrowings)) : ?>
    <div class="section-card mb-5">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="section-title">
                <h4 class="mb-1">Peminjaman Aktif</h4>
                <p class="text-muted mb-0">Buku yang sedang Anda pinjam</p>
            </div>
            <div class="section-badge">
                <span class="badge bg-primary"><?= count($active_borrowings) ?> Buku</span>
            </div>
        </div>
        <div class="section-content">
            <div class="row">
                <?php foreach ($active_borrowings as $borrowing) : ?>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="borrowing-card">
                        <div class="borrowing-cover">
                            <?php if (isset($borrowing['cover_image']) && $borrowing['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $borrowing['cover_image'])) : ?>
                                <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>"
                                     alt="Cover <?= esc($borrowing['book_title']) ?>">
                            <?php else : ?>
                                <div class="no-cover-borrowing">
                                    <i class="fas fa-book"></i>
                                    <span>No Cover</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="borrowing-info">
                            <h6 class="borrowing-title"><?= esc($borrowing['book_title']) ?></h6>
                            <p class="borrowing-author">
                                <i class="fas fa-user me-1"></i>
                                <?= esc($borrowing['author'] ?? 'Unknown Author') ?>
                            </p>
                            <?php
                            $dueDate = strtotime($borrowing['due_date']);
                            $today = strtotime('today');
                            $daysLeft = ceil(($dueDate - $today) / (60 * 60 * 24));

                            if ($daysLeft > 0) {
                                $statusClass = $daysLeft <= 2 ? 'warning' : 'success';
                                $statusIcon = $daysLeft <= 2 ? 'fa-exclamation-triangle' : 'fa-check-circle';
                                $message = "Sisa {$daysLeft} hari";
                            } else {
                                $statusClass = 'danger';
                                $statusIcon = 'fa-times-circle';
                                $message = "Terlambat " . abs($daysLeft) . " hari";
                            }
                            ?>
                            <div class="borrowing-status status-<?= $statusClass ?>">
                                <i class="fas <?= $statusIcon ?> me-2"></i>
                                <span><?= $message ?></span>
                            </div>
                            <div class="borrowing-date">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Kembali: <?= date('d M Y', strtotime($borrowing['due_date'])) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <!-- Recommendations -->
        <div class="col-lg-6 mb-4">
            <div class="section-card h-100">
                <div class="section-header">
                    <div class="section-icon bg-warning">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="mb-1">Rekomendasi untuk Anda</h5>
                        <p class="text-muted mb-0">Buku yang mungkin Anda sukai</p>
                    </div>
                </div>
                <div class="section-content">
                    <?php if (empty($recommendations)) : ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h6 class="empty-title">Belum Ada Rekomendasi</h6>
                            <p class="empty-text">Mulai meminjam buku untuk mendapatkan rekomendasi personal</p>
                            <a href="<?= base_url('user/books') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-search me-1"></i>Jelajahi Buku
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="recommendation-list">
                            <?php foreach ($recommendations as $book) : ?>
                                <div class="recommendation-item" onclick="window.location.href='<?= base_url('user/books/' . $book['id']) ?>'">
                                    <div class="recommendation-cover">
                                        <?php if (isset($book['cover_image']) && $book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])) : ?>
                                            <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>"
                                                 alt="Cover <?= esc($book['title']) ?>">
                                        <?php else : ?>
                                            <div class="no-cover-small">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="recommendation-info">
                                        <h6 class="recommendation-title">
                                            <a href="<?= base_url('user/books/' . $book['id']) ?>" onclick="event.stopPropagation();">
                                                <?= esc($book['title']) ?>
                                            </a>
                                        </h6>
                                        <p class="recommendation-author">
                                            <i class="fas fa-user me-1"></i> <?= esc($book['author']) ?>
                                        </p>
                                        <div class="recommendation-meta">
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i><?= $book['stock'] ?> tersedia
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Latest Books -->
        <div class="col-lg-6 mb-4">
            <div class="section-card h-100">
                <div class="section-header">
                    <div class="section-icon bg-info">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="section-title">
                        <h5 class="mb-1">Buku Terbaru</h5>
                        <p class="text-muted mb-0">Koleksi terbaru di perpustakaan</p>
                    </div>
                </div>
                <div class="section-content">
                    <?php if (empty($latest_books)) : ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h6 class="empty-title">Belum Ada Buku Terbaru</h6>
                            <p class="empty-text">Koleksi buku terbaru akan muncul di sini</p>
                        </div>
                    <?php else : ?>
                        <div class="latest-list">
                            <?php foreach ($latest_books as $book) : ?>
                                <div class="latest-item" onclick="window.location.href='<?= base_url('user/books/' . $book['id']) ?>'">
                                    <div class="latest-cover">
                                        <?php if (isset($book['cover_image']) && $book['cover_image'] && file_exists(FCPATH . 'uploads/covers/' . $book['cover_image'])) : ?>
                                            <img src="<?= base_url('uploads/covers/' . $book['cover_image']) ?>"
                                                 alt="Cover <?= esc($book['title']) ?>">
                                        <?php else : ?>
                                            <div class="no-cover-small">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="latest-info">
                                        <h6 class="latest-title">
                                            <a href="<?= base_url('user/books/' . $book['id']) ?>" onclick="event.stopPropagation();">
                                                <?= esc($book['title']) ?>
                                            </a>
                                        </h6>
                                        <p class="latest-author">
                                            <i class="fas fa-user me-1"></i> <?= esc($book['author']) ?>
                                        </p>
                                        <div class="latest-meta">
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($book['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- Close container -->
</div> <!-- Close container-fluid -->
</div>

<?= $this->section('styles') ?>
<style>
/* Enhanced Welcome Banner */
.welcome-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 50%, #1e293b 100%);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    margin: -1rem -15px 0 -15px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(30, 58, 138, 0.15);
}

.welcome-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.03)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.6;
}

.welcome-content {
    position: relative;
    z-index: 2;
}

.welcome-title {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.welcome-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 0;
}

.welcome-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1.25rem;
}

.btn-welcome-primary {
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    color: #1e3a8a;
    border: none;
    padding: 0.625rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(255, 255, 255, 0.2);
}

.btn-welcome-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
    color: #0f172a;
}

.btn-welcome-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.3);
    padding: 0.625rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-welcome-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-1px);
    color: #ffffff;
}

.floating-books {
    position: relative;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-books i {
    position: absolute;
    color: rgba(255, 255, 255, 0.25);
    animation: float 6s ease-in-out infinite;
}

.book-1 {
    font-size: 2rem;
    top: 20%;
    left: 20%;
    animation-delay: 0s;
}

.book-2 {
    font-size: 1.75rem;
    top: 50%;
    right: 30%;
    animation-delay: 2s;
}

.book-3 {
    font-size: 1.5rem;
    bottom: 20%;
    left: 50%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

/* Section Cards */
.section-card {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.section-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
}

.section-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
    border-bottom: 1px solid var(--blue-100);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.section-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--blue-500);
    color: #ffffff;
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.section-icon.bg-warning {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
}

.section-icon.bg-info {
    background: linear-gradient(135deg, #06b6d4, #0891b2);
    box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
}

.section-title h4,
.section-title h5 {
    color: var(--blue-900);
    font-weight: 600;
    margin: 0;
}

.section-badge {
    margin-left: auto;
}

.section-content {
    padding: 1.5rem;
}

/* Borrowing Cards */
.borrowing-card {
    background: #ffffff;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.08);
    border: 1px solid rgba(59, 130, 246, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.borrowing-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(59, 130, 246, 0.15);
}

.borrowing-cover {
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
    display: flex;
    align-items: center;
    justify-content: center;
}

.borrowing-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.borrowing-card:hover .borrowing-cover img {
    transform: scale(1.05);
}

.no-cover-borrowing {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: var(--blue-400);
    font-size: 0.9rem;
}

.no-cover-borrowing i {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    opacity: 0.6;
}

.borrowing-info {
    padding: 1.25rem;
}

.borrowing-title {
    color: var(--blue-900);
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.borrowing-author {
    color: var(--blue-600);
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.borrowing-status {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    display: inline-flex;
    align-items: center;
}

.status-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 1px solid #10b981;
}

.status-warning {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #f59e0b;
}

.status-danger {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #ef4444;
}

.borrowing-date {
    margin-top: 0.5rem;
}

/* Recommendation & Latest Items */
.recommendation-list,
.latest-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.recommendation-item,
.latest-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--blue-50);
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    border: 1px solid var(--blue-100);
    position: relative;
    cursor: pointer;
}

.recommendation-item:hover,
.latest-item:hover {
    background: var(--blue-100);
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
}

.recommendation-cover,
.latest-cover {
    width: 60px;
    height: 80px;
    border-radius: 0.5rem;
    overflow: hidden;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--blue-100), var(--blue-200));
    display: flex;
    align-items: center;
    justify-content: center;
}

.recommendation-cover img,
.latest-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-cover-small {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: var(--blue-400);
    font-size: 0.8rem;
}

.no-cover-small i {
    font-size: 1.5rem;
    margin-bottom: 0.25rem;
}

.recommendation-info,
.latest-info {
    flex: 1;
    min-width: 0;
}

.recommendation-title,
.latest-title {
    margin-bottom: 0.25rem;
    font-weight: 600;
    line-height: 1.3;
}

.recommendation-title a,
.latest-title a {
    color: var(--blue-900);
    text-decoration: none;
    transition: color 0.3s ease;
    position: relative;
    z-index: 10;
    display: block;
    font-weight: 600;
}

.recommendation-title a:hover,
.latest-title a:hover {
    color: var(--blue-600);
    text-decoration: underline;
}

.recommendation-title a:focus,
.latest-title a:focus {
    outline: 2px solid var(--blue-500);
    outline-offset: 2px;
    border-radius: 0.25rem;
}

.recommendation-author,
.latest-author {
    color: var(--blue-600);
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
}

.recommendation-meta,
.latest-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--blue-600);
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue-100), var(--blue-200));
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: var(--blue-500);
}

.empty-title {
    color: var(--blue-700);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-text {
    color: var(--blue-500);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-banner {
        margin: -1rem -15px 0 -15px;
        padding: 1.5rem 1rem;
    }

    .welcome-title {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .welcome-actions {
        flex-direction: column;
        align-items: stretch;
        margin-top: 1rem;
        gap: 0.5rem;
    }

    .btn-welcome-primary,
    .btn-welcome-secondary {
        text-align: center;
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
    }

    .floating-books {
        height: 80px;
    }

    .book-1, .book-2, .book-3 {
        font-size: 1.25rem;
    }

    .section-header {
        padding: 1rem;
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }

    .section-content {
        padding: 1rem;
    }

    .recommendation-item,
    .latest-item {
        padding: 0.75rem;
    }

    .recommendation-cover,
    .latest-cover {
        width: 50px;
        height: 65px;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
