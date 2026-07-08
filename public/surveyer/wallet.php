<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('surveyer');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get wallet info
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$wallet = $stmt->fetch();
$balance = $wallet['balance'] ?? 0.00;

// Get pending earnings
$stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'pending' AND type = 'credit'");
$stmt->execute([$userId]);
$pendingEarnings = $stmt->fetchColumn() ?: 0.00;

// Get transactions
$stmt = $db->prepare("SELECT * FROM wallet_transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 20");
$stmt->execute([$userId]);
$transactions = $stmt->fetchAll();

// Get withdrawal requests
$stmt = $db->prepare("SELECT * FROM withdrawal_requests WHERE user_id = ? ORDER BY requested_at DESC LIMIT 10");
$stmt->execute([$userId]);
$withdrawals = $stmt->fetchAll();

// Get user bank details for auto-fill
$stmt = $db->prepare("SELECT bank_name, account_number, ifsc_code, upi_id FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

$defaultPaymentInfo = "";
if ($user) {
    if (!empty($user['upi_id'])) {
        $defaultPaymentInfo .= "UPI: " . $user['upi_id'];
    }
    if (!empty($user['bank_name']) && !empty($user['account_number'])) {
        if (!empty($defaultPaymentInfo)) $defaultPaymentInfo .= "\n\n";
        $defaultPaymentInfo .= "Bank: " . $user['bank_name'] . "\nA/C: " . $user['account_number'] . "\nIFSC: " . $user['ifsc_code'];
    }
}

$pageTitle = "My Wallet";
include __DIR__ . '/../includes/header.php';
?>

<div style="margin-bottom: 24px;">
    <a href="dashboard.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">
        <i class="fa fa-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-top: 8px;">My Wallet</h1>
</div>

<div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, #1e1b4b 100%); color: white; border: none; margin-bottom: 32px;">
    <div style="font-size: 13px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Available Balance</div>
    <div style="font-size: 36px; font-weight: 700; margin-bottom: 16px;"><?= formatCurrency($balance) ?></div>
    <div style="font-size: 13px; opacity: 0.7;">Pending Approval: <?= formatCurrency($pendingEarnings) ?></div>
</div>

<div class="card">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--primary);">Request Withdrawal</h3>
    <form action="<?= site_url('app/actions/request_withdrawal.php') ?>" method="POST">
        <div class="form-group">
            <label class="form-label">Amount (Max: <?= formatCurrency($balance) ?>)</label>
            <input type="number" name="amount" class="form-control" step="0.01" min="1" max="<?= $balance ?>" required placeholder="Enter amount to withdraw">
        </div>
        <div class="form-group">
            <label class="form-label">UPI ID or Bank Details</label>
            <textarea name="payment_info" class="form-control" style="height: 100px; padding-top: 12px;" placeholder="Enter your UPI ID or Bank details" required><?= h($defaultPaymentInfo) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" <?= $balance <= 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' ?>>
            Submit Request
        </button>
    </form>
</div>

<div style="margin-top: 40px;">
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">Recent Transactions</h3>
    <div class="card" style="padding: 0;">
        <?php if (empty($transactions)): ?>
            <div style="padding: 30px; text-align: center; color: var(--text-muted); font-size: 14px;">
                No transactions yet.
            </div>
        <?php else: ?>
            <?php foreach ($transactions as $tx): ?>
                <div class="customer-item">
                    <div class="customer-info">
                        <div style="font-size: 14px; font-weight: 600;"><?= h($tx['description']) ?></div>
                        <div style="font-size: 12px; color: var(--text-muted);"><?= date('d M, h:i A', strtotime($tx['created_at'])) ?></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 700; color: <?= $tx['type'] == 'credit' ? 'var(--success)' : 'var(--danger)' ?>">
                            <?= $tx['type'] == 'credit' ? '+' : '-' ?><?= formatCurrency($tx['amount']) ?>
                        </div>
                        <span class="badge badge-<?= $tx['status'] ?>" style="font-size: 10px; padding: 2px 8px;"><?= $tx['status'] ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($withdrawals)): ?>
<div style="margin-top: 40px; margin-bottom: 40px;">
    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">Withdrawal Requests</h3>
    <div class="card" style="padding: 0;">
        <?php foreach ($withdrawals as $req): ?>
            <div class="customer-item">
                <div class="customer-info">
                    <div style="font-size: 14px; font-weight: 600;">Withdrawal Request</div>
                    <div style="font-size: 12px; color: var(--text-muted);"><?= date('d M, h:i A', strtotime($req['requested_at'])) ?></div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 700;"><?= formatCurrency($req['amount']) ?></div>
                    <span class="badge" style="font-size: 10px; padding: 2px 8px; background: <?= $req['status'] == 'pending' ? '#fef3c7' : ($req['status'] == 'paid' ? '#d1fae5' : '#fee2e2') ?>; color: <?= $req['status'] == 'pending' ? '#92400e' : ($req['status'] == 'paid' ? '#065f46' : '#991b1b') ?>;">
                        <?= strtoupper($req['status']) ?>
                    </span>
                    <?php if ($req['status'] == 'paid' && $req['payment_proof']): ?>
                        <div style="margin-top: 5px;">
                            <a href="<?= site_url('uploads/payouts/' . $req['payment_proof']) ?>" target="_blank" style="font-size: 11px; color: var(--primary); font-weight: 600; text-decoration: none;">
                                <i class="fa fa-image"></i> View Proof
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
