<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><?= $title ?></h3>
                        <a href="<?= base_url('admin/books') ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/books/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul Buku</label>
                                    <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" 
                                           id="title" name="title" value="<?= old('title') ?>">
                                    <?php if (session('errors.title')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.title') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="author" class="form-label">Penulis</label>
                                            <input type="text" class="form-control <?= session('errors.author') ? 'is-invalid' : '' ?>" 
                                                   id="author" name="author" value="<?= old('author') ?>">
                                            <?php if (session('errors.author')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.author') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="publisher" class="form-label">Penerbit</label>
                                            <input type="text" class="form-control <?= session('errors.publisher') ? 'is-invalid' : '' ?>" 
                                                   id="publisher" name="publisher" value="<?= old('publisher') ?>">
                                            <?php if (session('errors.publisher')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.publisher') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="year" class="form-label">Tahun Terbit</label>
                                            <input type="number" class="form-control <?= session('errors.year') ? 'is-invalid' : '' ?>" 
                                                   id="year" name="year" value="<?= old('year') ?>" min="1900" max="<?= date('Y') ?>">
                                            <?php if (session('errors.year')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.year') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="isbn" class="form-label">ISBN</label>
                                            <input type="text" class="form-control <?= session('errors.isbn') ? 'is-invalid' : '' ?>" 
                                                   id="isbn" name="isbn" value="<?= old('isbn') ?>">
                                            <?php if (session('errors.isbn')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.isbn') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stok</label>
                                            <input type="number" class="form-control <?= session('errors.stock') ? 'is-invalid' : '' ?>" 
                                                   id="stock" name="stock" value="<?= old('stock', 1) ?>" min="1">
                                            <?php if (session('errors.stock')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= session('errors.stock') ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select <?= session('errors.category') ? 'is-invalid' : '' ?>" 
                                            id="category" name="category">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Fiksi" <?= old('category') == 'Fiksi' ? 'selected' : '' ?>>Fiksi</option>
                                        <option value="Non-Fiksi" <?= old('category') == 'Non-Fiksi' ? 'selected' : '' ?>>Non-Fiksi</option>
                                        <option value="Pendidikan" <?= old('category') == 'Pendidikan' ? 'selected' : '' ?>>Pendidikan</option>
                                        <option value="Teknologi" <?= old('category') == 'Teknologi' ? 'selected' : '' ?>>Teknologi</option>
                                        <option value="Bisnis" <?= old('category') == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
                                        <option value="Agama" <?= old('category') == 'Agama' ? 'selected' : '' ?>>Agama</option>
                                        <option value="Anak-anak" <?= old('category') == 'Anak-anak' ? 'selected' : '' ?>>Anak-anak</option>
                                        <option value="Lainnya" <?= old('category') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                    </select>
                                    <?php if (session('errors.category')) : ?>
                                        <div class="invalid-feedback">
                                            <?= session('errors.category') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cover_image" class="form-label fw-bold mb-3">Cover Buku</label>

                                    <!-- Preview Image -->
                                    <div class="text-center mb-4">
                                        <div class="cover-preview-container">
                                            <img id="coverPreview"
                                                 src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjI4MCIgdmlld0JveD0iMCAwIDIwMCAyODAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjgwIiBmaWxsPSIjZjhmOWZhIiBzdHJva2U9IiNkZWUyZTYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWRhc2hhcnJheT0iOCA4Ii8+Cjx0ZXh0IHg9IjEwMCIgeT0iMTMwIiBmb250LWZhbWlseT0iQXJpYWwsIHNhbnMtc2VyaWYiIGZvbnQtc2l6ZT0iMTYiIGZpbGw9IiM2Yzc1N2QiIHRleHQtYW5jaG9yPSJtaWRkbGUiPkNvdmVyIEJ1a3U8L3RleHQ+CjxjaXJjbGUgY3g9IjEwMCIgY3k9IjE2MCIgcj0iMjAiIGZpbGw9IiNkZWUyZTYiLz4KPHN2ZyB4PSI5MCIgeT0iMTUwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iIzZjNzU3ZCI+CjxwYXRoIGQ9Ik0xOCA0VjNjMC0uNTUtLjQ1LTEtMS0xSDVjLS41NSAwLTEgLjQ1LTEgMXYxSDJjLS41NSAwLTEgLjQ1LTEgMXMuNDUgMSAxIDFoMXYxM2MwIDEuMS45IDIgMiAyaDEyYzEuMSAwIDItLjkgMi0yVjZoMWMuNTUgMCAxLS40NSAxLTFzLS40NS0xLTEtMWgtMnpNNiA2aDEydjEySDZWNnptMi0yaDh2MUg4VjR6Ii8+Cjwvc3ZnPgo8dGV4dCB4PSIxMDAiIHk9IjIwMCIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjEyIiBmaWxsPSIjNmM3NTdkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIj5QaWxpaCBmaWxlIHVudHVrIHVwbG9hZDwvdGV4dD4KPC9zdmc+"
                                                 alt="Cover Preview"
                                                 class="cover-preview-image">
                                        </div>
                                    </div>

                                    <!-- File Input -->
                                    <div class="mb-3">
                                        <input type="file"
                                               class="form-control <?= session('errors.cover_image') ? 'is-invalid' : '' ?>"
                                               id="cover_image"
                                               name="cover_image"
                                               accept="image/*"
                                               onchange="previewCover()"
                                               required>
                                        <?php if (session('errors.cover_image')) : ?>
                                            <div class="invalid-feedback">
                                                <?= session('errors.cover_image') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- File Info Display -->
                                    <div id="fileInfo" class="mb-3" style="display: none;">
                                        <div class="d-flex align-items-center p-2 bg-primary bg-opacity-10 border border-primary rounded">
                                            <i class="fas fa-check-circle text-primary me-2"></i>
                                            <div class="flex-grow-1">
                                                <small class="text-primary fw-semibold" id="fileName"></small><br>
                                                <small class="text-muted" id="fileSize"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Help Text -->
                                    <div class="help-text">
                                        <div class="p-3 bg-light border rounded">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-file-image text-primary me-1"></i>
                                                        <strong>Format:</strong><br>
                                                        JPG, PNG, GIF, WEBP
                                                    </small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">
                                                        <i class="fas fa-weight-hanging text-warning me-1"></i>
                                                        <strong>Maksimal:</strong><br>
                                                        5MB
                                                    </small>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-exclamation-circle text-danger me-1"></i>
                                                        <strong>Wajib:</strong> Cover buku harus diupload
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<style>
/* Cover Upload Styling */
.cover-preview-container {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.cover-preview-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.cover-preview-image {
    width: 200px;
    height: 280px;
    object-fit: cover;
    border: none;
    display: block;
}

/* File Input Styling */
.form-control[type="file"] {
    padding: 12px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    background-color: #f8f9fa;
    transition: all 0.3s ease;
}

.form-control[type="file"]:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    background-color: #fff;
}

.form-control[type="file"]::-webkit-file-upload-button {
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    margin-right: 12px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

.form-control[type="file"]::-webkit-file-upload-button:hover {
    background: linear-gradient(135deg, #0b5ed7, #0a58ca);
    transform: translateY(-1px);
}

/* Info Cards */
#fileInfo {
    transition: all 0.3s ease;
}

#fileInfo:hover {
    transform: translateY(-1px);
}

/* Help Text Styling */
.help-text .bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef !important;
}

.help-text i {
    width: 16px;
    text-align: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .cover-preview-image {
        width: 160px;
        height: 224px;
    }
}
</style>

<script>
function previewCover() {
    const cover = document.querySelector('#cover_image');
    const coverPreview = document.querySelector('#coverPreview');
    const file = cover.files[0];

    if (file) {
        // Validasi ukuran file (5MB = 5242880 bytes)
        const maxSize = 5242880; // 5MB
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Terlalu Besar',
                text: 'Ukuran file maksimal 5MB. Silakan pilih file yang lebih kecil.',
                confirmButtonColor: '#3085d6'
            });
            cover.value = '';
            return;
        }

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Format File Tidak Didukung',
                text: 'Gunakan format JPG, PNG, GIF, atau WEBP.',
                confirmButtonColor: '#3085d6'
            });
            cover.value = '';
            return;
        }

        // Preview image
        const reader = new FileReader();
        reader.addEventListener("load", function () {
            coverPreview.src = reader.result;

            // Show file info
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');

            // Truncate long filename
            const maxLength = 30;
            const displayName = file.name.length > maxLength ?
                file.name.substring(0, maxLength) + '...' : file.name;

            fileName.textContent = `File: ${displayName}`;
            fileSize.textContent = `Ukuran: ${formatFileSize(file.size)}`;
            fileInfo.style.display = 'block';

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'File Berhasil Dipilih',
                text: `File "${file.name}" siap untuk diupload.`,
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }, false);

        reader.readAsDataURL(file);
    }
}

// Format file size display
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?> 