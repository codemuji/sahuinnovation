<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['staff', 'admin']);

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT s.*, u.name as surveyer_name FROM survey_customers s JOIN users u ON s.surveyer_id = u.id WHERE s.id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    setFlash('danger', 'Customer not found.');
    redirect('survey-list.php');
}

// Get documents
$stmt = $db->prepare("SELECT * FROM survey_documents WHERE survey_customer_id = ?");
$stmt->execute([$id]);
$documents = $stmt->fetchAll();

$pageTitle = "Survey Details: " . h($customer['name']);
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="survey-list.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
        <h1 style="margin-top: 8px;">Survey Review: <?= h($customer['name']) ?></h1>
    </div>
    <div style="display: flex; gap: 12px;">
        <?php if ($customer['status'] === 'pending'): ?>
            <form action="<?= site_url('app/actions/revert_survey.php') ?>" method="POST" onsubmit="return promptRevert()">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <input type="hidden" name="reason" id="revert_reason_input">
                <button type="submit" class="btn" style="width: auto; background: #FF00FF; color: white;">Revert Back</button>
            </form>
            <form action="<?= site_url('app/actions/reject_survey.php') ?>" method="POST" onsubmit="return promptReject()">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <input type="hidden" name="reason" id="reject_reason_input">
                <button type="submit" class="btn" style="width: auto; background: var(--danger); color: white;">Reject</button>
            </form>
            <form action="<?= site_url('app/actions/approve_survey.php') ?>" method="POST" data-confirm="Are you sure you want to approve this survey?">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <button type="submit" class="btn" style="width: auto; background: var(--success); color: white;">Approve</button>
            </form>
        <?php else: ?>
            <span class="badge badge-<?= $customer['status'] ?>" style="font-size: 14px; padding: 12px 24px;"><?= str_replace('_', ' ', strtoupper($customer['status'])) ?></span>
        <?php endif; ?>
    </div>
</div>

<div class="detail-grid">
    <div class="detail-content">
        <div class="desktop-card detail-section">
            <h3>Customer Information</h3>
            <div class="data-row">
                <div class="data-label">Full Name</div>
                <div class="data-value"><?= h($customer['name']) ?></div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Consumer Number</div>
                    <div class="data-value"><?= h($customer['consumer_number']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Mobile Number</div>
                    <div class="data-value"><?= h($customer['phone']) ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Age/DOB</div>
                    <div class="data-value"><?= h($customer['age_dob']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Gender</div>
                    <div class="data-value"><?= h($customer['gender']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Email ID</div>
                    <div class="data-value"><?= h($customer['email']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Occupation</div>
                    <div class="data-value"><?= h($customer['occupation']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Post Office</div>
                    <div class="data-value"><?= h($customer['post_office']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Police Station</div>
                    <div class="data-value"><?= h($customer['police_station']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">District</div>
                    <div class="data-value"><?= h($customer['district']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">State</div>
                    <div class="data-value"><?= h($customer['state']) ?: 'Assam' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Complete Address</div>
                <div class="data-value"><?= nl2br(h($customer['address'])) ?></div>
            </div>
        </div>

        <div class="desktop-card detail-section">
            <h3>Survey & Property Details</h3>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">House Type</div>
                    <div class="data-value"><?= h($customer['house_type']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Customer Opinion</div>
                    <div class="data-value"><?= h($customer['customer_opinion']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Electricity Bill Amount</div>
                    <div class="data-value">Rs. <?= h($customer['electricity_bill_amount']) ?: '0' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Meter Type</div>
                    <div class="data-value"><?= h($customer['meter_type']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <div class="data-row">
                    <div class="data-label">Land Ownership Type</div>
                    <div class="data-value"><?= h($customer['land_type']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Annual Income</div>
                    <div class="data-value">Rs. <?= h($customer['annual_income']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid-2">
                <?php if ($customer['property_type']): ?>
                <div class="data-row">
                    <div class="data-label">Property Type (Legacy)</div>
                    <div class="data-value"><?= h($customer['property_type']) ?></div>
                </div>
                <?php endif; ?>
                <?php if ($customer['property_area']): ?>
                <div class="data-row">
                    <div class="data-label">Property Area (Legacy)</div>
                    <div class="data-value"><?= h($customer['property_area']) ?> Sq.Ft</div>
                </div>
                <?php endif; ?>
            </div>
            <?php if ($customer['notes']): ?>
            <div class="data-row">
                <div class="data-label">Additional Notes</div>
                <div class="data-value"><?= nl2br(h($customer['notes'])) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($customer['rejection_reason']): ?>
            <div class="data-row" style="margin-top: 15px; padding: 15px; background: #fff1f2; border-radius: 8px; border: 1px solid #fda4af;">
                <div class="data-label" style="color: #9f1239;"><?= $customer['status'] === 'revert_back' ? 'Revert Feedback' : 'Rejection Reason' ?></div>
                <div class="data-value" style="color: #9f1239;"><?= nl2br(h($customer['rejection_reason'])) ?></div>
            </div>
            <?php endif; ?>
        </div>

        <div class="desktop-card detail-section">
            <h3>Uploaded Documents</h3>
            <div class="doc-grid">
                <?php foreach ($documents as $doc): 
                    $fileUrl = site_url('public/file.php?type=survey&file='.urlencode($doc['file_path']));
                    $downloadUrl = $fileUrl . '&download=1';
                ?>
                    <div class="doc-card" style="position: relative;">
                        <a href="<?= $fileUrl ?>" target="_blank" style="text-decoration: none; color: inherit; display: block;">
                            <?php 
                            $icon = 'fa-file';
                            if ($doc['doc_type'] === 'gps_photo') $icon = 'fa-location-dot';
                            elseif ($doc['doc_type'] === 'house_photo') $icon = 'fa-house-chimney';
                            elseif (strpos($doc['file_path'], '.pdf') !== false) $icon = 'fa-file-pdf';
                            elseif (preg_match('/\.(jpg|jpeg|png)$/i', $doc['file_path'])) $icon = 'fa-file-image';
                            ?>
                            <i class="fa <?= $icon ?>" style="color: var(--primary); font-size: 28px; margin-bottom: 12px;"></i>
                            <div style="font-size: 13px; font-weight: 700; margin-bottom: 4px;"><?= ucwords(str_replace('_', ' ', $doc['doc_type'])) ?></div>
                            <div style="font-size: 11px; opacity: 0.6; margin-bottom: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= h($doc['original_name']) ?></div>
                        </a>
                        <a href="<?= $downloadUrl ?>" class="btn" style="height: 30px; padding: 0 10px; font-size: 11px; background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border);">
                            <i class="fa fa-download" style="margin-right: 5px;"></i> Download
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="detail-sidebar">
        <div class="desktop-card">
            <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px;">Submission Metadata</h3>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Submitted By</label>
                <div style="font-size: 14px; font-weight: 600;"><?= h($customer['surveyer_name']) ?></div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Submission Date</label>
                <div style="font-size: 14px; font-weight: 600;"><?= date('d M Y, h:i A', strtotime($customer['created_at'])) ?></div>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Status</label>
                <span class="badge badge-<?= $customer['status'] ?>" style="display: inline-block; margin-top: 4px;"><?= strtoupper($customer['status']) ?></span>
            </div>
            <?php if ($customer['status'] === 'rejected'): ?>
                <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                    <label style="display: block; font-size: 11px; color: var(--danger); text-transform: uppercase; font-weight: 700;">Rejection Reason</label>
                    <div style="font-size: 13px; color: var(--danger); margin-top: 4px;"><?= h($customer['rejection_reason']) ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function promptRevert() {
    const reason = prompt("Enter reason for reverting back to surveyor:");
    if (reason === null) return false;
    if (reason.trim() === "") {
        alert("Reason is required to revert.");
        return false;
    }
    document.getElementById('revert_reason_input').value = reason;
    return true;
}

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
