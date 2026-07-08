<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('staff');

$db = Database::getInstance()->getConnection();

$statusFilter = $_GET['status'] ?? 'pending';
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

$pageTitle = "Technical Review List";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Technical Review List</h1>
        <p>Review technical data and ownership documents submitted by DM and PE users.</p>
    </div>
</div>

<div style="display: flex; gap: 10px; margin-bottom: 24px;">
    <a href="technical-list.php?status=pending" class="badge" style="background: <?= $statusFilter == 'pending' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'pending' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Pending Review</a>
    <a href="technical-list.php?status=approved" class="badge" style="background: <?= $statusFilter == 'approved' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'approved' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Approved</a>
    <a href="technical-list.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>
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
                            <td><?= date('d M Y', strtotime($customer['created_at'])) ?></td>
                            <td><span class="badge badge-<?= $customer['status'] ?>"><?= strtoupper($customer['status']) ?></span></td>
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
