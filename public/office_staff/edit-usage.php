<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('office_staff');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

$id = intval($_GET['id'] ?? 0);

if (!$id) {
    setFlash('danger', 'Invalid expense ID.');
    redirect(site_url('public/director/usages.php'));
}

// Fetch record
$stmt = $db->prepare("SELECT * FROM fund_usages WHERE id = ? AND director_id = ?");
$stmt->execute([$id, $userId]);
$usage = $stmt->fetch();

if (!$usage || $usage['status'] !== 'revert_back') {
    setFlash('danger', 'Expense not found or not in reverted status.');
    redirect(site_url('public/director/usages.php'));
}

// Get wallet balance to display
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$balance = $stmt->fetchColumn() ?? 0.00;

$pageTitle = "Correct Expense Entry";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Correct Expense Entry</h1>
        <p>Modify and resubmit the reverted expense for MD verification.</p>
    </div>
</div>

<div class="desktop-card" style="max-w: 600px; margin: 0 auto 40px;">
    <!-- Correction Warning Box -->
    <div style="margin-bottom: 24px; padding: 16px; background-color: #fee2e2; border-radius: var(--radius); border-left: 4px solid var(--danger); color: #991b1b;">
        <div style="font-weight: 700; margin-bottom: 5px;"><i class="fa fa-circle-exclamation"></i> Action Required from MD:</div>
        <p style="font-size: 14px; font-style: italic; font-weight: 500;">"<?= h($usage['admin_note']) ?>"</p>
    </div>

    <div style="margin-bottom: 24px; padding: 16px; background-color: var(--background); border-radius: var(--radius); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; color: var(--text-muted);">Available Wallet Balance:</span>
        <span style="font-size: 18px; font-weight: 800; color: var(--primary);"><?= formatCurrency($balance) ?></span>
    </div>

    <form action="<?= site_url('app/actions/update_fund_usage.php') ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $usage['id'] ?>">

        <div class="form-group">
            <label class="form-label" for="amount">Expense Amount (₹) <span style="color: var(--danger);">*</span></label>
            <input type="number" step="0.01" min="0.01" max="<?= $balance + $usage['amount'] ?>" class="form-control" id="amount" name="amount" required value="<?= h($usage['amount']) ?>">
            <small style="color: var(--text-muted); font-size: 11px;">Must not exceed available wallet balance.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="purpose">Expense Purpose / Category <span style="color: var(--danger);">*</span></label>
            <select class="form-control" id="purpose" name="purpose" required>
                <option value="">-- Select Purpose --</option>
                <option value="Procurement & Materials" <?= $usage['purpose'] === 'Procurement & Materials' ? 'selected' : '' ?>>Procurement & Materials</option>
                <option value="Travel & Lodging" <?= $usage['purpose'] === 'Travel & Lodging' ? 'selected' : '' ?>>Travel & Lodging</option>
                <option value="Office & Administration" <?= $usage['purpose'] === 'Office & Administration' ? 'selected' : '' ?>>Office & Administration</option>
                <option value="Client & Marketing Expense" <?= $usage['purpose'] === 'Client & Marketing Expense' ? 'selected' : '' ?>>Client & Marketing Expense</option>
                <option value="Salaries & Labor Cost" <?= $usage['purpose'] === 'Salaries & Labor Cost' ? 'selected' : '' ?>>Salaries & Labor Cost</option>
                <option value="Taxes & Utility Bills" <?= $usage['purpose'] === 'Taxes & Utility Bills' ? 'selected' : '' ?>>Taxes & Utility Bills</option>
                <option value="Other / Miscellaneous" <?= $usage['purpose'] === 'Other / Miscellaneous' ? 'selected' : '' ?>>Other / Miscellaneous</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Detailed Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" style="height: auto; padding: 12px;"><?= h($usage['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="payment_proof">Update Payment Proof / Receipt</label>
            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept=".pdf, .jpg, .jpeg, .png" style="padding-top: 10px;">
            <div style="margin-top: 8px; display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 11px; color: var(--text-muted);">Current:</span>
                <a href="<?= site_url('public/file.php?type=expense&file=' . urlencode($usage['payment_proof'])) ?>" target="_blank" style="font-size: 11px; color: var(--accent); text-decoration: underline; font-weight: 600;">
                    <i class="fa fa-file-invoice"></i> View Current Receipt
                </a>
            </div>
            <small style="color: var(--text-muted); font-size: 11px; display: block; margin-top: 4px;">Leave empty to keep the current document.</small>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Resubmit for MD Verification</button>
            <a href="usages.php" class="btn" style="flex: 1; border: 1px solid var(--border); text-align: center; line-height: 48px; text-decoration: none; color: var(--text-main);">Back to Logs</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
