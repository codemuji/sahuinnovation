<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Status filters
$statusFilter = $_GET['status'] ?? '';

// Build query
$sql = "SELECT * FROM fund_usages WHERE director_id = ?";
$params = [$userId];

if ($statusFilter !== '') {
    $sql .= " AND status = ?";
    $params[] = $statusFilter;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$usages = $stmt->fetchAll();

$pageTitle = "Expense Logs";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
    <div class="panel-title">
        <h1>Expense Logs</h1>
        <p>List of all logged fund usages and their approval statuses.</p>
    </div>
    <div>
        <a href="add-usage.php" class="btn btn-primary" style="width: auto; padding: 0 20px;"><i class="fa fa-plus" style="margin-right: 8px;"></i> Log New Expense</a>
    </div>
</div>

<!-- Filters -->
<div class="desktop-card" style="padding: 15px; margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="usages.php" class="btn" style="width: auto; height: 36px; padding: 0 15px; font-size: 13px; line-height: 36px; background: <?= $statusFilter === '' ? 'var(--primary)' : 'transparent' ?>; color: <?= $statusFilter === '' ? 'white' : 'var(--text-main)' ?>; border: 1px solid var(--border); text-decoration: none;">All Expenses</a>
    <a href="usages.php?status=pending" class="btn" style="width: auto; height: 36px; padding: 0 15px; font-size: 13px; line-height: 36px; background: <?= $statusFilter === 'pending' ? 'var(--primary)' : 'transparent' ?>; color: <?= $statusFilter === 'pending' ? 'white' : 'var(--text-main)' ?>; border: 1px solid var(--border); text-decoration: none;">Pending Reviews</a>
    <a href="usages.php?status=approved" class="btn" style="width: auto; height: 36px; padding: 0 15px; font-size: 13px; line-height: 36px; background: <?= $statusFilter === 'approved' ? 'var(--primary)' : 'transparent' ?>; color: <?= $statusFilter === 'approved' ? 'white' : 'var(--text-main)' ?>; border: 1px solid var(--border); text-decoration: none;">Approved</a>
    <a href="usages.php?status=revert_back" class="btn" style="width: auto; height: 36px; padding: 0 15px; font-size: 13px; line-height: 36px; background: <?= $statusFilter === 'revert_back' ? 'var(--primary)' : 'transparent' ?>; color: <?= $statusFilter === 'revert_back' ? 'white' : 'var(--text-main)' ?>; border: 1px solid var(--border); text-decoration: none;">Reverted / Corrections Required</a>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Purpose</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usages)): ?>
                    <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">No expense records match the filter.</td></tr>
                <?php else:
                    foreach ($usages as $u): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($u['created_at'])) ?></td>
                            <td><strong style="color: var(--primary);"><?= h($u['purpose']) ?></strong></td>
                            <td style="max-width: 250px; font-size: 13px;"><?= nl2br(h($u['description'])) ?: '<span style="color: var(--text-muted);">No description</span>' ?></td>
                            <td style="font-weight: 800; font-size: 15px;"><?= formatCurrency($u['amount']) ?></td>
                            <td>
                                <?php if ($u['payment_proof']): ?>
                                    <a href="<?= site_url('public/file.php?type=expense&file=' . urlencode($u['payment_proof'])) ?>" target="_blank" class="btn" style="width: auto; height: 28px; font-size: 11px; padding: 0 8px; line-height: 28px; border: 1px solid var(--border); background: var(--background); text-decoration: none; color: var(--text-main);">
                                        <i class="fa fa-file-invoice"></i> View Proof
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--danger); font-size: 11px;">Missing</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                $bg = '#fef3c7'; $fg = '#92400e';
                                if ($u['status'] === 'approved') { $bg = '#d1fae5'; $fg = '#065f46'; }
                                elseif ($u['status'] === 'revert_back') { $bg = '#fee2e2'; $fg = '#991b1b'; }
                                ?>
                                <span class="badge" style="background: <?= $bg ?>; color: <?= $fg ?>;">
                                    <?= strtoupper($u['status'] === 'revert_back' ? 'REVERTED' : $u['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($u['status'] === 'revert_back'): ?>
                                    <a href="edit-usage.php?id=<?= $u['id'] ?>" class="btn btn-primary" style="width: auto; height: 28px; font-size: 11px; padding: 0 12px; line-height: 28px; text-decoration: none;">
                                        <i class="fa fa-edit"></i> Correct
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 11px;">No Action</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if ($u['status'] === 'revert_back' && $u['admin_note']): ?>
                            <tr style="background: #fff5f5;">
                                <td colspan="7" style="border-top: none; padding: 10px 20px;">
                                    <div style="padding: 10px 15px; border-left: 4px solid var(--danger); background-color: #fff; font-size: 13px; color: #991b1b; border-radius: 4px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);">
                                        <strong>MD Correction Note:</strong> <?= h($u['admin_note']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
// Fetch last 10 expenses from all directors
$stmtAll = $db->query("SELECT f.*, u.name as director_name FROM fund_usages f 
    JOIN users u ON f.director_id = u.id 
    ORDER BY f.created_at DESC LIMIT 10");
$allUsages = $stmtAll->fetchAll();
?>

<!-- Recent Expenses of All Directors Section -->
<div class="desktop-card" style="padding: 0; margin-top: 40px; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Expenses of All Directors (Last 10)</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Director</th>
                    <th>Purpose</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($allUsages)): ?>
                    <tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No expenses logged by any directors yet.</td></tr>
                <?php else:
                    foreach ($allUsages as $au): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($au['created_at'])) ?></td>
                            <td>
                                <strong style="color: var(--primary);"><?= h($au['director_name']) ?></strong>
                                <?php if ($au['director_id'] == $userId): ?>
                                    <span style="font-size: 10px; background: #e0f2fe; color: #0369a1; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: 4px;">YOU</span>
                                <?php endif; ?>
                            </td>
                            <td><?= h($au['purpose']) ?></td>
                            <td style="max-width: 250px; font-size: 13px;"><?= nl2br(h($au['description'])) ?: '<span style="color: var(--text-muted);">No description</span>' ?></td>
                            <td style="font-weight: 700;"><?= formatCurrency($au['amount']) ?></td>
                            <td>
                                <?php
                                $bg = '#fef3c7'; $fg = '#92400e';
                                if ($au['status'] === 'approved') { $bg = '#d1fae5'; $fg = '#065f46'; }
                                elseif ($au['status'] === 'revert_back') { $bg = '#fee2e2'; $fg = '#991b1b'; }
                                ?>
                                <span class="badge" style="background: <?= $bg ?>; color: <?= $fg ?>; font-size: 10px;">
                                    <?= strtoupper($au['status'] === 'revert_back' ? 'REVERTED' : $au['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
