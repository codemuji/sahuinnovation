<?php
/**
 * Reject Withdrawal Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = $_POST['id'] ?? 0;

    if (!$id) {
        setFlash('danger', 'Invalid request ID.');
        redirect(site_url('public/admin/withdrawals.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Get request info
        $stmt = $db->prepare("SELECT * FROM withdrawal_requests WHERE id = ?");
        $stmt->execute([$id]);
        $request = $stmt->fetch();

        if (!$request || $request['status'] !== 'pending') {
            throw new Exception("Request not found or already processed.");
        }

        $userId = $request['user_id'];
        $amount = $request['amount'];

        // 2. Update request status
        $stmt = $db->prepare("UPDATE withdrawal_requests SET status = 'rejected', resolved_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$id]);

        // 3. REFUND to Wallet Balance
        $stmt = $db->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
        $stmt->execute([$amount, $userId]);

        // 4. Update Wallet Transaction to rejected
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'rejected', description = 'Withdrawal Rejected (Refunded)' WHERE ref_type = 'withdrawal' AND ref_id = ?");
        $stmt->execute([$id]);

        $db->commit();
        setFlash('success', 'Withdrawal request rejected and amount refunded to user wallet.');
        redirect(site_url('public/admin/withdrawals.php?status=rejected'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/withdrawals.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
