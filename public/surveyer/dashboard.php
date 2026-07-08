<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('surveyer');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get counts
$stmt = $db->prepare("SELECT status, COUNT(*) as count FROM survey_customers WHERE surveyer_id = ? GROUP BY status");
$stmt->execute([$userId]);
$counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$pendingCount = $counts['pending'] ?? 0;
$revertCount = $counts['revert_back'] ?? 0;
$approvedCount = $counts['approved'] ?? 0;
$rejectedCount = $counts['rejected'] ?? 0;

// Get wallet info
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$wallet = $stmt->fetch();
$balance = $wallet['balance'] ?? 0.00;

// Get pending earnings (unapproved transactions)
$stmt = $db->prepare("SELECT SUM(amount) FROM wallet_transactions WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$userId]);
$pendingEarnings = $stmt->fetchColumn() ?: 0.00;

$pageTitle = "Surveyer Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div style="margin-bottom: 24px;">
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary);">Welcome, <?= h($user['name']) ?></h1>
    <p style="color: var(--text-muted); font-size: 14px;">Here is your survey activity summary.</p>
</div>

<!-- Wallet Section -->
<div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, #1e1b4b 100%); color: white; border: none;">
    <div style="font-size: 13px; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Available Balance</div>
    <div style="font-size: 32px; font-weight: 700; margin-bottom: 16px;"><?= formatCurrency($balance) ?></div>
    <div style="display: flex; gap: 20px; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1);">
        <div>
            <div style="font-size: 11px; opacity: 0.7;">Pending Earnings</div>
            <div style="font-size: 16px; font-weight: 600;"><?= formatCurrency($pendingEarnings) ?></div>
        </div>
        <div style="margin-left: auto;">
            <a href="wallet.php" class="btn" style="height: 36px; padding: 0 16px; font-size: 13px; background: var(--accent); width: auto;">Withdraw</a>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-4">
    <div class="card stats-card" style="border-bottom: 3px solid #00FFFF;">
        <div class="value"><?= $pendingCount ?></div>
        <div class="label">Pending</div>
    </div>
    <div class="card stats-card" style="border-bottom: 3px solid #FF00FF;">
        <div class="value"><?= $revertCount ?></div>
        <div class="label">Revert Back</div>
    </div>
    <div class="card stats-card" style="border-bottom: 3px solid #ef4444;">
        <div class="value"><?= $rejectedCount ?></div>
        <div class="label">Rejected</div>
    </div>
    <div class="card stats-card" style="border-bottom: 3px solid #10b981;">
        <div class="value"><?= $approvedCount ?></div>
        <div class="label">Approved</div>
    </div>
</div>

<div style="margin-top: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
    <a href="add-customer.php" class="btn btn-primary" style="height: 56px; font-size: 15px; border-radius: 12px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
        <i class="fa fa-plus-circle"></i> New Survey
    </a>
    <a href="profile.php" class="btn" style="height: 56px; font-size: 15px; border-radius: 12px; background: white; border: 1px solid var(--border); color: var(--primary); display: flex; align-items: center; justify-content: center; gap: 8px;">
        <i class="fa fa-user-circle"></i> My Profile
    </a>
</div>

<div style="margin-top: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h3 style="font-size: 18px; font-weight: 700;">Recent Submissions</h3>
        <a href="my-customers.php" style="color: var(--accent); text-decoration: none; font-size: 14px; font-weight: 600;">View All</a>
    </div>

    <div class="card" style="padding: 0;">
        <?php
        $stmt = $db->prepare("SELECT * FROM survey_customers WHERE surveyer_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$userId]);
        $recent = $stmt->fetchAll();

        if (empty($recent)): ?>
            <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                <i class="fa fa-folder-open" style="font-size: 48px; opacity: 0.2; margin-bottom: 16px; display: block;"></i>
                No customers added yet.
            </div>
        <?php else: ?>
            <?php foreach ($recent as $customer): ?>
                <div class="customer-item">
                    <div class="customer-info">
                        <h4><?= h($customer['name']) ?></h4>
                        <p><?= h($customer['phone']) ?> • <?= date('d M Y', strtotime($customer['created_at'])) ?></p>
                    </div>
                    <span class="badge badge-<?= $customer['status'] ?>"><?= str_replace('_', ' ', $customer['status']) ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
