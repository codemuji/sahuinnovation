<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['dm', 'pe']);

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();
$role = Auth::userRole();

// Get total received amount (credited from Stage 5 approvals)
$stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'approved' AND type = 'credit' AND amount > 0");
$stmt->execute([$userId]);
$totalReceived = $stmt->fetchColumn() ?: 0.00;

// Get real transactions history
$stmt = $db->prepare("SELECT * FROM wallet_transactions WHERE user_id = ? AND amount > 0 ORDER BY created_at DESC LIMIT 100");
$stmt->execute([$userId]);
$transactions = $stmt->fetchAll();

$pageTitle = "Payouts & Transactions History";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Payouts &amp; Transactions History</h1>
        <p>View your total earnings and transaction history from Stage 5 approvals.</p>
    </div>
</div>

<div class="grid grid-3" style="margin-bottom: 32px;">
    <div class="desktop-card" style="background: linear-gradient(135deg, var(--primary) 0%, #1e1b4b 100%); color: white; border: none; padding: 32px;">
        <div style="font-size: 13px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Total Received Amount</div>
        <div style="font-size: 40px; font-weight: 700; color: var(--accent);"><?= formatCurrency($totalReceived) ?></div>
        <div style="font-size: 12px; opacity: 0.7; margin-top: 6px;">Credited directly upon Stage 5 approval</div>
    </div>
</div>

<div class="desktop-card" style="padding: 0;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700;">Transactions History</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Date &amp; Time</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transactions)): ?>
                    <tr><td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">No transactions recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($transactions as $tx): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($tx['description']) ?></td>
                            <td style="color: var(--text-muted); font-size: 13px;"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></td>
                            <td style="font-weight: 700; color: var(--success);">
                                +<?= formatCurrency($tx['amount']) ?>
                            </td>
                            <td><span class="badge badge-approved" style="font-size: 11px;"><?= strtoupper($tx['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
