<style>
    :root {
        /* Restoran BilSky Brand Colors */
        --primary: #4A90E2; /* Professional blue */
        --primary-strong: #2E5BBA; /* Deeper blue */
        --accent: #7BB3F0; /* Light accent blue */
        --secondary: #F39C12; /* Warm orange accent */
        --success: #27AE60; /* Green for success */
        --warning: #E67E22; /* Orange for warnings */
        --danger: #E74C3C; /* Red for errors */
        --text: #2C3E50; /* Dark blue-gray text */
        --text-light: #7F8C8D; /* Light gray text */
        --card-bg: rgba(255, 255, 255, 0.95); /* Clean white */
        --sidebar-bg: linear-gradient(135deg, #4A90E2, #2E5BBA); /* Gradient sidebar */
        --big-card-overlay: rgba(46, 91, 186, 0.8); /* Professional overlay */
        --shadow: 0 4px 20px rgba(0,0,0,0.1); /* Soft shadow */
        --shadow-hover: 0 8px 30px rgba(0,0,0,0.15); /* Hover shadow */
        --border-radius: 12px; /* Modern border radius */
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); /* Smooth transitions */
    }

    /* Global Styles */
    body {
        color: var(--text);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    /* Sidebar Enhancement */
    .sidebar {
        background: var(--sidebar-bg) !important;
        box-shadow: var(--shadow);
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
    }

    .sidebar .logo {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .sidebar .logo h3 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 1.5rem;
    }

    .sidebar .logo .subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .sidebar a, .sidebar button {
        color: white !important;
        padding: 0.75rem 1.5rem;
        margin: 0.25rem 1rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .sidebar a:hover, .sidebar button:hover {
        background: rgba(255,255,255,0.2) !important;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .sidebar a.active {
        background: rgba(255,255,255,0.25) !important;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Topbar Enhancement */
    .main .topbar {
        background: var(--card-bg);
        box-shadow: var(--shadow);
        border-radius: var(--border-radius);
        margin: 1rem;
        padding: 1rem 1.5rem;
        backdrop-filter: blur(10px);
    }

    .topbar h4 {
        color: var(--primary-strong);
        font-weight: 600;
        margin: 0;
    }

    /* Card Enhancements */
    .card {
        background: var(--card-bg) !important;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    .card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-strong)) !important;
        color: white !important;
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card h3 {
        color: var(--primary-strong);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Big Card Enhancement */
    .big-card {
        position: relative;
        overflow: hidden;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
    }

    .big-card::before {
        background: var(--big-card-overlay);
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }

    .big-card .stat {
        position: relative;
        z-index: 2;
    }

    .big-card .stat h2 {
        color: white;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .big-card .stat p {
        color: rgba(255,255,255,0.9);
        font-weight: 500;
    }

    /* Button Enhancements */
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-strong));
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-strong), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        color: white;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success), #2ECC71);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #2ECC71, var(--success));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        color: white;
    }

    .btn-outline-secondary {
        border: 2px solid var(--primary-strong);
        color: var(--primary-strong);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .btn-outline-secondary:hover {
        background: var(--primary-strong);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(46, 91, 186, 0.3);
    }

    /* Table Enhancements */
    .table {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .table thead th {
        background: linear-gradient(135deg, var(--primary), var(--primary-strong));
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
    }

    .table tbody td {
        padding: 1rem;
        border-color: rgba(0,0,0,0.05);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.05);
        transform: scale(1.01);
        transition: var(--transition);
    }

    /* Form Enhancements */
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        transition: var(--transition);
        font-weight: 500;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.15);
        transform: translateY(-1px);
    }

    /* Modal Enhancements */
    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-strong)) !important;
        color: white !important;
        border: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .modal-body {
        padding: 2rem;
    }

    /* Badge Enhancements */
    .badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, var(--success), #2ECC71) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, var(--warning), #F39C12) !important;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, var(--danger), #C0392B) !important;
    }

    /* Meja Box Enhancement */
    .meja-box {
        border: 3px solid var(--primary-strong);
        border-radius: var(--border-radius);
        transition: var(--transition);
        background: white;
        box-shadow: var(--shadow);
    }

    .meja-box:hover {
        box-shadow: var(--shadow-hover);
        border-color: var(--primary);
        transform: translateY(-4px);
    }

    .meja-box.active {
        background: linear-gradient(135deg, #e7f1ff, #cfe2ff);
        border-color: var(--primary);
        box-shadow: 0 8px 25px rgba(74, 144, 226, 0.3);
    }

    .meja-box .nomor.text-primary {
        color: var(--primary-strong) !important;
        font-weight: 700;
    }

    /* Menu Item Enhancement */
    .menu-item-simple {
        border-left: 4px solid var(--primary-strong);
        border-radius: var(--border-radius);
        transition: var(--transition);
        background: white;
        box-shadow: var(--shadow);
    }

    .menu-item-simple:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
        border-left-color: var(--primary);
    }

    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Success/Error Messages */
    .alert {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.1));
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(192, 57, 43, 0.1));
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }

    /* Chart Container */
    .chart-container {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        margin: 1rem 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar {
            border-radius: 0;
        }
        
        .main .topbar {
            margin: 0.5rem;
            border-radius: var(--border-radius);
        }
        
        .card {
            margin: 0.5rem;
        }
    }

    /* Utility Classes */
    .text-primary { color: var(--primary-strong) !important; }
    .bg-primary { background-color: var(--primary-strong) !important; }
    .border-primary { border-color: var(--primary-strong) !important; }
    .shadow-soft { box-shadow: var(--shadow) !important; }
    .shadow-hover { box-shadow: var(--shadow-hover) !important; }
    .rounded-modern { border-radius: var(--border-radius) !important; }
    .transition-smooth { transition: var(--transition) !important; }
</style>