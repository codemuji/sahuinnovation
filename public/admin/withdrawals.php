<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

$statusFilter = $_GET['status'] ?? 'pending';
$query = "SELECT w.*, u.name as user_name, u.role as user_role, u.email as user_email FROM withdrawal_requests w JOIN users u ON w.user_id = u.id";
$params = [];

if ($statusFilter) {
    $query .= " WHERE w.status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY w.requested_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$requests = $stmt->fetchAll();

$pageTitle = "Withdrawal Requests";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Withdrawal Requests</h1>
        <p>Review and process incentive payout requests from agents.</p>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 24px;">
    <a href="withdrawals.php?status=pending" class="badge" style="background: <?= $statusFilter == 'pending' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'pending' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Pending Payouts</a>
    <a href="withdrawals.php?status=paid" class="badge" style="background: <?= $statusFilter == 'paid' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'paid' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Paid History</a>
    <a href="withdrawals.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>
    <a href="<?= site_url('public/admin/stage5-payouts.php') ?>" class="badge" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; margin-left: auto;"><i class="fa fa-wallet" style="margin-right: 6px;"></i> Stage 5 Payouts (Credit DM/Agent) &rarr;</a>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Amount</th>
                    <th>Payment Info</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)): ?>
                    <tr><td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No withdrawal requests found.</td></tr>
                <?php else: ?>
                    <?php foreach ($requests as $req): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 600;"><?= h($req['user_name']) ?></div>
                                <div style="font-size: 11px; opacity: 0.7;"><?= h($req['user_email']) ?></div>
                            </td>
                            <td><span style="font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.7;"><?= h($req['user_role']) ?></span></td>
                            <td style="font-weight: 700; color: var(--primary);"><?= formatCurrency($req['amount']) ?></td>
                            <td>
                                <div style="max-width: 250px; font-size: 13px; line-height: 1.4;">
                                    <?= nl2br(h($req['upi_or_account'])) ?>
                                </div>
                            </td>
                            <td><?= date('d M Y', strtotime($req['requested_at'])) ?></td>
                            <td><span class="badge" style="background: <?= $req['status'] == 'pending' ? '#fef3c7' : ($req['status'] == 'paid' ? '#d1fae5' : '#fee2e2') ?>; color: <?= $req['status'] == 'pending' ? '#92400e' : ($req['status'] == 'paid' ? '#065f46' : '#991b1b') ?>;"><?= strtoupper($req['status']) ?></span></td>
                            <td>
                                <?php if ($req['status'] === 'pending'): ?>
                                    <div style="display: flex; gap: 8px;">
                                        <form action="<?= site_url('app/actions/mark_withdrawal_paid.php') ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Mark this request as PAID? Ensure you have sent the money manually.')">
                                            <input type="hidden" name="id" value="<?= $req['id'] ?>">
                                            <div style="display: flex; flex-direction: column; gap: 5px;">
                                                <input type="file" name="payment_proof" style="font-size: 10px; width: 140px;" accept="image/*" title="Payment Proof">
                                                <button type="submit" class="btn" style="height: 28px; padding: 0 12px; font-size: 11px; width: auto; background: var(--success); color: white;">Mark Paid</button>
                                            </div>
                                        </form>
                                        <form action="<?= site_url('app/actions/reject_withdrawal.php') ?>" method="POST" onsubmit="return confirm('Reject this withdrawal request?')">
                                            <input type="hidden" name="id" value="<?= $req['id'] ?>">
                                            <button type="submit" class="btn" style="height: 32px; padding: 0 12px; font-size: 11px; width: auto; background: var(--danger); color: white;">Reject</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        Processed on <?= $req['resolved_at'] ? date('d M Y', strtotime($req['resolved_at'])) : 'N/A' ?>
                                        <?php if ($req['payment_proof']): ?>
                                            <div style="margin-top: 5px;">
                                                <a href="<?= site_url('uploads/payouts/' . $req['payment_proof']) ?>" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                                                    <i class="fa fa-image"></i> View Proof
                                                </a>
                                            </div>
                                        <?php endif; ?>
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

<?php include __DIR__ . '/../includes/footer.php'; ?>
