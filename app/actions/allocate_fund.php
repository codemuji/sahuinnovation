<?php
/**
 * Allocate Fund Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $adminId = Auth::userId();

    $directorId = intval($_POST['director_id'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');

    if (!$directorId || $amount <= 0) {
        setFlash('danger', 'Please select a director and enter a valid amount.');
        redirect(site_url('public/admin/allocate-funds.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Verify target user is a director
        $stmt = $db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$directorId]);
        $role = $stmt->fetchColumn();

        if ($role !== 'director') {
            throw new Exception("Selected user is not a Director.");
        }

        // 2. Insert Fund Allocation Record
        $stmt = $db->prepare("INSERT INTO fund_allocations (admin_id, director_id, amount, notes) VALUES (?, ?, ?, ?)");
        $stmt->execute([$adminId, $directorId, $amount, $notes]);
        $allocationId = $db->lastInsertId();

        // 3. Update or Create Wallet
        $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, ?) ON DUPLICATE KEY UPDATE balance = balance + ?");
        $stmt->execute([$directorId, $amount, $amount]);

        // 4. Record Wallet Transaction
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) 
            VALUES (?, 'fund_allocation', ?, 'credit', ?, 'approved', ?)");
        $stmt->execute([
            $directorId,
            $allocationId,
            $amount,
            "Fund allocation from Admin: " . ($notes ?: 'No description')
        ]);

        $db->commit();
        setFlash('success', 'Funds successfully allocated to Director.');
        redirect(site_url('public/admin/allocate-funds.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/allocate-funds.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
