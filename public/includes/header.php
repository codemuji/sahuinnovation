<?php
require_once __DIR__ . '/../../app/core/Auth.php';
$user = Auth::user();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sahu Innovation Portal' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset_url('css/main.css') ?>">
    <?php if (Auth::userRole() === 'surveyer'): ?>
        <link rel="stylesheet" href="<?= asset_url('css/mobile.css') ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?= asset_url('css/desktop.css') ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Outfit', sans-serif; }
        .sidebar { background: #0B1F3A !important; } /* Primary Color */
        .sidebar a:hover { background: rgba(255, 255, 255, 0.1) !important; }
        .main-content { background: #FAF9F6; } /* Background Color */
        :root {
            --primary: #0B1F3A;
            --primary-container: #1C385C;
            --accent: #B09362;
        }
    </style>
</head>
<body class="<?= Auth::userRole() === 'surveyer' ? 'mobile-view' : '' ?>">

<?php if (Auth::userRole() !== 'surveyer'): ?>
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="auth-logo" style="margin-bottom: 40px; text-align: left;">
            <h1 style="color: white; font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">Sahu Innovation</h1>
        </div>
        
        <nav style="flex-grow: 1;">
            <ul style="list-style: none;">
                <li style="margin-bottom: 8px;">
                    <a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                        <i class="fa fa-home" style="width: 24px;"></i> Dashboard
                    </a>
                </li>
                
                <?php if (Auth::userRole() === 'dm' || Auth::userRole() === 'pe'): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/add-customer.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'add-customer.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-plus-circle" style="width: 24px;"></i> Add Technical
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/my-customers.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'my-customers.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-users" style="width: 24px;"></i> My Customers
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/wallet.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'wallet.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-wallet" style="width: 24px;"></i> Wallet
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::userRole() === 'staff'): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/staff/survey-list.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'survey-list.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-lines" style="width: 24px;"></i> Survey Review
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/staff/technical-list.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'technical-list.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-contract" style="width: 24px;"></i> Technical Review
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::userRole() === 'admin'): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/users.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'users.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-user-gear" style="width: 24px;"></i> User Management
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/withdrawals.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'withdrawals.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-money-bill-transfer" style="width: 24px;"></i> Withdrawals
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
            <a href="<?= site_url('public/'.Auth::userRole().'/profile.php') ?>" style="display: flex; align-items: center; margin-bottom: 16px; text-decoration: none; color: white;">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent); background-image: url('<?= $user['profile_pic'] ? site_url('public/file.php?type=profile&file='.$user['profile_pic']) : asset_url('img/default-avatar.png') ?>'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-weight: 700; color: white; border: 2px solid rgba(255,255,255,0.1);">
                    <?php if (!$user['profile_pic']) echo substr($user['name'], 0, 1); ?>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 600;"><?= h($user['name']) ?></div>
                    <div style="font-size: 11px; opacity: 0.7; text-transform: uppercase;"><?= h($user['role']) ?></div>
                </div>
            </a>
            <a href="<?= site_url('public/logout.php') ?>" style="color: #ef4444; text-decoration: none; font-size: 14px; font-weight: 600;">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
    
    <main class="main-content">
<?php endif; ?>

<?php if (Auth::userRole() === 'surveyer'): ?>
    <header style="background: var(--primary); color: white; padding: 20px; position: sticky; top: 0; z-index: 100;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 20px; font-weight: 800; letter-spacing: -0.5px;">Sahu Innovation <span style="font-weight: 400; font-family: 'Inter', sans-serif; font-size: 16px; opacity: 0.8;">| Survey</span></h2>
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="<?= site_url('public/surveyer/profile.php') ?>" style="color: white; text-decoration: none;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent); background-image: url('<?= $user['profile_pic'] ? site_url('public/file.php?type=profile&file='.$user['profile_pic']) : asset_url('img/default-avatar.png') ?>'); background-size: cover; background-position: center; border: 2px solid rgba(255,255,255,0.2);"></div>
                </a>
                <a href="<?= site_url('public/logout.php') ?>" style="color: white; opacity: 0.8;"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        </div>
    </header>
    <div class="main-content">
<?php endif; ?>

<?php if ($flash): ?>
    <div class="alert alert-<?= h($flash['type']) ?>" style="margin-bottom: 24px;">
        <?= h($flash['message']) ?>
    </div>
<?php endif; ?>
