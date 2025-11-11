// UI Enhancement JavaScript for Restoran BilSky

// Loading States
function showLoading(text = 'Memproses...') {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.id = 'loading-overlay';
    
    overlay.innerHTML = `
        <div style="text-align: center;">
            <div class="loading-spinner"></div>
            <div class="loading-text">${text}</div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
}

function hideLoading() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) {
        overlay.remove();
        document.body.style.overflow = 'auto';
    }
}

// Button Loading States
function setButtonLoading(button, loading = true) {
    if (loading) {
        button.classList.add('btn-loading');
        button.disabled = true;
        const text = button.querySelector('.btn-text') || button;
        text.style.opacity = '0';
    } else {
        button.classList.remove('btn-loading');
        button.disabled = false;
        const text = button.querySelector('.btn-text') || button;
        text.style.opacity = '1';
    }
}

// Toast Notifications
function showToast(message, type = 'info', duration = 5000) {
    const container = getOrCreateToastContainer();
    const toast = createToast(message, type);
    
    container.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Auto remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

function getOrCreateToastContainer() {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    return container;
}

function createToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const iconMap = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    
    toast.innerHTML = `
        <div class="toast-header">
            <i class="toast-icon ${type} ${iconMap[type]}"></i>
            <h6 class="toast-title">${getToastTitle(type)}</h6>
            <button class="toast-close" onclick="closeToast(this)">&times;</button>
        </div>
        <div class="toast-body">${message}</div>
    `;
    
    return toast;
}

function getToastTitle(type) {
    const titles = {
        success: 'Berhasil!',
        error: 'Error!',
        warning: 'Peringatan!',
        info: 'Informasi'
    };
    return titles[type] || 'Notifikasi';
}

function closeToast(closeBtn) {
    const toast = closeBtn.closest('.toast');
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
}

// Form Validation
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            setFieldError(input, 'Field ini wajib diisi');
            isValid = false;
        } else {
            clearFieldError(input);
        }
    });
    
    return isValid;
}

function setFieldError(field, message) {
    field.classList.add('is-invalid');
    field.classList.remove('is-valid');
    
    let feedback = field.parentNode.querySelector('.invalid-feedback');
    if (!feedback) {
        feedback = document.createElement('div');
        feedback.className = 'invalid-feedback';
        field.parentNode.appendChild(feedback);
    }
    feedback.textContent = message;
}

function clearFieldError(field) {
    field.classList.remove('is-invalid');
    field.classList.add('is-valid');
    
    const feedback = field.parentNode.querySelector('.invalid-feedback');
    if (feedback) {
        feedback.remove();
    }
}

// Success/Error Animations
function showSuccessAnimation(element) {
    element.classList.add('success-animation');
    setTimeout(() => element.classList.remove('success-animation'), 600);
}

function showErrorAnimation(element) {
    element.classList.add('error-animation');
    setTimeout(() => element.classList.remove('error-animation'), 500);
}

// AJAX Form Submission with Loading States
function submitFormWithLoading(form, options = {}) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Set loading state
    setButtonLoading(submitBtn, true);
    
    // Show loading overlay
    showLoading(options.loadingText || 'Memproses data...');
    
    // Submit form
    fetch(form.action, {
        method: form.method || 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        setButtonLoading(submitBtn, false);
        
        if (data.success) {
            showToast(data.message || 'Data berhasil disimpan!', 'success');
            if (options.onSuccess) options.onSuccess(data);
        } else {
            showToast(data.message || 'Terjadi kesalahan!', 'error');
            if (options.onError) options.onError(data);
        }
    })
    .catch(error => {
        hideLoading();
        setButtonLoading(submitBtn, false);
        showToast('Terjadi kesalahan pada server!', 'error');
        console.error('Error:', error);
    });
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide Bootstrap alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Add loading states to forms
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (form.dataset.ajax !== 'false') {
                e.preventDefault();
                submitFormWithLoading(form);
            }
        });
    });
    
    // Add click animations to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!this.classList.contains('btn-loading')) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            }
        });
    });
});

// Utility Functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(amount);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(date));
}

// Export functions for global use
window.BilSkyUI = {
    showLoading,
    hideLoading,
    setButtonLoading,
    showToast,
    validateForm,
    setFieldError,
    clearFieldError,
    showSuccessAnimation,
    showErrorAnimation,
    submitFormWithLoading,
    formatCurrency,
    formatDate
};
