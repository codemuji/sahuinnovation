<?php
/**
 * Wallet Model
 */

class Wallet {
    /**
     * Get user balance
     */
    public static function getBalance($userId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?: 0.00;
    }

    /**
     * Get pending earnings
     */
    public static function getPendingEarnings($userId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'pending'");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?: 0.00;
    }

    /**
     * Create user wallet if not exists
     */
    public static function ensureWallet($userId) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT IGNORE INTO wallets (user_id, balance) VALUES (?, 0)");
        $stmt->execute([$userId]);
    }
}
