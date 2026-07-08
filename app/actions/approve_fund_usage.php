<?php
/**
 * Approve Fund Usage Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = intval($_POST['id'] ?? 0);

    if (!$id) {
        setFlash('danger', 'Invalid expense record ID.');
        redirect(site_url('public/admin/expense-reviews.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Get usage info
        $stmt = $db->prepare("SELECT * FROM fund_usages WHERE id = ?");
        $stmt->execute([$id]);
        $usage = $stmt->fetch();

        if (!$usage || $usage['status'] !== 'pending') {
            throw new Exception("Expense record not found or already processed.");
        }

        $directorId = $usage['director_id'];
        $amount = $usage['amount'];

        // 2. Lock and Check wallet balance
        $stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ? FOR UPDATE");
        $stmt->execute([$directorId]);
        $wallet = $stmt->fetch();
        $balance = $wallet['balance'] ?? 0;

        if ($balance < $amount) {
            throw new Exception("Director's wallet balance (" . formatCurrency($balance) . ") is insufficient to deduct this expense of " . formatCurrency($amount) . ".");
        }

        // 3. Deduct from wallet balance
        $stmt = $db->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?");
        $stmt->execute([$amount, $directorId]);

        // 4. Update status
        $stmt = $db->prepare("UPDATE fund_usages SET status = 'approved', resolved_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$id]);

        // 5. Record wallet transaction as approved debit
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) 
            VALUES (?, 'fund_usage', ?, 'debit', ?, 'approved', ?)");
        $stmt->execute([
            $directorId,
            $id,
            $amount,
            "Approved expense usage: " . $usage['purpose']
        ]);

        $db->commit();
        setFlash('success', 'Expense approved successfully and deducted from Director\'s wallet.');
        redirect(site_url('public/admin/expense-reviews.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/expense-reviews.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
