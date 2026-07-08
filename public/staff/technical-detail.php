<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('staff');

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT t.*, u.name as dm_name, u.role as dm_role FROM technical_customers t JOIN users u ON t.dm_id = u.id WHERE t.id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch();

if (!$customer) {
    setFlash('danger', 'Customer not found.');
    redirect('technical-list.php');
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

$pageTitle = "Technical Details: " . h($customer['name']);
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="technical-list.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
        <h1 style="margin-top: 8px;">Technical Review: <?= h($customer['name']) ?></h1>
    </div>
    <div style="display: flex; gap: 12px;">
        <?php if ($customer['status'] === 'pending'): ?>
            <form action="<?= site_url('app/actions/reject_technical.php') ?>" method="POST" onsubmit="return promptReject()">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <input type="hidden" name="reason" id="reject_reason_input">
                <button type="submit" class="btn" style="width: auto; background: var(--danger); color: white;">Reject</button>
            </form>
            <form action="<?= site_url('app/actions/approve_technical.php') ?>" method="POST" data-confirm="Are you sure you want to approve this technical record?">
                <input type="hidden" name="id" value="<?= $customer['id'] ?>">
                <button type="submit" class="btn" style="width: auto; background: var(--success); color: white;">Approve</button>
            </form>
        <?php else: ?>
            <span class="badge badge-<?= $customer['status'] ?>" style="font-size: 14px; padding: 12px 24px;"><?= strtoupper($customer['status']) ?></span>
        <?php endif; ?>
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
