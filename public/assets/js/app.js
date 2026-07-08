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
