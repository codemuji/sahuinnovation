<?php
/**
 * Approve Technical Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('staff');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = $_POST['id'] ?? 0;

    if (!$id) {
        setFlash('danger', 'Invalid customer ID.');
        redirect(site_url('public/staff/technical-list.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Get customer and DM info
        $stmt = $db->prepare("SELECT t.*, u.role as dm_role FROM technical_customers t JOIN users u ON t.dm_id = u.id WHERE t.id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer || $customer['status'] !== 'pending') {
            throw new Exception("Customer not found or not in pending status.");
        }

        $dmId = $customer['dm_id'];
        $incentiveAmount = ($customer['dm_role'] === 'dm') ? 20000.00 : 15000.00;

        // 2. Update customer status
        $stmt = $db->prepare("UPDATE technical_customers SET status = 'approved' WHERE id = ?");
        $stmt->execute([$id]);

        // 3. Update wallet transaction status
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'approved' WHERE ref_type = 'technical' AND ref_id = ? AND user_id = ?");
        $stmt->execute([$id, $dmId]);

        // 4. Update wallet balance
        $stmt = $db->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
        $stmt->execute([$incentiveAmount, $dmId]);

        $db->commit();
        setFlash('success', 'Technical record approved. Incentive of ' . formatCurrency($incentiveAmount) . ' credited.');
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));
    }
} else {
    redirect(site_url('public/staff/dashboard.php'));
}
