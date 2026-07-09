/**
 * Main Application JS
 */

document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide flash messages after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Handle file upload preview/text
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const formGroup = this.closest('.form-group');
                if (!formGroup) return; // Input is inside an upload-box, handled by its own handler
                const label = formGroup.querySelector('.form-label');
                if (label) {
                    const originalText = label.getAttribute('data-original-text') || label.innerText;
                    label.setAttribute('data-original-text', originalText);
                    label.innerHTML = `${originalText} <span style="color: var(--success); font-size: 11px;">(Selected: ${this.files[0].name})</span>`;
                }
            }
        });
    });

    // Confirmation for actions
    const confirmActions = document.querySelectorAll('[data-confirm]');
    confirmActions.forEach(action => {
        action.addEventListener('click', function(e) {
            if (!confirm(this.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });
});

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

