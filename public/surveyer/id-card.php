<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole(['surveyer', 'staff', 'admin', 'dm', 'pe']);

$db = Database::getInstance()->getConnection();

// Get the target user — surveyer sees own, others can pass ?user_id=
$targetId = $_GET['user_id'] ?? Auth::userId();
if (Auth::userRole() === 'surveyer') {
    $targetId = Auth::userId(); // Surveyer can only see own card
}

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$targetId]);
$profile = $stmt->fetch();

if (!$profile) {
    setFlash('danger', 'User not found.');
    redirect(site_url('public/surveyer/dashboard.php'));
}

$roleLabels = [
    'surveyer' => 'Field Survey Agent',
    'dm'       => 'District Manager',
    'pe'       => 'Project Executive',
    'staff'    => 'Staff',
    'admin'    => 'Administrator',
];
$designation = $roleLabels[$profile['role']] ?? ucfirst($profile['role']);
$verifyUrl   = site_url('public/verify.php?id=' . $profile['employee_id']);
$photoUrl    = $profile['profile_pic']
    ? site_url('public/file.php?type=profile&file=' . $profile['profile_pic'])
    : '';
$doj         = date('d M Y', strtotime($profile['created_at']));

$pageTitle = "ID Card – " . $profile['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($pageTitle) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #f0f4f8;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Page controls */
        .page-header {
            width: 100%;
            max-width: 420px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .download-btns { display: flex; gap: 10px; }
        .dl-btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .dl-pdf { background: #0B1F3A; color: white; }
        .dl-img { background: #B09362; color: white; }

        /* ── ID CARD ────────────────────────────────────────────── */
        #id-card {
            width: 380px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            position: relative;
        }

        /* Top header band */
        .card-header {
            background: linear-gradient(135deg, #0B1F3A 0%, #1C385C 100%);
            padding: 24px 24px 0;
            text-align: center;
            position: relative;
        }
        .card-logo {
            height: 44px;
            object-fit: contain;
            filter: brightness(0) invert(1);
            margin-bottom: 8px;
        }
        .card-company {
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 800;
            color: white;
            letter-spacing: 0.3px;
            line-height: 1.2;
        }
        .card-tagline {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        /* Curved separator with photo */
        .card-photo-wrap {
            display: flex;
            justify-content: center;
            margin-bottom: -50px;
        }
        .card-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 4px solid #B09362;
            object-fit: cover;
            background: #ddd;
            display: block;
        }
        .card-photo-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 4px solid #B09362;
            background: #1C385C;
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Wave SVG */
        .card-wave {
            display: block;
            width: 100%;
            margin-top: -2px;
        }

        /* Body */
        .card-body {
            padding: 60px 24px 20px;
            text-align: center;
        }
        .card-name {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: #0B1F3A;
            margin-bottom: 4px;
        }
        .card-designation {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #B09362;
            margin-bottom: 20px;
        }

        /* Info grid */
        .card-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 16px;
            text-align: left;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 7px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #94a3b8; font-weight: 500; display: flex; align-items: center; gap: 6px; }
        .info-value { color: #1e293b; font-weight: 600; text-align: right; }

        /* Employee ID pill */
        .emp-id-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0B1F3A;
            color: white;
            padding: 6px 16px;
            border-radius: 100px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        /* QR Code */
        .card-qr-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 16px;
            text-align: left;
        }
        #qrcode canvas, #qrcode img { border-radius: 6px; }
        .qr-text { flex: 1; }
        .qr-text p { font-size: 10px; color: #94a3b8; line-height: 1.5; }
        .qr-text strong { font-size: 11px; color: #0B1F3A; display: block; margin-bottom: 2px; }

        /* Footer bar */
        .card-footer {
            background: linear-gradient(135deg, #0B1F3A 0%, #1C385C 100%);
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-footer-left { font-size: 9px; color: rgba(255,255,255,0.6); line-height: 1.6; }
        .card-footer-sig { text-align: right; }
        .sig-line { width: 80px; height: 1px; background: rgba(255,255,255,0.4); margin-bottom: 4px; margin-left: auto; }
        .sig-label { font-size: 9px; color: rgba(255,255,255,0.6); }

        /* Gold accent bar at very bottom */
        .gold-bar { height: 4px; background: linear-gradient(90deg, #B09362, #d4b483, #B09362); }

        @media (max-width: 440px) {
            #id-card { width: 100%; }
            .page-header { max-width: 100%; }
        }
        @media print {
            body { background: white; padding: 0; }
            .page-header { display: none; }
            #id-card { box-shadow: none; }
        }
    </style>
</head>
<body>

<div class="page-header">
    <a href="<?= site_url('public/surveyer/profile.php') ?>" class="back-link">
        <i class="fa fa-arrow-left"></i> Back to Profile
    </a>
    <div class="download-btns">
        <button class="dl-btn dl-img" onclick="downloadPNG()"><i class="fa fa-image"></i> PNG</button>
        <button class="dl-btn dl-pdf" onclick="downloadPDF()"><i class="fa fa-file-pdf"></i> PDF</button>
    </div>
</div>

<div id="id-card">
    <!-- HEADER -->
    <div class="card-header">
        <img src="<?= asset_url('img/logo.png') ?>" alt="Sahu Innovation" class="card-logo" onerror="this.style.display='none'">
        <div class="card-company">Sahu Innovation Pvt. Ltd.</div>
        <div class="card-tagline">Solar Energy Solutions</div>

        <div class="card-photo-wrap">
            <?php if ($photoUrl): ?>
                <img src="<?= h($photoUrl) ?>" alt="Profile" class="card-photo" crossorigin="anonymous">
            <?php else: ?>
                <div class="card-photo-placeholder"><?= strtoupper(substr($profile['name'], 0, 1)) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Wave -->
    <svg class="card-wave" viewBox="0 0 380 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0,0 L0,20 Q95,50 190,25 Q285,0 380,20 L380,0 Z" fill="#1C385C"/>
    </svg>

    <!-- BODY -->
    <div class="card-body">
        <div class="card-name"><?= h($profile['name']) ?></div>
        <div class="card-designation"><?= $designation ?></div>

        <div class="emp-id-pill">
            <i class="fa fa-id-badge" style="font-size:14px;"></i>
            <?= h($profile['employee_id']) ?>
        </div>

        <!-- Info Table -->
        <div class="card-info">
            <div class="info-row">
                <span class="info-label"><i class="fa fa-phone" style="color:#B09362;width:12px;"></i> Mobile</span>
                <span class="info-value"><?= h($profile['phone']) ?: 'N/A' ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fa fa-envelope" style="color:#B09362;width:12px;"></i> Email</span>
                <span class="info-value" style="font-size:11px;"><?= h($profile['email']) ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fa fa-calendar" style="color:#B09362;width:12px;"></i> Joined</span>
                <span class="info-value"><?= $doj ?></span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fa fa-location-dot" style="color:#B09362;width:12px;"></i> Office</span>
                <span class="info-value" style="font-size:11px;">Dummy Address, India</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fa fa-circle-check" style="color:#10b981;width:12px;"></i> Status</span>
                <span class="info-value" style="color:#10b981;">Active</span>
            </div>
        </div>

        <!-- QR -->
        <div class="card-qr-section">
            <div id="qrcode"></div>
            <div class="qr-text">
                <strong>Scan to Verify</strong>
                <p>Scan the QR code to verify this employee's identity on the official Sahu Innovation portal.</p>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="card-footer">
        <div class="card-footer-left">
            Sahu Innovation Pvt. Ltd.<br>
            Dummy Address, India<br>
            www.sahuinnovation.com
        </div>
        <div class="card-footer-sig">
            <div class="sig-line"></div>
            <div class="sig-label">Authorized Signatory</div>
        </div>
    </div>
    <div class="gold-bar"></div>
</div>

<script>
// Generate QR code
new QRCode(document.getElementById("qrcode"), {
    text: "<?= addslashes($verifyUrl) ?>",
    width: 72,
    height: 72,
    colorDark: "#0B1F3A",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.M
});

async function captureCard() {
    // Wait for QR to render
    await new Promise(r => setTimeout(r, 300));
    return html2canvas(document.getElementById('id-card'), {
        scale: 3,
        useCORS: true,
        allowTaint: false,
        backgroundColor: '#ffffff'
    });
}

async function downloadPNG() {
    const btn = event.target;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    const canvas = await captureCard();
    const link = document.createElement('a');
    link.download = 'ID-Card-<?= h($profile['employee_id']) ?>.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
    btn.innerHTML = '<i class="fa fa-image"></i> PNG';
}

async function downloadPDF() {
    const btn = event.target;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
    const canvas = await captureCard();
    const imgData = canvas.toDataURL('image/png');
    const { jsPDF } = window.jspdf;

    // Standard ID card dimensions (85.6mm x 54mm)
    const pdf = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const cardW = 85.6;
    const cardH = (canvas.height / canvas.width) * cardW;
    const x = (210 - cardW) / 2;
    const y = 20;
    pdf.addImage(imgData, 'PNG', x, y, cardW, cardH);
    pdf.save('ID-Card-<?= h($profile['employee_id']) ?>.pdf');
    btn.innerHTML = '<i class="fa fa-file-pdf"></i> PDF';
}
</script>
</body>
</html>
