<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>🍽️ Entri Pesanan</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            transition: all 0.2s ease-in-out;
            border-radius: 16px;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .menu-grid label {
            width: 100%;
        }
        .btn-success {
            font-size: 1.1rem;
            font-weight: 600;
        }
        /* Meja layout (clickable) */
        .layout-meja {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border: 2px dashed #dee2e6;
            min-height: 200px;
            align-items: start;
        }
        
        .meja-box {
            background: #ffffff;
            border: 3px solid #0d6efd;
            border-radius: 15px;
            text-align: center;
            padding: 20px 15px;
            cursor: pointer;
            user-select: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .meja-box:hover { 
            transform: translateY(-5px) scale(1.02); 
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.2); 
            border-color: #0b5ed7;
        }
        
        .meja-box.active { 
            background: linear-gradient(135deg, #e7f1ff, #cfe2ff);
            border-color: #0b5ed7;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(13, 110, 253, 0.3);
        }
        
        .meja-box.disabled { 
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-color: #6c757d; 
            cursor: not-allowed !important;
            opacity: 0.6;
        }
        
        .meja-box.disabled:hover { 
            transform: none !important; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }
        
        .meja-box .nomor {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .meja-box .kapasitas {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .meja-box.disabled .nomor {
            color: #6c757d !important;
        }
        
        .meja-box.disabled .kapasitas {
            color: #adb5bd !important;
        }

        /* Responsive design untuk meja */
        @media (max-width: 768px) {
            .layout-meja {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 15px;
                padding: 15px;
            }
            
            .meja-box {
                padding: 15px 10px;
                min-height: 100px;
            }
            
            .meja-box .nomor {
                font-size: 1.1rem;
            }
            
            .meja-box .kapasitas {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .layout-meja {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 10px;
                padding: 10px;
            }
            
            .meja-box {
                padding: 12px 8px;
                min-height: 90px;
            }
            
            .meja-box .nomor {
                font-size: 1rem;
            }
            
            .meja-box .kapasitas {
                font-size: 0.75rem;
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
    <h2 class="mb-2 text-center">Entri Pesanan</h2>
    <div class="d-flex justify-content-center gap-2 mb-3">
        <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-sm {{ request('jenis') ? '' : 'active' }}">Semua</a>
        <a href="{{ route('pesanan.index', ['jenis' => 'makanan']) }}" class="btn btn-outline-secondary btn-sm {{ request('jenis') === 'makanan' ? 'active' : '' }}">Makanan</a>
        <a href="{{ route('pesanan.index', ['jenis' => 'minuman']) }}" class="btn btn-outline-secondary btn-sm {{ request('jenis') === 'minuman' ? 'active' : '' }}">Minuman</a>
    </div>

    {{-- Tombol kembali ke dashboard --}}
    @include('partials.back-to-dashboard')

    <?php if (session('success')): ?>
        <div class="alert alert-success">
            <?= session('success') ?>
        </div>
    <?php endif; ?>
    <?php if ($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors->all() as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= route('pesanan.store') ?>" method="POST" class="mb-4">
        <?= csrf_field() ?>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-6">
                <label for="idpelanggan" class="form-label">Pilih Pelanggan</label>
                <select name="idpelanggan" id="idpelanggan" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php if(isset($pelanggans)): ?>
                        <?php foreach($pelanggans as $pel): ?>
                            <option value="<?= $pel->idpelanggan ?>" <?= old('idpelanggan') == $pel->idpelanggan ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pel->nama_pelanggan) ?> (<?= $pel->jenis_kelamin ? 'L' : 'P' ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                
                <!-- List Pesanan Pelanggan -->
                <div id="pesananPelanggan" class="mt-3" style="display: none;">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">📋 Pesanan Aktif Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <div id="listPesanan">
                                <!-- List pesanan akan dimuat di sini -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6">
                <label class="form-label">Pilih Meja</label>
                <div id="mejaGrid">
                    <?php if(isset($meja) && count($meja) > 0): ?>
                        <div class="layout-meja">
                            <?php foreach($meja as $m): ?>
                                <?php 
                                    $checked = old('id_meja', isset($preselectedMeja) ? $preselectedMeja : '') == $m['id'];
                                    $isTerisi = isset($m['status']) && $m['status'] === 'terisi';
                                    $disabled = $isTerisi;
                                ?>
                                <label class="meja-box <?= $checked && !$disabled ? 'active' : '' ?> <?= $disabled ? 'disabled' : '' ?>" 
                                       for="meja_radio_<?= $m['id'] ?>" 
                                       style="<?= $disabled ? 'opacity: 0.5; cursor: not-allowed;' : '' ?>">
                                    <input type="radio" class="d-none meja-radio" 
                                           id="meja_radio_<?= $m['id'] ?>" 
                                           name="id_meja" 
                                           value="<?= $m['id'] ?>" 
                                           <?= $checked && !$disabled ? 'checked' : '' ?> 
                                           <?= $disabled ? 'disabled' : '' ?>
                                           required>
                                    <div class="nomor fw-semibold <?= $disabled ? 'text-danger' : 'text-primary' ?>">
                                        <?= htmlspecialchars($m['nomor_meja']) ?>
                                        <?= $disabled ? ' (TERISI)' : '' ?>
                                    </div>
                                    <div class="kapasitas text-muted small">👥 <?= (int)$m['kapasitas'] ?> orang</div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-muted small">Belum ada layout meja. Tambahkan di menu Meja.</div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- ID Waiter diisi otomatis dari session; input manual dihapus -->
        </div>

        <div class="menu-grid row row-cols-1 row-cols-md-3 g-3">
            <?php if(isset($menus) && count($menus) > 0): ?>
                <?php foreach($menus as $m): ?>
                    <div class="col">
                        <div class="card text-center shadow-sm">
                            <div class="card-body">
                                @if($m->foto)
                                    <img src="{{ asset($m->foto) }}" alt="{{ $m->nama_menu }}" 
                                         style="max-width: 100%; height: auto; max-height: 150px; object-fit: contain; border-radius: 8px; margin-bottom: 10px;">
                                @else
                                    <div style="width: 100%; min-height: 100px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; margin-bottom: 10px;">
                                        📷<br><small>No Image</small>
                                    </div>
                                @endif
                                <h5 class="card-title mb-1"><?= htmlspecialchars($m->nama_menu) ?></h5>
                                <p class="card-text mb-2">Rp <span class="price" data-price="<?= (int)$m->harga ?>"><?= number_format($m->harga, 0, ',', '.') ?></span></p>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <?php $chkId = 'menu_chk_' . $m->idmenu; ?>
                                    <div class="form-check">
                                        <input class="form-check-input menu-check" type="checkbox" id="<?= $chkId ?>" data-menu="<?= $m->idmenu ?>">
                                        <label class="form-check-label" for="<?= $chkId ?>">Pilih</label>
                                    </div>
                                    <input type="number" class="form-control form-control-sm qty-input" style="width: 90px;" min="1" value="1" data-menu="<?= $m->idmenu ?>" disabled>
                                </div>
                                <!-- Hidden input that will be enabled when checked -->
                                <input type="hidden" name="items[<?= $m->idmenu ?>][qty]" value="0" class="hidden-qty" data-menu="<?= $m->idmenu ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">Tidak ada menu tersedia.</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="fs-5">Total: <strong id="grandTotal">Rp 0</strong></div>
            <button type="submit" class="btn btn-success btn-lg px-4">🧾 Simpan Pesanan</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currency = (n) => new Intl.NumberFormat('id-ID').format(n);
    const grandTotalEl = document.getElementById('grandTotal');
    const checks = Array.from(document.querySelectorAll('.menu-check'));

    function recalc() {
        let total = 0;
        checks.forEach(chk => {
            const menuId = chk.getAttribute('data-menu');
            const priceEl = chk.closest('.card-body').querySelector('.price');
            const price = parseInt(priceEl.getAttribute('data-price')) || 0;
            const qtyInput = document.querySelector(`.qty-input[data-menu="${menuId}"]`);
            const hiddenQty = document.querySelector(`.hidden-qty[data-menu="${menuId}"]`);
            if (chk.checked) {
                qtyInput.disabled = false;
                const qty = Math.max(1, parseInt(qtyInput.value) || 1);
                hiddenQty.value = qty;
                total += price * qty;
            } else {
                qtyInput.disabled = true;
                hiddenQty.value = 0;
            }
        });
        grandTotalEl.textContent = 'Rp ' + currency(total);
    }
    // Meja selection (radio-based) → toggle active class on label
    const mejaRadios = Array.from(document.querySelectorAll('.meja-radio'));
    function updateMejaActive() {
        const labels = document.querySelectorAll('.meja-box');
        labels.forEach(l => l.classList.remove('active'));
        const checked = document.querySelector('.meja-radio:checked');
        if (checked) {
            const label = checked.closest('.meja-box');
            if (label) label.classList.add('active');
        }
    }
    mejaRadios.forEach(r => r.addEventListener('change', updateMejaActive));
    updateMejaActive();

    checks.forEach(chk => {
        chk.addEventListener('change', recalc);
        const menuId = chk.getAttribute('data-menu');
        const qtyInput = document.querySelector(`.qty-input[data-menu="${menuId}"]`);
        qtyInput.addEventListener('input', recalc);
    });

    recalc();

    // Load pesanan pelanggan saat dipilih
    const pelangganSelect = document.getElementById('idpelanggan');
    const pesananContainer = document.getElementById('pesananPelanggan');
    const listPesanan = document.getElementById('listPesanan');

    pelangganSelect.addEventListener('change', function() {
        const pelangganId = this.value;
        
        if (pelangganId) {
            // Tampilkan loading
            listPesanan.innerHTML = '<div class="text-center"><div class="spinner-border spinner-border-sm" role="status"></div> Memuat pesanan...</div>';
            pesananContainer.style.display = 'block';
            
            // Fetch pesanan pelanggan
            fetch(`/api/pesanan-pelanggan/${pelangganId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '<div class="table-responsive"><table class="table table-sm">';
                        html += '<thead><tr><th>Menu</th><th>Jumlah</th><th>Meja</th><th>Status</th></tr></thead><tbody>';
                        
                        data.forEach(pesanan => {
                            html += `<tr>
                                <td>${pesanan.nama_menu}</td>
                                <td>${pesanan.jumlah}</td>
                                <td>${pesanan.nomor_meja}</td>
                                <td><span class="badge ${pesanan.status === 'lunas' ? 'bg-success' : 'bg-warning'}">${pesanan.status}</span></td>
                            </tr>`;
                        });
                        
                        html += '</tbody></table></div>';
                        listPesanan.innerHTML = html;
                    } else {
                        listPesanan.innerHTML = '<div class="text-muted text-center">Tidak ada pesanan aktif untuk pelanggan ini.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    listPesanan.innerHTML = '<div class="text-danger text-center">Gagal memuat pesanan.</div>';
                });
        } else {
            pesananContainer.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
