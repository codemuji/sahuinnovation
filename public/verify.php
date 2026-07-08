<?php
/**
 * Public Employee Verification Page
 * No login required - accessible to anyone with the QR code link
 */
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/config/database.php';

$empId = $_GET['id'] ?? '';
$employee = null;

if ($empId) {
    $db = Database::getInstance()->getConnection();
    $stmt = $db->prepare("SELECT id, employee_id, name, role, phone, profile_pic, created_at FROM users WHERE employee_id = ? AND is_active = 1");
    $stmt->execute([$empId]);
    $employee = $stmt->fetch();
}

$roleLabels = [
    'surveyer' => 'Field Survey Agent',
    'dm' => 'District Manager',
    'pe' => 'Project Executive',
    'staff' => 'Staff',
    'admin' => 'Administrator',
    'director' => 'Director',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Verification | Sahu Innovation Pvt. Ltd.</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0B1F3A 0%, #1C385C 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }
        .verify-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .logo-area { margin-bottom: 24px; }
        .logo-area img { height: 50px; object-fit: contain; }
        .company-name { font-family: 'Outfit', sans-serif; font-size: 15px; font-weight: 700; color: #0B1F3A; margin-top: 6px; }
        .divider { height: 1px; background: #e2e8f0; margin: 20px 0; }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .status-valid { background: #d1fae5; color: #065f46; }
        .status-invalid { background: #fee2e2; color: #991b1b; }
        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #B09362;
            margin: 0 auto 16px;
            display: block;
            background: #e2e8f0;
        }
        .avatar-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #0B1F3A;
            color: white;
            font-size: 36px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border: 4px solid #B09362;
            font-family: 'Outfit', sans-serif;
        }
        .emp-name { font-family: 'Outfit', sans-serif; font-size: 22px; font-weight: 800; color: #0B1F3A; margin-bottom: 4px; }
        .emp-role { font-size: 14px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
        .detail-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #94a3b8; font-weight: 500; }
        .detail-value { color: #1e293b; font-weight: 600; }
        .not-found { color: #64748b; }
        .not-found i { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; display: block; }
        .footer-note { font-size: 11px; color: #94a3b8; margin-top: 24px; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="verify-card">
    <div class="logo-area">
        <img src="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/public/assets/img/logo.png" alt="Sahu Innovation Logo" onerror="this.style.display='none'">
        <div class="company-name">Sahu Innovation Pvt. Ltd.</div>
    </div>

    <?php if ($employee): ?>
        <div class="status-badge status-valid">
            <i class="fa fa-circle-check"></i> Verified Employee
        </div>
        <div class="divider"></div>

        <?php if ($employee['profile_pic']): ?>
            <img src="<?= rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') ?>/public/file.php?type=profile&file=<?= urlencode($employee['profile_pic']) ?>" alt="Profile" class="avatar">
        <?php else: ?>
            <div class="avatar-placeholder"><?= strtoupper(substr($employee['name'], 0, 1)) ?></div>
        <?php endif; ?>

        <div class="emp-name"><?= h($employee['name']) ?></div>
        <div class="emp-role"><?= $roleLabels[$employee['role']] ?? h($employee['role']) ?></div>

        <div>
            <div class="detail-row">
                <span class="detail-label">Employee ID</span>
                <span class="detail-value"><?= h($employee['employee_id']) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date of Joining</span>
                <span class="detail-value"><?= date('d M Y', strtotime($employee['created_at'])) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Contact</span>
                <span class="detail-value"><?= h($employee['phone']) ?: 'N/A' ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value" style="color: #10b981;"><i class="fa fa-circle" style="font-size:8px;"></i> Active</span>
            </div>
        </div>
    <?php else: ?>
        <div class="status-badge status-invalid">
            <i class="fa fa-circle-xmark"></i> Not Verified
        </div>
        <div class="not-found">
            <i class="fa fa-id-card-clip"></i>
            <p style="font-size: 16px; font-weight: 600; color: #475569; margin-bottom: 8px;">Employee Not Found</p>
            <p style="font-size: 13px;">The ID <strong><?= h($empId) ?></strong> does not match any active employee in our records.</p>
        </div>
    <?php endif; ?>

    <p class="footer-note">
        <i class="fa fa-lock" style="margin-right: 4px;"></i>
        This is an official verification page of Sahu Innovation Pvt. Ltd.<br>
        Do not share this link with unauthorized persons.
    </p>
</div>
</body>
</html>
