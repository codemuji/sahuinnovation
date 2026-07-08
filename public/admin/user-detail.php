<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

if (!$u) {
    setFlash('danger', 'User not found.');
    redirect('users.php');
}

$pageTitle = "User Details: " . h($u['name']);
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="users.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to Users
        </a>
        <h1 style="margin-top: 8px;">User Details: <?= h($u['name']) ?></h1>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="edit-user.php?id=<?= $u['id'] ?>" class="btn" style="width: auto; background: var(--border); color: var(--text-main);">Edit User</a>
    </div>
</div>

<div class="detail-grid">
    <div class="detail-content">
        <div class="desktop-card detail-section">
            <div style="display: flex; align-items: center; gap: 24px; margin-bottom: 32px;">
                <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--border); background-image: url('<?= $u['profile_pic'] ? site_url('public/file.php?type=profile&file='.$u['profile_pic']) : asset_url('img/default-avatar.png') ?>'); background-size: cover; background-position: center;"></div>
                <div>
                    <h2 style="font-size: 24px; font-weight: 700;"><?= h($u['name']) ?></h2>
                    <span class="badge" style="background: var(--primary); color: white; margin-top: 8px;"><?= strtoupper($u['role']) ?></span>
                </div>
            </div>

            <h3>Personal Information</h3>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Email</div>
                    <div class="data-value"><?= h($u['email']) ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Phone</div>
                    <div class="data-value"><?= h($u['phone']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">Address</div>
                <div class="data-value"><?= nl2br(h($u['address'])) ?: 'N/A' ?></div>
            </div>
            <div class="data-row">
                <div class="data-label">Employee ID</div>
                <div class="data-value"><?= h($u['employee_id']) ?: 'N/A' ?></div>
            </div>
        </div>

        <div class="desktop-card detail-section">
            <h3>Bank & Payment Details</h3>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Bank Name</div>
                    <div class="data-value"><?= h($u['bank_name']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Account Holder</div>
                    <div class="data-value"><?= h($u['account_holder_name']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="grid grid-2">
                <div class="data-row">
                    <div class="data-label">Account Number</div>
                    <div class="data-value"><?= h($u['account_number']) ?: 'N/A' ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">IFSC Code</div>
                    <div class="data-value"><?= h($u['ifsc_code']) ?: 'N/A' ?></div>
                </div>
            </div>
            <div class="data-row">
                <div class="data-label">UPI ID</div>
                <div class="data-value"><?= h($u['upi_id']) ?: 'N/A' ?></div>
            </div>
        </div>
    </div>

    <div class="detail-sidebar">
        <div class="desktop-card">
            <h3 style="font-size: 14px; font-weight: 700; margin-bottom: 16px;">Account Status</h3>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Status</label>
                <span class="badge" style="background: <?= $u['is_active'] ? '#d1fae5' : '#fee2e2' ?>; color: <?= $u['is_active'] ? '#065f46' : '#991b1b' ?>;">
                    <?= $u['is_active'] ? 'ACTIVE' : 'INACTIVE' ?>
                </span>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 11px; color: var(--text-muted); text-transform: uppercase;">Created On</label>
                <div style="font-size: 14px; font-weight: 600;"><?= date('d M Y', strtotime($u['created_at'])) ?></div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
