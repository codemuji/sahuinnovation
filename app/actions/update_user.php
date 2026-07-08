<?php
/**
 * Update User Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();

    $id = $_POST['id'] ?? 0;
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? '';
    $isActive = $_POST['is_active'] ?? 1;
    $password = $_POST['password'] ?? '';

    if (!$id || empty($name) || empty($email) || empty($role)) {
        setFlash('danger', 'Please fill in all required fields.');
        redirect(site_url("public/admin/edit-user.php?id={$id}"));
    }

    try {
        $db->beginTransaction();

        // 1. Check if email exists for other users
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            throw new Exception("Email address already registered to another user.");
        }

        // 2. Update User
        $sql = "UPDATE users SET name = ?, email = ?, phone = ?, role = ?, is_active = ? WHERE id = ?";
        $params = [$name, $email, $phone, $role, $isActive, $id];
        
        if (!empty($password)) {
            if (strlen($password) < 6) {
                throw new Exception("Password must be at least 6 characters long.");
            }
            $sql = "UPDATE users SET name = ?, email = ?, phone = ?, role = ?, is_active = ?, password = ? WHERE id = ?";
            $params = [$name, $email, $phone, $role, $isActive, password_hash($password, PASSWORD_BCRYPT), $id];
        }
        
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

        $db->commit();
        setFlash('success', "User account for {$name} updated successfully.");
        redirect(site_url('public/admin/users.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/admin/edit-user.php?id={$id}"));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
