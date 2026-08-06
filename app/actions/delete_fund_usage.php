<?php
/**
 * Delete Fund Usage (Expense) Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = intval($_POST['id'] ?? 0);

    if (!$id) {
        setFlash('danger', 'Invalid expense ID.');
        redirect(site_url('public/admin/expense-reviews.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Fetch expense details
        $stmt = $db->prepare("SELECT * FROM fund_usages WHERE id = ?");
        $stmt->execute([$id]);
        $usage = $stmt->fetch();

        if (!$usage) {
            throw new Exception("Expense record not found.");
        }

        // 2. If it was approved, refund wallet balance & cleanup wallet transactions
        if ($usage['status'] === 'approved') {
            $directorId = $usage['director_id'];
            $amount = $usage['amount'];

            // Refund wallet balance
            $stmt = $db->prepare("UPDATE wallets SET balance = balance + ? WHERE user_id = ?");
            $stmt->execute([$amount, $directorId]);

            // Remove wallet transaction
            $stmt = $db->prepare("DELETE FROM wallet_transactions WHERE user_id = ? AND ref_type = 'fund_usage' AND ref_id = ?");
            $stmt->execute([$directorId, $id]);
        }

        // 3. Optionally remove proof file if exists
        if (!empty($usage['payment_proof'])) {
            $proofPath = __DIR__ . '/../../uploads/expense_docs/' . $usage['payment_proof'];
            if (file_exists($proofPath)) {
                @unlink($proofPath);
            }
        }

        // 4. Delete the expense record
        $stmt = $db->prepare("DELETE FROM fund_usages WHERE id = ?");
        $stmt->execute([$id]);

        $db->commit();
        setFlash('success', 'Expense record deleted successfully.');
    } catch (Exception $e) {
        if ($db->inTransaction()) {
            $db->rollBack();
        }
        setFlash('danger', 'Error deleting expense: ' . $e->getMessage());
    }

    redirect(site_url('public/admin/expense-reviews.php'));
} else {
    redirect(site_url('public/admin/expense-reviews.php'));
}
