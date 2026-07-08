<?php
/**
 * Update Fund Usage (Resubmit Reverted Expense) Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('director');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $directorId = Auth::userId();

    $id = intval($_POST['id'] ?? 0);
    $amount = floatval($_POST['amount'] ?? 0);
    $purpose = trim($_POST['purpose'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$id || $amount <= 0 || empty($purpose)) {
        setFlash('danger', 'Please enter a valid amount and purpose.');
        redirect(site_url('public/director/usages.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Fetch usage and verify ownership and state
        $stmt = $db->prepare("SELECT * FROM fund_usages WHERE id = ? AND director_id = ?");
        $stmt->execute([$id, $directorId]);
        $usage = $stmt->fetch();

        if (!$usage) {
            throw new Exception("Expense record not found.");
        }

        if ($usage['status'] !== 'revert_back') {
            throw new Exception("You can only modify expenses that have been reverted by the Admin.");
        }

        // 2. Verify wallet balance
        $stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $stmt->execute([$directorId]);
        $wallet = $stmt->fetch();
        $balance = $wallet['balance'] ?? 0.00;

        if ($amount > $balance) {
            throw new Exception("Insufficient wallet balance. You cannot log an expense exceeding your current balance.");
        }

        // 3. Handle File Upload (Optional: if not uploaded, keep old proof)
        $paymentProof = $usage['payment_proof'];
        if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
            $targetDir = __DIR__ . '/../../uploads/expense_docs/';
            $upload = uploadFile($_FILES['payment_proof'], $targetDir);

            if (!isset($upload['success'])) {
                throw new Exception("Failed to upload new payment proof: " . $upload['error']);
            }
            $paymentProof = $upload['path'];
        }

        // 4. Update the expense record status back to pending
        $stmt = $db->prepare("UPDATE fund_usages 
            SET amount = ?, purpose = ?, description = ?, payment_proof = ?, status = 'pending', admin_note = NULL 
            WHERE id = ?");
        $stmt->execute([$amount, $purpose, $description, $paymentProof, $id]);

        $db->commit();
        setFlash('success', 'Expense updated and resubmitted for MD review.');
        redirect(site_url('public/director/usages.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/director/edit-usage.php?id={$id}"));
    }
} else {
    redirect(site_url('public/director/dashboard.php'));
}
