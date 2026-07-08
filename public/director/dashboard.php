<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('director');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get wallet balance
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$wallet = $stmt->fetch();
$balance = $wallet['balance'] ?? 0.00;

// Total Allocations
$stmt = $db->prepare("SELECT SUM(amount) FROM fund_allocations WHERE director_id = ?");
$stmt->execute([$userId]);
$totalAllocated = $stmt->fetchColumn() ?? 0.00;

// Total Expenses Approved
$stmt = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'approved'");
$stmt->execute([$userId]);
$totalApproved = $stmt->fetchColumn() ?? 0.00;

// Total Expenses Pending
$stmt = $db->prepare("SELECT SUM(amount) FROM fund_usages WHERE director_id = ? AND status = 'pending'");
$stmt->execute([$userId]);
$totalPending = $stmt->fetchColumn() ?? 0.00;

// Total Expenses Reverted
$stmt = $db->prepare("SELECT COUNT(*) FROM fund_usages WHERE director_id = ? AND status = 'revert_back'");
$stmt->execute([$userId]);
$revertedCount = $stmt->fetchColumn() ?? 0;

$pageTitle = "Director Dashboard";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Director Dashboard</h1>
        <p>Overview of allocated funds and logged expenses.</p>
    </div>
</div>

<?php if ($revertedCount > 0): ?>
    <div class="alert alert-danger" style="display: flex; justify-content: space-between; align-items: center; background-color: #fee2e2; color: #991b1b; padding: 15px; border-radius: var(--radius); margin-bottom: 25px; border: 1px solid #fecaca;">
        <span><i class="fa fa-circle-exclamation" style="margin-right: 8px;"></i> You have <strong><?= $revertedCount ?></strong> expense entry that requires correction.</span>
        <a href="usages.php?status=revert_back" style="color: #991b1b; font-weight: 700; text-decoration: underline;">View & Correct &rarr;</a>
    </div>
<?php endif; ?>

<div class="grid grid-4" style="margin-bottom: 40px;">
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Wallet Balance</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= formatCurrency($balance) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Available for expenses</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Total Allocated</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--accent); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalAllocated) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Overall funding received</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Approved Expenses</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--success); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalApproved) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Deducted from wallet</div>
    </div>
    <div class="desktop-card">
        <div style="font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">Pending Approval</div>
        <div style="font-size: 26px; font-weight: 800; color: var(--info); font-family: 'Outfit', sans-serif;"><?= formatCurrency($totalPending) ?></div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Under review by Admin</div>
    </div>
</div>

<div class="grid grid-2">
    <!-- Recent Allocations -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Allocations</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->prepare("SELECT * FROM fund_allocations WHERE director_id = ? ORDER BY created_at DESC LIMIT 5");
                    $stmt->execute([$userId]);
                    $allocs = $stmt->fetchAll();
                    if (empty($allocs)): ?>
                        <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">No allocations received yet.</td></tr>
                    <?php else:
                        foreach ($allocs as $a): ?>
                            <tr>
                                <td><?= date('d M Y', strtotime($a['created_at'])) ?></td>
                                <td style="font-weight: 700; color: var(--accent);"><?= formatCurrency($a['amount']) ?></td>
                                <td style="font-size: 13px;"><?= h($a['notes']) ?: 'No description' ?></td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="desktop-card" style="padding: 0;">
        <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Expenses</h3>
            <a href="usages.php" style="font-size: 12px; color: var(--accent); text-decoration: none; font-weight: 600;">View All &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->prepare("SELECT * FROM fund_usages WHERE director_id = ? ORDER BY created_at DESC LIMIT 5");
                    $stmt->execute([$userId]);
                    $usages = $stmt->fetchAll();
                    if (empty($usages)): ?>
                        <tr><td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">No expenses logged yet.</td></tr>
                    <?php else:
                        foreach ($usages as $u): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= h($u['purpose']) ?></td>
                                <td style="font-weight: 700;"><?= formatCurrency($u['amount']) ?></td>
                                <td>
                                    <?php
                                    $bg = '#fef3c7'; $fg = '#92400e';
                                    if ($u['status'] === 'approved') { $bg = '#d1fae5'; $fg = '#065f46'; }
                                    elseif ($u['status'] === 'revert_back') { $bg = '#fee2e2'; $fg = '#991b1b'; }
                                    ?>
                                    <span class="badge" style="background: <?= $bg ?>; color: <?= $fg ?>; font-size: 10px;">
                                        <?= strtoupper($u['status'] === 'revert_back' ? 'REVERTED' : $u['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach;
                    endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Wallet Transactions Log -->
<div class="desktop-card" style="padding: 0; margin-top: 40px;">
    <div style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-size: 16px; font-weight: 700; margin: 0;">Recent Wallet Transactions (Last 7)</h3>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM wallet_transactions WHERE user_id = ? ORDER BY created_at DESC LIMIT 7");
                $stmt->execute([$userId]);
                $txs = $stmt->fetchAll();
                if (empty($txs)): ?>
                    <tr><td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">No wallet transactions logged yet.</td></tr>
                <?php else:
                    foreach ($txs as $t): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($t['created_at'])) ?></td>
                            <td>
                                <span style="font-weight: 600; text-transform: uppercase; font-size: 11px; color: <?= $t['type'] === 'credit' ? 'var(--success)' : 'var(--danger)' ?>;">
                                    <?= h($t['type']) ?>
                                </span>
                            </td>
                            <td><span style="font-size: 12px; font-weight: 600; text-transform: capitalize; color: var(--text-muted);"><?= str_replace('_', ' ', $t['ref_type']) ?> #<?= $t['ref_id'] ?></span></td>
                            <td style="font-weight: 700; color: <?= $t['type'] === 'credit' ? 'var(--success)' : 'var(--text-main)' ?>;">
                                <?= ($t['type'] === 'credit' ? '+' : '-') . formatCurrency($t['amount']) ?>
                            </td>
                            <td>
                                <?php
                                $tbg = '#fef3c7'; $tfg = '#92400e';
                                if ($t['status'] === 'approved') { $tbg = '#d1fae5'; $tfg = '#065f46'; }
                                elseif ($t['status'] === 'rejected') { $tbg = '#fee2e2'; $tfg = '#991b1b'; }
                                ?>
                                <span class="badge" style="background: <?= $tbg ?>; color: <?= $tfg ?>; font-size: 10px;">
                                    <?= strtoupper($t['status']) ?>
                                </span>
                            </td>
                            <td style="font-size: 13px; color: var(--text-muted);"><?= h($t['description']) ?></td>
                        </tr>
                    <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
