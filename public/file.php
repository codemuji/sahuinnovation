<?php
/**
 * Secure File Proxy
 * Serves files from private uploads/ directory
 */

require_once __DIR__ . '/../app/core/Auth.php';

Auth::requireRole(['staff', 'admin', 'dm', 'pe', 'surveyer', 'director']);

$type = $_GET['type'] ?? ''; // 'survey', 'technical', 'profile', 'expense', or 'payout'
$file = $_GET['file'] ?? '';

if (!$file) {
    header("HTTP/1.0 404 Not Found");
    die("File not found.");
}

// Normalize path separators from Windows (\) to Linux (/)
$file = str_replace('\\', '/', trim($file));
$cleanName = basename($file);
$cleanRelPath = ltrim(preg_replace('#\.\.+/#', '', $file), '/');

// Base directories allowed for storage
$uploadsRoot = realpath(__DIR__ . '/../uploads') ?: (__DIR__ . '/../uploads');
$publicUploadsRoot = realpath(__DIR__ . '/uploads') ?: (__DIR__ . '/uploads');

$subDir = '';
if ($type === 'survey') $subDir = 'survey_docs/';
elseif ($type === 'technical') $subDir = 'technical_docs/';
elseif ($type === 'profile') $subDir = 'profile_pics/';
elseif ($type === 'expense') $subDir = 'expense_docs/';
elseif ($type === 'payout' || $type === 'withdrawal') $subDir = 'payouts/';

// Build candidate search folders in priority order
$searchDirs = [];
if ($subDir) {
    $searchDirs[] = rtrim($uploadsRoot, '/\\') . '/' . rtrim($subDir, '/\\');
}
$searchDirs = array_merge($searchDirs, [
    rtrim($uploadsRoot, '/\\') . '/expense_docs',
    rtrim($uploadsRoot, '/\\') . '/survey_docs',
    rtrim($uploadsRoot, '/\\') . '/technical_docs',
    rtrim($uploadsRoot, '/\\') . '/profile_pics',
    rtrim($uploadsRoot, '/\\') . '/payouts',
    rtrim($uploadsRoot, '/\\'),
    rtrim($publicUploadsRoot, '/\\')
]);

$filePath = false;

// 1. Direct candidate checks using $cleanName
foreach ($searchDirs as $dir) {
    $candidate1 = rtrim($dir, '/\\') . '/' . $cleanName;
    if (is_file($candidate1)) {
        $filePath = realpath($candidate1) ?: $candidate1;
        break;
    }
}

// 2. Check if cleanRelPath resolves directly
if (!$filePath && is_file(rtrim($uploadsRoot, '/\\') . '/' . $cleanRelPath)) {
    $filePath = realpath(rtrim($uploadsRoot, '/\\') . '/' . $cleanRelPath) ?: (rtrim($uploadsRoot, '/\\') . '/' . $cleanRelPath);
}
if (!$filePath && is_file(rtrim($publicUploadsRoot, '/\\') . '/' . $cleanRelPath)) {
    $filePath = realpath(rtrim($publicUploadsRoot, '/\\') . '/' . $cleanRelPath) ?: (rtrim($publicUploadsRoot, '/\\') . '/' . $cleanRelPath);
}

// 3. Case-insensitive fallback for Linux live servers (where filename casing might differ between DB and disk)
if (!$filePath) {
    foreach ($searchDirs as $dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            if ($files !== false) {
                foreach ($files as $f) {
                    if (strcasecmp($f, $cleanName) === 0 && is_file($dir . '/' . $f)) {
                        $filePath = realpath($dir . '/' . $f) ?: ($dir . '/' . $f);
                        break 2;
                    }
                }
            }
        }
    }
}

// Security check: ensure the resolved file resides safely within authorized directories
$safe = false;
if ($filePath && is_file($filePath)) {
    $realPath = realpath($filePath) ?: $filePath;
    $realUploads = realpath($uploadsRoot) ?: $uploadsRoot;
    $realPublicUploads = realpath($publicUploadsRoot) ?: $publicUploadsRoot;
    if (strpos(str_replace('\\', '/', $realPath), str_replace('\\', '/', $realUploads)) === 0 ||
        strpos(str_replace('\\', '/', $realPath), str_replace('\\', '/', $realPublicUploads)) === 0) {
        $safe = true;
    }
}

if (!$safe || !$filePath) {
    header("HTTP/1.0 404 Not Found");
    die("File not found.");
}

// Check if user has permission to see this specific file
// (For simplicity in this internal system, we allow all roles to view if they are authenticated, 
// but in a production system, you'd check if the user is the owner or staff/admin)

$mimeType = @mime_content_type($filePath) ?: 'application/octet-stream';
header("Content-Type: " . $mimeType);
header("Content-Length: " . (@filesize($filePath) ?: 0));

// If download parameter is set, force download
if (isset($_GET['download'])) {
    header('Content-Disposition: attachment; filename="' . $file . '"');
} else {
    // Optionally force download for some types or just show inline
    header('Content-Disposition: inline; filename="' . $file . '"');
}

readfile($filePath);
exit();
