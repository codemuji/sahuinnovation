<?php
/**
 * Secure File Proxy
 * Serves files from private uploads/ directory
 */

require_once __DIR__ . '/../app/core/Auth.php';

Auth::requireRole(['staff', 'admin', 'dm', 'pe', 'surveyer', 'director']);

$type = $_GET['type'] ?? ''; // 'survey', 'technical', 'profile', or 'expense'
$file = $_GET['file'] ?? '';

if (!$type || !$file) {
    die("Invalid request.");
}

$baseDir = __DIR__ . '/../uploads/';
$subDir = 'survey_docs/';
if ($type === 'technical') $subDir = 'technical_docs/';
if ($type === 'profile') $subDir = 'profile_pics/';
if ($type === 'expense') $subDir = 'expense_docs/';

$filePath = realpath($baseDir . $subDir . $file);

// Security check: ensure the file is within the intended directory
if (!$filePath || strpos($filePath, realpath($baseDir)) !== 0 || !is_file($filePath)) {
    header("HTTP/1.0 404 Not Found");
    die("File not found.");
}

// Check if user has permission to see this specific file
// (For simplicity in this internal system, we allow all roles to view if they are authenticated, 
// but in a production system, you'd check if the user is the owner or staff/admin)

$mimeType = mime_content_type($filePath);
header("Content-Type: " . $mimeType);
header("Content-Length: " . filesize($filePath));

// If download parameter is set, force download
if (isset($_GET['download'])) {
    header('Content-Disposition: attachment; filename="' . $file . '"');
} else {
    // Optionally force download for some types or just show inline
    header('Content-Disposition: inline; filename="' . $file . '"');
}

readfile($filePath);
exit();
