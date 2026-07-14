<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$userToEdit = $stmt->fetch();

if (!$userToEdit) {
    setFlash('danger', 'User not found.');
    redirect('users.php');
}

$pageTitle = "Edit User: " . h($userToEdit['name']);
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <a href="users.php" style="color: var(--text-muted); text-decoration: none; font-size: 13px;">
            <i class="fa fa-arrow-left"></i> Back to User List
        </a>
        <h1 style="margin-top: 8px;">Edit User: <?= h($userToEdit['name']) ?></h1>
    </div>
</div>

<div class="grid" style="grid-template-columns: 1fr 1fr;">
    <div class="desktop-card">
        <form action="<?= site_url('app/actions/update_user.php') ?>" method="POST">
            <input type="hidden" name="id" value="<?= $userToEdit['id'] ?>">
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= h($userToEdit['name']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="<?= h($userToEdit['email']) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="tel" name="phone" class="form-control" value="<?= h($userToEdit['phone']) ?>">
            </div>

            <div class="form-group">
                <label class="form-label">User Role</label>
                <select name="role" class="form-control" required>
                    <option value="surveyer" <?= $userToEdit['role'] == 'surveyer' ? 'selected' : '' ?>>Surveyer</option>
                    <option value="dm" <?= $userToEdit['role'] == 'dm' ? 'selected' : '' ?>>DM</option>
                    <option value="pe" <?= $userToEdit['role'] == 'pe' ? 'selected' : '' ?>>PE</option>
                    <option value="staff" <?= $userToEdit['role'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="admin" <?= $userToEdit['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                    <option value="director" <?= $userToEdit['role'] == 'director' ? 'selected' : '' ?>>Director</option>
                    <option value="office_staff" <?= $userToEdit['role'] == 'office_staff' ? 'selected' : '' ?>>Office Staff</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-control" required>
                    <option value="1" <?= $userToEdit['is_active'] ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= !$userToEdit['is_active'] ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">New Password (Leave blank to keep current)</label>
                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters">
            </div>

            <div style="margin-top: 32px;">
                <button type="submit" class="btn btn-primary">Update User Account</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
