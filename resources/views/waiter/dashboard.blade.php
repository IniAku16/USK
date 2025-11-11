<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Waiter Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: url("https://images.unsplash.com/photo-1671034456366-77aff6bd3316?q=80&w=735&auto=format&fit=crop") no-repeat center center/cover;
      color: #1a1a1a;
      display: flex;
      transition: margin-left 0.3s;
      height: 100vh;
      overflow: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background: rgba(65, 154, 255, 0.95);
      color: white;
      height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      position: fixed;
      top: 0;
      left: 0;
      box-shadow: 2px 0 15px rgba(0,0,0,0.2);
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .sidebar h2 { font-size: 1.3rem; text-align: center; margin-bottom: 30px; font-weight: 700; }

    .sidebar a,
    .sidebar button {
      font-weight: 600;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      display: block;
      border-radius: 10px;
      margin: 6px 15px;
      background: transparent;
      border: none;
      text-align: left;
      cursor: pointer;
      transition: 0.3s;
    }
    .sidebar a:hover, .sidebar button:hover { background: rgba(255,255,255,0.2); }
    .btn-logout { margin-top: auto; background: #3498ff !important; border: 2px solid #000; border-radius: 12px; font-weight: 700; text-align: center; color: #fff; }

    /* Main */
    .main { flex: 1; margin-left: 240px; padding: 0; transition: margin-left 0.3s; height: 100vh; display: flex; flex-direction: column; }
    .main.full { margin-left: 0; }

    /* Topbar */
    .topbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); border-bottom: 1px solid rgba(0,0,0,0.05); }
    .topbar-left { display: flex; align-items: center; gap: 12px; }
    .menu-toggle { background: transparent; border: none; font-size: 20px; cursor: pointer; }
    .topbar img { width: 40px; height: 40px; border-radius: 50%; }

    /* Content */
    .content { padding: 16px; flex: 1; overflow-y: auto; }

    .dashboard { display: grid; grid-template-columns: 1.3fr 1fr; gap: 12px; height: 100%; }

    .card { background: rgba(255, 255, 255, 0.9); border-radius: 16px; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 12px; height: fit-content; max-height: 100%; overflow: hidden; margin: 0; }

    .big-card { background: url('https://images.unsplash.com/photo-1671034456366-77aff6bd3316?q=80&w=735&auto=format&fit=crop') no-repeat center/cover; position: relative; color: white; height: 240px; width: 100%; max-width: 520px; margin: 0; align-self: start; display: flex; flex-direction: column; justify-content: space-between; }
    .big-card::before { content: ""; position: absolute; inset: 0; background: rgba(25, 85, 170, 0.6); border-radius: 20px; }
    .big-card > * { position: relative; z-index: 2; }
    .big-card p { margin: 0 0 6px 0; font-size: 0.95rem; }

    .stats { display: flex; justify-content: space-between; margin-top: 10px; flex: 1; align-items: center; gap: 8px; }
    .stat { text-align: center; flex: 1; }
    .stat h2 { margin: 0; font-size: 1.4rem; font-weight: 700; }
    .stat p { margin: 2px 0 0 0; font-size: 0.85rem; }

    .list { margin: 0; padding-left: 18px; }
    .list li { margin: 6px 0; }

    canvas { width: 100%; height: 120px; }
    #chart1 { height: 120px !important; max-height: 120px; }
    .card h3 { margin: 0 0 4px 0; font-size: 0.95rem; }

    @media (max-width: 992px) {
      .dashboard { grid-template-columns: 1fr; gap: 10px; }
      .main { margin-left: 0; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->  
  <div class="sidebar" id="sidebar">
    <h2>Restoran BilSky</h2>
    <a href="{{route('menu.index')}}">Menu</a>
    <a href="{{route('pesanan.index')}}">Pesanan</a>
    <a href="{{route('laporan.index')}}">Laporan</a>
    <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
  </div>

  <!-- Main -->
  <div class="main" id="main">
    <div class="topbar">
      <div class="topbar-left">
        <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
        <h4>Selamat Datang, Waiter</h4>
      </div>
      <img src="https://cdn-icons-png.flaticon.com/128/4681/4681809.png" alt="avatar">
    </div>

    <div class="content">
      <div class="dashboard">
        <div class="card big-card">
          <p>Kondisi data terkini</p>
          <div class="stats">
            <div class="stat">
              <h2>{{ number_format($waiterStats['pesananSaya'] ?? 0) }}</h2>
              <p>Pesanan Saya</p>
            </div>
            <div class="stat">
              <h2>{{ number_format($waiterStats['pesananPending'] ?? 0) }}</h2>
              <p>Pending</p>
            </div>
            <div class="stat">
              <h2>{{ number_format($waiterStats['pesananSelesai'] ?? 0) }}</h2>
              <p>Selesai</p>
            </div>
          </div>
        </div>

        <div class="card">
          <h3>Analytics</h3>
          <canvas id="chart1"></canvas>
        </div>

        <div class="card">
          <h3>Tugas</h3>
          <ul class="list">
            @forelse(($waiterTasks ?? []) as $t)
              <li>{{ date('d M H:i', strtotime($t->created_at)) }} - {{ $t->nama_pelanggan }} (Meja {{ $t->id_meja }}) - {{ $t->nama_menu }} x{{ $t->jumlah }}</li>
            @empty
              <li class="text-muted">Tidak ada tugas.</li>
            @endforelse
          </ul>
        </div>

        <div class="card">
          <h3>Notifications</h3>
          <ul class="list">
            @foreach(($notifications ?? []) as $n)
              <li>{{ $n['text'] }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("hidden");
      document.getElementById("main").classList.toggle("full");
    }

    const ctx = document.getElementById('chart1').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($labels7 ?? []),
        datasets: [{
          label: 'Pesanan',
          data: @json($pesanan7 ?? []),
          borderColor: '#10b981',
          backgroundColor: 'rgba(16,185,129,0.15)',
          tension: 0.35,
          fill: true
        }]
      },
      options: { responsive: true, maintainAspectRatio: false }
    });
  </script>
</body>
</html>