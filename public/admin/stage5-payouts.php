<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

$tab = $_GET['tab'] ?? 'all';

// Base stages that mean Stage 4 (LOAN DISBURSEMENT) or beyond has been reached/crossed
$stage4Plus = [
    'LOAN DISBURSEMENT',
    'DM/AGENT PAYMENT',
    'INSTALLATION',
    'ACTIVATION BY APDCL',
    'SUBSIDY REQUEST',
    'SUBSIDY DISBURSEMENT',
    'LOAN 2ND DISBURSEMENT',
    'CUSTOMER FEEDBACK'
];

$placeholders = implode(',', array_fill(0, count($stage4Plus), '?'));
$query = "SELECT t.*, u.name as dm_name, u.role as dm_role, u.employee_id as dm_empid, u.email as dm_email 
          FROM technical_customers t 
          JOIN users u ON t.dm_id = u.id 
          WHERE t.status IN ($placeholders)";
$params = $stage4Plus;

if ($tab === 'ready') {
    $query .= " AND (t.payment_amount IS NULL OR t.payment_amount = 0)";
} elseif ($tab === 'paid') {
    $query .= " AND t.payment_amount IS NOT NULL AND t.payment_amount > 0";
}

$query .= " ORDER BY t.created_at DESC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$customers = $stmt->fetchAll();

$pageTitle = "Stage 5 Payouts (Crossed Stage 4)";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Stage 5 DM/Agent Payout Management</h1>
        <p>Exclusive Admin view displaying only technical applications that have crossed Stage 4 (Loan Disbursement).</p>
    </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 24px;">
    <a href="stage5-payouts.php?tab=all" class="badge" style="background: <?= $tab === 'all' ? 'var(--primary)' : '#e2e8f0' ?>; color: <?= $tab === 'all' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">All Crossed Stage 4 (<?= count($customers) ?>)</a>
    <a href="stage5-payouts.php?tab=ready" class="badge" style="background: <?= $tab === 'ready' ? 'var(--warning)' : '#e2e8f0' ?>; color: <?= $tab === 'ready' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;"><i class="fa fa-clock" style="margin-right: 6px;"></i> Ready / Pending Stage 5 Payout</a>
    <a href="stage5-payouts.php?tab=paid" class="badge" style="background: <?= $tab === 'paid' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $tab === 'paid' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;"><i class="fa fa-check-circle" style="margin-right: 6px;"></i> Stage 5 Paid / Credited</a>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Info</th>
                    <th>DM/PE Agent</th>
                    <th>Current Stage</th>
                    <th>1st Disbursement Details</th>
                    <th>Stage 5 Payout Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px; color: var(--text-muted);">
                            <i class="fa fa-folder-open" style="font-size: 32px; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
                            No applications currently found matching this criteria. Applications will appear right here once Staff advances them to or past Stage 4 (Loan Disbursement).
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($customers as $c): ?>
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: var(--text-main); font-size: 14px;"><?= h($c['customer_name']) ?></div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;"><i class="fa fa-phone" style="font-size: 10px;"></i> <?= h($c['contact_number']) ?></div>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= h($c['district'] ?: $c['address']) ?></div>
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 13px;"><?= h($c['dm_name']) ?></div>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= strtoupper(h($c['dm_role'])) ?> <?= $c['dm_empid'] ? ('(' . h($c['dm_empid']) . ')') : '' ?></div>
                            </td>
                            <td>
                                <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 11px; padding: 6px 12px;">
                                    <?= h($c['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($c['disbursement_1_amount']): ?>
                                    <div style="font-weight: 700; color: var(--success); font-size: 13px;">Rs. <?= formatCurrency($c['disbursement_1_amount']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= $c['disbursement_1_date'] ? date('d M Y', strtotime($c['disbursement_1_date'])) : '' ?></div>
                                    <?php if (!empty($c['disbursement_1_remarks'])): ?>
                                        <div style="font-size: 11px; color: var(--text-muted); margin-top: 2px; font-style: italic;"><i class="fa fa-comment-dots"></i> <?= h($c['disbursement_1_remarks']) ?></div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 12px;">Disbursement stage active</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($c['payment_amount'] !== null && $c['payment_amount'] > 0): ?>
                                    <div style="font-weight: 700; color: var(--success); font-size: 14px;">Rs. <?= formatCurrency($c['payment_amount']) ?></div>
                                    <span class="badge" style="background: #d1fae5; color: #065f46; font-size: 10px; margin-top: 4px;">CREDITED TO WALLET</span>
                                    <?php if (!empty($c['payment_receipt'])): ?>
                                        <div style="margin-top: 4px;">
                                            <a href="<?= site_url('public/uploads/' . h($c['payment_receipt'])) ?>" target="_blank" style="font-size: 11px; color: var(--primary); text-decoration: underline;"><i class="fa fa-receipt"></i> View Proof</a>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 6px 10px;"><i class="fa fa-clock"></i> Pending Admin Input</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= site_url('public/staff/technical-detail.php?id=' . $c['id']) ?>" class="btn btn-primary" style="padding: 8px 14px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; border-radius: 6px;">
                                    <span>Open & Process</span>
                                    <i class="fa fa-arrow-right"></i>
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
