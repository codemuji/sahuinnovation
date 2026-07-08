<?php
/**
 * Mark Withdrawal as Paid Action
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

        // 2. Handle Payment Proof Upload (Optional but recommended)
        $paymentProof = null;
        if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../../uploads/payouts/';
            $upload = uploadFile($_FILES['payment_proof'], $targetDir);
            
            if (isset($upload['success'])) {
                $paymentProof = $upload['path'];
            } else {
                throw new Exception("Failed to upload payment proof: " . $upload['error']);
            }
        }

        // 3. Update request status
        $stmt = $db->prepare("UPDATE withdrawal_requests SET status = 'paid', resolved_at = CURRENT_TIMESTAMP, payment_proof = ? WHERE id = ?");
        $stmt->execute([$paymentProof, $id]);

        // 4. Update Wallet Transaction to approved
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'approved', description = 'Withdrawal Payout' WHERE ref_type = 'withdrawal' AND ref_id = ?");
        $stmt->execute([$id]);

        // Note: Balance was already deducted during request phase.

        $db->commit();
        setFlash('success', 'Withdrawal marked as PAID and wallet balance updated.');
        redirect(site_url('public/admin/withdrawals.php?status=paid'));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/withdrawals.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
