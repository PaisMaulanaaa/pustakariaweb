<?= $this->extend('layout/user_layout') ?>

<?= $this->section('styles') ?>
<style>
:root {
    --blue-50: #eff6ff;
    --blue-100: #dbeafe;
    --blue-200: #bfdbfe;
    --blue-300: #93c5fd;
    --blue-400: #60a5fa;
    --blue-500: #3b82f6;
    --blue-600: #2563eb;
    --blue-700: #1d4ed8;
    --blue-800: #1e40af;
    --blue-900: #1e3a8a;
}

/* Page Header */
.page-header-stats {
    display: flex;
    gap: 2rem;
    align-items: center;
}

.stat-counter {
    text-align: center;
    padding: 0.5rem;
}

.stat-counter .number {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.stat-counter .label {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
}

/* Enhanced Cards */
.borrowing-card {
    background: #ffffff;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(59, 130, 246, 0.1);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.borrowing-card:hover {
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
    transform: translateY(-2px);
}

.borrowing-card .card-header {
    background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
    border-bottom: 1px solid var(--blue-200);
    padding: 1.5rem;
    border-radius: 0;
}

.borrowing-card .card-header h6 {
    color: var(--blue-700);
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.borrowing-card .card-body {
    padding: 1.5rem;
}

/* Enhanced Table */
.table-enhanced {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--blue-100);
}

.table-enhanced thead th {
    background: var(--blue-600);
    color: #ffffff;
    font-weight: 600;
    border: none;
    padding: 1rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-enhanced tbody td {
    padding: 1rem;
    border-color: var(--blue-100);
    vertical-align: middle;
    color: #374151;
}

.table-enhanced tbody td strong {
    color: #1f2937;
    font-weight: 600;
}

.table-enhanced tbody tr:hover {
    background: var(--blue-50);
}

/* Enhanced Badges */
.badge-enhanced {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-success-enhanced {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
}

.badge-danger-enhanced {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #ffffff;
}

.badge-warning-enhanced {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #ffffff;
}

.badge-info-enhanced {
    background: linear-gradient(135deg, var(--blue-500), var(--blue-600));
    color: #ffffff;
}

/* Enhanced Buttons */
.btn-enhanced {
    border-radius: 0.5rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-success-enhanced {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #ffffff;
}

.btn-success-enhanced:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-warning-enhanced {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #ffffff;
}

.btn-warning-enhanced:hover {
    background: linear-gradient(135deg, #d97706, #b45309);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-danger-enhanced {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #ffffff;
}

.btn-danger-enhanced:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--blue-500);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h5 {
    color: var(--blue-600);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--blue-500);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header-stats {
        gap: 1rem;
        flex-wrap: wrap;
    }

    .stat-counter .number {
        font-size: 1.25rem;
    }

    .stat-counter .label {
        font-size: 0.7rem;
    }

    .borrowing-card .card-header,
    .borrowing-card .card-body {
        padding: 1rem;
    }

    .table-enhanced thead th,
    .table-enhanced tbody td {
        padding: 0.75rem 0.5rem;
        font-size: 0.85rem;
    }

    .btn-enhanced {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .d-flex.align-items-center.justify-content-between {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }

    .d-flex.gap-3 {
        align-self: stretch;
        justify-content: space-around;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark fw-bold">
                <i class="fas fa-history me-2 text-primary"></i>
                <?= $title ?>
            </h1>
            <p class="text-muted mb-0">Kelola peminjaman buku Anda dengan mudah</p>
        </div>
        <div class="d-flex gap-3">
            <div class="text-center">
                <div class="fw-bold text-primary fs-4"><?= count($active_borrowings) ?></div>
                <small class="text-muted">Aktif</small>
            </div>
            <div class="text-center">
                <div class="fw-bold text-danger fs-4"><?= count($overdue_borrowings ?? []) ?></div>
                <small class="text-muted">Terlambat</small>
            </div>
            <div class="text-center">
                <div class="fw-bold text-success fs-4"><?= count($borrowings) ?></div>
                <small class="text-muted">Total</small>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Active Borrowings Card -->
    <div class="borrowing-card">
        <div class="card-header">
            <h6>
                <i class="fas fa-book-open"></i>
                Peminjaman Aktif
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($active_borrowings)) : ?>
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h5>Tidak Ada Peminjaman Aktif</h5>
                    <p>Anda belum memiliki peminjaman buku yang aktif saat ini</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-enhanced">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($active_borrowings as $borrowing) : ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($borrowing['book_title']) ?></strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-clock me-1"></i>
                                        <?= date('d/m/Y', strtotime($borrowing['due_date'])) ?>
                                        <?php if (strtotime($borrowing['due_date']) < time()) : ?>
                                            <br><span class="badge badge-danger-enhanced">Terlambat</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($borrowing['status'] == 'borrowed') : ?>
                                            <span class="badge badge-info-enhanced">Dipinjam</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <?php if (!$borrowing['extended'] && strtotime($borrowing['due_date']) > time()) : ?>
                                                <form action="<?= base_url('user/borrowings/extend/' . $borrowing['id']) ?>"
                                                      method="POST" style="display: inline-block;" class="extend-form">
                                                    <?= csrf_field() ?>
                                                    <button type="button" class="btn btn-warning-enhanced btn-enhanced extend-btn">
                                                        <i class="fas fa-clock me-1"></i> Perpanjang
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?= base_url('user/borrowings/return/' . $borrowing['id']) ?>"
                                                  method="POST" style="display: inline-block;" class="return-form">
                                                <?= csrf_field() ?>
                                                <button type="button" class="btn btn-success-enhanced btn-enhanced return-btn">
                                                    <i class="fas fa-undo me-1"></i> Kembalikan
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Overdue Borrowings Card -->
    <?php if (!empty($overdue_borrowings)) : ?>
    <div class="borrowing-card" style="border-left: 4px solid #ef4444;">
        <div class="card-header" style="background: linear-gradient(135deg, #fef2f2, #fee2e2);">
            <h6 style="color: #dc2626;">
                <i class="fas fa-exclamation-triangle"></i>
                Peminjaman Terlambat
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-enhanced">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Keterlambatan</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdue_borrowings as $borrowing) : ?>
                            <tr>
                                <td>
                                    <strong><?= esc($borrowing['book_title']) ?></strong>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?>
                                </td>
                                <td>
                                    <i class="fas fa-clock me-1"></i>
                                    <?= date('d/m/Y', strtotime($borrowing['due_date'])) ?>
                                </td>
                                <td>
                                    <span class="badge badge-danger-enhanced">
                                        <i class="fas fa-exclamation-circle me-1"></i>
                                        <?php
                                        $days = ceil((time() - strtotime($borrowing['due_date'])) / (60 * 60 * 24));
                                        echo $days . ' hari';
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($borrowing['fine_amount'] > 0) : ?>
                                        <div>
                                            <strong>Rp <?= number_format($borrowing['fine_amount'], 0, ',', '.') ?></strong>
                                            <br>
                                            <?php if ($borrowing['fine_paid']) : ?>
                                                <span class="badge badge-success-enhanced">Lunas</span>
                                            <?php else : ?>
                                                <span class="badge badge-danger-enhanced">Belum Lunas</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($borrowing['fine_amount'] > 0 && !$borrowing['fine_paid']) : ?>
                                        <a href="<?= base_url('user/borrowings/payFine/' . $borrowing['id']) ?>"
                                           class="btn btn-warning-enhanced btn-enhanced"
                                           onclick="return confirm('Apakah Anda yakin ingin membayar denda?')">
                                            <i class="fas fa-credit-card me-1"></i> Bayar Denda
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Borrowing History Card -->
    <div class="borrowing-card">
        <div class="card-header">
            <h6>
                <i class="fas fa-history"></i>
                Riwayat Peminjaman
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($borrowings)) : ?>
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <h5>Belum Ada Riwayat Peminjaman</h5>
                    <p>Anda belum pernah melakukan peminjaman buku sebelumnya</p>
                </div>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-enhanced" id="borrowingHistory">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($borrowings as $borrowing) : ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($borrowing['book_title']) ?></strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?= date('d/m/Y', strtotime($borrowing['borrow_date'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($borrowing['return_date']) : ?>
                                            <i class="fas fa-calendar-check me-1"></i>
                                            <?= date('d/m/Y', strtotime($borrowing['return_date'])) ?>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($borrowing['status'] == 'borrowed') : ?>
                                            <span class="badge badge-info-enhanced">Dipinjam</span>
                                        <?php elseif ($borrowing['status'] == 'returned') : ?>
                                            <span class="badge badge-success-enhanced">Dikembalikan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($borrowing['fine_amount'] > 0) : ?>
                                            <div>
                                                <strong>Rp <?= number_format($borrowing['fine_amount'], 0, ',', '.') ?></strong>
                                                <br>
                                                <?php if ($borrowing['fine_paid'] >= $borrowing['fine_amount']) : ?>
                                                    <span class="badge badge-success-enhanced">Lunas</span>
                                                <?php else : ?>
                                                    <span class="badge badge-danger-enhanced">Belum Lunas</span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else : ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
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

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable for borrowing history
    if ($.fn.DataTable) {
        $('#borrowingHistory').DataTable({
            "order": [[1, "desc"]],
            "pageLength": 10,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "columnDefs": [
                { "orderable": false, "targets": [3, 4] }
            ]
        });
    }

    // Enhanced tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Handle return and extend buttons
    const returnBtns = document.querySelectorAll('.return-btn');
    const extendBtns = document.querySelectorAll('.extend-btn');

    returnBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('.return-form');
            if (form) {
                confirmReturn('Apakah Anda yakin ingin mengembalikan buku ini?').then(result => {
                    if (result) {
                        form.submit();
                    }
                });
            }
        });
    });

    extendBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const form = this.closest('.extend-form');
            if (form) {
                confirmExtend('Apakah Anda yakin ingin memperpanjang peminjaman ini?').then(result => {
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

<?= $this->endSection() ?>