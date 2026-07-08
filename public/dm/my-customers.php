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
<div style="display: flex; gap: 10px; margin-bottom: 24px;">
    <a href="my-customers.php" class="badge" style="background: <?= !$statusFilter ? 'var(--primary)' : '#e2e8f0' ?>; color: <?= !$statusFilter ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">All Submissions</a>
    <a href="my-customers.php?status=pending" class="badge" style="background: <?= $statusFilter == 'pending' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'pending' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Pending Review</a>
    <a href="my-customers.php?status=approved" class="badge" style="background: <?= $statusFilter == 'approved' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'approved' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Approved</a>
    <a href="my-customers.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>
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
                    <th>Rejection Reason</th>
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
                            <td><span class="badge badge-<?= $customer['status'] ?>"><?= strtoupper($customer['status']) ?></span></td>
                            <td style="color: var(--danger); font-size: 13px;"><?= h($customer['rejection_reason']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
