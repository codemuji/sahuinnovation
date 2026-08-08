<?php
/**
 * Global Helper Functions
 */

require_once __DIR__ . '/../config/site.php';

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

/**
 * Ensure Sub-Contract tables exist in database
 */
function ensureSubcontractTables($db) {
    @$db->exec("ALTER TABLE users MODIFY COLUMN role ENUM('surveyer', 'dm', 'pe', 'staff', 'admin', 'director', 'office_staff', 'subcontractor', 'subcontract_staff') NOT NULL");
    try {
        @$db->exec("ALTER TABLE users ADD COLUMN subcontractor_id INT NULL");
    } catch (Exception $e) {}

    @$db->exec("CREATE TABLE IF NOT EXISTS subcontract_projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        contractor_id INT NOT NULL,
        created_by_staff_id INT NOT NULL,
        customer_name VARCHAR(150) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        consumer_number VARCHAR(100),
        address TEXT NOT NULL,
        contract_type ENUM('12_step', 'part_pay') NOT NULL DEFAULT '12_step',
        status VARCHAR(100) DEFAULT '1. APPLICATION',
        payment_1_amount DECIMAL(10, 2) DEFAULT 0.00,
        payment_1_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
        payment_1_date TIMESTAMP NULL,
        payment_1_notes TEXT,
        payment_2_amount DECIMAL(10, 2) DEFAULT 0.00,
        payment_2_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
        payment_2_date TIMESTAMP NULL,
        payment_2_notes TEXT,
        part_pay_amount DECIMAL(10, 2) DEFAULT 0.00,
        part_pay_status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
        part_pay_date TIMESTAMP NULL,
        part_pay_notes TEXT,
        customer_feedback TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (contractor_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (created_by_staff_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    @$db->exec("CREATE TABLE IF NOT EXISTS subcontract_documents (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        step_name VARCHAR(100) NOT NULL,
        file_path VARCHAR(500) NOT NULL,
        original_name VARCHAR(255) NOT NULL,
        uploaded_by INT NOT NULL,
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (project_id) REFERENCES subcontract_projects(id) ON DELETE CASCADE,
        FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
}
