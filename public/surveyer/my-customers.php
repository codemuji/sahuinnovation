<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('surveyer');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get filter
$statusFilter = $_GET['status'] ?? '';
$query = "SELECT * FROM survey_customers WHERE surveyer_id = ?";
$params = [$userId];

if ($statusFilter) {
    $query .= " AND status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$pageTitle = "My Customers";
include __DIR__ . '/../includes/header.php';
?>

<div style="margin-bottom: 24px;">
    <a href="dashboard.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">
        <i class="fa fa-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-top: 8px;">My Customers</h1>
</div>

<!-- Filters -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 5px;">
    <a href="my-customers.php" class="badge" style="background: <?= !$statusFilter ? 'var(--primary)' : 'var(--border)' ?>; color: <?= !$statusFilter ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 8px 16px;">All</a>
    <a href="my-customers.php?status=pending" class="badge" style="background: <?= $statusFilter == 'pending' ? '#00FFFF' : 'var(--border)' ?>; color: <?= $statusFilter == 'pending' ? 'black' : 'var(--text-muted)' ?>; text-decoration: none; padding: 8px 16px;">Pending</a>
    <a href="my-customers.php?status=revert_back" class="badge" style="background: <?= $statusFilter == 'revert_back' ? '#FF00FF' : 'var(--border)' ?>; color: <?= $statusFilter == 'revert_back' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 8px 16px;">Revert Back</a>
    <a href="my-customers.php?status=approved" class="badge" style="background: <?= $statusFilter == 'approved' ? 'var(--success)' : 'var(--border)' ?>; color: <?= $statusFilter == 'approved' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 8px 16px;">Approved</a>
    <a href="my-customers.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : 'var(--border)' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 8px 16px;">Rejected</a>
</div>

<div class="card" style="padding: 0;">
    <?php if (empty($customers)): ?>
        <div style="padding: 40px; text-align: center; color: var(--text-muted);">
            No customers found.
        </div>
    <?php else: ?>
        <?php foreach ($customers as $customer): ?>
            <div class="customer-item">
                <div class="customer-info" style="flex-grow: 1;">
                    <h4><?= h($customer['name']) ?></h4>
                    <p><?= h($customer['phone']) ?> • <?= date('d M Y', strtotime($customer['created_at'])) ?></p>
                    <?php if (($customer['status'] === 'rejected' || $customer['status'] === 'revert_back') && $customer['rejection_reason']): ?>
                        <p style="color: <?= $customer['status'] === 'rejected' ? 'var(--danger)' : '#FF00FF' ?>; font-size: 11px; margin-top: 4px;">
                            <strong><?= $customer['status'] === 'revert_back' ? 'Feedback:' : 'Reason:' ?></strong> <?= h($customer['rejection_reason']) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div style="text-align: right; display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                    <span class="badge badge-<?= $customer['status'] ?>"><?= str_replace('_', ' ', $customer['status']) ?></span>
                    <?php if ($customer['status'] === 'revert_back'): ?>
                        <a href="edit-customer.php?id=<?= $customer['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--accent); color: white; text-decoration: none; border-radius: 6px; display: flex; align-items: center;">
                            Edit & Resubmit
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
