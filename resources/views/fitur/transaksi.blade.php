<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📑 Daftar Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
        }

        h2 { font-size: 1.25rem; }
        .container { max-width: 1100px; }

        .main-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.06);
            padding: 16px;
        }

        .transaction-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: box-shadow 0.2s ease;
        }

        .transaction-card:hover { box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08); }

        .transaction-card.lunas { border-left: 3px solid #28a745; }
        .transaction-card.belum-lunas { border-left: 3px solid #ffc107; }

        .card-header-simple {
            background: #f9fafb;
            border-bottom: 1px solid #eef2f7;
            padding: 10px 12px;
        }

        .menu-item-simple {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 6px 8px;
            margin-bottom: 6px;
            border-left: 3px solid #5AA9FF;
            font-size: 13px;
        }

        .total-section-simple {
            background: #f3f4f6;
            padding: 10px 12px;
            border-radius: 0 0 8px 8px;
        }

        .status-badge-simple {
            font-size: 0.72rem;
            padding: 3px 6px;
            border-radius: 4px;
        }

        .btn-pay-simple {
            background: #28a745;
            border: none;
            border-radius: 5px;
            padding: 6px 14px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .btn-pay-simple:hover { background: #218838; }

        .meja-badge-simple {
            background: #5AA9FF;
            color: white;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
        }

        .search-filter {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 14px;
        }

        .stats-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-3">
    <div class="main-container">
        <div class="mb-3">
            @include('partials.back-to-dashboard')
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">
                <i class="fas fa-receipt text-primary me-2"></i>
                Daftar Transaksi
            </h2>
            <div class="text-muted">
                <i class="fas fa-calendar-alt me-1"></i>
                <?= date('d M Y H:i') ?>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter">
            <form method="GET" action="{{ route('transaksi.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Pelanggan/Meja</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ $search ?? '' }}" placeholder="Nama pelanggan atau nomor meja">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="lunas" {{ ($status ?? '') == 'lunas' ? 'selected' : '' }}>Sudah Bayar</option>
                            <option value="belum_lunas" {{ ($status ?? '') == 'belum_lunas' ? 'selected' : '' }}>Belum Bayar</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2 btn-sm">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-refresh me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
        
        <?php if (session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($transaksiWithTotal->count() > 0): ?>
            <?php foreach ($transaksiWithTotal as $i => $group): ?>
                <div class="transaction-card <?= $group->is_lunas ? 'lunas' : 'belum-lunas' ?>">
                    <div class="card-header-simple">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">
                                    <i class="fas fa-user me-2"></i>
                                    <?= htmlspecialchars($group->nama_pelanggan) ?>
                                </h5>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    <?= date('d M Y H:i', strtotime($group->created_at)) ?>
                                    <span class="meja-badge-simple ms-2">
                                        <i class="fas fa-chair me-1"></i>
                                        Meja <?= $group->id_meja ?>
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge status-badge-simple <?= $group->is_lunas ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $group->is_lunas ? 'LUNAS' : 'BELUM LUNAS' ?>
                                </span>
                                <a href="<?= route('transaksi.download-pdf', $group->items->first()->idtransaksi) ?>" 
                                   class="btn btn-sm btn-outline-primary ms-2" title="Download PDF">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3">
                        <h6 class="text-muted mb-2">
                            <i class="fas fa-list me-2"></i>
                            Detail Pesanan
                        </h6>
                        
                        <?php foreach ($group->items as $item): ?>
                            <div class="menu-item-simple">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <span class="fw-medium"><?= htmlspecialchars($item->nama_menu) ?></span>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span class="badge bg-primary"><?= (int)$item->jumlah ?>x</span>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <strong class="text-success">
                                            Rp <?= number_format($item->total, 0, ',', '.') ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="total-section-simple">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Total Pesanan</h6>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h5 class="mb-1">Rp <?= number_format($group->total_harga, 0, ',', '.') ?></h5>
                                    <?php if ($group->total_bayar > 0): ?>
                                        <small class="text-muted">
                                            Bayar: Rp <?= number_format($group->total_bayar, 0, ',', '.') ?> | 
                                            Kembali: Rp <?= number_format($group->kembalian, 0, ',', '.') ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if (!$group->is_lunas): ?>
                                <hr class="my-2">
                                <form action="<?= route('transaksi.pay', $group->items->first()->idtransaksi) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                </span>
                                                <input type="number" name="bayar" class="form-control" 
                                                       placeholder="Masukkan jumlah bayar" 
                                                       min="<?= $group->total_harga ?>" 
                                                       value="<?= $group->total_bayar > 0 ? $group->total_bayar : $group->total_harga ?>"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button type="submit" class="btn btn-pay-simple">
                                                <i class="fas fa-credit-card me-2"></i>
                                                Bayar Sekarang
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="text-center mt-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span class="text-muted">Pembayaran telah lunas</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada transaksi</h4>
                <p class="text-muted">Transaksi akan muncul setelah ada pesanan</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


