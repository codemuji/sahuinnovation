<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('subcontractor');

$db = Database::getInstance()->getConnection();
$user = Auth::user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $bank_name = trim($_POST['bank_name'] ?? '');
    $account_holder_name = trim($_POST['account_holder_name'] ?? '');
    $account_number = trim($_POST['account_number'] ?? '');
    $ifsc_code = trim($_POST['ifsc_code'] ?? '');
    $upi_id = trim($_POST['upi_id'] ?? '');

    $stmt = $db->prepare("UPDATE users SET phone = ?, bank_name = ?, account_holder_name = ?, account_number = ?, ifsc_code = ?, upi_id = ? WHERE id = ?");
    $stmt->execute([$phone, $bank_name, $account_holder_name, $account_number, $ifsc_code, $upi_id, $user['id']]);

    setFlash('success', 'Profile and bank details updated successfully.');
    redirect(site_url('public/subcontractor/profile.php'));
}

$pageTitle = "My Profile";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>Sub-Contractor Profile</h1>
        <p>Manage your account, contact details, and payout bank information.</p>
    </div>
</div>

<div class="grid grid-2" style="max-width: 900px; margin: 0 auto 40px;">
    <div class="desktop-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Sub-Contractor Information</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" value="<?= h($user['name']) ?>" disabled style="background-color: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" value="<?= h($user['email']) ?>" disabled style="background-color: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Employee / ID Code</label>
                <input type="text" class="form-control" value="<?= h($user['employee_id']) ?>" disabled style="background-color: var(--background);">
            </div>
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" value="<?= h($user['phone']) ?>" placeholder="10-digit mobile number">
            </div>

            <h3 style="font-size: 15px; font-weight: 700; margin-top: 30px; margin-bottom: 15px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">Bank & UPI Details for MD Payouts</h3>
            
            <div class="form-group">
                <label class="form-label">Bank Name</label>
                <input type="text" name="bank_name" class="form-control" value="<?= h($user['bank_name']) ?>" placeholder="e.g. State Bank of India">
            </div>
            <div class="form-group">
                <label class="form-label">Account Holder Name</label>
                <input type="text" name="account_holder_name" class="form-control" value="<?= h($user['account_holder_name']) ?>" placeholder="Name as per bank account">
            </div>
            <div class="form-group">
                <label class="form-label">Account Number</label>
                <input type="text" name="account_number" class="form-control" value="<?= h($user['account_number']) ?>" placeholder="Bank Account Number">
            </div>
            <div class="form-group">
                <label class="form-label">IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control" value="<?= h($user['ifsc_code']) ?>" placeholder="e.g. SBIN0001234">
            </div>
            <div class="form-group">
                <label class="form-label">UPI ID</label>
                <input type="text" name="upi_id" class="form-control" value="<?= h($user['upi_id']) ?>" placeholder="e.g. mobile@upi">
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Save Details</button>
            </div>
        </form>
    </div>

    <div>
        <div class="desktop-card" style="margin-bottom: 20px; border-left: 4px solid var(--accent);">
            <h4 style="font-size: 15px; font-weight: 700; color: var(--primary);">Important Note for Payouts</h4>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 8px; line-height: 1.6;">
                Ensure your bank account number and IFSC code are accurate. Sub-Contract 1st & 2nd payments disbursed by the MD will be transferred based on these banking records.
            </p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
