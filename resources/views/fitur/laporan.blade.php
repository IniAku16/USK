<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f9ff;
            font-family: 'Poppins', sans-serif;
            color: #1e3a8a;
        }

        h2 {
            font-weight: 700;
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            margin-top: 40px;
            max-width: 1200px;
            background: #ffffffcc;
            backdrop-filter: blur(6px);
            border-radius: 20px;
            padding: 40px 50px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 500;
            color: #1e3a8a;
        }

        .btn-primary {
            background-color: #60a5fa;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #3b82f6;
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }

        .btn-success {
            background-color: #34d399;
            border: none;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-secondary {
            background-color: #93c5fd;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            color: #1e3a8a;
        }

        .btn-secondary:hover {
            background-color: #60a5fa;
            color: white;
        }

        .card {
            border: none;
            border-radius: 16px;
            background: #e0f2fe;
            color: #1e3a8a;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card .text-muted {
            color: #475569 !important;
        }

        table {
            border-radius: 12px;
            overflow: hidden;
        }

        thead {
            background-color: #1e3a8a;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #e0f2fe;
        }

        tbody tr:hover {
            background-color: #bfdbfe;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        /* Input styling */
        .form-control {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96,165,250,0.25);
        }

        /* Cetak */
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .container {
                box-shadow: none;
                padding: 0;
                background: white;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }
        }
        .btn-outline-secondary {
        border-color: #4A90E2;
        color: #4A90E2;
        font-weight: 500;
    }

    .btn-outline-secondary:hover {
        background: #4A90E2;
        color: white;
    }
    </style>
</head>
<body>

<div class="container">
    <h2>📊 Laporan Transaksi</h2>

    @include('partials.back-to-dashboard')

    <form action="" method="GET" class="no-print mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Cari (nama pelanggan / menu / meja / ID pelanggan)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" class="form-control" placeholder="cth: Siti, Bakso, Meja 3, 102">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end gap-2 flex-wrap">
                <button class="btn btn-primary">Terapkan</button>
                <a href="<?= route('laporan.export.csv', ['search' => $search]) ?>" class="btn btn-success">Export CSV</a>
                <a href="<?= route('laporan.export.pdf', ['search' => $search]) ?>" class="btn btn-secondary">Export PDF</a>
                <a href="<?= route('laporan.index') ?>" class="btn btn-outline-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Ringkasan KPI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted">Omzet Diterima</div>
                    <div class="fs-4 fw-bold">Rp <?= number_format($omzetDiterima ?? 0, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted">Total Tagihan</div>
                    <div class="fs-4 fw-bold">Rp <?= number_format($totalTagihan ?? 0, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted">Piutang (Belum Dibayar)</div>
                    <div class="fs-4 fw-bold">Rp <?= number_format($piutang ?? 0, 0, ',', '.') ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-muted">Transaksi (Lunas/Belum)</div>
                    <div class="fs-6 fw-semibold"><?= (int)($jumlahLunas ?? 0) ?> / <?= (int)($jumlahBelum ?? 0) ?></div>
                    <div class="small text-muted">Total: <?= (int)($jumlahItem ?? 0) ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- (Disederhanakan: bagian profit dihapus) -->

    <!-- Tabel Menu Favorit -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">🍽️ Menu Paling Favorit</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Menu</th>
                            <th>Qty Terjual</th>
                            <th>Subtotal (Akru)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $rank = 1; ?>
                        <?php foreach(($menuFavorit ?? []) as $fav): ?>
                            <tr>
                                <td><?= $rank++ ?></td>
                                <td><?= htmlspecialchars($fav['nama_menu']) ?></td>
                                <td><?= (int)$fav['qty'] ?></td>
                                <td>Rp <?= number_format($fav['omzet_subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($menuFavorit) || count($menuFavorit) === 0): ?>
                            <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Meja</th>
                        <th>Pelanggan</th>
                        <th>Rincian</th>
                        <th>Total Qty</th>
                        <th>Total Harga</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($grouped ?? []) as $g): ?>
                        <tr>
                            <td><?= $g->created_at ?></td>
                            <td><?= $g->id_meja ?></td>
                            <td><?= $g->nama_pelanggan ? htmlspecialchars($g->nama_pelanggan) . ' (#' . $g->idpelanggan . ')' : $g->idpelanggan ?></td>
                            <td>
                                <ul class="mb-0" style="padding-left:18px">
                                    <?php foreach ($g->items as $it): ?>
                                        <li><?= htmlspecialchars($it['nama_menu']) ?> (<?= (int)$it['jumlah'] ?> x Rp <?= number_format($it['harga'],0,',','.') ?>) = Rp <?= number_format($it['total'],0,',','.') ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td><?= (int)$g->total_qty ?></td>
                            <td>Rp <?= number_format($g->total_harga, 0, ',', '.') ?></td>
                            <td><?= $g->total_bayar > 0 ? 'Rp ' . number_format($g->total_bayar, 0, ',', '.') : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
