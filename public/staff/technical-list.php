<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin']);

$db = Database::getInstance()->getConnection();

$statusFilter = $_GET['status'] ?? '';
$query = "SELECT t.*, u.name as dm_name, u.role as dm_role FROM technical_customers t JOIN users u ON t.dm_id = u.id";
$params = [];

if ($statusFilter) {
    $query .= " WHERE t.status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY t.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$stages = [
    'APPLICATION',
    'APPLY ON OFFICIAL SITE',
    'LOAN PROCESS TO BANK',
    'LOAN DISBURSEMENT',
    'DM/AGENT PAYMENT',
    'INSTALLATION',
    'ACTIVATION BY APDCL',
    'SUBSIDY REQUEST',
    'SUBSIDY DISBURSEMENT',
    'LOAN 2ND DISBURSEMENT',
    'CUSTOMER FEEDBACK'
];

$pageTitle = "PM Surya Ghar Application List";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>PM Surya Ghar Application List</h1>
        <p>Review and update technical data across all 11 customer status stages.</p>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 24px;">
    <a href="technical-list.php" class="badge" style="background: <?= $statusFilter === '' ? 'var(--primary)' : '#e2e8f0' ?>; color: <?= $statusFilter === '' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">All Submissions</a>
    <a href="technical-list.php?status=APPLICATION" class="badge" style="background: <?= $statusFilter === 'APPLICATION' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $statusFilter === 'APPLICATION' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">1. Application</a>
    <a href="technical-list.php?status=DM%2FAGENT+PAYMENT" class="badge" style="background: <?= $statusFilter === 'DM/AGENT PAYMENT' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter === 'DM/AGENT PAYMENT' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">5. DM/Agent Payment</a>
    <a href="technical-list.php?status=CUSTOMER+FEEDBACK" class="badge" style="background: <?= $statusFilter === 'CUSTOMER FEEDBACK' ? 'var(--info)' : '#e2e8f0' ?>; color: <?= $statusFilter === 'CUSTOMER FEEDBACK' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">11. Customer Feedback</a>
    <a href="technical-list.php?status=rejected" class="badge" style="background: <?= $statusFilter === 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter === 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>

    <form method="GET" action="technical-list.php" style="margin-left: auto; display: flex; gap: 8px;">
        <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 8px 12px; border-radius: 6px; border: 1px solid var(--border); font-size: 13px;">
            <option value="">Filter by Specific Stage...</option>
            <?php foreach ($stages as $idx => $stg): ?>
                <option value="<?= h($stg) ?>" <?= $statusFilter === $stg ? 'selected' : '' ?>><?= ($idx + 1) . '. ' . h($stg) ?></option>
            <?php endforeach; ?>
            <option value="rejected" <?= $statusFilter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
    </form>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Submitted By</th>
                    <th>Role</th>
                    <th>Consumer Number</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr><td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">No records found for this status.</td></tr>
                <?php else: ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($customer['name']) ?></td>
                            <td><?= h($customer['dm_name']) ?></td>
                            <td><span style="font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.7;"><?= h($customer['dm_role']) ?></span></td>
                            <td><?= h($customer['consumer_number']) ?: 'N/A' ?></td>
                            <?php
                            $badgeBgList = ($customer['status'] === 'rejected') ? '#ef4444' : (($customer['status'] === 'CUSTOMER FEEDBACK') ? '#10b981' : '#f97316');
                            ?>
                            <td><span class="badge" style="background: <?= $badgeBgList ?>; color: white;"><?= strtoupper($customer['status']) ?></span></td>
                            <td>
                                <a href="technical-detail.php?id=<?= $customer['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--primary); color: white;">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
