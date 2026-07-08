<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('admin');

$db = Database::getInstance()->getConnection();

$roleFilter = $_GET['role'] ?? '';
$query = "SELECT * FROM users";
$params = [];

if ($roleFilter) {
    $query .= " WHERE role = ?";
    $params[] = $roleFilter;
}

$query .= " ORDER BY name ASC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll();

$pageTitle = "User Management";
include __DIR__ . '/../includes/header.php';
?>

<div class="panel-header">
    <div class="panel-title">
        <h1>User Management</h1>
        <p>Create and manage user accounts for all roles.</p>
    </div>
    <a href="add-user.php" class="btn btn-primary" style="width: auto;">
        <i class="fa fa-user-plus" style="margin-right: 8px;"></i> Create New User
    </a>
</div>

<div style="display: flex; gap: 10px; margin-bottom: 24px; overflow-x: auto; padding-bottom: 5px;">
    <a href="users.php" class="badge" style="background: <?= !$roleFilter ? 'var(--primary)' : '#e2e8f0' ?>; color: <?= !$roleFilter ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">All Roles</a>
    <a href="users.php?role=surveyer" class="badge" style="background: <?= $roleFilter == 'surveyer' ? 'var(--accent)' : '#e2e8f0' ?>; color: <?= $roleFilter == 'surveyer' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Surveyers</a>
    <a href="users.php?role=dm" class="badge" style="background: <?= $roleFilter == 'dm' ? 'var(--info)' : '#e2e8f0' ?>; color: <?= $roleFilter == 'dm' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">DM</a>
    <a href="users.php?role=pe" class="badge" style="background: <?= $roleFilter == 'pe' ? 'var(--info)' : '#e2e8f0' ?>; color: <?= $roleFilter == 'pe' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">PE</a>
    <a href="users.php?role=staff" class="badge" style="background: <?= $roleFilter == 'staff' ? 'var(--success)' : '#e2e8f0' ?>; color: <?= $roleFilter == 'staff' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Staff</a>
    <a href="users.php?role=admin" class="badge" style="background: <?= $roleFilter == 'admin' ? '#475569' : '#e2e8f0' ?>; color: <?= $roleFilter == 'admin' ? 'white' : 'var(--text-muted)' ?>; text-decoration: none; padding: 10px 20px;">Admins</a>
</div>

<div class="desktop-card" style="padding: 0;">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td style="font-weight: 600;"><?= h($u['name']) ?></td>
                        <td><?= h($u['email']) ?></td>
                        <td><?= h($u['phone']) ?: 'N/A' ?></td>
                        <td><span style="font-size: 11px; text-transform: uppercase; font-weight: 700; opacity: 0.7;"><?= h($u['role']) ?></span></td>
                        <td>
                            <span class="badge" style="background: <?= $u['is_active'] ? '#d1fae5' : '#fee2e2' ?>; color: <?= $u['is_active'] ? '#065f46' : '#991b1b' ?>;">
                                <?= $u['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="user-detail.php?id=<?= $u['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--primary); color: white;">View</a>
                                <a href="edit-user.php?id=<?= $u['id'] ?>" class="btn" style="height: 32px; padding: 0 12px; font-size: 12px; width: auto; background: var(--border); color: var(--text-main);">Edit</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
