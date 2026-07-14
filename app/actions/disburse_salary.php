<?php
/**
 * Disburse Salary / Advance Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $adminId = Auth::userId();

    $userId = intval($_POST['user_id'] ?? 0);
    $type = in_array($_POST['type'] ?? '', ['salary', 'advance']) ? $_POST['type'] : 'salary';
    $amount = floatval($_POST['amount'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');

    if (!$userId || $amount <= 0) {
        setFlash('danger', 'Please select a director and enter a valid amount.');
        redirect(site_url('public/admin/disburse-salary.php'));
    }

    try {
        $db->beginTransaction();

        // 0. Ensure table exists and ref_type accepts arbitrary string references
        $db->exec("CREATE TABLE IF NOT EXISTS salary_disbursements (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            user_id INT NOT NULL,
            type ENUM('salary', 'advance') NOT NULL DEFAULT 'salary',
            amount DECIMAL(10, 2) NOT NULL,
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        @$db->exec("ALTER TABLE wallet_transactions MODIFY COLUMN ref_type VARCHAR(50) NOT NULL");

        // 1. Verify target user exists and is a Director or Office Staff
        $stmt = $db->prepare("SELECT name FROM users WHERE id = ? AND role IN ('director', 'office_staff') AND is_active = 1");
        $stmt->execute([$userId]);
        $targetUser = $stmt->fetch();

        if (!$targetUser) {
            throw new Exception("Selected user not found or is not an active Director or Office Staff.");
        }

        // 2. Insert Disbursement Record
        $stmt = $db->prepare("INSERT INTO salary_disbursements (admin_id, user_id, type, amount, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$adminId, $userId, $type, $amount, $notes]);
        $disbursementId = $db->lastInsertId();

        // 3. Update or Create Wallet
        $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
        $stmt->execute([$userId, $amount, $amount]);

        // 4. Record Wallet Transaction
        $typeTitle = ucfirst($type);
        $desc = "{$typeTitle} Disbursement from Admin: " . ($notes ?: 'No description');
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) 
            VALUES (?, 'salary_disbursement', ?, 'credit', ?, 'approved', ?)");
        $stmt->execute([
            $userId,
            $disbursementId,
            $amount,
            $desc
        ]);

        $db->commit();
        setFlash('success', "{$typeTitle} successfully disbursed to {$targetUser['name']}.");
        redirect(site_url('public/admin/disburse-salary.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/disburse-salary.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
