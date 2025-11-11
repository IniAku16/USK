/* Animations & Micro-interactions for Restoran BilSky */

/* Page Load Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Page Load Classes */
.page-load {
    animation: fadeInUp 0.6s ease-out;
}

.card-load {
    animation: fadeInUp 0.6s ease-out;
    animation-fill-mode: both;
}

.card-load:nth-child(1) { animation-delay: 0.1s; }
.card-load:nth-child(2) { animation-delay: 0.2s; }
.card-load:nth-child(3) { animation-delay: 0.3s; }
.card-load:nth-child(4) { animation-delay: 0.4s; }
.card-load:nth-child(5) { animation-delay: 0.5s; }
.card-load:nth-child(6) { animation-delay: 0.6s; }

.sidebar-load {
    animation: fadeInLeft 0.5s ease-out;
}

.topbar-load {
    animation: slideInDown 0.5s ease-out;
}

/* Hover Animations */
.hover-lift {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.hover-scale {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-scale:hover {
    transform: scale(1.05);
}

.hover-glow {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-glow:hover {
    box-shadow: 0 0 20px rgba(74, 144, 226, 0.4);
}

/* Button Animations */
.btn-pulse {
    position: relative;
    overflow: hidden;
}

.btn-pulse::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-pulse:active::before {
    width: 300px;
    height: 300px;
}

.btn-bounce {
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.btn-bounce:hover {
    transform: scale(1.1);
}

.btn-bounce:active {
    transform: scale(0.95);
}

/* Card Animations */
.card-flip {
    perspective: 1000px;
}

.card-flip-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.6s;
    transform-style: preserve-3d;
}

.card-flip:hover .card-flip-inner {
    transform: rotateY(180deg);
}

.card-flip-front, .card-flip-back {
    position: absolute;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
    border-radius: 20px;
}

.card-flip-back {
    transform: rotateY(180deg);
}

/* Loading Animations */
@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.pulse {
    animation: pulse 2s infinite;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -30px, 0);
    }
    70% {
        transform: translate3d(0, -15px, 0);
    }
    90% {
        transform: translate3d(0, -4px, 0);
    }
}

.bounce {
    animation: bounce 1s infinite;
}

@keyframes shake {
    0%, 100% {
        transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
        transform: translateX(-10px);
    }
    20%, 40%, 60%, 80% {
        transform: translateX(10px);
    }
}

.shake {
    animation: shake 0.5s ease-in-out;
}

/* Progress Animations */
@keyframes progressFill {
    from {
        width: 0%;
    }
    to {
        width: var(--progress-width);
    }
}

.progress-animated {
    animation: progressFill 1s ease-out;
}

/* Table Row Animations */
.table-row-enter {
    animation: fadeInUp 0.5s ease-out;
}

.table-row-exit {
    animation: fadeOutDown 0.3s ease-in;
}

@keyframes fadeOutDown {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(20px);
    }
}

/* Modal Animations */
.modal-fade-in {
    animation: fadeInUp 0.3s ease-out;
}

.modal-backdrop {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Sidebar Animations */
.sidebar-slide-in {
    animation: slideInLeft 0.3s ease-out;
}

@keyframes slideInLeft {
    from {
        transform: translateX(-100%);
    }
    to {
        transform: translateX(0);
    }
}

.sidebar-slide-out {
    animation: slideOutLeft 0.3s ease-in;
}

@keyframes slideOutLeft {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-100%);
    }
}

/* Notification Animations */
.notification-slide-in {
    animation: slideInRight 0.3s ease-out;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
    }
    to {
        transform: translateX(0);
    }
}

.notification-slide-out {
    animation: slideOutRight 0.3s ease-in;
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(100%);
    }
}

/* Chart Animations */
.chart-fade-in {
    animation: fadeInUp 0.8s ease-out;
}

.chart-bar-animate {
    animation: barGrow 1s ease-out;
}

@keyframes barGrow {
    from {
        height: 0;
    }
    to {
        height: var(--bar-height);
    }
}

/* Icon Animations */
.icon-spin {
    animation: spin 1s linear infinite;
}

.icon-bounce {
    animation: bounce 1s infinite;
}

.icon-pulse {
    animation: pulse 2s infinite;
}

.icon-wiggle {
    animation: wiggle 0.5s ease-in-out;
}

@keyframes wiggle {
    0%, 100% {
        transform: rotate(0deg);
    }
    25% {
        transform: rotate(5deg);
    }
    75% {
        transform: rotate(-5deg);
    }
}

/* Text Animations */
.text-fade-in {
    animation: fadeInUp 0.6s ease-out;
}

.text-slide-in {
    animation: slideInLeft 0.6s ease-out;
}

.text-typewriter {
    overflow: hidden;
    border-right: 2px solid #4A90E2;
    white-space: nowrap;
    animation: typewriter 3s steps(40, end), blink-caret 0.75s step-end infinite;
}

@keyframes typewriter {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

@keyframes blink-caret {
    from, to {
        border-color: transparent;
    }
    50% {
        border-color: #4A90E2;
    }
}

/* Scroll Animations */
.scroll-reveal {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.6s ease-out;
}

.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Stagger Animation */
.stagger-item {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease-out forwards;
}

.stagger-item:nth-child(1) { animation-delay: 0.1s; }
.stagger-item:nth-child(2) { animation-delay: 0.2s; }
.stagger-item:nth-child(3) { animation-delay: 0.3s; }
.stagger-item:nth-child(4) { animation-delay: 0.4s; }
.stagger-item:nth-child(5) { animation-delay: 0.5s; }
.stagger-item:nth-child(6) { animation-delay: 0.6s; }
.stagger-item:nth-child(7) { animation-delay: 0.7s; }
.stagger-item:nth-child(8) { animation-delay: 0.8s; }

/* Micro-interactions */
.interactive-element {
    cursor: pointer;
    transition: all 0.2s ease;
}

.interactive-element:hover {
    transform: scale(1.02);
}

.interactive-element:active {
    transform: scale(0.98);
}

/* Focus Animations */
.focus-ring {
    transition: all 0.2s ease;
}

.focus-ring:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.3);
    transform: scale(1.02);
}

/* Responsive Animations */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Performance Optimizations */
.gpu-accelerated {
    transform: translateZ(0);
    will-change: transform;
}

.smooth-scroll {
    scroll-behavior: smooth;
}
