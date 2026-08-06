<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('subcontractor');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();
$id = intval($_GET['id'] ?? 0);

if (!$id) {
    setFlash('danger', 'Invalid project ID.');
    redirect(site_url('public/subcontractor/projects.php'));
}

$stmt = $db->prepare("SELECT p.*, s.name as staff_name FROM subcontract_projects p 
    LEFT JOIN users s ON p.created_by_staff_id = s.id 
    WHERE p.id = ? AND p.contractor_id = ?");
$stmt->execute([$id, $userId]);
$project = $stmt->fetch();

if (!$project) {
    setFlash('danger', 'Sub-contract project not found.');
    redirect(site_url('public/subcontractor/projects.php'));
}

// Fetch documents for this project
$stmt = $db->prepare("SELECT d.*, u.name as uploader_name FROM subcontract_documents d JOIN users u ON d.uploaded_by = u.id WHERE d.project_id = ? ORDER BY d.uploaded_at DESC");
$stmt->execute([$id]);
$documents = $stmt->fetchAll();

// Define 12 Steps Workflow Array
$steps = [
    1 => ['name' => '1. APPLICATION', 'actor' => 'Staff'],
    2 => ['name' => '2. APPLY ON OFFICIAL SITE', 'actor' => 'Staff'],
    3 => ['name' => '3. LOAN PROCESS TO BANK', 'actor' => 'Staff'],
    4 => ['name' => '4. LOAN DISBURSEMENT', 'actor' => 'Staff'],
    5 => ['name' => '5. SUB CONTRACT 1ST PAYMENT', 'actor' => 'MD'],
    6 => ['name' => '6. INSTALLATION', 'actor' => 'Staff'],
    7 => ['name' => '7. ACTIVATION BY APDCL', 'actor' => 'Staff'],
    8 => ['name' => '8. SUBSIDY REQUEST', 'actor' => 'Staff'],
    9 => ['name' => '9. SUBSIDY DISBURSEMENT', 'actor' => 'Staff'],
    10 => ['name' => '10. LOAN 2ND DISBURSEMENT', 'actor' => 'Staff'],
    11 => ['name' => '11. SUB CONTRACT 2ND PAYMENT', 'actor' => 'MD'],
    12 => ['name' => '12. CUSTOMER FEEDBACK', 'actor' => 'Staff'],
];

// Determine current active step index
$currentStepNum = 1;
if (preg_match('/^(\d+)\./', $project['status'], $matches)) {
    $currentStepNum = intval($matches[1]);
} elseif ($project['status'] === 'COMPLETED') {
    $currentStepNum = 13;
}

$pageTitle = "Sub-Contract Project Timeline";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="projects.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px; font-weight: 500;">
            <i class="fa fa-arrow-left"></i> Back to Sub-Contracts
        </a>
        <h1 style="margin-top: 8px;"><?= h($project['customer_name']) ?></h1>
        <p>Consumer #: <strong><?= h($project['consumer_number']) ?: 'N/A' ?></strong> | Assigned Staff: <strong><?= h($project['staff_name']) ?></strong></p>
    </div>
</div>

<!-- Overview Banner Card -->
<div class="desktop-card" style="margin-bottom: 30px; border-left: 4px solid <?= $project['contract_type'] === '12_step' ? 'var(--accent)' : '#7c3aed' ?>;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px;">
        <div>
            <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px;">Customer Details</div>
            <h2 style="font-size: 20px; font-weight: 700; color: var(--primary); margin-top: 4px;"><?= h($project['customer_name']) ?></h2>
            <div style="font-size: 13px; color: var(--text-main); margin-top: 4px;"><i class="fa fa-phone" style="margin-right: 6px; color: var(--text-muted);"></i><?= h($project['phone']) ?></div>
            <div style="font-size: 13px; color: var(--text-muted); margin-top: 2px;"><i class="fa fa-location-dot" style="margin-right: 6px;"></i><?= h($project['address']) ?></div>
        </div>
        <div style="text-align: right;">
            <span class="badge" style="background: <?= $project['contract_type'] === '12_step' ? '#e0f2fe' : '#f3e8ff' ?>; color: <?= $project['contract_type'] === '12_step' ? '#0369a1' : '#6b21a8' ?>; font-size: 11px;">
                <?= $project['contract_type'] === '12_step' ? '12-STEP SUB CONTRACT' : 'PART PAY SUB CONTRACT' ?>
            </span>
            <div style="margin-top: 10px; font-size: 12px; color: var(--text-muted);">Current Active Stage:</div>
            <div style="font-size: 16px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= h($project['status']) ?></div>
        </div>
    </div>
</div>

<?php if ($project['contract_type'] === '12_step'): ?>
<!-- 12-STEP VISUAL PROGRESS TIMELINE -->
<div class="desktop-card" style="margin-bottom: 40px; padding: 24px;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 10px;">
        12-Step Sub-Contract Workflow Timeline
    </h3>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
        <?php foreach ($steps as $num => $s):
            $isPassed = $currentStepNum > $num;
            $isCurrent = $currentStepNum === $num;
            $isMDStep = ($num === 5 || $num === 11);
            
            $bg = $isCurrent ? '#eff6ff' : ($isPassed ? '#f0fdf4' : '#f8fafc');
            $borderColor = $isCurrent ? 'var(--accent)' : ($isPassed ? 'var(--success)' : 'var(--border)');
            $iconColor = $isCurrent ? 'var(--accent)' : ($isPassed ? 'var(--success)' : '#94a3b8');
            ?>
            <div style="background: <?= $bg ?>; border: 1.5px solid <?= $borderColor ?>; border-radius: var(--radius); padding: 14px; position: relative;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <span style="font-size: 11px; font-weight: 800; color: <?= $isPassed ? '#15803d' : ($isCurrent ? '#0369a1' : 'var(--text-muted)') ?>; text-transform: uppercase;">
                        Step <?= $num ?>
                    </span>
                    <span class="badge" style="background: <?= $isMDStep ? '#fef3c7' : '#e2e8f0' ?>; color: <?= $isMDStep ? '#92400e' : '#334155' ?>; font-size: 9px; font-weight: 700;">
                        <?= $s['actor'] ?>
                    </span>
                </div>
                <div style="font-size: 13px; font-weight: 700; color: var(--primary); margin-bottom: 6px;">
                    <?= h($s['name']) ?>
                </div>

                <!-- Milestone Payment Indicators for Steps 5 & 11 -->
                <?php if ($num === 5 && floatval($project['payment_1_amount']) > 0): ?>
                    <div style="font-size: 11px; color: var(--success); font-weight: 700; margin-top: 4px;">
                        <i class="fa fa-circle-check"></i> Disbursed: <?= formatCurrency($project['payment_1_amount']) ?>
                    </div>
                <?php elseif ($num === 11 && floatval($project['payment_2_amount']) > 0): ?>
                    <div style="font-size: 11px; color: var(--success); font-weight: 700; margin-top: 4px;">
                        <i class="fa fa-circle-check"></i> Disbursed: <?= formatCurrency($project['payment_2_amount']) ?>
                    </div>
                <?php endif; ?>

                <div style="margin-top: 8px; font-size: 11px; font-weight: 600; color: <?= $isPassed ? 'var(--success)' : ($isCurrent ? 'var(--accent)' : 'var(--text-muted)') ?>;">
                    <?php if ($isPassed): ?>
                        <i class="fa fa-circle-check"></i> Completed
                    <?php elseif ($isCurrent): ?>
                        <i class="fa fa-spinner fa-spin"></i> Currently In Progress
                    <?php else: ?>
                        <i class="fa fa-clock"></i> Pending
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<!-- PART PAY SUMMARY CARD -->
<div class="desktop-card" style="margin-bottom: 40px; padding: 24px; border-left: 4px solid #7c3aed;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 12px; color: #6b21a8;">Part Pay Sub-Contract Summary</h3>
    <p style="font-size: 13px; color: var(--text-main);">Partial payment sub-contract model for this installation job.</p>
    
    <div style="margin-top: 20px; background: #f3e8ff; padding: 16px; border-radius: var(--radius); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <div style="font-size: 11px; font-weight: 700; color: #6b21a8; text-transform: uppercase;">Total Part Payments Disbursed by MD</div>
            <div style="font-size: 24px; font-weight: 800; color: #6b21a8; margin-top: 4px; font-family: 'Outfit', sans-serif;"><?= formatCurrency($project['part_pay_amount']) ?></div>
        </div>
        <span class="badge" style="background: white; color: #6b21a8; font-weight: 700; font-size: 11px; padding: 6px 12px;">
            <?= strtoupper($project['part_pay_status']) ?>
        </span>
    </div>
    <?php if ($project['part_pay_notes']): ?>
        <div style="font-size: 12px; color: var(--text-muted); margin-top: 10px;">
            <strong>MD Notes:</strong> <?= h($project['part_pay_notes']) ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Payment Summary Details -->
<div class="grid grid-2" style="margin-bottom: 40px;">
    <div class="desktop-card">
        <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">MD Disbursement Breakdown</h3>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px;">
            <li style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border);">
                <span>1st Payment (Step 5 - MD):</span>
                <strong><?= formatCurrency($project['payment_1_amount']) ?></strong>
            </li>
            <li style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border);">
                <span>2nd Payment (Step 11 - MD):</span>
                <strong><?= formatCurrency($project['payment_2_amount']) ?></strong>
            </li>
            <li style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--border);">
                <span>Part Payment (MD):</span>
                <strong><?= formatCurrency($project['part_pay_amount']) ?></strong>
            </li>
            <li style="display: flex; justify-content: space-between; padding: 12px 0; font-weight: 700; font-size: 15px; color: var(--success);">
                <span>Total Received:</span>
                <span><?= formatCurrency(floatval($project['payment_1_amount']) + floatval($project['payment_2_amount']) + floatval($project['part_pay_amount'])) ?></span>
            </li>
        </ul>
    </div>

    <!-- Uploaded Stage Documents -->
    <div class="desktop-card">
        <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Uploaded Stage Proofs & Documents</h3>
        <?php if (empty($documents)): ?>
            <p style="font-size: 13px; color: var(--text-muted); text-align: center; padding: 20px 0;">No proof documents uploaded for this project yet.</p>
        <?php else: ?>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <?php foreach ($documents as $doc): ?>
                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border);">
                        <div>
                            <span style="font-size: 12px; font-weight: 700; color: var(--primary);"><?= h($doc['step_name']) ?></span>
                            <div style="font-size: 11px; color: var(--text-muted);"><?= h($doc['original_name']) ?> • Uploaded by <?= h($doc['uploader_name']) ?></div>
                        </div>
                        <a href="<?= site_url('public/file.php?type=technical&file=' . urlencode($doc['file_path'])) ?>" target="_blank" class="btn" style="width: auto; height: 28px; font-size: 11px; line-height: 28px; padding: 0 10px; border: 1px solid var(--border); text-decoration: none; color: var(--text-main); font-weight: 600;">
                            <i class="fa fa-download" style="margin-right: 4px;"></i> View
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
