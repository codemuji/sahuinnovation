<?php
/**
 * Request Withdrawal Action
 */

require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../config/database.php';

Auth::requireRole(['surveyer', 'dm', 'pe']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = Database::getInstance()->getConnection();
    $userId = Auth::userId();
    $role = Auth::userRole();

    $amount = floatval($_POST['amount'] ?? 0);
    $paymentInfo = trim($_POST['payment_info'] ?? '');

    if ($amount <= 0 || empty($paymentInfo)) {
        setFlash('danger', 'Invalid amount or payment information.');
        redirect(site_url("public/{$role}/wallet.php"));
    }

    try {
        $db->beginTransaction();

        // Check balance inside transaction with write-lock to prevent race conditions
        $stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ? FOR UPDATE");
        $stmt->execute([$userId]);
        $wallet = $stmt->fetch();
        $balance = $wallet['balance'] ?? 0;

        if ($amount > $balance) {
            throw new Exception("Insufficient balance.");
        }

        // 1. Insert Withdrawal Request
        $stmt = $db->prepare("INSERT INTO withdrawal_requests (user_id, amount, upi_or_account, status) VALUES (?, ?, ?, 'pending')");
        $stmt->execute([$userId, $amount, $paymentInfo]);
        $requestId = $db->lastInsertId();

        // 2. Deduct from Wallet Balance
        $stmt = $db->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?");
        $stmt->execute([$amount, $userId]);

        // 3. Create Debit Transaction record
        $stmt = $db->prepare("INSERT INTO wallet_transactions (user_id, ref_type, ref_id, type, amount, status, description) VALUES (?, 'withdrawal', ?, 'debit', ?, 'pending', 'Withdrawal Request')");
        $stmt->execute([$userId, $requestId, $amount]);

        $db->commit();
        setFlash('success', 'Withdrawal request submitted. Amount is now locked in your wallet.');
        redirect(site_url("public/{$role}/wallet.php"));

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        setFlash('danger', 'Error: ' . $e->getMessage());
        redirect(site_url("public/{$role}/wallet.php"));
    }
} else {
    redirect(site_url('public/index.php'));
}
