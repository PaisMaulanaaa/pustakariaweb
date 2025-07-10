<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perpustakaan - Selamat Datang</title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            color: #333;
        }
        .navbar {
            background-color: #8B4513 !important;
        }
        .btn-primary {
            background-color: #8B4513;
            border-color: #8B4513;
        }
        .btn-primary:hover {
            background-color: #A0522D;
            border-color: #A0522D;
        }
        .hero {
            background: linear-gradient(rgba(139, 69, 19, 0.8), rgba(139, 69, 19, 0.9)), url('<?= base_url("assets/img/library-bg.jpg") ?>');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        .feature-box {
            padding: 30px;
            text-align: center;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .feature-box:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 40px;
            color: #8B4513;
            margin-bottom: 20px;
        }
        .book-card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .book-card:hover {
            transform: translateY(-5px);
        }
        .footer {
            background-color: #8B4513;
            color: white;
            padding: 50px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-book-reader mr-2"></i>
                Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/register') ?>">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="container">
            <h1 class="display-4 mb-4">Selamat Datang di Perpustakaan</h1>
            <p class="lead mb-5">Temukan ribuan koleksi buku untuk menambah wawasan dan pengetahuan Anda</p>
            <a href="<?= base_url('auth/register') ?>" class="btn btn-light btn-lg">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-book feature-icon"></i>
                        <h4>Koleksi Lengkap</h4>
                        <p>Ribuan koleksi buku dari berbagai kategori tersedia untuk Anda</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-laptop feature-icon"></i>
                        <h4>Sistem Digital</h4>
                        <p>Peminjaman dan pengembalian buku dengan sistem digital yang mudah</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-box">
                        <i class="fas fa-clock feature-icon"></i>
                        <h4>Layanan 24/7</h4>
                        <p>Akses katalog buku kapan saja dan di mana saja</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Books Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Buku Terbaru</h2>
            <div class="row">
                <?php foreach ($latest_books as $book): ?>
                <div class="col-md-3 mb-4">
                    <div class="card book-card h-100">
                        <?php if ($book['cover']): ?>
                            <img src="<?= base_url('uploads/covers/' . $book['cover']) ?>" 
                                 class="card-img-top" alt="<?= $book['title'] ?>"
                                 style="height: 250px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?= base_url('assets/img/book-cover-placeholder.jpg') ?>" 
                                 class="card-img-top" alt="No Cover"
                                 style="height: 250px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= $book['title'] ?></h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> <?= $book['author'] ?>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Tentang Kami</h5>
                    <p>Perpustakaan kami berkomitmen untuk menyediakan akses ke pengetahuan dan pembelajaran sepanjang hayat bagi semua anggota masyarakat.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Jam Operasional</h5>
                    <ul class="list-unstyled">
                        <li>Senin - Jumat: 08:00 - 16:00</li>
                        <li>Sabtu: 09:00 - 14:00</li>
                        <li>Minggu: Tutup</li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt mr-2"></i> Jl. Perpustakaan No. 123</li>
                        <li><i class="fas fa-phone mr-2"></i> (021) 123-4567</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@perpustakaan.com</li>
                    </ul>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p class="mb-0">Copyright &copy; Perpustakaan <?= date('Y') ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html> 