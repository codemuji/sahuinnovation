<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['admin', 'director']);

$db = Database::getInstance()->getConnection();
ensureSubcontractTables($db);

// Fetch all Sub-Contract Projects
$stmt = $db->query("SELECT p.*, c.name as contractor_name, c.employee_id as contractor_emp_id, c.bank_name, c.account_number, c.ifsc_code, c.upi_id, s.name as staff_name 
    FROM subcontract_projects p 
    JOIN users c ON p.contractor_id = c.id 
    JOIN users s ON p.created_by_staff_id = s.id 
    ORDER BY p.created_at DESC");
$projects = $stmt->fetchAll();

$pageTitle = "Sub-Contract MD Payments";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Sub-Contract MD Payments</h1>
        <p>Review sub-contract stage progression and disburse Step 5 (1st Payment), Step 11 (2nd Payment), and Part Payments to Subcontractors.</p>
    </div>
</div>

<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Sub-Contract Projects Overview</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer Details</th>
                    <th>Subcontractor</th>
                    <th>Contract Type</th>
                    <th>Current Stage</th>
                    <th>1st Payment (Step 5)</th>
                    <th>2nd Payment (Step 11)</th>
                    <th>Part Payments</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($projects)): ?>
                    <tr><td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">No sub-contract projects found.</td></tr>
                <?php else:
                    foreach ($projects as $p): ?>
                        <tr>
                            <td data-label="Customer">
                                <strong><?= h($p['customer_name']) ?></strong>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= h($p['phone']) ?></div>
                            </td>
                            <td data-label="Subcontractor">
                                <strong><?= h($p['contractor_name']) ?></strong>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= h($p['contractor_emp_id']) ?></div>
                            </td>
                            <td data-label="Type">
                                <span class="badge" style="background: <?= $p['contract_type'] === '12_step' ? '#e0f2fe' : '#f3e8ff' ?>; color: <?= $p['contract_type'] === '12_step' ? '#0369a1' : '#6b21a8' ?>; font-size: 10px;">
                                    <?= $p['contract_type'] === '12_step' ? '12-STEP' : 'PART PAY' ?>
                                </span>
                            </td>
                            <td data-label="Stage">
                                <span class="badge" style="background: #f8fafc; color: var(--primary); font-weight: 700; font-size: 11px;">
                                    <?= h($p['status']) ?>
                                </span>
                            </td>
                            <td data-label="1st Payment">
                                <strong><?= formatCurrency($p['payment_1_amount']) ?></strong>
                                <span class="badge" style="background: <?= $p['payment_1_status'] === 'approved' ? '#d1fae5' : '#fee2e2' ?>; color: <?= $p['payment_1_status'] === 'approved' ? '#065f46' : '#991b1b' ?>; font-size: 9px; display: block; margin-top: 2px;">
                                    <?= strtoupper($p['payment_1_status']) ?>
                                </span>
                            </td>
                            <td data-label="2nd Payment">
                                <strong><?= formatCurrency($p['payment_2_amount']) ?></strong>
                                <span class="badge" style="background: <?= $p['payment_2_status'] === 'approved' ? '#d1fae5' : '#fee2e2' ?>; color: <?= $p['payment_2_status'] === 'approved' ? '#065f46' : '#991b1b' ?>; font-size: 9px; display: block; margin-top: 2px;">
                                    <?= strtoupper($p['payment_2_status']) ?>
                                </span>
                            </td>
                            <td data-label="Part Payments">
                                <strong><?= formatCurrency($p['part_pay_amount']) ?></strong>
                            </td>
                            <td data-label="Action" style="text-align: right;">
                                <a href="<?= site_url('public/staff/subcontract-detail.php?id=' . $p['id']) ?>" class="btn btn-primary" style="width: auto; height: 30px; line-height: 30px; padding: 0 12px; font-size: 12px; text-decoration: none;">
                                    Manage Payouts
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
