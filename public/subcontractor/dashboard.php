<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('subcontractor');

$db = Database::getInstance()->getConnection();
ensureSubcontractTables($db);
$userId = Auth::userId();
$user = Auth::user();

// Ensure wallet exists
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$wallet = $stmt->fetch();
$balance = $wallet['balance'] ?? 0.00;

// Fetch Subcontractor Projects
$stmt = $db->prepare("SELECT * FROM subcontract_projects WHERE contractor_id = ? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$projects = $stmt->fetchAll();

$totalProjects = count($projects);
$step12Count = 0;
$partPayCount = 0;
$completedCount = 0;
$totalEarnings = 0.00;

foreach ($projects as $p) {
    if ($p['contract_type'] === '12_step') {
        $step12Count++;
    } else {
        $partPayCount++;
    }
    if ($p['status'] === 'COMPLETED' || $p['status'] === '12. CUSTOMER FEEDBACK') {
        $completedCount++;
    }
    $totalEarnings += floatval($p['payment_1_amount']) + floatval($p['payment_2_amount']) + floatval($p['part_pay_amount']);
}

$recentProjects = array_slice($projects, 0, 5);

$pageTitle = "Sub-Contractor Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Welcome, <?= h($user['name']) ?></h1>
        <p>Sub-Contractor Portal — Overview of assigned projects, stage progression, and payment milestones.</p>
    </div>
</div>

<!-- Metrics Overview Cards -->
<div class="grid grid-4" style="margin-bottom: 35px;">
    <div class="desktop-card" style="border-left: 4px solid var(--accent); position: relative; overflow: hidden;">
        <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Assigned Sub-Contracts</div>
        <div style="font-size: 32px; font-weight: 800; color: var(--primary); margin-top: 6px; font-family: 'Outfit', sans-serif;"><?= $totalProjects ?></div>
        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Total projects allocated</div>
    </div>

    <div class="desktop-card" style="border-left: 4px solid var(--info);">
        <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">12-Step Projects</div>
        <div style="font-size: 32px; font-weight: 800; color: #0284c7; margin-top: 6px; font-family: 'Outfit', sans-serif;"><?= $step12Count ?></div>
        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Standard milestone workflow</div>
    </div>

    <div class="desktop-card" style="border-left: 4px solid #8b5cf6;">
        <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Part Pay Projects</div>
        <div style="font-size: 32px; font-weight: 800; color: #7c3aed; margin-top: 6px; font-family: 'Outfit', sans-serif;"><?= $partPayCount ?></div>
        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Partial payment model</div>
    </div>

    <div class="desktop-card" style="border-left: 4px solid var(--success);">
        <div style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Payouts Received</div>
        <div style="font-size: 28px; font-weight: 800; color: var(--success); margin-top: 6px; font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalEarnings) ?></div>
        <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Disbursed by MD</div>
    </div>
</div>

<!-- Recent Sub-Contracts Section -->
<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Sub-Contract Projects</h3>
            <p style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Latest project status updates and stage progression.</p>
        </div>
        <a href="projects.php" class="btn btn-primary" style="width: auto; height: 36px; padding: 0 16px; font-size: 13px; line-height: 36px; text-decoration: none;">
            View All Projects <i class="fa fa-arrow-right" style="margin-left: 6px;"></i>
        </a>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Consumer #</th>
                    <th>Contract Type</th>
                    <th>Current Stage Status</th>
                    <th>MD Payments</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentProjects)): ?>
                    <tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">No sub-contract projects assigned to you yet.</td></tr>
                <?php else:
                    foreach ($recentProjects as $p): ?>
                        <tr>
                            <td data-label="Customer">
                                <strong><?= h($p['customer_name']) ?></strong>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= h($p['phone']) ?></div>
                            </td>
                            <td data-label="Consumer #"><?= h($p['consumer_number']) ?: '<span style="color: var(--text-muted);">N/A</span>' ?></td>
                            <td data-label="Type">
                                <span class="badge" style="background: <?= $p['contract_type'] === '12_step' ? '#e0f2fe' : '#f3e8ff' ?>; color: <?= $p['contract_type'] === '12_step' ? '#0369a1' : '#6b21a8' ?>; font-size: 10px;">
                                    <?= $p['contract_type'] === '12_step' ? '12-STEP WORKFLOW' : 'PART PAY' ?>
                                </span>
                            </td>
                            <td data-label="Current Stage">
                                <span class="badge" style="background: #f1f5f9; color: var(--primary); font-size: 11px; font-weight: 700;">
                                    <?= h($p['status']) ?>
                                </span>
                            </td>
                            <td data-label="MD Payments">
                                <?php
                                $paidSum = floatval($p['payment_1_amount']) + floatval($p['payment_2_amount']) + floatval($p['part_pay_amount']);
                                ?>
                                <strong style="color: <?= $paidSum > 0 ? 'var(--success)' : 'var(--text-muted)' ?>;">
                                    <?= formatCurrency($paidSum) ?>
                                </strong>
                            </td>
                            <td data-label="Action" style="text-align: right;">
                                <a href="project-detail.php?id=<?= $p['id'] ?>" class="btn" style="width: auto; height: 30px; line-height: 30px; padding: 0 12px; font-size: 12px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600;">
                                    View Progress
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
