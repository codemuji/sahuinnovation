<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

// Fetch pending and reverted expenses
$stmt = $db->query("SELECT f.*, u.name as director_name, u.employee_id as director_emp_id FROM fund_usages f 
    JOIN users u ON f.director_id = u.id 
    WHERE f.status IN ('pending', 'revert_back') 
    ORDER BY f.status ASC, f.created_at DESC");
$reviews = $stmt->fetchAll();

$pageTitle = "Expense Reviews";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Expense Reviews</h1>
        <p>Review and clear expense logs submitted by Directors. Approved amounts are deducted from their wallets.</p>
    </div>
</div>

<div class="grid grid-1" style="max-width: 900px; margin: 0 auto 40px;">
    <?php if (empty($reviews)): ?>
        <div class="desktop-card" style="text-align: center; padding: 50px; color: var(--text-muted);">
            <i class="fa fa-circle-check" style="font-size: 48px; color: var(--success); margin-bottom: 16px;"></i>
            <h3>All Caught Up!</h3>
            <p style="margin-top: 8px;">No expense reports are currently pending review.</p>
        </div>
    <?php else:
        foreach ($reviews as $r): 
            $isReverted = $r['status'] === 'revert_back';
            ?>
            <div class="desktop-card" style="border-left: 4px solid <?= $isReverted ? 'var(--danger)' : 'var(--info)' ?>; margin-bottom: 20px; padding: 24px; position: relative;">
                
                <!-- Card Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <div style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.5px;">Director Details</div>
                        <h2 style="font-size: 18px; font-weight: 700; color: var(--primary); margin-top: 4px;"><?= h($r['director_name']) ?></h2>
                        <span style="font-size: 12px; color: var(--text-muted);">Emp ID: <strong><?= h($r['director_emp_id']) ?></strong></span>
                    </div>
                    <div style="text-align: right;">
                        <span class="badge" style="background: <?= $isReverted ? '#fee2e2' : '#e0f2fe' ?>; color: <?= $isReverted ? '#991b1b' : '#0369a1' ?>; font-size: 11px; margin-bottom: 8px; display: inline-block;">
                            <?= strtoupper($r['status'] === 'revert_back' ? 'REVERTED' : 'PENDING REVIEW') ?>
                        </span>
                        <div style="font-size: 22px; font-weight: 800; color: var(--primary); font-family: 'Outfit', sans-serif;"><?= formatCurrency($r['amount']) ?></div>
                    </div>
                </div>

                <!-- Card Details -->
                <div class="grid grid-2" style="background-color: var(--background); padding: 15px; border-radius: var(--radius); gap: 15px; margin-bottom: 20px;">
                    <div>
                        <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Purpose Category:</span>
                        <p style="font-size: 14px; font-weight: 700; color: var(--primary); margin-top: 2px;"><?= h($r['purpose']) ?></p>
                    </div>
                    <div>
                        <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Submitted Date:</span>
                        <p style="font-size: 14px; font-weight: 600; color: var(--primary); margin-top: 2px;"><?= date('d M Y, H:i', strtotime($r['created_at'])) ?></p>
                    </div>
                    <div style="grid-column: span 2;">
                        <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">Detailed Description:</span>
                        <p style="font-size: 13px; color: var(--text-main); margin-top: 4px; line-height: 1.5;"><?= nl2br(h($r['description'])) ?: '<em>No description provided.</em>' ?></p>
                    </div>
                </div>

                <!-- Proof of Payment Document -->
                <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; border: 1px solid var(--border); padding: 12px 16px; border-radius: var(--radius); background-color: #fff;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <i class="fa fa-file-pdf" style="font-size: 20px; color: var(--accent);"></i>
                        <div>
                            <span style="font-size: 13px; font-weight: 600; color: var(--primary);">Payment Receipt Proof</span>
                            <p style="font-size: 11px; color: var(--text-muted);"><?= h($r['payment_proof']) ?></p>
                        </div>
                    </div>
                    <a href="<?= site_url('public/file.php?type=expense&file=' . urlencode($r['payment_proof'])) ?>" target="_blank" class="btn" style="width: auto; height: 32px; font-size: 12px; line-height: 32px; padding: 0 16px; border: 1px solid var(--accent); color: var(--accent); background: transparent; text-decoration: none; font-weight: 600;">
                        <i class="fa fa-external-link" style="margin-right: 6px;"></i> View Document
                    </a>
                </div>

                <!-- Displays existing Reverted reason -->
                <?php if ($isReverted && $r['admin_note']): ?>
                    <div style="background-color: #fff5f5; border: 1px solid #fecaca; padding: 12px 16px; border-radius: var(--radius); margin-bottom: 20px; font-size: 13px; color: #991b1b;">
                        <strong>Current Revert Message:</strong> <?= h($r['admin_note']) ?>
                    </div>
                <?php endif; ?>

                <!-- Approval Actions -->
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <!-- Approve Button Form -->
                    <form action="<?= site_url('app/actions/approve_fund_usage.php') ?>" method="POST" style="flex: 1; min-width: 150px;">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button type="submit" class="btn btn-primary" style="background-color: var(--success); width: 100%; display: flex; gap: 6px;" data-confirm="Are you sure you want to approve this expense? This will deduct the amount from the director's wallet.">
                            <i class="fa fa-circle-check"></i> Approve & Deduct
                        </button>
                    </form>

                    <!-- Revert Action Trigger -->
                    <button type="button" class="btn" style="flex: 1; min-width: 150px; background-color: var(--danger); color: white; display: flex; gap: 6px;" onclick="toggleRevertBox(<?= $r['id'] ?>)">
                        <i class="fa fa-rotate-left"></i> Revert / Ask for Correction
                    </button>
                </div>

                <!-- Hidden Reversion Box -->
                <div id="revert-box-<?= $r['id'] ?>" style="display: none; margin-top: 20px; border-top: 1px solid var(--border); padding-top: 20px;">
                    <form action="<?= site_url('app/actions/revert_fund_usage.php') ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <div class="form-group">
                            <label class="form-label" for="admin_note_<?= $r['id'] ?>">Correction Note for Director <span style="color: var(--danger);">*</span></label>
                            <textarea class="form-control" id="admin_note_<?= $r['id'] ?>" name="admin_note" rows="3" style="height: auto; padding: 12px;" required placeholder="Explain what is wrong (e.g. Receipt is missing date, amount mismatch, etc.)"></textarea>
                        </div>
                        <div style="display: flex; gap: 10px; margin-top: 10px;">
                            <button type="submit" class="btn btn-primary" style="background-color: var(--danger); width: auto; padding: 0 20px;">Send Correction Message</button>
                            <button type="button" class="btn" style="width: auto; padding: 0 20px; border: 1px solid var(--border);" onclick="toggleRevertBox(<?= $r['id'] ?>)">Cancel</button>
                        </div>
                    </form>
                </div>

            </div>
        <?php endforeach;
    endif; ?>
</div>

<script>
function toggleRevertBox(id) {
    const box = document.getElementById('revert-box-' + id);
    if (box.style.display === 'none') {
        box.style.display = 'block';
        box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        box.style.display = 'none';
    }
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
