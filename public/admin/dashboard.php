<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

// Get counts
$userCount = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
$surveyCount = $db->query("SELECT COUNT(*) FROM survey_customers")->fetchColumn();
$techCount = $db->query("SELECT COUNT(*) FROM technical_customers")->fetchColumn();
$pendingWithdrawals = $db->query("SELECT COUNT(*) FROM withdrawal_requests WHERE status = 'pending'")->fetchColumn();

$pageTitle = "Managing Director Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Managing Director Dashboard</h1>
        <p>System-wide overview and management.</p>
    </div>
</div>

<!-- Public Website Launch / Visibility Status -->
<div class="desktop-card" style="margin-bottom: 24px; border-left: 4px solid <?= SHOW_PUBLIC_WEBSITE ? 'var(--success)' : '#eab308' ?>; background: <?= SHOW_PUBLIC_WEBSITE ? '#f0fdf4' : '#fefce8' ?>;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: <?= SHOW_PUBLIC_WEBSITE ? '#15803d' : '#a16207' ?>; letter-spacing: 0.5px;">
                <i class="fa <?= SHOW_PUBLIC_WEBSITE ? 'fa-globe' : 'fa-eye-slash' ?>" style="margin-right: 6px;"></i>
                Public Website Status: <?= SHOW_PUBLIC_WEBSITE ? 'LIVE & VISIBLE' : 'HIDDEN (LAUNCH PREPARATION MODE)' ?>
            </div>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: var(--text-muted);">
                <?= SHOW_PUBLIC_WEBSITE 
                    ? 'The public website is currently live to all visitors.' 
                    : 'Visitors are currently redirected to the login portal. Internal management system remains fully active.' ?>
            </p>
        </div>
        <div>
            <?php if (!SHOW_PUBLIC_WEBSITE): ?>
                <a href="<?= site_url('public/index.php?preview=1') ?>" target="_blank" class="btn btn-primary" style="font-size: 12px; padding: 6px 14px; text-decoration: none;">
                    <i class="fa fa-eye" style="margin-right: 4px;"></i> Preview Site
                </a>
            <?php else: ?>
                <a href="<?= site_url('public/index.php') ?>" target="_blank" class="btn btn-secondary" style="font-size: 12px; padding: 6px 14px; text-decoration: none;">
                    <i class="fa fa-external-link" style="margin-right: 4px;"></i> Visit Site
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-4" style="margin-bottom: 40px;">
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Total Users</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--primary);"><?= $userCount ?></div>
        <a href="users.php" style="font-size: 11px; color: var(--accent); text-decoration: none; margin-top: 8px; display: block;">Manage Users &rarr;</a>
    </div>
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Surveys Collected</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--info);"><?= $surveyCount ?></div>
        <a href="<?= site_url('public/staff/survey-list.php') ?>" style="font-size: 11px; color: var(--accent); text-decoration: none; margin-top: 8px; display: block;">View All &rarr;</a>
    </div>
    <div class="desktop-card">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Technical Records</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--success);"><?= $techCount ?></div>
        <a href="<?= site_url('public/staff/technical-list.php') ?>" style="font-size: 11px; color: var(--accent); text-decoration: none; margin-top: 8px; display: block;">View All &rarr;</a>
    </div>
    <div class="desktop-card" style="border-left: 4px solid var(--danger);">
        <div style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Payout Requests</div>
        <div style="font-size: 24px; font-weight: 700; color: var(--danger);"><?= $pendingWithdrawals ?></div>
        <a href="withdrawals.php" style="font-size: 11px; color: var(--accent); text-decoration: none; margin-top: 8px; display: block;">Process Payouts &rarr;</a>
    </div>
</div>

<div class="grid grid-2">
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700;">Recent User Registrations</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
                    while ($u = $stmt->fetch()): ?>
                        <tr>
                            <td style="font-weight: 600;"><?= h($u['name']) ?></td>
                            <td><span style="font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.7;"><?= h($u['role']) ?></span></td>
                            <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700;">Recent Payout Requests</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("SELECT w.*, u.name as user_name FROM withdrawal_requests w JOIN users u ON w.user_id = u.id ORDER BY w.requested_at DESC LIMIT 5");
                    while ($r = $stmt->fetch()): ?>
                        <tr>
                            <td><?= h($r['user_name']) ?></td>
                            <td style="font-weight: 700;"><?= formatCurrency($r['amount']) ?></td>
                            <td><span class="badge" style="font-size: 10px; background: <?= $r['status'] == 'pending' ? '#fef3c7' : ($r['status'] == 'paid' ? '#d1fae5' : '#fee2e2') ?>; color: <?= $r['status'] == 'pending' ? '#92400e' : ($r['status'] == 'paid' ? '#065f46' : '#991b1b') ?>;"><?= strtoupper($r['status']) ?></span></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
