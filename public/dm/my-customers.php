<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['dm', 'pe']);

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get filter
$statusFilter = $_GET['status'] ?? '';
$query = "SELECT * FROM technical_customers WHERE dm_id = ?";
$params = [$userId];

if ($statusFilter) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$pageTitle = "My Technical Customers";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>My Technical Customers</h1>
        <p>List of all customers you have submitted for technical verification.</p>
    </div>
    <a href="dashboard.php" class="btn" style="width: auto; background: var(--border); color: var(--text-main);">
        <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Back to Dashboard
    </a>
</div>

<!-- Filters -->
<?php
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
?>
<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 24px;">
    <a href="my-customers.php" class="badge" style="background: <?= !$statusFilter ? 'var(--primary)' : '#e2e8f0' ?>; color: <?= !$statusFilter ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">All Submissions</a>
    <a href="my-customers.php?status=APPLICATION" class="badge" style="background: <?= $statusFilter == 'APPLICATION' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'APPLICATION' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">1. Application</a>
    <a href="my-customers.php?status=DM%2FAGENT+PAYMENT" class="badge" style="background: <?= $statusFilter == 'DM/AGENT PAYMENT' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'DM/AGENT PAYMENT' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">5. DM/Agent Payment</a>
    <a href="my-customers.php?status=CUSTOMER+FEEDBACK" class="badge" style="background: <?= $statusFilter == 'CUSTOMER FEEDBACK' ? 'var(--info)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'CUSTOMER FEEDBACK' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">11. Customer Feedback</a>
    <a href="my-customers.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>

    <form method="GET" action="my-customers.php" style="margin-left: auto; display: flex; gap: 8px;">
        <select name="status" onchange="this.form.submit()" class="form-control" style="padding: 8px 12px; border-radius: 6px; border: 1px solid var(--border); font-size: 13px;">
            <option value="">Filter by Stage...</option>
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
                    <th>Phone</th>
                    <th>Date Submitted</th>
                    <th>Consumer Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">No submissions found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($customer['name']) ?></td>
                            <td><?= h($customer['phone']) ?></td>
                            <td><?= date('d M Y, h:i A', strtotime($customer['created_at'])) ?></td>
                            <td><?= h($customer['consumer_number']) ?: 'N/A' ?></td>
                            <td><span class="badge badge-<?= $customer['status'] === 'rejected' ? 'rejected' : 'approved' ?>"><?= strtoupper($customer['status']) ?></span></td>
                            <td>
                                <a href="../staff/technical-detail.php?id=<?= $customer['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--primary); color: white;">
                                    View Pipeline & Details
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
