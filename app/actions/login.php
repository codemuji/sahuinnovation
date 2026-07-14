<?php
/**
 * Login Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        setFlash('danger', 'Please enter both email and password.');
        redirect(site_url('public/login.php'));
    }

    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Ensure ENUM supports office_staff
        @$db->exec("ALTER TABLE users MODIFY COLUMN role ENUM('surveyer', 'dm', 'pe', 'staff', 'admin', 'director', 'office_staff') NOT NULL");

        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect based on role
        $role = $user['role'];
        $validRoles = ['surveyer', 'dm', 'pe', 'director', 'office_staff', 'staff', 'admin'];
        if (in_array($role, $validRoles)) {
            redirect(site_url('public/' . ($role === 'pe' ? 'dm' : $role) . '/dashboard.php'));
        } else {
            session_destroy();
            setFlash('danger', 'Your account role is invalid or unassigned. Please contact Admin.');
            redirect(site_url('public/login.php'));
        }
    } else {
        setFlash('danger', 'Invalid email or password.');
        redirect(site_url('public/login.php'));
    }
} else {
    redirect(site_url('public/login.php'));
}
