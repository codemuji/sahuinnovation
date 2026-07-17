<?php
require_once __DIR__ . '/../app/core/Auth.php';

// If already logged in, redirect to dashboard
if (Auth::check()) {
    $role = Auth::userRole();
    $validRoles = ['surveyer', 'dm', 'pe', 'director', 'office_staff', 'staff', 'admin'];
    if (in_array($role, $validRoles)) {
        redirect(site_url('public/' . ($role === 'pe' ? 'dm' : $role) . '/dashboard.php'));
    } else {
        unset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['user_name']);
    }
}

$flash = getFlash();

$roleNames = [
    'admin' => 'Managing Director / Admin Panel',
    'director' => 'Director Panel',
    'staff' => 'Staff / Review Panel',
    'office_staff' => 'Staff / Review Panel',
    'dm' => 'DM / PE Panel',
    'pe' => 'DM / PE Panel',
    'surveyer' => 'Field Surveyor Panel'
];
$selectedRole = $_GET['role'] ?? '';
$roleDisplayName = $roleNames[$selectedRole] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $roleDisplayName ? h($roleDisplayName) . ' Login' : 'Login' ?> | Sahu Innovation Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset_url('css/main.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }
        .auth-logo h1 { font-size: 32px; font-weight: 800; letter-spacing: -1px; color: #0B1F3A; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="<?= site_url('public/index.php') ?>" style="text-decoration: none;">
                    <h1>Sahu Innovation</h1>
                </a>
                <p style="color: var(--text-muted); font-size: 14px; margin-top: 8px;">Internal Management Platform</p>
                <?php if ($roleDisplayName): ?>
                    <div style="background: #e0f2fe; color: #0369a1; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 700; text-align: center; margin-top: 14px; border: 1px solid #bae6fd;">
                        <i class="fa fa-shield-halved" style="margin-right: 6px;"></i> Signing into <?= h($roleDisplayName) ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($flash): ?>
                <div class="alert alert-<?= h($flash['type']) ?>">
                    <?= h($flash['message']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('app/actions/login.php') ?>" method="POST">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            
            <div style="margin-top: 24px; text-align: center; font-size: 13px; color: var(--text-muted);">
                &copy; <?= date('Y') ?> Sahu Innovation. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html>
