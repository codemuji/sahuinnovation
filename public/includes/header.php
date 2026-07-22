<?php
require_once __DIR__ . '/../../app/core/Auth.php';
$user = Auth::user();
$flash = getFlash();

$pendingExpenseCount = 0;
if (Auth::check() && Auth::userRole() === 'admin') {
    $db = Database::getInstance()->getConnection();
    $pendingExpenseCount = $db->query("SELECT COUNT(*) FROM fund_usages WHERE status = 'pending'")->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sahu Innovation Portal' ?></title>
    <link rel="icon" type="image/png" href="<?= asset_url('img/logo.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset_url('css/main.css') ?>">
    <?php if (Auth::userRole() === 'surveyer'): ?>
        <link rel="stylesheet" href="<?= asset_url('css/mobile.css') ?>">
    <?php else: ?>
        <link rel="stylesheet" href="<?= asset_url('css/desktop.css') ?>">
        <link rel="stylesheet" href="<?= asset_url('css/director-mobile.css') ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php if (Auth::userRole() !== 'surveyer'): ?>
    <script>
        function openSidebar()  { document.body.classList.add('sidebar-open');    document.getElementById('sidebarOverlay').classList.add('open'); }
        function closeSidebar() { document.body.classList.remove('sidebar-open'); document.getElementById('sidebarOverlay').classList.remove('open'); }
    </script>
    <?php endif; ?>
    <style>
        .portal-desktop-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .portal-desktop-header .header-left {
            display: flex;
            align-items: center;
            gap: 24px;
        }
        .portal-desktop-header .header-nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .portal-desktop-header .header-nav-links a {
            color: #1e293b;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .portal-desktop-header .header-nav-links a:hover {
            background: #f1f5f9;
            color: #0B1F3A;
        }
        .portal-desktop-header .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        @media (max-width: 767px) {
            .portal-desktop-header { display: none !important; }
        }
        .surveyer-header-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }
        .surveyer-header-nav a {
            color: #ffffff;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            background: rgba(255,255,255,0.1);
            padding: 6px 14px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.2s;
        }
        .surveyer-header-nav a:hover, .surveyer-header-nav a.active {
            background: #B09362;
            border-color: #B09362;
            color: #ffffff;
        }
    </style>
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
        <div class="auth-logo" style="margin-bottom: 30px; text-align: left; padding: 4px 0;">
            <a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                <div style="background: rgba(255,255,255,0.08); padding: 8px 10px; border-radius: 10px; border: 1px solid rgba(212, 175, 55, 0.35); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                    <img src="<?= asset_url('img/logo.png') ?>" alt="Sahu Innovation Logo" style="height: 36px; width: auto; object-fit: contain;">
                </div>
                <div style="display: flex; flex-direction: column;">
                    <span style="color: #ffffff; font-size: 18px; font-weight: 800; font-family: 'Outfit', sans-serif; letter-spacing: -0.5px; line-height: 1.1;">SAHU</span>
                    <span style="color: #D4AF37; font-size: 9px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-family: 'Inter', sans-serif; line-height: 1.1; margin-top: 2px;">INNOVATION</span>
                </div>
            </a>
        </div>
        
        <nav style="flex-grow: 1;">
            <ul style="list-style: none;">
                <li style="margin-bottom: 8px;">
                    <a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                        <i class="fa fa-home" style="width: 24px;"></i> <?= in_array(Auth::userRole(), ['director', 'office_staff']) ? 'Home' : 'Dashboard' ?>
                    </a>
                </li>
                
                <?php if (Auth::userRole() === 'dm' || Auth::userRole() === 'pe'): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/add-customer.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'add-customer.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-plus-circle" style="width: 24px;"></i> Add Consumer
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/my-customers.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'my-customers.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-users" style="width: 24px;"></i> My Customers
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/dm/wallet.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'wallet.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-receipt" style="width: 24px;"></i> Payouts History
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::userRole() === 'staff'): ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/staff/survey-list.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'survey-list.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-lines" style="width: 24px;"></i> Application Review
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/staff/technical-list.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'technical-list.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-contract" style="width: 24px;"></i> PM Surya Ghar Application
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (in_array(Auth::userRole(), ['director', 'office_staff'])):
                    $panelDir = Auth::userRole() === 'office_staff' ? 'office_staff' : 'director';
                ?>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/add-usage.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'add-usage.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-plus-circle" style="width: 24px;"></i> Add Expense
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/usages.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'usages.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-receipt" style="width: 24px;"></i> Expense
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/total-expenses.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'total-expenses.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-calculator" style="width: 24px;"></i> Total Expense
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/salary-advance.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'salary-advance.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-money-check-dollar" style="width: 24px;"></i> Salary & Advance
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/profile.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'profile.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-user" style="width: 24px;"></i> Profile
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/' . $panelDir . '/report.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'report.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-chart-line" style="width: 24px;"></i> CA Budget Report
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (Auth::userRole() === 'admin'):
                    // Determine which admin section we're in
                    $expensePages = ['allocate-funds.php', 'disburse-salary.php', 'expense-reviews.php', 'budget-report.php', 'director-reports.php'];
                    $currentPage  = basename($_SERVER['PHP_SELF']);
                    $isExpenseSection = in_array($currentPage, $expensePages);
                ?>

                    <?php if (!$isExpenseSection): ?>
                    <!-- USER MANAGEMENT NAV -->
                    <li style="padding: 10px 12px 5px; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px;">User Management</li>
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
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/staff/survey-list.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'survey-list.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-lines" style="width: 24px;"></i> Application Review
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/stage5-payouts.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'stage5-payouts.php') !== false || strpos($_SERVER['PHP_SELF'], 'technical-detail.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-file-contract" style="width: 24px;"></i> Stage 5 Payouts
                        </a>
                    </li>
                    <!-- Switch to Expense panel -->
                    <li style="margin-top: 24px;">
                        <a href="<?= site_url('public/admin/allocate-funds.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 10px 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.4); font-size: 13px; font-weight: 600; gap: 8px;">
                            <i class="fa fa-arrow-right-long"></i> Expense Management
                        </a>
                    </li>

                    <?php else: ?>
                    <!-- EXPENSE MANAGEMENT NAV -->
                    <li style="padding: 10px 12px 5px; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.5px;">Expense Management</li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/allocate-funds.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'allocate-funds.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-hand-holding-dollar" style="width: 24px;"></i> Allocate Funds
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/disburse-salary.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'disburse-salary.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-money-check-dollar" style="width: 24px;"></i> Salary / Advance
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/expense-reviews.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'expense-reviews.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-clipboard-check" style="width: 24px;"></i> Expense Reviews
                            <?php if ($pendingExpenseCount > 0): ?>
                                <span style="background-color: var(--danger); color: white; border-radius: 50%; font-size: 11px; padding: 2px 6px; margin-left: auto; font-weight: 700;"><?= $pendingExpenseCount ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/budget-report.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'budget-report.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-briefcase" style="width: 24px;"></i> Annual Budget Report
                        </a>
                    </li>
                    <li style="margin-bottom: 8px;">
                        <a href="<?= site_url('public/admin/director-reports.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 12px; border-radius: 8px; background: <?= strpos($_SERVER['PHP_SELF'], 'director-reports.php') !== false ? 'rgba(255,255,255,0.1)' : 'transparent' ?>">
                            <i class="fa fa-users-rectangle" style="width: 24px;"></i> Director-wise Reports
                        </a>
                    </li>
                    <!-- Switch to User panel -->
                    <li style="margin-top: 24px;">
                        <a href="<?= site_url('public/admin/dashboard.php') ?>" style="color: white; text-decoration: none; display: flex; align-items: center; padding: 10px 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.4); font-size: 13px; font-weight: 600; gap: 8px;">
                            <i class="fa fa-arrow-left-long"></i> User Management
                        </a>
                    </li>
                    <?php endif; ?>

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
                    <div style="font-size: 11px; opacity: 0.7; text-transform: uppercase;"><?= $user['role'] === 'admin' ? 'MANAGING DIRECTOR' : h($user['role']) ?></div>
                </div>
            </a>
            <a href="<?= site_url('public/logout.php') ?>" style="color: #ef4444; text-decoration: none; font-size: 14px; font-weight: 600;">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>

    <!-- Mobile: sidebar overlay backdrop -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Mobile: top bar with navigation hamburger menu -->
    <div class="director-mobile-topbar">
        <a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
            <img src="<?= asset_url('img/logo.png') ?>" alt="Sahu Innovation" style="height: 28px; width: auto; object-fit: contain;">
            <span class="topbar-logo" style="margin: 0; font-size: 16px;">Sahu <span>Innovation</span></span>
        </a>
        <div class="topbar-actions">
            <a href="<?= site_url('public/'.Auth::userRole().'/profile.php') ?>" class="topbar-avatar"
               style="background-image: url('<?= $user['profile_pic'] ? site_url('public/file.php?type=profile&file='.$user['profile_pic']) : asset_url('img/default-avatar.png') ?>')">
               <?php if (!$user['profile_pic']) echo substr($user['name'], 0, 1); ?>
            </a>
            <button class="hamburger-btn" onclick="openSidebar()" aria-label="Open menu">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>

    <main class="main-content">
        <!-- Desktop Header Navigation Bar -->
        <header class="portal-desktop-header">
            <div class="header-left">
                <a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                    <img src="<?= asset_url('img/logo.png') ?>" alt="Sahu Innovation" style="height: 32px; width: auto; object-fit: contain;">
                    <div style="display: flex; flex-direction: column;">
                        <span style="color: #0B1F3A; font-size: 15px; font-weight: 800; font-family: 'Outfit', sans-serif; line-height: 1;">SAHU</span>
                        <span style="color: #B08B28; font-size: 8px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase;">INNOVATION</span>
                    </div>
                </a>
                <div style="height: 24px; width: 1px; background: #e2e8f0; margin: 0 4px;"></div>
                <h2 style="font-size: 16px; font-weight: 800; color: #0B1F3A; margin: 0; font-family: 'Outfit', sans-serif;">
                    <?= strtoupper(Auth::userRole() === 'admin' ? 'Managing Director Panel' : Auth::userRole() . ' Portal') ?>
                </h2>
                <ul class="header-nav-links">
                    <li><a href="<?= site_url('public/'.Auth::userRole().'/dashboard.php') ?>"><i class="fa fa-home" style="margin-right: 6px; opacity: 0.7;"></i>Dashboard</a></li>
                    <?php if (in_array(Auth::userRole(), ['dm', 'pe'])): ?>
                        <li><a href="<?= site_url('public/dm/add-customer.php') ?>"><i class="fa fa-plus-circle" style="margin-right: 6px; opacity: 0.7;"></i>Add Consumer</a></li>
                        <li><a href="<?= site_url('public/dm/my-customers.php') ?>"><i class="fa fa-users" style="margin-right: 6px; opacity: 0.7;"></i>My Consumers</a></li>
                    <?php elseif (Auth::userRole() === 'staff'): ?>
                        <li><a href="<?= site_url('public/staff/survey-list.php') ?>"><i class="fa fa-file-lines" style="margin-right: 6px; opacity: 0.7;"></i>Review Applications</a></li>
                    <?php elseif (in_array(Auth::userRole(), ['director', 'office_staff'])):
                        $panelDir = Auth::userRole() === 'office_staff' ? 'office_staff' : 'director';
                    ?>
                        <li><a href="<?= site_url('public/' . $panelDir . '/usages.php') ?>"><i class="fa fa-receipt" style="margin-right: 6px; opacity: 0.7;"></i>Expenses</a></li>
                        <li><a href="<?= site_url('public/' . $panelDir . '/report.php') ?>"><i class="fa fa-chart-line" style="margin-right: 6px; opacity: 0.7;"></i>CA Report</a></li>
                    <?php elseif (Auth::userRole() === 'admin'): ?>
                        <li><a href="<?= site_url('public/admin/users.php') ?>"><i class="fa fa-users-gear" style="margin-right: 6px; opacity: 0.7;"></i>Users</a></li>
                        <li><a href="<?= site_url('public/admin/allocate-funds.php') ?>"><i class="fa fa-hand-holding-dollar" style="margin-right: 6px; opacity: 0.7;"></i>Expenses</a></li>
                    <?php endif; ?>
                    <li><a href="<?= site_url('public/index.php') ?>" target="_blank"><i class="fa fa-globe" style="margin-right: 6px; opacity: 0.7;"></i>Website</a></li>
                </ul>
            </div>
            <div class="header-right">
                <a href="<?= site_url('public/'.Auth::userRole().'/profile.php') ?>" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #1e293b;">
                    <div style="width: 34px; height: 34px; border-radius: 50%; background: var(--accent); background-image: url('<?= $user['profile_pic'] ? site_url('public/file.php?type=profile&file='.$user['profile_pic']) : asset_url('img/default-avatar.png') ?>'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; font-weight: 700; color: white; border: 2px solid #e2e8f0;">
                        <?php if (!$user['profile_pic']) echo substr($user['name'], 0, 1); ?>
                    </div>
                    <span style="font-size: 13.5px; font-weight: 600;"><?= h($user['name']) ?></span>
                </a>
                <a href="<?= site_url('public/logout.php') ?>" style="color: #ef4444; text-decoration: none; font-size: 13.5px; font-weight: 600; padding: 6px 12px; border-radius: 6px; background: #fef2f2; border: 1px solid #fee2e2;">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </header>
<?php endif; ?>

<?php if (Auth::userRole() === 'surveyer'): ?>
    <header style="background: var(--primary); color: white; padding: 20px; position: sticky; top: 0; z-index: 100;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img src="<?= asset_url('img/logo.png') ?>" alt="Sahu Innovation Logo" style="height: 32px; width: auto; object-fit: contain; background: #ffffff; padding: 3px 6px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                <h2 style="font-size: 18px; font-weight: 800; letter-spacing: -0.5px; margin: 0;">Sahu Innovation <span style="font-weight: 400; font-family: 'Inter', sans-serif; font-size: 14px; opacity: 0.85;">| Survey</span></h2>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="<?= site_url('public/surveyer/profile.php') ?>" style="color: white; text-decoration: none;">
                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent); background-image: url('<?= $user['profile_pic'] ? site_url('public/file.php?type=profile&file='.$user['profile_pic']) : asset_url('img/default-avatar.png') ?>'); background-size: cover; background-position: center; border: 2px solid rgba(255,255,255,0.2);"></div>
                </a>
                <a href="<?= site_url('public/logout.php') ?>" style="color: white; opacity: 0.8;"><i class="fa fa-sign-out-alt"></i></a>
            </div>
        </div>
        <nav class="surveyer-header-nav">
            <a href="<?= site_url('public/surveyer/dashboard.php') ?>" class="<?= strpos($_SERVER['PHP_SELF'], 'dashboard.php') !== false ? 'active' : '' ?>"><i class="fa fa-home" style="margin-right: 5px;"></i>Dashboard</a>
            <a href="<?= site_url('public/surveyer/add-customer.php') ?>" class="<?= strpos($_SERVER['PHP_SELF'], 'add-customer.php') !== false ? 'active' : '' ?>"><i class="fa fa-plus-circle" style="margin-right: 5px;"></i>Add Consumer</a>
            <a href="<?= site_url('public/surveyer/my-customers.php') ?>" class="<?= strpos($_SERVER['PHP_SELF'], 'my-customers.php') !== false ? 'active' : '' ?>"><i class="fa fa-users" style="margin-right: 5px;"></i>My Consumers</a>
            <a href="<?= site_url('public/surveyer/wallet.php') ?>" class="<?= strpos($_SERVER['PHP_SELF'], 'wallet.php') !== false ? 'active' : '' ?>"><i class="fa fa-receipt" style="margin-right: 5px;"></i>Wallet & Payouts</a>
            <a href="<?= site_url('public/surveyer/profile.php') ?>" class="<?= strpos($_SERVER['PHP_SELF'], 'profile.php') !== false ? 'active' : '' ?>"><i class="fa fa-user" style="margin-right: 5px;"></i>Profile</a>
        </nav>
    </header>
    <div class="main-content">
<?php endif; ?>

<?php if ($flash): ?>
    <div class="alert alert-<?= h($flash['type']) ?>" style="margin-bottom: 24px;">
        <?= h($flash['message']) ?>
    </div>
<?php endif; ?>
