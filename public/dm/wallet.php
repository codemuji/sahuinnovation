<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['dm', 'pe']);

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();
$role = Auth::userRole();

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
$stmt = $db->prepare("SELECT * FROM wallet_transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 50");
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

<div class="panel-header">
    <div class="panel-title">
        <h1>My Wallet</h1>
        <p>Manage your earnings and withdrawal requests.</p>
    </div>
</div>

<div class="grid grid-2" style="margin-bottom: 40px; align-items: start;">
    <div class="desktop-card" style="background: linear-gradient(135deg, var(--primary) 0%, #1e1b4b 100%); color: white; border: none; padding: 40px;">
        <div style="font-size: 14px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Available Balance</div>
        <div style="font-size: 48px; font-weight: 700; margin-bottom: 24px; color: var(--accent);"><?= formatCurrency($balance) ?></div>
        <div style="display: flex; gap: 32px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1);">
            <div>
                <div style="font-size: 12px; opacity: 0.7;">Pending Approval</div>
                <div style="font-size: 18px; font-weight: 600;"><?= formatCurrency($pendingEarnings) ?></div>
            </div>
            <div>
                <div style="font-size: 12px; opacity: 0.7;">Lifetime Earned</div>
                <?php
                $stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'approved' AND type = 'credit'");
                $stmt->execute([$userId]);
                $lifetime = $stmt->fetchColumn() ?: 0.00;
                ?>
                <div style="font-size: 18px; font-weight: 600;"><?= formatCurrency($lifetime) ?></div>
            </div>
        </div>
    </div>

    <div class="desktop-card">
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px; color: var(--primary);">Request Withdrawal</h3>
        <form action="<?= site_url('app/actions/request_withdrawal.php') ?>" method="POST">
            <div class="form-group">
                <label class="form-label">Withdrawal Amount (Max: <?= formatCurrency($balance) ?>)</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="1" max="<?= $balance ?>" required placeholder="0.00">
            </div>
            <div class="form-group">
                <label class="form-label">UPI ID or Bank Account Details</label>
                <textarea name="payment_info" class="form-control" style="height: 100px; padding-top: 12px;" placeholder="Provide your UPI ID or Bank Account Number, IFSC, and Branch Name." required><?= h($defaultPaymentInfo) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" <?= $balance <= 0 ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : '' ?>>
                Confirm Withdrawal Request
            </button>
        </form>
    </div>
</div>

<div class="grid grid-2" style="align-items: start;">
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700;">Wallet Transactions</h3>
        </div>
        <div class="table-responsive" style="max-height: 500px;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="3" style="text-align: center; padding: 24px; color: var(--text-muted);">No transactions yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600;"><?= h($tx['description']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></div>
                                </td>
                                <td style="font-weight: 700; color: <?= $tx['type'] == 'credit' ? 'var(--success)' : 'var(--danger)' ?>">
                                    <?= $tx['type'] == 'credit' ? '+' : '-' ?><?= formatCurrency($tx['amount']) ?>
                                </td>
                                <td><span class="badge badge-<?= $tx['status'] ?>" style="font-size: 10px;"><?= strtoupper($tx['status']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700;">Recent Payouts</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($withdrawals)): ?>
                        <tr><td colspan="3" style="text-align: center; padding: 24px; color: var(--text-muted);">No payout requests yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($withdrawals as $req): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($req['requested_at'])) ?></td>
                                <td style="font-weight: 700;"><?= formatCurrency($req['amount']) ?></td>
                                <td>
                                    <span class="badge" style="font-size: 10px; background: <?= $req['status'] == 'pending' ? '#fef3c7' : ($req['status'] == 'paid' ? '#d1fae5' : '#fee2e2') ?>; color: <?= $req['status'] == 'pending' ? '#92400e' : ($req['status'] == 'paid' ? '#065f46' : '#991b1b') ?>;">
                                        <?= strtoupper($req['status']) ?>
                                    </span>
                                    <?php if ($req['status'] == 'paid' && $req['payment_proof']): ?>
                                        <div style="margin-top: 5px;">
                                            <a href="<?= site_url('uploads/payouts/' . $req['payment_proof']) ?>" target="_blank" style="font-size: 11px; color: var(--primary); font-weight: 600; text-decoration: none;">
                                                <i class="fa fa-image"></i> View Proof
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
