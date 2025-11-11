/* Loading States & Feedback Messages */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    backdrop-filter: blur(5px);
}

.loading-spinner {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-top: 4px solid #4A90E2;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading-text {
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
    margin-top: 1rem;
    text-align: center;
}

.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.btn-loading .btn-text {
    opacity: 0;
}

/* Toast Notifications */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9998;
}

.toast {
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid #4A90E2;
    transform: translateX(400px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 300px;
    max-width: 400px;
}

.toast.show {
    transform: translateX(0);
}

.toast.success {
    border-left-color: #27AE60;
}

.toast.error {
    border-left-color: #E74C3C;
}

.toast.warning {
    border-left-color: #E67E22;
}

.toast-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.toast-icon {
    font-size: 1.2rem;
}

.toast-icon.success {
    color: #27AE60;
}

.toast-icon.error {
    color: #E74C3C;
}

.toast-icon.warning {
    color: #E67E22;
}

.toast-title {
    font-weight: 600;
    color: #2C3E50;
    margin: 0;
}

.toast-body {
    color: #7F8C8D;
    font-size: 0.9rem;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    color: #7F8C8D;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: auto;
    padding: 0;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.toast-close:hover {
    background: rgba(0, 0, 0, 0.1);
    color: #2C3E50;
}

/* Alert Messages */
.alert {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
    font-weight: 500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.1));
    color: #27AE60;
    border-left: 4px solid #27AE60;
}

.alert-danger {
    background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(192, 57, 43, 0.1));
    color: #E74C3C;
    border-left: 4px solid #E74C3C;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(230, 126, 34, 0.1), rgba(243, 156, 18, 0.1));
    color: #E67E22;
    border-left: 4px solid #E67E22;
}

.alert-info {
    background: linear-gradient(135deg, rgba(74, 144, 226, 0.1), rgba(46, 91, 186, 0.1));
    color: #4A90E2;
    border-left: 4px solid #4A90E2;
}

/* Form Validation States */
.form-control.is-valid {
    border-color: #27AE60;
    box-shadow: 0 0 0 0.25rem rgba(39, 174, 96, 0.15);
}

.form-control.is-invalid {
    border-color: #E74C3C;
    box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.15);
}

.invalid-feedback {
    color: #E74C3C;
    font-size: 0.85rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.valid-feedback {
    color: #27AE60;
    font-size: 0.85rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

/* Success Animation */
@keyframes successPulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.7);
    }
    70% {
        transform: scale(1.05);
        box-shadow: 0 0 0 10px rgba(39, 174, 96, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(39, 174, 96, 0);
    }
}

.success-animation {
    animation: successPulse 0.6s ease-in-out;
}

/* Error Animation */
@keyframes errorShake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}

.error-animation {
    animation: errorShake 0.5s ease-in-out;
}

/* Progress Bar */
.progress {
    height: 8px;
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(135deg, #4A90E2, #2E5BBA);
    border-radius: 10px;
    transition: width 0.3s ease;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: #7F8C8D;
}

.empty-state i {
    font-size: 4rem;
    color: #4A90E2;
    margin-bottom: 1rem;
}

.empty-state h4 {
    color: #2C3E50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .toast-container {
        top: 10px;
        right: 10px;
        left: 10px;
    }
    
    .toast {
        min-width: auto;
        max-width: none;
    }
    
    .loading-overlay {
        padding: 1rem;
    }
    
    .loading-spinner {
        width: 50px;
        height: 50px;
    }
}
