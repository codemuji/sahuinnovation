<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('surveyer');

$db = Database::getInstance()->getConnection();
$id = $_GET['id'] ?? 0;
$userId = Auth::userId();

// Fetch customer data
$stmt = $db->prepare("SELECT * FROM survey_customers WHERE id = ? AND surveyer_id = ?");
$stmt->execute([$id, $userId]);
$customer = $stmt->fetch();

if (!$customer || $customer['status'] !== 'revert_back') {
    setFlash('danger', 'Survey not found or not in revert status.');
    redirect('my-customers.php');
}

// Fetch existing documents
$stmt = $db->prepare("SELECT doc_type, original_name FROM survey_documents WHERE survey_customer_id = ?");
$stmt->execute([$id]);
$docs = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$pageTitle = "Edit & Resubmit Survey";
include __DIR__ . '/../includes/header.php';
?>

<style>
    .survey-card {
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
    }
    .survey-item { margin-bottom: 20px; font-size: 16px; }
    .survey-item label { display: block; margin-bottom: 8px; font-weight: 500; }
    .survey-item .item-number { font-weight: 700; margin-right: 5px; }
    .radio-group { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 5px; }
    .radio-option { display: flex; align-items: center; gap: 8px; }
    .radio-option input[type="radio"] { width: 20px; height: 20px; }
    .upload-box { border: 2px dashed #ccc; padding: 15px; text-align: center; border-radius: 8px; margin-top: 5px; background: #f9f9f9; cursor: pointer; }
    .upload-box i { font-size: 24px; color: var(--primary); margin-bottom: 5px; }
    .grid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .feedback-box { background: #fff1f2; border: 1px solid #fda4af; padding: 15px; border-radius: 8px; margin-bottom: 25px; color: #9f1239; }
    @media (max-width: 600px) { .grid-row { grid-template-columns: 1fr; } }
</style>

<div style="margin-bottom: 24px;">
    <a href="my-customers.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">
        <i class="fa fa-arrow-left"></i> Back to My Customers
    </a>
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-top: 8px;">Edit & Resubmit Survey</h1>
</div>

<?php if ($customer['rejection_reason']): ?>
<div class="feedback-box">
    <strong><i class="fa fa-exclamation-circle"></i> Staff Feedback:</strong>
    <p style="margin-top: 5px;"><?= h($customer['rejection_reason']) ?></p>
</div>
<?php endif; ?>

<form action="<?= site_url('app/actions/update_survey_customer.php') ?>" method="POST" enctype="multipart/form-data" class="mobile-form">
    <input type="hidden" name="id" value="<?= $customer['id'] ?>">
    
    <div class="survey-card">
        <div class="survey-item">
            <label><span class="item-number">1)</span> Consumer Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="<?= h($customer['name']) ?>" required>
        </div>

        <div class="survey-item">
            <label><span class="item-number">2)</span> Consumer Number</label>
            <input type="number" name="consumer_number" class="form-control" value="<?= h($customer['consumer_number']) ?>">
        </div>

        <div class="grid-row">
            <div class="survey-item">
                <label><span class="item-number">3)</span> Age/DOB</label>
                <input type="text" name="age_dob" class="form-control" value="<?= h($customer['age_dob']) ?>">
            </div>
            <div class="survey-item">
                <label><span class="item-number">4)</span> Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?= $customer['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= $customer['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= $customer['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
        </div>

        <div class="survey-item">
            <label><span class="item-number">5)</span> Mobile No <span class="text-danger">*</span></label>
            <input type="tel" name="phone" class="form-control" value="<?= h($customer['phone']) ?>" required pattern="[0-9]{10}">
        </div>

        <div class="survey-item">
            <label><span class="item-number">6)</span> Email Id (Optional)</label>
            <input type="email" name="email" class="form-control" value="<?= h($customer['email']) ?>">
        </div>

        <div class="survey-item">
            <label><span class="item-number">7)</span> Occupation <span class="text-danger">*</span></label>
            <input type="text" name="occupation" class="form-control" value="<?= h($customer['occupation']) ?>" required>
        </div>

        <div class="survey-item">
            <label><span class="item-number">8)</span> District <span class="text-danger">*</span></label>
            <select name="district" class="form-control" required>
                <option value="">Select District</option>
                <?php
                $districts = ["Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup Metropolitan", "Kamrup", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", "South Salmara-Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong", "Bajali", "Tamulpur"];
                foreach($districts as $d) {
                    $selected = ($customer['district'] ?? '') == $d ? 'selected' : '';
                    echo "<option value=\"$d\" $selected>$d</option>";
                }
                ?>
            </select>
        </div>

        <div class="grid-row">
            <div class="survey-item">
                <label><span class="item-number">9)</span> Post Office <span class="text-danger">*</span></label>
                <input type="text" name="post_office" class="form-control" value="<?= h($customer['post_office'] ?? '') ?>" required>
            </div>
            <div class="survey-item">
                <label><span class="item-number">10)</span> Police Station <span class="text-danger">*</span></label>
                <input type="text" name="police_station" class="form-control" value="<?= h($customer['police_station'] ?? '') ?>" required>
            </div>
        </div>

        <div class="survey-item">
            <label><span class="item-number">11)</span> State <span class="text-danger">*</span></label>
            <input type="text" name="state" class="form-control" value="<?= h($customer['state'] ?? 'Assam') ?>" readonly required>
        </div>

        <div class="survey-item">
            <label><span class="item-number">12)</span> Address <span class="text-danger">*</span></label>
            <textarea name="address" class="form-control" style="height: 80px;" required><?= h($customer['address']) ?></textarea>
        </div>

        <div class="survey-item">
            <label><span class="item-number">13)</span> House <span class="text-danger">*</span></label>
            <div class="radio-group">
                <label class="radio-option"><input type="radio" name="house_type" value="Building" <?= $customer['house_type'] == 'Building' ? 'checked' : '' ?> required> Building</label>
                <label class="radio-option"><input type="radio" name="house_type" value="Assam Model" <?= $customer['house_type'] == 'Assam Model' ? 'checked' : '' ?> required> Assam Model</label>
                <label class="radio-option"><input type="radio" name="house_type" value="Kutcha House" <?= $customer['house_type'] == 'Kutcha House' ? 'checked' : '' ?> required> Kutcha House</label>
            </div>
        </div>

        <div class="survey-item">
            <label><span class="item-number">14)</span> Customer Opinion <span class="text-danger">*</span></label>
            <div class="radio-group">
                <label class="radio-option"><input type="radio" name="customer_opinion" value="Interested" <?= $customer['customer_opinion'] == 'Interested' ? 'checked' : '' ?> required> Interested</label>
                <label class="radio-option"><input type="radio" name="customer_opinion" value="Not Interested" <?= $customer['customer_opinion'] == 'Not Interested' ? 'checked' : '' ?> required> Not Interested</label>
            </div>
        </div>

        <div class="survey-item">
            <label><span class="item-number">15)</span> Approx Electricity Bill in Rs. <span class="text-danger">*</span></label>
            <input type="number" name="electricity_bill_amount" class="form-control" value="<?= h($customer['electricity_bill_amount']) ?>" required>
        </div>

        <div class="grid-row">
            <div class="survey-item">
                <label><span class="item-number">16)</span> Meter Type <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label class="radio-option"><input type="radio" name="meter_type" value="Smart" <?= $customer['meter_type'] == 'Smart' ? 'checked' : '' ?> required> Smart</label>
                    <label class="radio-option"><input type="radio" name="meter_type" value="Normal" <?= $customer['meter_type'] == 'Normal' ? 'checked' : '' ?> required> Normal</label>
                </div>
            </div>
            <div class="survey-item">
                <label><span class="item-number">17)</span> Land Ownership Type <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label class="radio-option"><input type="radio" name="land_type" value="Owned" <?= $customer['land_type'] == 'Owned' ? 'checked' : '' ?> required> Owned</label>
                    <label class="radio-option"><input type="radio" name="land_type" value="Rented" <?= $customer['land_type'] == 'Rented' ? 'checked' : '' ?> required> Rented</label>
                </div>
            </div>
        </div>

        <div class="survey-item">
            <label><span class="item-number">18)</span> Annual Income Approx. in Rs. <span class="text-danger">*</span></label>
            <input type="text" name="annual_income" class="form-control" value="<?= h($customer['annual_income']) ?>" required>
        </div>

        <!-- Documents section -->
        <?php
        $uploadFields = [
            'doc_gps_photo' => ['label' => '19) Live GPS Photo', 'icon' => 'fa-location-dot', 'type' => 'gps_photo'],
            'doc_house_photo' => ['label' => '20) House Photo', 'icon' => 'fa-house-chimney', 'type' => 'house_photo'],
            'doc_bank_passbook' => ['label' => 'Bank Passbook', 'icon' => 'fa-file-invoice', 'type' => 'bank_passbook'],
            'doc_aadhaar' => ['label' => 'Aadhaar Card', 'icon' => 'fa-id-card', 'type' => 'aadhaar'],
            'doc_pan' => ['label' => 'PAN Card', 'icon' => 'fa-id-card', 'type' => 'pan'],
            'doc_electricity_bill' => ['label' => 'Electricity Bill', 'icon' => 'fa-bolt', 'type' => 'electricity_bill'],
            'doc_signature' => ['label' => 'Signature', 'icon' => 'fa-signature', 'type' => 'signature']
        ];
        ?>

        <?php foreach ($uploadFields as $name => $info): ?>
        <div class="survey-item">
            <label><?= $info['label'] ?> <?php if (in_array($name, ['doc_gps_photo', 'doc_house_photo'])) echo '<span class="text-danger">*</span>'; ?></label>
            <div class="upload-box" id="<?= str_replace('_', '-', $name) ?>-upload-box" onclick="document.getElementById('<?= $name ?>_input').click()">
                <i class="fa <?= $info['icon'] ?>"></i>
                <div class="upload-text" id="<?= str_replace('_', '-', $name) ?>-upload-text" style="font-size: 13px;">
                    <?php if (isset($docs[$info['type']])): ?>
                        <span style="color: var(--success);">Current: <?= h($docs[$info['type']]) ?></span><br>
                        Tap to change
                    <?php else: ?>
                        Tap to capture/upload
                    <?php endif; ?>
                </div>
                <div class="file-indicator" id="<?= str_replace('_', '-', $name) ?>-file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span id="<?= str_replace('_', '-', $name) ?>-file-name"></span>
                </div>
                
                <input type="file" id="<?= $name ?>_input" hidden 
                    <?php if ($name === 'doc_gps_photo'): ?>
                        accept="image/*" capture="environment" onchange="processGPSPhoto(this)"
                    <?php else: ?>
                        accept="image/*<?= $name === 'doc_house_photo' ? '' : ',application/pdf' ?>" onchange="updateIndicator(this)"
                    <?php endif; ?>
                >
                <?php if ($name === 'doc_gps_photo'): ?>
                    <input type="hidden" name="doc_gps_photo_b64" id="gps_photo_b64">
                    <input type="file" name="doc_gps_photo" id="gps_photo_real" hidden accept="image/*">
                <?php else: ?>
                    <input type="file" name="<?= $name ?>" id="<?= $name ?>_real" hidden accept="image/*<?= $name === 'doc_house_photo' ? '' : ',application/pdf' ?>">
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div style="margin-bottom: 40px;">
        <button type="submit" class="btn btn-primary" style="height: 60px; font-size: 18px; border-radius: 12px; background: var(--primary);">
            Resubmit for Review
        </button>
    </div>
</form>

<script>
function updateIndicator(input) {
    const box = input.closest('.upload-box');
    const text = box.querySelector('.upload-text');
    const indicator = box.querySelector('.file-indicator');
    const fileName = indicator.querySelector('span');
    
    if (input.files && input.files[0]) {
        text.style.display = 'none';
        indicator.style.display = 'block';
        fileName.textContent = input.files[0].name;
        box.style.borderColor = 'var(--success)';
        box.style.background = '#f0fdf4';
    }
}

/**
 * Read EXIF orientation from a JPEG file blob and return the rotation degrees.
 */
async function getExifOrientation(file) {
    return new Promise(resolve => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const view = new DataView(e.target.result);
            if (view.getUint16(0, false) !== 0xFFD8) return resolve(1);
            const length = view.byteLength;
            let offset = 2;
            while (offset < length) {
                if (view.getUint16(offset + 2, false) <= 8) return resolve(1);
                const marker = view.getUint16(offset, false);
                offset += 2;
                if (marker === 0xFFE1) {
                    if (view.getUint32(offset += 2, false) !== 0x45786966) return resolve(1);
                    const little = view.getUint16(offset += 6, false) === 0x4949;
                    offset += view.getUint32(offset + 4, little);
                    const tags = view.getUint16(offset, little);
                    offset += 2;
                    for (let i = 0; i < tags; i++) {
                        if (view.getUint16(offset + (i * 12), little) === 0x0112) {
                            return resolve(view.getUint16(offset + (i * 12) + 8, little));
                        }
                    }
                } else if ((marker & 0xFF00) !== 0xFF00) break;
                else offset += view.getUint16(offset, false);
            }
            resolve(1);
        };
        reader.readAsArrayBuffer(file.slice(0, 65536));
    });
}

function applyExifRotation(ctx, canvas, img, orientation) {
    const w = img.width, h = img.height;
    if (orientation <= 4) {
        canvas.width = w; canvas.height = h;
    } else {
        canvas.width = h; canvas.height = w;
    }
    switch (orientation) {
        case 2: ctx.transform(-1, 0, 0, 1, w, 0); break;
        case 3: ctx.transform(-1, 0, 0, -1, w, h); break;
        case 4: ctx.transform(1, 0, 0, -1, 0, h); break;
        case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
        case 6: ctx.transform(0, 1, -1, 0, h, 0); break;
        case 7: ctx.transform(0, -1, -1, 0, h, w); break;
        case 8: ctx.transform(0, -1, 1, 0, 0, w); break;
        default: break;
    }
    ctx.drawImage(img, 0, 0);
}

async function processGPSPhoto(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file for GPS Photo.');
        return;
    }

    // Check for Geolocation support & Secure Context
    if (!navigator.geolocation) {
        alert("Geolocation is not supported by this browser.");
        return;
    }
    if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        alert("Geolocation requires HTTPS.");
        return;
    }

    const uploadText   = document.getElementById('doc-gps-photo-upload-text');
    const indicator    = document.getElementById('doc-gps-photo-file-indicator');
    const fileNameSpan = document.getElementById('doc-gps-photo-file-name');
    const box          = document.getElementById('doc-gps-photo-upload-box');
    const b64Input     = document.getElementById('gps_photo_b64');
    const realInput    = document.getElementById('gps_photo_real');
    const originalText = uploadText.innerHTML;

    uploadText.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Requesting Location...';
    uploadText.style.display = 'block';
    indicator.style.display = 'none';
    box.style.pointerEvents = 'none';

    try {
        let position;
        try {
            position = await new Promise((resolve, reject) =>
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: true, timeout: 10000, maximumAge: 0
                })
            );
        } catch {
            position = await new Promise((resolve, reject) =>
                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: false, timeout: 15000, maximumAge: 60000
                })
            );
        }

        uploadText.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing Photo...';

        const lat     = position.coords.latitude.toFixed(6);
        const lng     = position.coords.longitude.toFixed(6);
        const dateStr = new Date().toLocaleString();

        const orientation = await getExifOrientation(file);
        const img = new Image();
        img.src = URL.createObjectURL(file);
        await new Promise((resolve, reject) => { img.onload = resolve; img.onerror = reject; });

        const correctedCanvas = document.createElement('canvas');
        const correctedCtx   = correctedCanvas.getContext('2d');
        applyExifRotation(correctedCtx, correctedCanvas, img, orientation);
        URL.revokeObjectURL(img.src);

        const MAX_WIDTH = 1200;
        let width  = correctedCanvas.width;
        let height = correctedCanvas.height;
        if (width > MAX_WIDTH) {
            height = Math.round((height * MAX_WIDTH) / width);
            width  = MAX_WIDTH;
        }

        const canvas = document.createElement('canvas');
        const ctx    = canvas.getContext('2d');
        canvas.width  = width;
        canvas.height = height;
        ctx.drawImage(correctedCanvas, 0, 0, width, height);

        const padding    = 20;
        const fontSize   = Math.max(16, Math.round(width * 0.035));
        ctx.font         = `bold ${fontSize}px sans-serif`;
        ctx.textAlign    = 'left';
        ctx.textBaseline = 'top';

        const lines      = [`Lat: ${lat}`, `Lng: ${lng}`, `Time: ${dateStr}`];
        const lineHeight = fontSize * 1.4;
        const boxHeight  = (lines.length * lineHeight) + padding;

        let maxTextWidth = 0;
        lines.forEach(line => {
            const m = ctx.measureText(line);
            if (m.width > maxTextWidth) maxTextWidth = m.width;
        });
        const boxWidth = maxTextWidth + (padding * 2);
        const boxX     = 20;
        const boxY     = height - boxHeight - 20;

        ctx.fillStyle = 'rgba(0,0,0,0.65)';
        if (ctx.roundRect) {
            ctx.beginPath();
            ctx.roundRect(boxX, boxY, boxWidth, boxHeight, 8);
            ctx.fill();
        } else {
            ctx.fillRect(boxX, boxY, boxWidth, boxHeight);
        }

        ctx.fillStyle     = '#ffffff';
        ctx.shadowColor   = 'rgba(0,0,0,0.8)';
        ctx.shadowBlur    = 4;
        ctx.shadowOffsetX = 1;
        ctx.shadowOffsetY = 1;
        lines.forEach((line, i) => ctx.fillText(line, boxX + padding, boxY + (padding / 2) + (i * lineHeight)));
        ctx.shadowColor = 'transparent'; ctx.shadowBlur = 0;

        let dataTransferOk = false;
        try {
            const blob    = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.85));
            const newFile = new File([blob], file.name.replace(/\.[^.]+$/, '') + '_gps.jpg', { type: 'image/jpeg', lastModified: Date.now() });
            const dt = new DataTransfer();
            dt.items.add(newFile);
            realInput.files = dt.files;
            if (realInput.files && realInput.files[0]) {
                dataTransferOk = true;
                b64Input.value = '';
            }
        } catch(e) {
            console.warn('DataTransfer failed:', e);
        }

        if (!dataTransferOk) {
            const base64 = canvas.toDataURL('image/jpeg', 0.85);
            b64Input.value = base64;
        }

        indicator.style.display = 'block';
        fileNameSpan.textContent = file.name + ' (GPS tagged)';
        box.style.borderColor = 'var(--success)';
        box.style.background  = '#f0fdf4';
        uploadText.style.display = 'none';

    } catch (error) {
        console.error('GPS Photo error:', error);
        alert('Could not get location.');
        uploadText.innerHTML = originalText;
        uploadText.style.display = 'block';
    } finally {
        box.style.pointerEvents = 'auto';
    }
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
