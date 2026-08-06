<?php
/**
 * Delete User Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();
$currentUserId = Auth::userId();

$id = intval($_POST['id'] ?? $_GET['id'] ?? 0);

if (!$id) {
    setFlash('danger', 'Invalid user ID.');
    redirect(site_url('public/admin/users.php'));
}

if ($id === $currentUserId) {
    setFlash('danger', 'You cannot delete your own admin account.');
    redirect(site_url('public/admin/users.php'));
}

try {
    // Check if user exists
    $stmt = $db->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception("User not found.");
    }

    // Delete user
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    setFlash('success', "User '" . $user['name'] . "' has been deleted successfully.");
} catch (Exception $e) {
    setFlash('danger', 'Error deleting user: ' . $e->getMessage());
}

redirect(site_url('public/admin/users.php'));
