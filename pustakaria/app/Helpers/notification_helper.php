<?php

/**
 * NOTIFICATION HELPER - PERPUSTAKAAN
 * Helper functions for managing notifications
 */

if (!function_exists('set_flash_notification')) {
    /**
     * Set flash notification
     * @param string $message
     * @param string $type (success, danger, warning, info, primary)
     * @param array $options
     */
    function set_flash_notification($message, $type = 'info', $options = []) {
        $session = session();
        
        $notification = [
            'message' => $message,
            'type' => $type,
            'options' => $options
        ];
        
        $session->setFlashdata('notification', $notification);
    }
}

if (!function_exists('set_success_notification')) {
    /**
     * Set success notification
     * @param string $message
     * @param array $options
     */
    function set_success_notification($message, $options = []) {
        set_flash_notification($message, 'success', $options);
    }
}

if (!function_exists('set_error_notification')) {
    /**
     * Set error notification
     * @param string $message
     * @param array $options
     */
    function set_error_notification($message, $options = []) {
        set_flash_notification($message, 'danger', $options);
    }
}

if (!function_exists('set_warning_notification')) {
    /**
     * Set warning notification
     * @param string $message
     * @param array $options
     */
    function set_warning_notification($message, $options = []) {
        set_flash_notification($message, 'warning', $options);
    }
}

if (!function_exists('set_info_notification')) {
    /**
     * Set info notification
     * @param string $message
     * @param array $options
     */
    function set_info_notification($message, $options = []) {
        set_flash_notification($message, 'info', $options);
    }
}

if (!function_exists('render_flash_notifications')) {
    /**
     * Render flash notifications as HTML
     * @param string $format ('alert', 'toast', 'data-attribute')
     * @return string
     */
    function render_flash_notifications($format = 'alert') {
        $session = session();
        $html = '';
        
        // Handle single notification
        $notification = $session->getFlashdata('notification');
        if ($notification) {
            $html .= render_notification($notification, $format);
        }
        
        // Handle multiple notifications
        $notifications = $session->getFlashdata('notifications');
        if ($notifications && is_array($notifications)) {
            foreach ($notifications as $notif) {
                $html .= render_notification($notif, $format);
            }
        }
        
        // Handle legacy flash messages
        $legacyTypes = ['success', 'error', 'warning', 'info'];
        foreach ($legacyTypes as $type) {
            $message = $session->getFlashdata($type);
            if ($message) {
                $legacyType = $type === 'error' ? 'danger' : $type;
                $html .= render_notification([
                    'message' => $message,
                    'type' => $legacyType,
                    'options' => []
                ], $format);
            }
        }
        
        return $html;
    }
}

if (!function_exists('render_notification')) {
    /**
     * Render single notification
     * @param array $notification
     * @param string $format
     * @return string
     */
    function render_notification($notification, $format = 'alert') {
        $message = $notification['message'] ?? '';
        $type = $notification['type'] ?? 'info';
        $options = $notification['options'] ?? [];
        
        if (empty($message)) {
            return '';
        }
        
        switch ($format) {
            case 'toast':
                return render_toast_notification($message, $type, $options);
            case 'data-attribute':
                return render_data_attribute_notification($message, $type, $options);
            case 'alert':
            default:
                return render_alert_notification($message, $type, $options);
        }
    }
}

if (!function_exists('render_alert_notification')) {
    /**
     * Render alert notification
     */
    function render_alert_notification($message, $type, $options) {
        $dismissible = $options['dismissible'] ?? true;
        $icon = $options['icon'] ?? get_notification_icon($type);
        $title = $options['title'] ?? null;
        $permanent = $options['permanent'] ?? false;
        
        $classes = "alert alert-{$type} fade-in";
        if ($dismissible) {
            $classes .= ' alert-dismissible';
        }
        if ($permanent) {
            $classes .= ' alert-permanent';
        }
        
        $html = "<div class=\"{$classes}\" role=\"alert\">";
        
        if ($icon || $title) {
            $html .= '<div class="alert-with-icon">';
            if ($icon) {
                $html .= "<i class=\"alert-icon {$icon}\"></i>";
            }
            $html .= '<div class="alert-content">';
            if ($title) {
                $html .= "<div class=\"alert-title\">{$title}</div>";
            }
            $html .= "<div class=\"alert-message\">{$message}</div>";
            $html .= '</div></div>';
        } else {
            $html .= "<div class=\"alert-message\">{$message}</div>";
        }
        
        if ($dismissible) {
            $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>';
        }
        
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('render_toast_notification')) {
    /**
     * Render toast notification (JavaScript-based)
     */
    function render_toast_notification($message, $type, $options) {
        $jsOptions = json_encode($options);
        return "<script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof showToast === 'function') {
                    showToast('{$message}', '{$type}', {$jsOptions});
                }
            });
        </script>";
    }
}

if (!function_exists('render_data_attribute_notification')) {
    /**
     * Render notification as data attributes (for JavaScript processing)
     */
    function render_data_attribute_notification($message, $type, $options) {
        $optionsJson = htmlspecialchars(json_encode($options), ENT_QUOTES, 'UTF-8');
        return "<div data-flash-message=\"{$message}\" data-flash-type=\"{$type}\" data-flash-options=\"{$optionsJson}\" style=\"display: none;\"></div>";
    }
}

if (!function_exists('get_notification_icon')) {
    /**
     * Get default icon for notification type
     */
    function get_notification_icon($type) {
        $icons = [
            'success' => 'fas fa-check-circle',
            'danger' => 'fas fa-exclamation-circle',
            'warning' => 'fas fa-exclamation-triangle',
            'info' => 'fas fa-info-circle',
            'primary' => 'fas fa-bell'
        ];
        
        return $icons[$type] ?? 'fas fa-bell';
    }
}

if (!function_exists('get_notification_title')) {
    /**
     * Get default title for notification type
     */
    function get_notification_title($type) {
        $titles = [
            'success' => 'Berhasil',
            'danger' => 'Error',
            'warning' => 'Peringatan',
            'info' => 'Informasi',
            'primary' => 'Notifikasi'
        ];
        
        return $titles[$type] ?? 'Notifikasi';
    }
}

if (!function_exists('add_multiple_notifications')) {
    /**
     * Add multiple notifications
     * @param array $notifications
     */
    function add_multiple_notifications($notifications) {
        $session = session();
        $existing = $session->getFlashdata('notifications') ?? [];
        $merged = array_merge($existing, $notifications);
        $session->setFlashdata('notifications', $merged);
    }
}

if (!function_exists('notification_badge')) {
    /**
     * Create notification badge HTML
     * @param int $count
     * @param string $type
     * @param array $options
     * @return string
     */
    function notification_badge($count, $type = 'danger', $options = []) {
        if ($count <= 0) {
            return '';
        }
        
        $maxCount = $options['max_count'] ?? 99;
        $displayCount = $count > $maxCount ? "{$maxCount}+" : $count;
        
        return "<span class=\"badge badge-{$type}\">{$displayCount}</span>";
    }
}

if (!function_exists('notification_wrapper')) {
    /**
     * Wrap element with notification badge
     * @param string $content
     * @param int $count
     * @param string $type
     * @param array $options
     * @return string
     */
    function notification_wrapper($content, $count, $type = 'danger', $options = []) {
        $badge = notification_badge($count, $type, $options);
        
        if (empty($badge)) {
            return $content;
        }
        
        return "<div class=\"notification-badge\">{$content}{$badge}</div>";
    }
}

if (!function_exists('format_notification_time')) {
    /**
     * Format notification time
     * @param string $datetime
     * @return string
     */
    function format_notification_time($datetime) {
        $time = strtotime($datetime);
        $now = time();
        $diff = $now - $time;
        
        if ($diff < 60) {
            return 'Baru saja';
        } elseif ($diff < 3600) {
            $minutes = floor($diff / 60);
            return "{$minutes} menit yang lalu";
        } elseif ($diff < 86400) {
            $hours = floor($diff / 3600);
            return "{$hours} jam yang lalu";
        } elseif ($diff < 604800) {
            $days = floor($diff / 86400);
            return "{$days} hari yang lalu";
        } else {
            return date('d M Y', $time);
        }
    }
}

if (!function_exists('clean_notification_message')) {
    /**
     * Clean and sanitize notification message
     * @param string $message
     * @return string
     */
    function clean_notification_message($message) {
        // Remove HTML tags except allowed ones
        $allowedTags = '<strong><b><em><i><u><br>';
        $cleaned = strip_tags($message, $allowedTags);

        // Escape quotes for JavaScript safety
        $cleaned = htmlspecialchars($cleaned, ENT_QUOTES, 'UTF-8');

        return $cleaned;
    }
}

/**
 * USAGE EXAMPLES:
 *
 * 1. Basic Flash Notifications:
 *    set_success_notification('Data berhasil disimpan');
 *    set_error_notification('Terjadi kesalahan');
 *    set_warning_notification('Peringatan: Data akan dihapus');
 *    set_info_notification('Informasi penting');
 *
 * 2. Advanced Notifications:
 *    set_flash_notification('Custom message', 'success', [
 *        'title' => 'Custom Title',
 *        'icon' => 'fas fa-custom-icon',
 *        'dismissible' => true,
 *        'permanent' => false
 *    ]);
 *
 * 3. Multiple Notifications:
 *    add_multiple_notifications([
 *        ['message' => 'First message', 'type' => 'success'],
 *        ['message' => 'Second message', 'type' => 'info']
 *    ]);
 *
 * 4. In Views:
 *    <?= render_flash_notifications('alert') ?>
 *    <?= render_flash_notifications('toast') ?>
 *    <?= render_flash_notifications('data-attribute') ?>
 *
 * 5. Notification Badges:
 *    <?= notification_wrapper('<i class="fas fa-bell"></i>', 5) ?>
 *    <?= notification_badge(10, 'warning') ?>
 *
 * 6. JavaScript Usage:
 *    showToast('Message', 'success');
 *    showAlert('Message', 'danger');
 *    showConfirm('Title', 'Text').then((result) => {
 *        if (result.isConfirmed) {
 *            // User confirmed
 *        }
 *    });
 *    showLoading('Processing...');
 *    hideLoading();
 */
