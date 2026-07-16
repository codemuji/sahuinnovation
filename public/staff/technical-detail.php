<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin', 'dm', 'pe']);

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;
$role = Auth::userRole();
$userId = Auth::userId();

$stmt = $db->prepare("SELECT t.*, u.name as dm_name, u.role as dm_role FROM technical_customers t JOIN users u ON t.dm_id = u.id WHERE t.id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    setFlash('danger', 'Customer not found.');
    redirect('technical-list.php');
}

if (in_array($role, ['dm', 'pe']) && $customer['dm_id'] != $userId) {
    setFlash('danger', 'Unauthorized access to this customer.');
    redirect(site_url('public/dm/my-customers.php'));
}

// Get documents
$stmt = $db->prepare("SELECT * FROM technical_documents WHERE technical_customer_id = ?");
$stmt->execute([$id]);
$documents = $stmt->fetchAll();

// Categorize documents
$requiredDocTypes = ['Aadhaar Card', 'Pan Card', 'Bank Passbook', 'Electricity Bill', 'Signature'];
$requiredDocs = [];
$ownershipDoc = null;

foreach ($documents as $doc) {
    if (in_array($doc['doc_type'], $requiredDocTypes)) {
        $requiredDocs[] = $doc;
    } else {
        $ownershipDoc = $doc;
    }
}

$backUrl = in_array($role, ['dm', 'pe']) ? site_url('public/dm/my-customers.php') : 'technical-list.php';
$stages = [
    'APPLICATION',
    'APPLY ON OFFICIAL SITE',
    'LOAN PROCESS TO BANK',
    'LOAN DISBURSEMENT',
    'DM/AGENT PAYMENT',
    'INSTALLATION',
    'ACTIVATION BY APDCL',
    'SUBSIDY REQUEST',
    'SUBSIDY DISBURSEMENT',
    'LOAN 2ND DISBURSEMENT',
    'CUSTOMER FEEDBACK'
];
$currentStepIdx = array_search($customer['status'], $stages);
if ($currentStepIdx === false) {
    if ($customer['status'] === 'pending') $currentStepIdx = 0;
    elseif ($customer['status'] === 'approved') $currentStepIdx = 10;
    else $currentStepIdx = -1;
}

$pageTitle = "Technical Details: " . h($customer['name']);
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="<?= $backUrl ?>" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
        <h1 style="margin-top: 8px;">Technical Review: <?= h($customer['name']) ?></h1>
    </div>
    <div style="display: flex; gap: 12px;">
        <?php if (in_array($role, ['staff', 'admin']) && $customer['status'] !== 'rejected'): ?>
            <form action="<?= site_url('app/actions/reject_technical.php') ?>" method="POST" onsubmit="return promptReject()">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <input type="hidden" name="reason" id="reject_reason_input">
                <button type="submit" class="btn" style="width: auto; background: var(--danger); color: white;">Reject</button>
            </form>
        <?php endif; ?>
        <span class="badge badge-<?= $customer['status'] === 'rejected' ? 'rejected' : 'approved' ?>" style="font-size: 14px; padding: 12px 24px;">
            <?= strtoupper($customer['status']) ?>
        </span>
    </div>
</div>

<!-- Customer Status Pipeline (11 Steps) -->
<div class="desktop-card" style="margin-bottom: 24px;">
    <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">Customer Status Pipeline (11 Stages)</h3>
    <?php if ($customer['status'] === 'rejected'): ?>
        <div style="padding: 16px; background: #fef2f2; border: 1px solid var(--danger); border-radius: 8px; color: var(--danger); font-weight: 600;">
            Status: REJECTED &mdash; Reason: <?= h($customer['rejection_reason']) ?>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 20px;">
            <?php foreach ($stages as $idx => $stageName): 
                $isPassed = ($currentStepIdx !== false && $idx < $currentStepIdx);
                $isCurrent = ($currentStepIdx !== false && $idx === $currentStepIdx);
                $bg = $isCurrent ? 'var(--primary)' : ($isPassed ? '#10b981' : '#e2e8f0');
                $fg = ($isCurrent || $isPassed) ? 'white' : 'var(--text-muted)';
            ?>
                <div style="background: <?= $bg ?>; color: <?= $fg ?>; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                    <span><?= $idx + 1 ?>. <?= h($stageName) ?></span>
                    <?php if ($isPassed): ?><i class="fa fa-check"></i><?php endif; ?>
                </div>
                <?php if ($idx < count($stages) - 1): ?>
                    <i class="fa fa-chevron-right" style="font-size: 10px; color: var(--text-muted);"></i>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-3" style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
        <div>
            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Bank & Sanction</span>
            <div style="font-size: 13px; font-weight: 600; margin-top: 4px;">
                <?= h($customer['bank_details'] ?: 'N/A') ?> 
                <?= $customer['sanction_amount'] ? (' (Rs. ' . formatCurrency($customer['sanction_amount']) . ')') : '' ?>
            </div>
        </div>
        <div>
            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase;">1st Disbursement</span>
            <div style="font-size: 13px; font-weight: 600; margin-top: 4px;">
                <?= $customer['disbursement_1_amount'] ? ('Rs. ' . formatCurrency($customer['disbursement_1_amount'])) : 'N/A' ?>
                <?= $customer['disbursement_1_date'] ? (' on ' . h($customer['disbursement_1_date'])) : '' ?>
            </div>
        </div>
        <div>
            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase;">DM/Agent Payment (Admin Only)</span>
            <div style="font-size: 13px; font-weight: 600; margin-top: 4px; color: <?= $customer['payment_amount'] !== null && $customer['payment_amount'] >= 0 ? 'var(--success)' : 'inherit' ?>;">
                <?= $customer['payment_amount'] !== null ? ('Rs. ' . formatCurrency($customer['payment_amount'])) : 'Pending Admin Input' ?>
            </div>
        </div>
        <div>
            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase;">2nd Disbursement</span>
            <div style="font-size: 13px; font-weight: 600; margin-top: 4px;">
                <?= $customer['disbursement_2_amount'] ? ('Rs. ' . formatCurrency($customer['disbursement_2_amount'])) : 'N/A' ?>
                <?= $customer['disbursement_2_date'] ? (' on ' . h($customer['disbursement_2_date'])) : '' ?>
            </div>
        </div>
        <div style="grid-column: span 2;">
            <span style="font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Customer Feedback</span>
            <div style="font-size: 13px; font-weight: 600; margin-top: 4px;">
                <?= h($customer['customer_feedback'] ?: 'No feedback provided yet.') ?>
            </div>
        </div>
    </div>
</div>

<div class="detail-grid">
    <div class="detail-content">
        <!-- Section 1: Consumer Information -->
        <div class="desktop-card detail-section">
            <h3>Consumer Information</h3>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Consumer Name</div>
                    <div class="data-value"><?= h($customer['name']) ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Consumer Number</div>
                    <div class="data-value"><?= h($customer['consumer_number']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Date of Birth</div>
                    <div class="data-value"><?= h($customer['dob']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Gender</div>
                    <div class="data-value"><?= h($customer['gender']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Mobile Number</div>
                    <div class="data-value"><?= h($customer['phone']) ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Email ID</div>
                    <div class="data-value"><?= h($customer['email']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Occupation</div>
                <div class="data-value"><?= h($customer['occupation']) ?: 'N/A' ?></div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">State</div>
                    <div class="data-value"><?= h($customer['state']) ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">District</div>
                    <div class="data-value"><?= h($customer['district']) ?></div>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Post Office</div>
                    <div class="data-value"><?= h($customer['post_office']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Police Station</div>
                    <div class="data-value"><?= h($customer['police_station']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Electrical Subdivision</div>
                <div class="data-value"><?= h($customer['electrical_subdivision']) ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Full Address</div>
                <div class="data-value"><?= nl2br(h($customer['address'])) ?></div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">House Structure</div>
                    <div class="data-value"><?= h($customer['house_type']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Meter Type</div>
                    <div class="data-value"><?= h($customer['meter_type']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Annual Income</div>
                <div class="data-value">Rs. <?= h($customer['annual_income']) ?: 'N/A' ?></div>
            </div>
        </div>

        <!-- Section 2: Technical Details -->
        <div class="desktop-card detail-section">
            <h3>Additional Technical Details</h3>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Survey Number</div>
                    <div class="data-value"><?= h($customer['survey_number']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Plot Area</div>
                    <div class="data-value"><?= h($customer['plot_area']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Road Width</div>
                    <div class="data-value"><?= h($customer['road_width']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Zone</div>
                    <div class="data-value"><?= h($customer['zone']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Remarks</div>
                <div class="data-value"><?= nl2br(h($customer['remarks'])) ?: 'N/A' ?></div>
            </div>
        </div>

        <!-- Section 3: Required Documents -->
        <div class="desktop-card detail-section">
            <h3>Required Documents</h3>
            <div class="doc-grid">
                <?php foreach ($requiredDocs as $doc): 
                    $fileUrl = site_url('public/file.php?type=technical&file='.urlencode($doc['file_path']));
                    $downloadUrl = $fileUrl . '&download=1';
                ?>
                    <div class="doc-card" style="position: relative;">
                        <a href="<?= $fileUrl ?>" target="_blank" style="text-decoration: none; color: inherit; display: block;">
                            <i class="fa fa-file-contract" style="font-size: 28px; color: var(--primary); margin-bottom: 12px;"></i>
                            <div style="font-size: 13px; font-weight: 700; margin-bottom: 4px;"><?= h($doc['doc_type']) ?></div>
                            <div style="font-size: 11px; opacity: 0.6; margin-bottom: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= h($doc['original_name']) ?></div>
                        </a>
                        <a href="<?= $downloadUrl ?>" class="btn" style="height: 30px; padding: 0 10px; font-size: 11px; background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border);">
                            <i class="fa fa-download" style="margin-right: 5px;"></i> Download
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Section 4: Land Ownership Document -->
        <?php if ($ownershipDoc): ?>
        <div class="desktop-card detail-section">
            <h3>Land Ownership Document</h3>
            <div class="doc-grid">
                <?php 
                    $fileUrl = site_url('public/file.php?type=technical&file='.urlencode($ownershipDoc['file_path']));
                    $downloadUrl = $fileUrl . '&download=1';
                ?>
                <div class="doc-card" style="position: relative;">
                    <a href="<?= $fileUrl ?>" target="_blank" style="text-decoration: none; color: inherit; display: block;">
                        <i class="fa fa-file-contract" style="font-size: 28px; color: var(--primary); margin-bottom: 12px;"></i>
                        <div style="font-size: 13px; font-weight: 700; margin-bottom: 4px;"><?= h($ownershipDoc['doc_type']) ?></div>
                        <div style="font-size: 11px; opacity: 0.6; margin-bottom: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= h($ownershipDoc['original_name']) ?></div>
                    </a>
                    <a href="<?= $downloadUrl ?>" class="btn" style="height: 30px; padding: 0 10px; font-size: 11px; background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border);">
                        <i class="fa fa-download" style="margin-right: 5px;"></i> Download
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="detail-sidebar">
        <div class="desktop-card">
            <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px;">Submission Metadata</h3>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Submitted By</label>
                <div style="font-size: 14px; font-weight: 600;"><?= h($customer['dm_name']) ?></div>
                <div style="font-size: 11px; opacity: 0.7; text-transform: uppercase;"><?= h($customer['dm_role']) ?></div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Submission Date</label>
                <div style="font-size: 14px; font-weight: 600;"><?= date('d M Y, h:i A', strtotime($customer['created_at'])) ?></div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Status</label>
                <span class="badge badge-<?= $customer['status'] === 'rejected' ? 'rejected' : 'approved' ?>" style="display: inline-block; margin-top: 4px;"><?= strtoupper($customer['status']) ?></span>
            </div>
            <?php if ($customer['status'] === 'rejected'): ?>
                <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                    <label style="display: block; font-size: 11px; color: var(--danger); text-transform: uppercase; font-weight: 700;">Rejection Reason</label>
                    <div style="font-size: 13px; color: var(--danger); margin-top: 4px;"><?= h($customer['rejection_reason']) ?></div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (in_array($role, ['staff', 'admin']) && $customer['status'] !== 'rejected'): ?>
        <div class="desktop-card" style="margin-top: 20px;">
            <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px; color: var(--primary);">Stage & Status Management</h3>
            <form action="<?= site_url('app/actions/update_technical_status.php') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px;">Update Current Stage</label>
                    <select name="status" class="form-control" style="width: 100%; padding: 8px; border-radius: 6px; border: 1px solid var(--border);">
                        <?php foreach ($stages as $stg): 
                            $isAdminOnly = ($stg === 'DM/AGENT PAYMENT');
                            $disabled = ($isAdminOnly && $role !== 'admin') ? 'disabled' : '';
                        ?>
                            <option value="<?= h($stg) ?>" <?= $customer['status'] === $stg ? 'selected' : '' ?> <?= $disabled ?>>
                                <?= h($stg) ?> <?= $isAdminOnly ? ' (Admin Payment Only)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 12px;">Stage 3: Bank & Sanction</div>
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Bank Details</label>
                    <input type="text" name="bank_details" value="<?= h($customer['bank_details'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="Bank Name & A/C details">
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Sanction Amount (Rs)</label>
                    <input type="number" step="0.01" name="sanction_amount" value="<?= h($customer['sanction_amount'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="e.g. 150000">
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 12px;">Stage 4: 1st Disbursement</div>
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Amount (Rs)</label>
                    <input type="number" step="0.01" name="disbursement_1_amount" value="<?= h($customer['disbursement_1_amount'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="e.g. 80000">
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Date</label>
                    <input type="date" name="disbursement_1_date" value="<?= h($customer['disbursement_1_date'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 4px;">
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px; background: #f8fafc; padding: 12px; border-radius: 6px;">
                    <div style="font-size: 12px; font-weight: 700; color: <?= $role === 'admin' ? 'var(--primary)' : 'var(--text-muted)' ?>; margin-bottom: 8px;">
                        Stage 5: DM/Agent Payment <?= $role === 'admin' ? '(Manual Admin Input)' : '(Admin Only)' ?>
                    </div>
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Payment Amount (Rs)</label>
                    <input type="number" step="0.01" name="payment_amount" value="<?= h($customer['payment_amount'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="<?= $role === 'admin' ? 'Enter manual payment to credit DM/Agent' : 'Admin only' ?>" <?= $role !== 'admin' ? 'readonly' : '' ?>>
                    <?php if ($role === 'admin'): ?>
                        <div style="font-size: 11px; color: var(--success); margin-top: 4px;"><i class="fa fa-info-circle"></i> Entering amount & selecting Stage 5 will credit this custom amount to the DM/Agent wallet.</div>
                    <?php endif; ?>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 12px;">Stage 10: 2nd Disbursement</div>
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Amount (Rs)</label>
                    <input type="number" step="0.01" name="disbursement_2_amount" value="<?= h($customer['disbursement_2_amount'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; margin-bottom: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="e.g. 70000">
                    <label style="display: block; font-size: 11px; color: var(--text-muted); margin-bottom: 4px;">Date</label>
                    <input type="date" name="disbursement_2_date" value="<?= h($customer['disbursement_2_date'] ?? '') ?>" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 4px;">
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px;">
                    <div style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 12px;">Stage 11: Customer Feedback</div>
                    <textarea name="customer_feedback" rows="3" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border); border-radius: 4px;" placeholder="Feedback or notes..."><?= h($customer['customer_feedback'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Update Status & Save Details</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function promptReject() {
    const reason = prompt("Enter rejection reason:");
    if (reason === null) return false;
    if (reason.trim() === "") {
        alert("Rejection reason is required.");
        return false;
    }
    document.getElementById('reject_reason_input').value = reason;
    return true;
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
