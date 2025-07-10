<?= $this->extend('layout/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

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
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Profil</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/profile/update') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="fullname">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control <?= (session('errors.fullname')) ? 'is-invalid' : '' ?>" 
                                   id="fullname" 
                                   name="fullname" 
                                   value="<?= old('fullname', $user['fullname']) ?>" 
                                   required>
                            <?php if (session('errors.fullname')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.fullname') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" 
                                   class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>" 
                                   id="email" 
                                   name="email" 
                                   value="<?= old('email', $user['email']) ?>" 
                                   required>
                            <?php if (session('errors.email')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.email') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="text" 
                                   class="form-control <?= (session('errors.phone')) ? 'is-invalid' : '' ?>" 
                                   id="phone" 
                                   name="phone" 
                                   value="<?= old('phone', $user['phone'] ?? '') ?>">
                            <?php if (session('errors.phone')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.phone') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control <?= (session('errors.address')) ? 'is-invalid' : '' ?>" 
                                       id="address" 
                                       name="address" 
                                       rows="3"><?= old('address', $user['address'] ?? '') ?></textarea>
                            <?php if (session('errors.address')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.address') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <hr>
                        <h6 class="font-weight-bold">Ganti Password</h6>
                        <small class="text-muted mb-3 d-block">Kosongkan jika tidak ingin mengubah password</small>

                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" 
                                   class="form-control <?= (session('errors.current_password')) ? 'is-invalid' : '' ?>" 
                                   id="current_password" 
                                   name="current_password">
                            <?php if (session('errors.current_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.current_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" 
                                   class="form-control <?= (session('errors.new_password')) ? 'is-invalid' : '' ?>" 
                                   id="new_password" 
                                   name="new_password">
                            <?php if (session('errors.new_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.new_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password Baru</label>
                            <input type="password" 
                                   class="form-control <?= (session('errors.confirm_password')) ? 'is-invalid' : '' ?>" 
                                   id="confirm_password" 
                                   name="confirm_password">
                            <?php if (session('errors.confirm_password')) : ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.confirm_password') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
