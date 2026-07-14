<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('office_staff');

$db = Database::getInstance()->getConnection();
$userId = Auth::userId();

// Get wallet balance to display
$stmt = $db->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$userId]);
$balance = $stmt->fetchColumn() ?? 0.00;

$pageTitle = "Log Expense";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Log New Expense</h1>
        <p>Record a fund usage entry and submit it for MD verification.</p>
    </div>
</div>

<div class="desktop-card" style="max-w: 600px; margin: 0 auto 40px;">
    <div style="margin-bottom: 24px; padding: 16px; background-color: var(--background); border-radius: var(--radius); border-left: 4px solid var(--accent); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; color: var(--text-muted);">Available Wallet Balance:</span>
        <span style="font-size: 18px; font-weight: 800; color: var(--primary);"><?= formatCurrency($balance) ?></span>
    </div>

    <form action="<?= site_url('app/actions/add_fund_usage.php') ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-label" for="amount">Expense Amount (₹) <span style="color: var(--danger);">*</span></label>
            <input type="number" step="0.01" min="0.01" max="<?= $balance ?>" class="form-control" id="amount" name="amount" required placeholder="0.00">
            <small style="color: var(--text-muted); font-size: 11px;">Must not exceed your current wallet balance.</small>
        </div>

        <div class="form-group">
            <label class="form-label" for="purpose">Expense Purpose / Category <span style="color: var(--danger);">*</span></label>
            <select class="form-control" id="purpose" name="purpose" required>
                <option value="">-- Select Purpose --</option>
                <option value="Procurement & Materials">Procurement & Materials</option>
                <option value="Travel & Lodging">Travel & Lodging</option>
                <option value="Office & Administration">Office & Administration</option>
                <option value="Client & Marketing Expense">Client & Marketing Expense</option>
                <option value="Salaries & Labor Cost">Salaries & Labor Cost</option>
                <option value="Taxes & Utility Bills">Taxes & Utility Bills</option>
                <option value="Other / Miscellaneous">Other / Miscellaneous</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Detailed Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" style="height: auto; padding: 12px;" placeholder="Describe the reason for this expense..."></textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="payment_proof">Payment Proof / Receipt <span style="color: var(--danger);">*</span></label>
            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept=".pdf, .jpg, .jpeg, .png" required style="padding-top: 10px;">
            <small style="color: var(--text-muted); font-size: 11px;">Accepted formats: PDF, JPG, PNG. Max size: 5MB.</small>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 15px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Submit Expense for Review</button>
            <a href="dashboard.php" class="btn" style="flex: 1; border: 1px solid var(--border); text-align: center; line-height: 48px; text-decoration: none; color: var(--text-main);">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
