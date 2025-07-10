<?= $this->extend('layout/user_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
    </div>

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



    <!-- Active Borrowings -->
    <?php if (!empty($active_borrowings)) : ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0">
                <div class="d-flex align-items-center">
                    <i class="fas fa-clock text-primary me-2"></i>
                    <h5 class="mb-0">Peminjaman Aktif</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($active_borrowings as $borrowing) : ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 book-card border-0 shadow-hover">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <?php if ($borrowing['cover_image'] && file_exists('uploads/covers/' . $borrowing['cover_image'])) : ?>
                                            <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>" 
                                                 class="img-fluid rounded-start h-100 w-100 object-fit-cover" 
                                                 alt="Cover <?= esc($borrowing['book_title']) ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                                                 class="img-fluid rounded-start h-100 w-100 object-fit-cover" 
                                                 alt="No Cover">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h6 class="card-title text-truncate mb-1">
                                                <?= esc($borrowing['book_title']) ?>
                                            </h6>
                                            <div class="text-muted small mb-2">
                                                <div><i class="fas fa-calendar-alt me-1"></i> Dipinjam: <?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></div>
                                                <div><i class="fas fa-calendar-check me-1"></i> Jatuh Tempo: <?= date('d/m/Y', strtotime($borrowing['due_date'])) ?></div>
                                            </div>
                                            <?php
                                            $dueDate = strtotime($borrowing['due_date']);
                                            $today = strtotime('today');
                                            $daysLeft = ceil(($dueDate - $today) / (60 * 60 * 24));
                                            
                                            if ($daysLeft > 0) {
                                                $alertClass = $daysLeft <= 2 ? 'warning' : 'info';
                                                $message = "Sisa {$daysLeft} hari";
                                            } else {
                                                $alertClass = 'danger';
                                                $message = "Terlambat " . abs($daysLeft) . " hari";
                                            }
                                            ?>
                                            <div class="mb-2">
                                                <span class="badge bg-<?= $alertClass ?> rounded-pill">
                                                    <i class="fas fa-clock me-1"></i> <?= $message ?>
                                                </span>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <a href="<?= base_url('user/books/' . $borrowing['book_id']) ?>"
                                                   class="btn btn-sm btn-outline-primary flex-fill">
                                                    <i class="fas fa-info-circle"></i> Detail
                                                </a>
                                                <?php if ($daysLeft > 0): ?>
                                                <form action="<?= base_url('user/borrowings/extend/' . $borrowing['id']) ?>"
                                                      method="POST" class="flex-fill extend-form-simple">
                                                    <?= csrf_field() ?>
                                                    <button type="button" class="btn btn-sm btn-warning w-100 extend-btn-simple">
                                                        <i class="fas fa-calendar-plus"></i> Perpanjang
                                                    </button>
                                                </form>
                                                <?php endif; ?>
                                                <form action="<?= base_url('user/borrowings/return/' . $borrowing['id']) ?>"
                                                      method="POST" class="flex-fill return-form-simple">
                                                    <?= csrf_field() ?>
                                                    <button type="button" class="btn btn-sm btn-success w-100 return-btn-simple">
                                                        <i class="fas fa-undo"></i> Kembalikan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Borrowing History -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex align-items-center">
                <i class="fas fa-history text-primary me-2"></i>
                <h5 class="mb-0">Riwayat Peminjaman</h5>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($borrowing_history)) : ?>
                <div class="text-center py-5">
                    <img src="<?= base_url('assets/img/empty.svg') ?>" alt="Empty" class="img-fluid mb-3" style="max-width: 200px;">
                    <h6 class="text-muted">Belum ada riwayat peminjaman</h6>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borrowing_history as $borrowing) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="book-cover-small me-3">
                                                <?php if ($borrowing['cover_image'] && file_exists('uploads/covers/' . $borrowing['cover_image'])) : ?>
                                                    <img src="<?= base_url('uploads/covers/' . $borrowing['cover_image']) ?>" 
                                                         alt="Cover <?= esc($borrowing['book_title']) ?>">
                                                <?php else : ?>
                                                    <img src="<?= base_url('assets/img/no-cover.png') ?>" 
                                                         alt="No Cover">
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <h6 class="mb-0"><?= esc($borrowing['book_title']) ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?></td>
                                    <td><?= $borrowing['return_date'] ? date('d/m/Y', strtotime($borrowing['return_date'])) : '-' ?></td>
                                    <td>
                                        <span class="badge bg-<?= $borrowing['status'] == 'returned' ? 'success' : 'warning' ?> rounded-pill">
                                            <?= $borrowing['status'] == 'returned' ? 'Dikembalikan' : 'Dipinjam' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($borrowing['fine_amount'] > 0) : ?>
                                            <span class="badge bg-danger rounded-pill">
                                                Rp <?= number_format($borrowing['fine_amount'], 0, ',', '.') ?>
                                            </span>
                                        <?php else : ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('user/books/' . $borrowing['book_id']) ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->section('styles') ?>
<style>
.book-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
    overflow: hidden;
}

.book-card:hover {
    transform: translateY(-5px);
}

.shadow-hover {
    transition: box-shadow 0.3s ease;
}

.shadow-hover:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}

.object-fit-cover {
    object-fit: cover;
}

.book-cover-small {
    width: 48px;
    height: 48px;
    border-radius: 0.5rem;
    overflow: hidden;
}

.book-cover-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}

.table thead th {
    background-color: #f8f9fa !important;
    color: #495057 !important;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.table tbody td {
    color: #374151 !important;
    border-color: #e5e7eb;
}

.table tbody td strong {
    color: #1f2937 !important;
    font-weight: 600;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: #f8fafc !important;
}

.badge {
    padding: 0.5rem 1rem;
}

.btn-sm {
    border-radius: 0.5rem;
}

.card {
    border-radius: 1rem;
}

.card-header {
    padding: 1.5rem;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Simple form submission handler
document.addEventListener('DOMContentLoaded', function() {
    // Handle extend buttons
    const extendBtns = document.querySelectorAll('.extend-btn-simple');
    extendBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('.extend-form-simple');
            if (form) {
                confirmExtend('Yakin ingin memperpanjang peminjaman?').then(result => {
                    if (result) {
                        form.submit();
                    }
                });
            }
        });
    });

    // Handle return buttons
    const returnBtns = document.querySelectorAll('.return-btn-simple');
    returnBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('.return-form-simple');
            if (form) {
                confirmReturn('Yakin ingin mengembalikan buku ini?').then(result => {
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