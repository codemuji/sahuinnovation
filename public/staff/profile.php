<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('staff');

$user = Auth::user(); 
$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user['id']]);
$profile = $stmt->fetch();

$pageTitle = "My Profile";
include __DIR__ . '/../includes/header.php';
?>

<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .profile-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 30px;
    }
    .avatar-upload {
        position: relative;
        width: 120px;
        height: 120px;
        margin-bottom: 15px;
    }
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-image: url('<?= $profile['profile_pic'] ? site_url('public/file.php?type=profile&file='.$profile['profile_pic']) : asset_url('img/default-avatar.png') ?>');
        border: 4px solid var(--accent);
        background-color: #eee;
    }
    .avatar-edit {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--primary);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid white;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
</style>

<div style="margin-bottom: 24px;">
    <a href="dashboard.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">
        <i class="fa fa-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-top: 8px;">My Profile</h1>
</div>

<form action="<?= site_url('app/actions/update_profile.php') ?>" method="POST" enctype="multipart/form-data">
    <div class="profile-header">
        <div class="avatar-upload">
            <div id="imagePreview" class="avatar-preview"></div>
            <label for="imageUpload" class="avatar-edit">
                <i class="fa fa-camera"></i>
            </label>
            <input type="file" id="imageUpload" name="profile_pic" hidden accept="image/*">
        </div>
        <h2 style="font-size: 20px; font-weight: 700;"><?= h($profile['name']) ?></h2>
        <p style="color: var(--text-muted); font-size: 14px; text-transform: uppercase; margin-bottom: 8px;"><?= h($profile['role']) ?></p>
        <?php if ($profile['employee_id']): ?>
        <div style="background: #0B1F3A; color: white; padding: 5px 16px; border-radius: 100px; font-size: 13px; font-weight: 700; letter-spacing: 1px; margin-bottom: 12px;">
            <i class="fa fa-id-badge" style="margin-right:6px;"></i><?= h($profile['employee_id']) ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Personal Info -->
    <div class="profile-card">
        <div class="section-title">
            <i class="fa fa-user"></i> Personal Information
        </div>
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" value="<?= h($profile['name']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" value="<?= h($profile['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" class="form-control" value="<?= h($profile['phone']) ?>">
        </div>
        <div class="form-group">
            <label>Residential Address</label>
            <textarea name="address" class="form-control" style="height: 80px;"><?= h($profile['address']) ?></textarea>
        </div>
    </div>

    <!-- Bank Details -->
    <div class="profile-card">
        <div class="section-title">
            <i class="fa fa-university"></i> Bank Details
        </div>
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="bank_name" class="form-control" placeholder="e.g. State Bank of India" value="<?= h($profile['bank_name']) ?>">
        </div>
        <div class="form-group">
            <label>Account Holder Name</label>
            <input type="text" name="account_holder_name" class="form-control" placeholder="Name as per bank records" value="<?= h($profile['account_holder_name']) ?>">
        </div>
        <div class="form-group">
            <label>Account Number</label>
            <input type="text" name="account_number" class="form-control" placeholder="Enter bank account number" value="<?= h($profile['account_number']) ?>">
        </div>
        <div class="form-group">
            <label>IFSC Code</label>
            <input type="text" name="ifsc_code" class="form-control" placeholder="e.g. SBIN0001234" value="<?= h($profile['ifsc_code']) ?>">
        </div>
        <div class="form-group">
            <label>UPI ID (Optional)</label>
            <input type="text" name="upi_id" class="form-control" placeholder="e.g. yourname@upi" value="<?= h($profile['upi_id']) ?>">
        </div>
    </div>

    <div style="margin-bottom: 40px;">
        <button type="submit" class="btn btn-primary" style="height: 56px; font-size: 16px; border-radius: 12px; background: var(--primary);">
            Update Profile
        </button>
    </div>
</form>

<script>
document.getElementById('imageUpload').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').style.backgroundImage = 'url('+e.target.result+')';
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
