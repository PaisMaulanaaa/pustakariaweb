<?php

if (!function_exists('validateImageUpload')) {
    /**
     * Validate image upload
     * 
     * @param object $file Uploaded file object
     * @param int $maxSize Maximum file size in bytes (default: 5MB)
     * @param array $allowedTypes Allowed MIME types
     * @return array Validation result
     */
    function validateImageUpload($file, $maxSize = 5242880, $allowedTypes = null)
    {
        if ($allowedTypes === null) {
            $allowedTypes = [
                'image/jpeg',
                'image/jpg', 
                'image/png',
                'image/gif',
                'image/webp'
            ];
        }

        $result = [
            'valid' => true,
            'errors' => []
        ];

        // Check if file is uploaded
        if (!$file->isValid()) {
            $result['valid'] = false;
            $result['errors'][] = 'File tidak valid atau tidak terupload.';
            return $result;
        }

        // Check file size
        if ($file->getSize() > $maxSize) {
            $result['valid'] = false;
            $result['errors'][] = 'Ukuran file terlalu besar. Maksimal ' . formatBytes($maxSize) . '.';
        }

        // Check MIME type
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            $result['valid'] = false;
            $result['errors'][] = 'Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.';
        }

        // Check if it's actually an image
        if (!$file->isValid() || !getimagesize($file->getTempName())) {
            $result['valid'] = false;
            $result['errors'][] = 'File bukan gambar yang valid.';
        }

        return $result;
    }
}

if (!function_exists('formatBytes')) {
    /**
     * Format bytes to human readable format
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('getMaxUploadSize')) {
    /**
     * Get maximum upload size from PHP configuration
     * 
     * @return int Maximum upload size in bytes
     */
    function getMaxUploadSize()
    {
        $upload_max = ini_get('upload_max_filesize');
        $post_max = ini_get('post_max_size');
        
        $upload_max_bytes = convertToBytes($upload_max);
        $post_max_bytes = convertToBytes($post_max);
        
        return min($upload_max_bytes, $post_max_bytes);
    }
}

if (!function_exists('convertToBytes')) {
    /**
     * Convert PHP ini size format to bytes
     * 
     * @param string $size
     * @return int
     */
    function convertToBytes($size)
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;
        
        switch ($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }
        
        return $size;
    }
}

if (!function_exists('generateUniqueFileName')) {
    /**
     * Generate unique file name for upload
     * 
     * @param object $file
     * @param string $prefix
     * @return string
     */
    function generateUniqueFileName($file, $prefix = 'cover_')
    {
        $extension = $file->getClientExtension();
        $timestamp = time();
        $random = bin2hex(random_bytes(8));
        
        return $prefix . $timestamp . '_' . $random . '.' . $extension;
    }
}

if (!function_exists('createUploadDirectory')) {
    /**
     * Create upload directory if not exists
     * 
     * @param string $path
     * @return bool
     */
    function createUploadDirectory($path)
    {
        if (!is_dir($path)) {
            return mkdir($path, 0755, true);
        }
        return true;
    }
}

if (!function_exists('deleteOldFile')) {
    /**
     * Delete old file safely
     * 
     * @param string $filePath
     * @return bool
     */
    function deleteOldFile($filePath)
    {
        if (file_exists($filePath) && is_file($filePath)) {
            try {
                return unlink($filePath);
            } catch (Exception $e) {
                log_message('error', 'Failed to delete file: ' . $filePath . ' - ' . $e->getMessage());
                return false;
            }
        }
        return true;
    }
}
