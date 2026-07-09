<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$pageTitle = "Create New User";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="users.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to User List
        </a>
        <h1 style="margin-top: 8px;">Create New User</h1>
    </div>
</div>

<div class="grid" style="grid-template-columns: 1fr 1fr;">
    <div class="desktop-card">
        <form action="<?= site_url('app/actions/create_user.php') ?>" method="POST">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required placeholder="Enter full name">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" required placeholder="name@example.com">
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile">
            </div>

            <div class="form-group">
                <label class="form-label">User Role</label>
                <select name="role" class="form-control" required>
                    <option value="">Select Role</option>
                    <option value="surveyer">Surveyer (Field Agent)</option>
                    <option value="dm">DM (Technical)</option>
                    <option value="pe">PE (Technical)</option>
                    <option value="staff">Staff (Reviewer)</option>
                    <option value="admin">Administrator</option>
                    <option value="director">Director</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimum 6 characters">
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
        </form>
    </div>

    <div style="padding: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: var(--primary);">Role Access Levels</h3>
        <ul style="font-size: 14px; color: var(--text-muted); padding-left: 20px; line-height: 2;">
            <li><strong>Surveyer:</strong> Add customers, upload survey docs, track ₹30 incentives.</li>
            <li><strong>DM/PE:</strong> Add technical customers, upload ownership docs, track ₹20k/₹15k incentives.</li>
            <li><strong>Staff:</strong> Review all submissions, approve or reject records.</li>
            <li><strong>Admin:</strong> System management, user control, and payout processing.</li>
            <li><strong>Director:</strong> Log budget usages, upload payment proofs, view CA reports.</li>
        </ul>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
