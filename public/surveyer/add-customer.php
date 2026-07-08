<?php
require_once __DIR__ . '/../../app/core/Auth.php';
Auth::requireRole('surveyer');

$pageTitle = "Add New Customer";
include __DIR__ . '/../includes/header.php';
?>

<style>
    :root {
        --neon-yellow: #FFFF00;
        --neon-green: #00FF00;
        --neon-magenta: #FF00FF;
        --neon-cyan: #00FFFF;
    }
    
    .survey-card {
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border);
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: var(--shadow);
    }

    .survey-item {
        margin-bottom: 20px;
        font-size: 16px;
    }

    .survey-item label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .survey-item .item-number {
        font-weight: 700;
        margin-right: 5px;
    }

    .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 5px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .radio-option input[type="radio"] {
        width: 20px;
        height: 20px;
    }

    .upload-box {
        border: 2px dashed #ccc;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        margin-top: 5px;
        background: #f9f9f9;
    }

    .upload-box i {
        font-size: 24px;
        color: var(--primary);
        margin-bottom: 5px;
    }

    .grid-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 600px) {
        .grid-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div style="margin-bottom: 24px;">
    <a href="dashboard.php" style="color: var(--text-muted); text-decoration: none; font-size: 14px;">
        <i class="fa fa-arrow-left"></i> Back to Dashboard
    </a>
    <h1 style="font-size: 24px; font-weight: 700; color: var(--primary); margin-top: 8px;">Add New Customer</h1>
</div>

<form action="<?= site_url('app/actions/add_survey_customer.php') ?>" method="POST" enctype="multipart/form-data" class="mobile-form">
    <div class="survey-card">
        <!-- 1. Consumer Name -->
        <div class="survey-item">
            <label><span class="item-number">1)</span> Consumer Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" required>
        </div>

        <!-- 2. Consumer Number -->
        <div class="survey-item">
            <label><span class="item-number">2)</span> Consumer Number</label>
            <input type="number" name="consumer_number" class="form-control" placeholder="Enter consumer number">
        </div>

        <div class="grid-row">
            <!-- 3. Age/DOB -->
            <div class="survey-item">
                <label><span class="item-number">3)</span> Age/DOB</label>
                <input type="text" name="age_dob" class="form-control" placeholder="e.g. 35 or 01/01/1990">
            </div>

            <!-- 4. Gender -->
            <div class="survey-item">
                <label><span class="item-number">4)</span> Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <!-- 5. Mobile No -->
        <div class="survey-item">
            <label><span class="item-number">5)</span> Mobile No <span class="text-danger">*</span></label>
            <input type="tel" name="phone" class="form-control" placeholder="10-digit mobile number" required pattern="[0-9]{10}">
        </div>

        <!-- 6. Email Id (Optional) -->
        <div class="survey-item">
            <label><span class="item-number">6)</span> Email Id (Optional)</label>
            <input type="email" name="email" class="form-control" placeholder="example@mail.com">
        </div>

        <!-- 7. Occupation -->
        <div class="survey-item">
            <label><span class="item-number">7)</span> Occupation <span class="text-danger">*</span></label>
            <input type="text" name="occupation" class="form-control" placeholder="e.g. Farmer, Business, Service" required>
        </div>

        <!-- District -->
        <div class="survey-item">
            <label><span class="item-number">8)</span> District <span class="text-danger">*</span></label>
            <select name="district" class="form-control" required>
                <option value="">Select District</option>
                <option value="Baksa">Baksa</option>
                <option value="Barpeta">Barpeta</option>
                <option value="Biswanath">Biswanath</option>
                <option value="Bongaigaon">Bongaigaon</option>
                <option value="Cachar">Cachar</option>
                <option value="Charaideo">Charaideo</option>
                <option value="Chirang">Chirang</option>
                <option value="Darrang">Darrang</option>
                <option value="Dhemaji">Dhemaji</option>
                <option value="Dhubri">Dhubri</option>
                <option value="Dibrugarh">Dibrugarh</option>
                <option value="Dima Hasao">Dima Hasao</option>
                <option value="Goalpara">Goalpara</option>
                <option value="Golaghat">Golaghat</option>
                <option value="Hailakandi">Hailakandi</option>
                <option value="Hojai">Hojai</option>
                <option value="Jorhat">Jorhat</option>
                <option value="Kamrup Metropolitan">Kamrup Metropolitan</option>
                <option value="Kamrup">Kamrup</option>
                <option value="Karbi Anglong">Karbi Anglong</option>
                <option value="Karimganj">Karimganj</option>
                <option value="Kokrajhar">Kokrajhar</option>
                <option value="Lakhimpur">Lakhimpur</option>
                <option value="Majuli">Majuli</option>
                <option value="Morigaon">Morigaon</option>
                <option value="Nagaon">Nagaon</option>
                <option value="Nalbari">Nalbari</option>
                <option value="Sivasagar">Sivasagar</option>
                <option value="Sonitpur">Sonitpur</option>
                <option value="South Salmara-Mankachar">South Salmara-Mankachar</option>
                <option value="Tinsukia">Tinsukia</option>
                <option value="Udalguri">Udalguri</option>
                <option value="West Karbi Anglong">West Karbi Anglong</option>
                <option value="Bajali">Bajali</option>
                <option value="Tamulpur">Tamulpur</option>
            </select>
        </div>

        <div class="grid-row">
            <div class="survey-item">
                <label><span class="item-number">9)</span> Post Office <span class="text-danger">*</span></label>
                <input type="text" name="post_office" class="form-control" placeholder="Enter post office" required>
            </div>
            <div class="survey-item">
                <label><span class="item-number">10)</span> Police Station <span class="text-danger">*</span></label>
                <input type="text" name="police_station" class="form-control" placeholder="Enter police station" required>
            </div>
        </div>

        <!-- State -->
        <div class="survey-item">
            <label><span class="item-number">11)</span> State <span class="text-danger">*</span></label>
            <input type="text" name="state" class="form-control" value="Assam" readonly required>
        </div>

        <!-- 10. Address -->
        <div class="survey-item">
            <label><span class="item-number">12)</span> Address <span class="text-danger">*</span></label>
            <textarea name="address" class="form-control" style="height: 80px;" placeholder="Full postal address" required></textarea>
        </div>

        <!-- 11. House -->
        <div class="survey-item">
            <label><span class="item-number">13)</span> House <span class="text-danger">*</span></label>
            <div class="radio-group">
                <label class="radio-option"><input type="radio" name="house_type" value="Building" required> Building</label>
                <label class="radio-option"><input type="radio" name="house_type" value="Assam Model" required> Assam Model</label>
                <label class="radio-option"><input type="radio" name="house_type" value="Kutcha House" required> Kutcha House</label>
            </div>
        </div>

        <!-- 14. Customer Opinion -->
        <div class="survey-item">
            <label><span class="item-number">14)</span> Customer Opinion <span class="text-danger">*</span></label>
            <div class="radio-group">
                <label class="radio-option"><input type="radio" name="customer_opinion" value="Interested" required> Interested</label>
                <label class="radio-option"><input type="radio" name="customer_opinion" value="Not Interested" required> Not Interested</label>
            </div>
        </div>

        <!-- 15. Approx Electricity Bill -->
        <div class="survey-item">
            <label><span class="item-number">15)</span> Approx Electricity Bill in Rs. <span class="text-danger">*</span></label>
            <input type="number" name="electricity_bill_amount" class="form-control" placeholder="e.g. 1500" required>
        </div>

        <div class="grid-row">
            <!-- 16. Meter Type -->
            <div class="survey-item">
                <label><span class="item-number">16)</span> Meter Type <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label class="radio-option"><input type="radio" name="meter_type" value="Smart" required> Smart</label>
                    <label class="radio-option"><input type="radio" name="meter_type" value="Normal" required> Normal</label>
                </div>
            </div>

            <!-- 17. Land Ownership Type -->
            <div class="survey-item">
                <label><span class="item-number">17)</span> Land Ownership Type <span class="text-danger">*</span></label>
                <div class="radio-group">
                    <label class="radio-option"><input type="radio" name="land_type" value="Owned" required> Owned</label>
                    <label class="radio-option"><input type="radio" name="land_type" value="Rented" required> Rented</label>
                </div>
            </div>
        </div>

        <!-- 18. Annual Income -->
        <div class="survey-item">
            <label><span class="item-number">18)</span> Annual Income Approx. in Rs. <span class="text-danger">*</span></label>
            <input type="text" name="annual_income" class="form-control" placeholder="e.g. 2,00,000" required>
        </div>

        <!-- 19. Live GPS Photo -->
        <div class="survey-item">
            <label><span class="item-number">19)</span> Live GPS Photo with Customer <span class="text-danger">*</span></label>
            <div class="upload-box" id="gps-upload-box" onclick="document.getElementById('gps_photo_input').click()">
                <i class="fa fa-location-dot"></i>
                <div class="upload-text" id="gps-upload-text" style="font-size: 13px;">Tap to capture/upload</div>
                <div class="file-indicator" id="gps-file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span id="gps-file-name"></span>
                </div>
                <!-- capture="environment" forces camera on mobile devices to ensure a live photo is taken -->
                <input type="file" id="gps_photo_input" hidden accept="image/*" capture="environment" onchange="processGPSPhoto(this)">
                <!-- Base64 fallback for iOS (where setting input.files is not supported) -->
                <input type="hidden" name="doc_gps_photo_b64" id="gps_photo_b64">
                <!-- Actual file input used when DataTransfer works (Android/Desktop) -->
                <input type="file" name="doc_gps_photo" id="gps_photo_real" hidden accept="image/*">
            </div>
        </div>

        <!-- 20. House Photo -->
        <div class="survey-item">
            <label><span class="item-number">20)</span> House Photo <span class="text-danger">*</span></label>
            <div class="upload-box" onclick="this.querySelector('input').click()">
                <i class="fa fa-house-chimney"></i>
                <div class="upload-text" style="font-size: 13px;">Tap to capture/upload</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_house_photo" hidden required accept="image/*" capture="environment" onchange="updateIndicator(this)">
            </div>
        </div>
    </div>

    <!-- Additional Documents -->
    <div class="survey-card">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--primary);">Other Required Documents</h3>
        
        <div class="form-group">
            <label class="form-label">Bank Passbook</label>
            <div class="upload-box" onclick="this.querySelector('input').click()" style="padding: 10px;">
                <div class="upload-text" style="font-size: 13px;">Select Bank Passbook</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_bank_passbook" hidden accept="image/*,application/pdf" onchange="updateIndicator(this)">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Aadhaar Card</label>
            <div class="upload-box" onclick="this.querySelector('input').click()" style="padding: 10px;">
                <div class="upload-text" style="font-size: 13px;">Select Aadhaar Card</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_aadhaar" hidden accept="image/*,application/pdf" onchange="updateIndicator(this)">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">PAN Card</label>
            <div class="upload-box" onclick="this.querySelector('input').click()" style="padding: 10px;">
                <div class="upload-text" style="font-size: 13px;">Select PAN Card</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_pan" hidden accept="image/*,application/pdf" onchange="updateIndicator(this)">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Electricity Bill (File)</label>
            <div class="upload-box" onclick="this.querySelector('input').click()" style="padding: 10px;">
                <div class="upload-text" style="font-size: 13px;">Select Electricity Bill</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_electricity_bill" hidden accept="image/*,application/pdf" onchange="updateIndicator(this)">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Signature</label>
            <div class="upload-box" onclick="this.querySelector('input').click()" style="padding: 10px;">
                <div class="upload-text" style="font-size: 13px;">Select Signature File</div>
                <div class="file-indicator" style="display: none; color: var(--success); font-weight: 600; font-size: 12px; margin-top: 5px;">
                    <i class="fa fa-check-circle"></i> <span></span>
                </div>
                <input type="file" name="doc_signature" hidden accept="image/*,application/pdf" onchange="updateIndicator(this)">
            </div>
        </div>
    </div>

    <div style="margin-bottom: 40px;">
        <button type="submit" class="btn btn-primary" style="height: 60px; font-size: 18px; border-radius: 12px; background: var(--primary);">
            Submit Survey Data
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
    } else {
        text.style.display = 'block';
        indicator.style.display = 'none';
        box.style.borderColor = '#ccc';
        box.style.background = '#f9f9f9';
    }
}

/**
 * Read EXIF orientation from a JPEG file blob and return the rotation degrees.
 * iOS Safari captures images with EXIF orientation instead of rotating pixels,
 * so we must correct for it before drawing on canvas.
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

/**
 * Apply EXIF orientation correction to a canvas context.
 * Returns the corrected [width, height] the canvas should be.
 */
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
        alert("Geolocation requires HTTPS. Please ask your admin to enable SSL.");
        return;
    }

    const uploadText   = document.getElementById('gps-upload-text');
    const indicator    = document.getElementById('gps-file-indicator');
    const fileNameSpan = document.getElementById('gps-file-name');
    const box          = document.getElementById('gps-upload-box');
    const b64Input     = document.getElementById('gps_photo_b64');
    const realInput    = document.getElementById('gps_photo_real');
    const originalText = uploadText.innerHTML;

    uploadText.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Requesting Location...';
    uploadText.style.display = 'block';
    indicator.style.display = 'none';
    box.style.pointerEvents = 'none';

    try {
        // Get GPS position (with high-accuracy → low-accuracy fallback)
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

        // Load image & correct EXIF orientation (critical for iOS)
        const orientation = await getExifOrientation(file);
        const img = new Image();
        img.src = URL.createObjectURL(file);
        await new Promise((resolve, reject) => { img.onload = resolve; img.onerror = reject; });

        // --- Create first canvas for EXIF-corrected image ---
        const correctedCanvas = document.createElement('canvas');
        const correctedCtx   = correctedCanvas.getContext('2d');
        applyExifRotation(correctedCtx, correctedCanvas, img, orientation);
        URL.revokeObjectURL(img.src);

        // --- Scale down if needed ---
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

        // --- Draw GPS watermark ---
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

        // --- Attach result to form ---
        // Strategy 1: try DataTransfer (works on Android/Desktop Chrome)
        let dataTransferOk = false;
        try {
            const blob    = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', 0.85));
            const newFile = new File([blob], file.name.replace(/\.[^.]+$/, '') + '_gps.jpg',
                                     { type: 'image/jpeg', lastModified: Date.now() });
            const dt = new DataTransfer();
            dt.items.add(newFile);
            realInput.files = dt.files;
            // Verify it actually stuck (iOS silently ignores this)
            if (realInput.files && realInput.files[0]) {
                dataTransferOk = true;
                b64Input.value = ''; // clear base64 so server uses file input
            }
        } catch(e) {
            console.warn('DataTransfer failed:', e);
        }

        // Strategy 2: base64 fallback for iOS Safari
        if (!dataTransferOk) {
            const base64 = canvas.toDataURL('image/jpeg', 0.85);
            b64Input.value = base64;
            console.log('iOS fallback: using base64 hidden input');
        }

        // Update UI
        indicator.style.display = 'block';
        fileNameSpan.textContent = file.name + ' (GPS tagged)';
        box.style.borderColor = 'var(--success)';
        box.style.background  = '#f0fdf4';
        uploadText.style.display = 'none';

    } catch (error) {
        console.error('GPS Photo error:', error);
        alert('Could not get location. Make sure location services are enabled for this browser in Settings → Privacy → Location Services.');
        uploadText.innerHTML = originalText;
        uploadText.style.display = 'block';
    } finally {
        box.style.pointerEvents = 'auto';
    }
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
