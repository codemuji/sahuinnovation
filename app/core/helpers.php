<?php
/**
 * Global Helper Functions
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Sanitize output
 */
function h($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to a URL
 */
function redirect($path) {
    header("Location: " . $path);
    exit();
}

/**
 * Set flash message
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get flash message
 */
function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format currency
 */
function formatCurrency($amount) {
    return '₹' . number_format($amount, 2);
}

/**
 * Debugging helper
 */
function dd($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die();
}

/**
 * Get site URL (base path)
 */
function site_url($path = '') {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $baseDir = str_replace('\\', '/', dirname($script));
    
    // List of subfolders to strip to reach the project root
    $subfolders = ['/public', '/app/actions', '/app/core'];
    foreach ($subfolders as $sub) {
        if (($pos = strpos($baseDir, $sub)) !== false) {
            $baseDir = substr($baseDir, 0, $pos);
            break;
        }
    }
    
    return $protocol . "://" . $host . rtrim($baseDir, '/') . '/' . ltrim($path, '/');
}

/**
 * Get asset URL
 */
function asset_url($path) {
    return site_url('public/assets/' . ltrim($path, '/'));
}
/**
 * Upload File Helper
 */
function uploadFile($file, $targetDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'File upload error code: ' . $file['error']];
    }

    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedTypes)) {
        return ['error' => 'File type not allowed.'];
    }

    if ($fileSize > 5 * 1024 * 1024) { // 5MB
        return ['error' => 'File size exceeds 5MB limit.'];
    }

    $newFileName = uniqid('DOC_') . '.' . $ext;
    $targetPath = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newFileName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($fileTmp, $targetPath)) {
        return [
            'success' => true,
            'path' => $newFileName,
            'original_name' => $fileName
        ];
    }

    return ['error' => 'Failed to move uploaded file.'];
}
