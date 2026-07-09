<?php
/**
 * Create User Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Wallet.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($role) || empty($password)) {
        setFlash('danger', 'Please fill in all required fields.');
        redirect(site_url('public/admin/add-user.php'));
    }

    if (strlen($password) < 6) {
        setFlash('danger', 'Password must be at least 6 characters long.');
        redirect(site_url('public/admin/add-user.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new Exception("Email address already registered.");
        }

        // 2. Insert User
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("INSERT INTO users (name, email, phone, role, password, is_active) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->execute([$name, $email, $phone, $role, $hashedPassword]);
        $userId = $db->lastInsertId();

        // 2b. Generate unique Employee ID: SI-XXXX
        $employeeId = 'SI-' . str_pad($userId, 4, '0', STR_PAD_LEFT);
        $stmt = $db->prepare("UPDATE users SET employee_id = ? WHERE id = ?");
        $stmt->execute([$employeeId, $userId]);

        // 3. Create Wallet
        Wallet::ensureWallet($userId);

        $db->commit();
        setFlash('success', "User account for {$name} created successfully. Employee ID: {$employeeId}");
        redirect(site_url('public/admin/users.php'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/add-user.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
