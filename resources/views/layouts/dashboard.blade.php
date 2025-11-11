<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $roleTitle ?? 'Dashboard' }} - Restoran BilSky</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #2C3E50;
      display: flex;
      transition: margin-left 0.3s;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 280px;
      background: linear-gradient(135deg, #4A90E2, #2E5BBA);
      color: white;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 0;
      position: fixed;
      top: 0;
      left: 0;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      transition: transform 0.3s ease;
      z-index: 1000;
      border-radius: 0 20px 20px 0;
    }

    .sidebar .logo {
      text-align: center;
      padding: 2rem 1rem;
      border-bottom: 1px solid rgba(255,255,255,0.2);
      margin-bottom: 1rem;
    }

    .sidebar .logo h2 {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
    }

    .sidebar .logo .subtitle {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.8);
      margin-top: 0.5rem;
      font-weight: 500;
    }

    .sidebar a,
    .sidebar button {
      font-weight: 500;
      color: white;
      text-decoration: none;
      padding: 1rem 1.5rem;
      margin: 0.25rem 1rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      border-radius: 12px;
      background: transparent;
      border: none;
      text-align: left;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-size: 0.95rem;
    }

    .sidebar a:hover,
    .sidebar button:hover {
      background: rgba(255,255,255,0.2);
      transform: translateX(6px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .sidebar a.active {
      background: rgba(255,255,255,0.25);
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .sidebar a i {
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
    }

    /* Logout button */
    .btn-logout {
      margin-top: auto;
      background: linear-gradient(135deg, #F39C12, #E67E22) !important;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      text-align: center;
      color: white;
      margin: 1rem;
      padding: 1rem 1.5rem;
      box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-logout:hover {
      background: linear-gradient(135deg, #E67E22, #F39C12) !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(243, 156, 18, 0.4);
    }

    /* Main */
    .main {
      flex: 1;
      margin-left: 280px;
      padding: 0;
      transition: margin-left 0.3s;
    }

    .main.full {
      margin-left: 0;
    }

    /* Topbar */
    .topbar {
      background: rgba(255, 255, 255, 0.95);
      padding: 1.5rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      backdrop-filter: blur(10px);
      border-radius: 0 0 20px 20px;
      margin: 1rem 1rem 0 0;
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .menu-toggle {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #4A90E2;
      cursor: pointer;
      padding: 0.5rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .menu-toggle:hover {
      background: rgba(74, 144, 226, 0.1);
    }

    .topbar-left div h4 {
      margin: 0;
      font-size: 1.5rem;
      font-weight: 600;
      color: #2E5BBA;
    }

    .topbar-left div small {
      color: #7F8C8D;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .user-profile {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 0.75rem 1.25rem;
      background: rgba(74, 144, 226, 0.1);
      border-radius: 12px;
      border: 2px solid rgba(74, 144, 226, 0.2);
    }

    .user-profile img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      border: 3px solid #4A90E2;
    }

    .user-profile span {
      font-weight: 600;
      color: #2C3E50;
      font-size: 1rem;
    }

    /* Content */
    .content {
      padding: 2rem;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* Cards */
    .card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      overflow: hidden;
      border: none;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .big-card {
      grid-column: 1 / -1;
      background: linear-gradient(135deg, #4A90E2, #2E5BBA);
      position: relative;
      overflow: hidden;
      color: white;
    }

    .big-card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(46, 91, 186, 0.8);
      border-radius: 20px;
    }

    .big-card > * {
      position: relative;
      z-index: 2;
    }

    .big-card-header {
      padding: 2rem 2rem 1rem 2rem;
    }

    .big-card-header h3 {
      font-size: 1.8rem;
      font-weight: 700;
      margin: 0 0 0.5rem 0;
      color: white;
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .big-card-header p {
      color: rgba(255,255,255,0.9);
      margin: 0;
      font-size: 1rem;
      font-weight: 500;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      padding: 1rem 2rem 2rem 2rem;
    }

    .stat {
      text-align: center;
      padding: 1.5rem;
      background: rgba(255,255,255,0.1);
      border-radius: 16px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
    }

    .stat-icon {
      font-size: 2.5rem;
      color: rgba(255,255,255,0.9);
      margin-bottom: 1rem;
    }

    .stat h2 {
      margin: 0 0 0.5rem 0;
      font-size: 2.2rem;
      font-weight: 700;
      color: white;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .stat p {
      margin: 0;
      color: rgba(255,255,255,0.9);
      font-weight: 500;
      font-size: 0.95rem;
    }

    .card-header {
      background: linear-gradient(135deg, #4A90E2, #2E5BBA);
      color: white;
      border: none;
      padding: 1.5rem 2rem;
      border-radius: 20px 20px 0 0;
    }

    .card-header h3 {
      font-size: 1.3rem;
      font-weight: 600;
      margin: 0 0 0.5rem 0;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .card-header p {
      margin: 0;
      font-size: 0.95rem;
      opacity: 0.9;
      font-weight: 500;
    }

    .card-body {
      padding: 2rem;
    }

    /* Activity List */
    .activity-list {
      max-height: 400px;
      overflow-y: auto;
    }

    .activity-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .activity-item:last-child {
      border-bottom: none;
    }

    .activity-icon {
      color: #4A90E2;
      font-size: 0.6rem;
      margin-top: 0.75rem;
    }

    .activity-content p {
      margin: 0 0 0.5rem 0;
      font-size: 0.95rem;
      line-height: 1.5;
      color: #2C3E50;
    }

    .activity-content small {
      color: #7F8C8D;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .no-activity {
      text-align: center;
      padding: 3rem;
      color: #7F8C8D;
    }

    .no-activity i {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #4A90E2;
    }

    .no-activity p {
      font-size: 1rem;
      font-weight: 500;
    }

    /* Notification List */
    .notification-list {
      max-height: 400px;
      overflow-y: auto;
    }

    .notification-item {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      padding: 1rem 0;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .notification-item:last-child {
      border-bottom: none;
    }

    .notification-icon {
      color: #E67E22;
      font-size: 1.2rem;
      margin-top: 0.25rem;
    }

    .notification-content p {
      margin: 0;
      font-size: 0.95rem;
      line-height: 1.5;
      color: #2C3E50;
    }

    .no-notification {
      text-align: center;
      padding: 3rem;
      color: #27AE60;
    }

    .no-notification i {
      font-size: 3rem;
      margin-bottom: 1rem;
    }

    .no-notification p {
      font-size: 1rem;
      font-weight: 500;
    }

    /* Chart */
    canvas {
      width: 100%;
      height: 250px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 100%;
        border-radius: 0;
      }

      .sidebar.hidden {
        transform: translateX(0);
      }

      .main {
        margin-left: 0;
      }

      .topbar {
        margin: 0.5rem;
        border-radius: 12px;
        padding: 1rem 1.5rem;
      }

      .content {
        padding: 1rem;
      }

      .dashboard {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .stats {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
    }

    /* Hidden class for sidebar */
    .sidebar.hidden {
      transform: translateX(-100%);
    }
  </style>
</head>
<body>
  @include('partials.theme-override')
  @include('partials.ui-enhancements')
  @include('partials.animations')

  <!-- Sidebar -->  
  <div class="sidebar sidebar-load" id="sidebar">
    <div class="logo">
      <h2><i class="fas fa-utensils"></i> BilSky</h2>
      <div class="subtitle">Restoran Management</div>
    </div>
    
    @yield('sidebar-menu')
    
    <a href="{{ route('logout') }}" class="btn-logout">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>

  <!-- Main -->
  <div class="main" id="main">
    <!-- Topbar -->
    <div class="topbar topbar-load">
      <div class="topbar-left">
        <button class="menu-toggle hover-scale" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>
        <div>
          <h4>@yield('welcome-title', 'Selamat Datang')</h4>
          <small>@yield('welcome-subtitle', 'Dashboard Restoran BilSky')</small>
        </div>
      </div>
      <div class="user-profile hover-lift">
        <img src="https://cdn-icons-png.flaticon.com/128/4681/4681809.png" alt="avatar">
        <span>@yield('user-role', 'User')</span>
      </div>
    </div>

    <!-- Content -->
    <div class="content page-load">
      <div class="dashboard">
        @yield('dashboard-content')
      </div>
    </div>
  </div>

  <!-- JS Sidebar -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("sidebar");
      sidebar.classList.toggle("hidden");
      
      // Add animation classes
      if (sidebar.classList.contains("hidden")) {
        sidebar.classList.add("sidebar-slide-out");
        sidebar.classList.remove("sidebar-slide-in");
      } else {
        sidebar.classList.add("sidebar-slide-in");
        sidebar.classList.remove("sidebar-slide-out");
      }
    }

    // Add scroll reveal animations
    function revealOnScroll() {
      const reveals = document.querySelectorAll('.scroll-reveal');
      reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < windowHeight - elementVisible) {
          element.classList.add('revealed');
        }
      });
    }

    window.addEventListener('scroll', revealOnScroll);
    
    // Initialize animations on page load
    document.addEventListener('DOMContentLoaded', function() {
      // Add card load animations
      const cards = document.querySelectorAll('.card');
      cards.forEach((card, index) => {
        card.classList.add('card-load');
        card.style.animationDelay = `${index * 0.1}s`;
      });
      
      // Add stagger animations to lists
      const listItems = document.querySelectorAll('.activity-item, .notification-item');
      listItems.forEach((item, index) => {
        item.classList.add('stagger-item');
        item.style.animationDelay = `${index * 0.1}s`;
      });
    });

    // Chart.js
    @yield('chart-script')
  </script>
  
  @include('partials.ui-scripts')
</body>
</html>
