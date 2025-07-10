<?php

/**
 * NOTIFICATION EXAMPLES - PERPUSTAKAAN
 * Contoh penggunaan sistem notifikasi
 */

// Load helper
helper('notification');

/**
 * CONTOH PENGGUNAAN DI CONTROLLER
 */

class ExampleController extends BaseController
{
    public function successExample()
    {
        // Basic success notification
        set_success_notification('Data berhasil disimpan!');
        
        // Advanced success notification
        set_flash_notification('Buku berhasil ditambahkan ke perpustakaan', 'success', [
            'title' => 'Berhasil Menambah Buku',
            'icon' => 'fas fa-book',
            'dismissible' => true
        ]);
        
        return redirect()->to('admin/books');
    }
    
    public function errorExample()
    {
        // Basic error notification
        set_error_notification('Terjadi kesalahan saat menyimpan data');
        
        // Advanced error notification
        set_flash_notification('File yang diupload terlalu besar', 'danger', [
            'title' => 'Upload Gagal',
            'icon' => 'fas fa-exclamation-triangle',
            'permanent' => true // Won't auto-hide
        ]);
        
        return redirect()->back();
    }
    
    public function warningExample()
    {
        // Warning notification
        set_warning_notification('Stok buku hampir habis!');
        
        return redirect()->to('admin/dashboard');
    }
    
    public function infoExample()
    {
        // Info notification
        set_info_notification('Sistem akan maintenance pada pukul 02:00 WIB');
        
        return redirect()->to('user/dashboard');
    }
    
    public function multipleNotifications()
    {
        // Multiple notifications at once
        add_multiple_notifications([
            [
                'message' => 'Data berhasil disimpan',
                'type' => 'success',
                'options' => ['title' => 'Sukses']
            ],
            [
                'message' => 'Email notifikasi telah dikirim',
                'type' => 'info',
                'options' => ['title' => 'Informasi']
            ],
            [
                'message' => 'Backup otomatis akan dilakukan dalam 1 jam',
                'type' => 'warning',
                'options' => ['title' => 'Peringatan']
            ]
        ]);
        
        return redirect()->to('admin/dashboard');
    }
}

/**
 * CONTOH PENGGUNAAN DI VIEW
 */
?>

<!-- 1. Render semua flash notifications sebagai alert -->
<?= render_flash_notifications('alert') ?>

<!-- 2. Render sebagai toast (JavaScript) -->
<?= render_flash_notifications('toast') ?>

<!-- 3. Render sebagai data attributes untuk JavaScript processing -->
<?= render_flash_notifications('data-attribute') ?>

<!-- 4. Manual alert dengan custom styling -->
<div class="alert alert-success alert-with-icon" role="alert">
    <i class="alert-icon fas fa-check-circle"></i>
    <div class="alert-content">
        <div class="alert-title">Berhasil!</div>
        <div class="alert-message">Data telah disimpan dengan sukses.</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert">&times;</button>
</div>

<!-- 5. Notification badge -->
<div class="notification-badge">
    <i class="fas fa-bell"></i>
    <?= notification_badge(5, 'danger') ?>
</div>

<!-- 6. Notification wrapper -->
<?= notification_wrapper('<i class="fas fa-envelope"></i> Pesan', 3, 'info') ?>

<script>
/**
 * CONTOH PENGGUNAAN JAVASCRIPT
 */

// Basic toast notifications
showToast('Operasi berhasil!', 'success');
showToast('Terjadi kesalahan', 'danger');
showToast('Peringatan penting', 'warning');
showToast('Informasi berguna', 'info');

// Advanced toast with options
showToast('Data berhasil disimpan', 'success', {
    title: 'Sukses',
    duration: 3000,
    icon: 'fas fa-save'
});

// Alert notifications
showAlert('Ini adalah alert notification', 'info', {
    title: 'Informasi',
    dismissible: true,
    icon: 'fas fa-info-circle'
});

// Confirmation dialog
showConfirm('Hapus Data', 'Apakah Anda yakin ingin menghapus data ini?', {
    confirmButtonText: 'Ya, Hapus',
    cancelButtonText: 'Batal',
    icon: 'warning'
}).then((result) => {
    if (result.isConfirmed) {
        showToast('Data berhasil dihapus', 'success');
    }
});

// Success dialog
showSuccess('Berhasil!', 'Data telah disimpan dengan sukses');

// Error dialog
showError('Gagal!', 'Terjadi kesalahan saat menyimpan data');

// Loading overlay
showLoading('Menyimpan data...');
setTimeout(() => {
    hideLoading();
    showToast('Data berhasil disimpan', 'success');
}, 2000);

// Form submission with loading
document.getElementById('myForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    showLoading('Memproses data...');
    
    // Simulate API call
    setTimeout(() => {
        hideLoading();
        showToast('Form berhasil disubmit', 'success');
    }, 1500);
});

// Auto-show notifications from server
document.addEventListener('DOMContentLoaded', function() {
    // Check for server-side flash messages
    const flashData = document.querySelector('[data-flash-message]');
    if (flashData) {
        const message = flashData.getAttribute('data-flash-message');
        const type = flashData.getAttribute('data-flash-type');
        showToast(message, type);
    }
});
</script>

<style>
/**
 * CONTOH CUSTOM STYLING
 */

/* Custom notification colors */
.alert-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

/* Notification animation */
.notification-slide-in {
    animation: slideInFromRight 0.5s ease-out;
}

@keyframes slideInFromRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Custom toast positioning */
.toast-bottom-left {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 1055;
}

/* Notification counter */
.notification-counter {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
</style>

<?php
/**
 * CONTOH PENGGUNAAN DALAM BERBAGAI SKENARIO
 */

// 1. Setelah login berhasil
set_success_notification('Selamat datang kembali!', [
    'title' => 'Login Berhasil',
    'icon' => 'fas fa-user-check'
]);

// 2. Validasi form gagal
set_error_notification('Mohon periksa kembali data yang diinput', [
    'title' => 'Validasi Gagal',
    'icon' => 'fas fa-exclamation-circle'
]);

// 3. Operasi berhasil dengan detail
set_flash_notification('Buku "Laskar Pelangi" berhasil dipinjam', 'success', [
    'title' => 'Peminjaman Berhasil',
    'icon' => 'fas fa-book-open'
]);

// 4. Peringatan stok
set_warning_notification('Stok buku "Harry Potter" tinggal 2 eksemplar', [
    'title' => 'Stok Menipis',
    'icon' => 'fas fa-exclamation-triangle'
]);

// 5. Informasi sistem
set_info_notification('Fitur pencarian telah diperbarui', [
    'title' => 'Update Sistem',
    'icon' => 'fas fa-sync-alt'
]);

// 6. Notifikasi dengan aksi
set_flash_notification('Peminjaman akan berakhir besok', 'warning', [
    'title' => 'Pengingat',
    'icon' => 'fas fa-clock',
    'action_url' => base_url('user/borrowings/extend/123'),
    'action_text' => 'Perpanjang Sekarang'
]);
?>
