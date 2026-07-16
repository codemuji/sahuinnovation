<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['dm', 'pe']);

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();
$role = Auth::userRole();

// Get counts
$stmt = $db->prepare("SELECT status, COUNT(*) as count FROM technical_customers WHERE dm_id = ? GROUP BY status");
$stmt->execute([$userId]);
$counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$pendingCount = ($counts['pending'] ?? 0) + ($counts['APPLICATION'] ?? 0);
$rejectedCount = $counts['rejected'] ?? 0;
$approvedCount = 0;
foreach ($counts as $stg => $cnt) {
    if (!in_array($stg, ['pending', 'APPLICATION', 'rejected'])) {
        $approvedCount += $cnt;
    }
}

// Total received amount (credited from Stage 5 approvals)
$stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'approved' AND type = 'credit' AND amount > 0");
$stmt->execute([$userId]);
$totalReceived = $stmt->fetchColumn() ?: 0.00;

$pageTitle = strtoupper($role) . " Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Welcome, <?= h($user['name']) ?></h1>
        <p>Manage your technical customer submissions and view payouts.</p>
    </div>
    <a href="add-customer.php" class="btn btn-primary" style="width: auto;">
        <i class="fa fa-plus-circle" style="margin-right: 8px;"></i> Add Consumer
    </a>
</div>

<div class="grid grid-3" style="margin-bottom: 32px;">
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Received Amount</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--success);"><?= formatCurrency($totalReceived) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Direct payouts on Stage 5 approval</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Approved Records</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--accent);"><?= $approvedCount ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Lifetime completions</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Pending Review</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--warning);"><?= $pendingCount ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Awaiting staff action</div>
    </div>
</div>

<div class="desktop-card" style="padding: 0;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 16px; font-weight: 700;">Recent Submissions</h3>
        <a href="my-customers.php" style="font-size: 13px; color: var(--accent); text-decoration: none;">View All</a>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Zone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM technical_customers WHERE dm_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$userId]);
                $recent = $stmt->fetchAll();

                if (empty($recent)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">No records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recent as $row): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($row['name']) ?></td>
                            <td><?= h($row['phone']) ?></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                            <td><?= h($row['zone']) ?></td>
                            <td><span class="badge badge-<?= $row['status'] === 'rejected' ? 'rejected' : 'approved' ?>"><?= h($row['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
