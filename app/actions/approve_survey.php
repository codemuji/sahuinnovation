<?php
/**
 * Approve Survey Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['staff', 'admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = $_POST['id'] ?? 0;

    if (!$id) {
        setFlash('danger', 'Invalid customer ID.');
        redirect(site_url('public/staff/survey-list.php'));
    }

    try {
        $db->beginTransaction();

        // 1. Get customer and surveyer info
        $stmt = $db->prepare("SELECT * FROM survey_customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer || $customer['status'] !== 'pending') {
            throw new Exception("Customer not found or not in pending status.");
        }

        $surveyerId = $customer['surveyer_id'];

        // 2. Update customer status
        $stmt = $db->prepare("UPDATE survey_customers SET status = 'approved' WHERE id = ?");
        $stmt->execute([$id]);

        // 3. Update wallet transaction status
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'approved' WHERE ref_type = 'survey' AND ref_id = ? AND user_id = ?");
        $stmt->execute([$id, $surveyerId]);

        // 4. Update wallet balance (create wallet row if it does not exist)
        $stmt = $db->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 30.00) ON DUPLICATE KEY UPDATE balance = balance + 30.00");
        $stmt->execute([$surveyerId]);

        $db->commit();
        setFlash('success', 'Survey approved successfully. Incentive credited to surveyer.');
        redirect(site_url("public/staff/survey-detail.php?id={$id}"));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/staff/survey-detail.php?id={$id}"));
    }
} else {
    redirect(site_url('public/staff/dashboard.php'));
}
