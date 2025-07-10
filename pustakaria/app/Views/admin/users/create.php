<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah User Baru</h1>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/users/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                        id="username" name="username" value="<?= old('username') ?>">
                    <?php if (session('errors.username')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.username') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                        id="email" name="email" value="<?= old('email') ?>">
                    <?php if (session('errors.email')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.email') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="fullname">Nama Lengkap</label>
                    <input type="text" class="form-control <?= session('errors.fullname') ? 'is-invalid' : '' ?>"
                        id="fullname" name="fullname" value="<?= old('fullname') ?>">
                    <?php if (session('errors.fullname')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.fullname') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                        id="password" name="password">
                    <?php if (session('errors.password')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.password') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="password_confirm">Konfirmasi Password</label>
                    <input type="password" class="form-control <?= session('errors.password_confirm') ? 'is-invalid' : '' ?>"
                        id="password_confirm" name="password_confirm">
                    <?php if (session('errors.password_confirm')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.password_confirm') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control <?= session('errors.role') ? 'is-invalid' : '' ?>"
                        id="role" name="role">
                        <option value="">Pilih Role</option>
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                    <?php if (session('errors.role')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.role') ?>
                        </div>
                    <?php endif ?>
                </div>

                <div class="form-group">
                    <label for="is_active">Status</label>
                    <select class="form-control <?= session('errors.is_active') ? 'is-invalid' : '' ?>"
                        id="is_active" name="is_active">
                        <option value="">Pilih Status</option>
                        <option value="1" <?= old('is_active') === '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= old('is_active') === '0' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <?php if (session('errors.is_active')) : ?>
                        <div class="invalid-feedback">
                            <?= session('errors.is_active') ?>
                        </div>
                    <?php endif ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 