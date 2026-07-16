<?php
/**
 * Revert Survey Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['staff', 'admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = $_POST['id'] ?? 0;
    $reason = trim($_POST['reason'] ?? '');

    if (!$id || empty($reason)) {
        setFlash('danger', 'Customer ID and revert reason are required.');
        redirect(site_url("public/staff/survey-detail.php?id={$id}"));
    }

    try {
        $db->beginTransaction();

        // 1. Get customer info
        $stmt = $db->prepare("SELECT * FROM survey_customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer || $customer['status'] !== 'pending') {
            throw new Exception("Customer not found or not in pending status.");
        }

        // 2. Update customer status to revert_back
        $stmt = $db->prepare("UPDATE survey_customers SET status = 'revert_back', rejection_reason = ? WHERE id = ?");
        $stmt->execute([$reason, $id]);

        // 3. Keep wallet transaction as pending (or we could reject it, but revert usually implies resubmission)
        // For now, let's keep it pending so it doesn't disappear from surveyor's potential earnings
        // or we can set it to 'rejected' and create a new one on resubmit.
        // Let's set it to 'rejected' to be safe, as the surveyor will submit a "new" version.
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'rejected', description = CONCAT('REVERTED: ', description) WHERE ref_type = 'survey' AND ref_id = ?");
        $stmt->execute([$id]);

        $db->commit();
        setFlash('success', 'Survey reverted back to surveyor for corrections.');
        redirect(site_url("public/staff/survey-detail.php?id={$id}"));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/staff/survey-detail.php?id={$id}"));
    }
} else {
    redirect(site_url('public/staff/dashboard.php'));
}
