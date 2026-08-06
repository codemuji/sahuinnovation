<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin']);

$db = Database::getInstance()->getConnection();
$id = intval($_GET['id'] ?? 0);

if (!$id) {
    setFlash('danger', 'Invalid project ID.');
    redirect(site_url('public/staff/subcontract-list.php'));
}

$stmt = $db->prepare("SELECT p.*, c.name as contractor_name, c.employee_id as contractor_emp_id, s.name as staff_name 
    FROM subcontract_projects p 
    JOIN users c ON p.contractor_id = c.id 
    JOIN users s ON p.created_by_staff_id = s.id 
    WHERE p.id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    setFlash('danger', 'Project not found.');
    redirect(site_url('public/staff/subcontract-list.php'));
}

// Fetch documents
$stmt = $db->prepare("SELECT d.*, u.name as uploader_name FROM subcontract_documents d JOIN users u ON d.uploaded_by = u.id WHERE d.project_id = ? ORDER BY d.uploaded_at DESC");
$stmt->execute([$id]);
$documents = $stmt->fetchAll();

// 12 Steps Definition
$stepOptions = [
    '1. APPLICATION' => '1. APPLICATION (Staff)',
    '2. APPLY ON OFFICIAL SITE' => '2. APPLY ON OFFICIAL SITE (Staff)',
    '3. LOAN PROCESS TO BANK' => '3. LOAN PROCESS TO BANK (Staff)',
    '4. LOAN DISBURSEMENT' => '4. LOAN DISBURSEMENT (Staff)',
    '5. SUB CONTRACT 1ST PAYMENT (MD)' => '5. SUB CONTRACT 1ST PAYMENT (MD Required)',
    '6. INSTALLATION' => '6. INSTALLATION (Staff)',
    '7. ACTIVATION BY APDCL' => '7. ACTIVATION BY APDCL (Staff)',
    '8. SUBSIDY REQUEST' => '8. SUBSIDY REQUEST (Staff)',
    '9. SUBSIDY DISBURSEMENT' => '9. SUBSIDY DISBURSEMENT (Staff)',
    '10. LOAN 2ND DISBURSEMENT' => '10. LOAN 2ND DISBURSEMENT (Staff)',
    '11. SUB CONTRACT 2ND PAYMENT (MD)' => '11. SUB CONTRACT 2ND PAYMENT (MD Required)',
    '12. CUSTOMER FEEDBACK' => '12. CUSTOMER FEEDBACK (Staff)',
    'COMPLETED' => 'COMPLETED (Project Finalized)'
];

$pageTitle = "Sub-Contract Stage Management";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="subcontract-list.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to Sub-Contract List
        </a>
        <h1 style="margin-top: 8px;">Manage Stage: <?= h($project['customer_name']) ?></h1>
        <p>Assigned Subcontractor: <strong><?= h($project['contractor_name']) ?> (<?= h($project['contractor_emp_id']) ?>)</strong></p>
    </div>
</div>

<div class="grid grid-2" style="margin-bottom: 40px;">
    <!-- Stage Update Control (Staff) -->
    <div class="desktop-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Update Workflow Stage</h3>

        <form action="<?= site_url('app/actions/subcontract_actions.php') ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="update_stage">
            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">

            <div class="form-group">
                <label class="form-label" for="status">Select Next Stage / Status <span style="color: var(--danger);">*</span></label>
                <select class="form-control" id="status" name="status" required>
                    <?php if ($project['contract_type'] === 'part_pay'): ?>
                        <option value="PART PAY INITIATED" <?= $project['status'] === 'PART PAY INITIATED' ? 'selected' : '' ?>>PART PAY INITIATED</option>
                        <option value="PART PAY COMPLETED" <?= $project['status'] === 'PART PAY COMPLETED' ? 'selected' : '' ?>>PART PAY COMPLETED</option>
                    <?php else: ?>
                        <?php foreach ($stepOptions as $val => $label): ?>
                            <option value="<?= $val ?>" <?= $project['status'] === $val ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="step_doc">Upload Stage Proof / Receipt Document</label>
                <input type="file" class="form-control" id="step_doc" name="step_doc" accept=".pdf,.jpg,.png,.jpeg">
                <small style="color: var(--text-muted); font-size: 11px;">e.g. Bank Sanction, APDCL Receipt, Installation Photo, Subsidy Proof.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="customer_feedback">Customer Feedback / Remarks</label>
                <textarea class="form-control" id="customer_feedback" name="customer_feedback" rows="3" placeholder="Enter customer feedback or stage remarks..."><?= h($project['customer_feedback']) ?></textarea>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;"><i class="fa fa-save" style="margin-right: 6px;"></i> Update Stage & Progress</button>
            </div>
        </form>
    </div>

    <!-- MD Payment Status & Actions -->
    <div class="desktop-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">MD Sub-Contract Payments</h3>

        <div style="background-color: var(--background); padding: 16px; border-radius: var(--radius); margin-bottom: 20px;">
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Step 5: Sub Contract 1st Payment (MD)</div>
            <div style="font-size: 20px; font-weight: 800; color: var(--primary); margin-top: 4px; font-family: 'Outfit', sans-serif;">
                <?= formatCurrency($project['payment_1_amount']) ?>
            </div>
            <span class="badge" style="background: <?= $project['payment_1_status'] === 'approved' ? '#d1fae5' : '#fee2e2' ?>; color: <?= $project['payment_1_status'] === 'approved' ? '#065f46' : '#991b1b' ?>; font-size: 10px; margin-top: 6px; display: inline-block;">
                <?= strtoupper($project['payment_1_status']) ?>
            </span>
            <?php if ($project['payment_1_notes']): ?>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Notes: <?= h($project['payment_1_notes']) ?></div>
            <?php endif; ?>
        </div>

        <div style="background-color: var(--background); padding: 16px; border-radius: var(--radius); margin-bottom: 20px;">
            <div style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Step 11: Sub Contract 2nd Payment (MD)</div>
            <div style="font-size: 20px; font-weight: 800; color: var(--primary); margin-top: 4px; font-family: 'Outfit', sans-serif;">
                <?= formatCurrency($project['payment_2_amount']) ?>
            </div>
            <span class="badge" style="background: <?= $project['payment_2_status'] === 'approved' ? '#d1fae5' : '#fee2e2' ?>; color: <?= $project['payment_2_status'] === 'approved' ? '#065f46' : '#991b1b' ?>; font-size: 10px; margin-top: 6px; display: inline-block;">
                <?= strtoupper($project['payment_2_status']) ?>
            </span>
            <?php if ($project['payment_2_notes']): ?>
                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Notes: <?= h($project['payment_2_notes']) ?></div>
            <?php endif; ?>
        </div>

        <?php if (Auth::userRole() === 'admin' || Auth::userRole() === 'director'): ?>
            <!-- Form for MD to disburse payments directly from this detail page -->
            <form action="<?= site_url('app/actions/subcontract_actions.php') ?>" method="POST" style="border-top: 1px solid var(--border); padding-top: 15px; margin-top: 15px;">
                <input type="hidden" name="action" value="process_md_payment">
                <input type="hidden" name="project_id" value="<?= $project['id'] ?>">

                <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 12px; color: var(--accent);">Disburse MD Payment Now</h4>
                <div class="form-group">
                    <label class="form-label" for="payment_type">Payment Type</label>
                    <select class="form-control" name="payment_type" required>
                        <option value="1st_payment">Step 5: Sub Contract 1st Payment</option>
                        <option value="2nd_payment">Step 11: Sub Contract 2nd Payment</option>
                        <option value="part_pay">Part Payment</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Amount (₹)</label>
                    <input type="number" step="0.01" min="1" name="amount" class="form-control" required placeholder="0.00">
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="Payment reference or notes">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; background: var(--success);"><i class="fa fa-money-bill-wave"></i> Disburse Payout to Subcontractor</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Uploaded Documents Table -->
<div class="desktop-card" style="padding: 0; margin-bottom: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border);">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Uploaded Stage Documents</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Stage Step</th>
                    <th>File Name</th>
                    <th>Uploaded By</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documents)): ?>
                    <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">No stage proof documents uploaded yet.</td></tr>
                <?php else:
                    foreach ($documents as $d): ?>
                        <tr>
                            <td data-label="Date"><?= date('d M Y, H:i', strtotime($d['uploaded_at'])) ?></td>
                            <td data-label="Step"><strong><?= h($d['step_name']) ?></strong></td>
                            <td data-label="File"><?= h($d['original_name']) ?></td>
                            <td data-label="Uploader"><?= h($d['uploader_name']) ?></td>
                            <td data-label="Action" style="text-align: right;">
                                <a href="<?= site_url('public/file.php?type=technical&file=' . urlencode($d['file_path'])) ?>" target="_blank" class="btn" style="width: auto; height: 28px; line-height: 28px; padding: 0 12px; font-size: 11px; border: 1px solid var(--border); text-decoration: none; color: var(--text-main); font-weight: 600;">
                                    View File
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
