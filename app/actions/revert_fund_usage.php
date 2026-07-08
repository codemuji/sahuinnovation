<?php
/**
 * Revert Fund Usage Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = intval($_POST['id'] ?? 0);
    $adminNote = trim($_POST['admin_note'] ?? '');

    if (!$id || empty($adminNote)) {
        setFlash('danger', 'Please provide a correction message for the Director.');
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

        // 2. Set status to revert_back and add admin note
        $stmt = $db->prepare("UPDATE fund_usages SET status = 'revert_back', admin_note = ? WHERE id = ?");
        $stmt->execute([$adminNote, $id]);

        $db->commit();
        setFlash('success', 'Expense successfully reverted back to Director for correction.');
        redirect(site_url('public/admin/expense-reviews.php'));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url('public/admin/expense-reviews.php'));
    }
} else {
    redirect(site_url('public/admin/dashboard.php'));
}
