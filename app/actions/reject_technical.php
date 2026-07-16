<?php
/**
 * Reject Technical Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['staff', 'admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $id = $_POST['id'] ?? 0;
    $reason = trim($_POST['reason'] ?? '');

    if (!$id || empty($reason)) {
        setFlash('danger', 'Customer ID and rejection reason are required.');
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));
    }

    try {
        $db->beginTransaction();

        // 1. Get customer info
        $stmt = $db->prepare("SELECT * FROM technical_customers WHERE id = ?");
        $stmt->execute([$id]);
        $customer = $stmt->fetch();

        if (!$customer || $customer['status'] !== 'pending') {
            throw new Exception("Customer not found or not in pending status.");
        }

        // 2. Update customer status
        $stmt = $db->prepare("UPDATE technical_customers SET status = 'rejected', rejection_reason = ? WHERE id = ?");
        $stmt->execute([$reason, $id]);

        // 3. Update wallet transaction status
        $stmt = $db->prepare("UPDATE wallet_transactions SET status = 'rejected' WHERE ref_type = 'technical' AND ref_id = ?");
        $stmt->execute([$id]);

        $db->commit();
        setFlash('success', 'Technical record rejected.');
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));

    } catch (Exception $e) {
        $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/staff/technical-detail.php?id={$id}"));
    }
} else {
    redirect(site_url('public/staff/dashboard.php'));
}
