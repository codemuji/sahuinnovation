<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('subcontractor');

$db = Database::getInstance()->getConnection();
ensureSubcontractTables($db);
$userId = Auth::userId();

$filterType = $_GET['type'] ?? 'all';

$sql = "SELECT * FROM subcontract_projects WHERE contractor_id = ?";
$params = [$userId];

if ($filterType === '12_step') {
    $sql .= " AND contract_type = '12_step'";
} elseif ($filterType === 'part_pay') {
    $sql .= " AND contract_type = 'part_pay'";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$projects = $stmt->fetchAll();

$pageTitle = "My Sub-Contract Projects";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>My Sub-Contract Projects</h1>
        <p>Complete list of assigned projects, workflow stages, and disbursement updates.</p>
    </div>
</div>

<!-- Category Filter Tabs -->
<div style="display: flex; gap: 10px; margin-bottom: 25px; flex-wrap: wrap;">
    <a href="projects.php?type=all" class="btn" style="width: auto; height: 36px; padding: 0 18px; font-size: 13px; line-height: 36px; border: 1px solid var(--border); text-decoration: none; color: <?= $filterType === 'all' ? 'white' : 'var(--text-main)' ?>; background: <?= $filterType === 'all' ? 'var(--primary)' : 'white' ?>; font-weight: 600;">
        All Projects
    </a>
    <a href="projects.php?type=12_step" class="btn" style="width: auto; height: 36px; padding: 0 18px; font-size: 13px; line-height: 36px; border: 1px solid var(--border); text-decoration: none; color: <?= $filterType === '12_step' ? 'white' : 'var(--text-main)' ?>; background: <?= $filterType === '12_step' ? 'var(--accent)' : 'white' ?>; font-weight: 600;">
        12-Step Projects
    </a>
    <a href="projects.php?type=part_pay" class="btn" style="width: auto; height: 36px; padding: 0 18px; font-size: 13px; line-height: 36px; border: 1px solid var(--border); text-decoration: none; color: <?= $filterType === 'part_pay' ? 'white' : 'var(--text-main)' ?>; background: <?= $filterType === 'part_pay' ? '#7c3aed' : 'white' ?>; font-weight: 600;">
        Part Pay Projects
    </a>
</div>

<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Customer Name</th>
                    <th>Consumer #</th>
                    <th>Contract Model</th>
                    <th>Current Active Stage</th>
                    <th>Payments Released</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($projects)): ?>
                    <tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">No matching sub-contract projects found.</td></tr>
                <?php else:
                    foreach ($projects as $p):
                        $paidSum = floatval($p['payment_1_amount']) + floatval($p['payment_2_amount']) + floatval($p['part_pay_amount']);
                        ?>
                        <tr>
                            <td data-label="Date"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
                            <td data-label="Customer">
                                <strong><?= h($p['customer_name']) ?></strong>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= h($p['phone']) ?></div>
                            </td>
                            <td data-label="Consumer #"><?= h($p['consumer_number']) ?: '<span style="color: var(--text-muted);">N/A</span>' ?></td>
                            <td data-label="Model">
                                <span class="badge" style="background: <?= $p['contract_type'] === '12_step' ? '#e0f2fe' : '#f3e8ff' ?>; color: <?= $p['contract_type'] === '12_step' ? '#0369a1' : '#6b21a8' ?>; font-size: 10px;">
                                    <?= $p['contract_type'] === '12_step' ? '12-STEP FLOW' : 'PART PAY' ?>
                                </span>
                            </td>
                            <td data-label="Stage">
                                <span class="badge" style="background: #f8fafc; border: 1px solid var(--border); color: var(--primary); font-size: 11px; font-weight: 700;">
                                    <?= h($p['status']) ?>
                                </span>
                            </td>
                            <td data-label="Payments">
                                <strong style="color: <?= $paidSum > 0 ? 'var(--success)' : 'var(--text-muted)' ?>;">
                                    <?= formatCurrency($paidSum) ?>
                                </strong>
                            </td>
                            <td data-label="Action" style="text-align: right;">
                                <a href="project-detail.php?id=<?= $p['id'] ?>" class="btn" style="width: auto; height: 30px; line-height: 30px; padding: 0 14px; font-size: 12px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600;">
                                    <i class="fa fa-eye" style="margin-right: 4px;"></i> View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
