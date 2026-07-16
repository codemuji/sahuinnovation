<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin']);

$db = Database::getInstance()->getConnection();

$statusFilter = $_GET['status'] ?? 'pending';
$query = "SELECT s.*, u.name as surveyer_name FROM survey_customers s JOIN users u ON s.surveyer_id = u.id";
$params = [];

if ($statusFilter) {
    $query .= " WHERE s.status = ?";
    $params[] = $statusFilter;
}

$query .= " ORDER BY s.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$pageTitle = "Survey Review List";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Survey Review List</h1>
        <p>Review customer data and documents collected by field agents.</p>
    </div>
</div>

<div style="display: flex; gap: 10px; margin-bottom: 24px;">
    <a href="survey-list.php?status=pending" class="badge" style="background: <?= $statusFilter == 'pending' ? '#00FFFF' : '#e2e8f0' ?>; color: <?= $statusFilter == 'pending' ? 'black' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Pending Review</a>
    <a href="survey-list.php?status=revert_back" class="badge" style="background: <?= $statusFilter == 'revert_back' ? '#FF00FF' : '#e2e8f0' ?>; color: <?= $statusFilter == 'revert_back' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Revert Back</a>
    <a href="survey-list.php?status=approved" class="badge" style="background: <?= $statusFilter == 'approved' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'approved' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Approved</a>
    <a href="survey-list.php?status=rejected" class="badge" style="background: <?= $statusFilter == 'rejected' ? 'var(--danger)' : '#e2e8f0' ?>; color: <?= $statusFilter == 'rejected' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Rejected</a>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Surveyer</th>
                    <th>Phone</th>
                    <th>Date Submitted</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">No records found for this status.</td></tr>
                <?php else: ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($customer['name']) ?></td>
                            <td><?= h($customer['surveyer_name']) ?></td>
                            <td><?= h($customer['phone']) ?></td>
                            <td><?= date('d M Y, h:i A', strtotime($customer['created_at'])) ?></td>
                            <td><span class="badge badge-<?= $customer['status'] ?>"><?= str_replace('_', ' ', strtoupper($customer['status'])) ?></span></td>
                            <td>
                                <a href="survey-detail.php?id=<?= $customer['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--primary); color: white;">
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
