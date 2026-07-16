<?php
/**
 * Authentication Class
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/../config/database.php';

class Auth {
    /**
     * Check if user is logged in
     */
    public static function check() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get logged in user ID
     */
    public static function userId() {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get logged in user role
     */
    public static function userRole() {
        return $_SESSION['role'] ?? null;
    }

    /**
     * Get logged in user data
     */
    public static function user() {
        if (!self::check()) return null;
        
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([self::userId()]);
        return $stmt->fetch();
    }

    /**
     * Require a user to be logged in with specific role(s)
     */
    public static function requireRole($roles) {
        if (!self::check()) {
            setFlash('danger', 'Please login to access this page.');
            redirect(site_url('public/index.php'));
        }

        if (is_string($roles)) {
            $roles = [$roles];
        }

        if (self::userRole() !== 'admin' && !in_array(self::userRole(), $roles)) {
            setFlash('danger', 'You do not have permission to access this page.');
            redirect(site_url('public/index.php'));
        }
    }

    /**
     * Logout user
     */
    public static function logout() {
        session_unset();
        session_destroy();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
