<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Menu - Restoran BilSky</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

    body {
        background: linear-gradient(135deg, #ccefff 0%, #99d6ff 100%);
        font-family: 'Inter', sans-serif;
        color: #2C3E50;
        min-height: 100vh;
        margin: 0;
        padding: 2rem;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        width: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #99d6ff, #66b3ff);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem 2rem;
        font-weight: 600;
        font-size: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 12px rgba(102, 179, 255, 0.5);
    }

    .btn-primary {
        background: linear-gradient(135deg, #66b3ff, #3399ff);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(102, 179, 255, 0.4);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-block;
        text-align: center;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3399ff, #66b3ff);
        box-shadow: 0 6px 20px rgba(102, 179, 255, 0.6);
        transform: translateY(-2px);
        color: white;
    }

    .btn-outline-secondary {
        border: 2px solid #3399ff;
        background: transparent;
        color: #3399ff;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-outline-secondary:hover {
        background: #3399ff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(51, 153, 255, 0.4);
    }

    .form-control, .form-select {
        border: 2px solid #ccefff;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        background: rgba(255, 255, 255, 0.9);
        color: #2C3E50;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 1rem;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3399ff;
        box-shadow: 0 0 8px rgba(51, 153, 255, 0.5);
        outline: none;
        background: white;
        transform: translateY(-1px);
    }

    .table {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        background: white;
        border-collapse: collapse;
        margin-top: 1.5rem;
    }

    .table thead th {
        background: linear-gradient(90deg, #99d6ff, #66b3ff);
        color: white;
        font-weight: 600;
        border: none;
        padding: 1rem;
        text-align: center;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e6f0ff;
        color: #2C3E50;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(102, 179, 255, 0.1);
        transform: scale(1.01);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    h2 {
        color: #3399ff;
        font-weight: 700;
        margin-bottom: 1rem;
        text-align: center;
    }

    /* Badge */
    .badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        color: white;
        display: inline-block;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #33cc66, #28a745);
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffcc33, #ffb703);
        color: #2C3E50;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #ff6666, #cc3333);
    }

</style>
</head>

<body>
<div class="container py-4 fade-in">

    {{-- Tombol kembali ke dashboard --}}
    @include('partials.back-to-dashboard')

    <h2 class="mb-2 fw-bold" style="color: rgba(65, 154, 255, 0.95);;">Manajemen Menu</h2>
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm {{ empty($filterJenis) ? 'active' : '' }}">Semua</a>
        <a href="{{ route('menu.index', ['jenis' => 'makanan']) }}" class="btn btn-outline-secondary btn-sm {{ ($filterJenis ?? '') === 'makanan' ? 'active' : '' }}">Makanan</a>
        <a href="{{ route('menu.index', ['jenis' => 'minuman']) }}" class="btn btn-outline-secondary btn-sm {{ ($filterJenis ?? '') === 'minuman' ? 'active' : '' }}">Minuman</a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Form Tambah Menu --}}
    <div class="card mb-5">
        <div class="card-header text-white fw-semibold" style="background-color:#A7C7E7; color:#1a202c;">
            Tambah Menu Baru
        </div>
        <div class="card-body">
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="nama_menu"
                        class="form-control @error('nama_menu') is-invalid @enderror"
                        placeholder="Nama Menu" required>
                    @error('nama_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                        <option value="">Pilih Jenis</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                    @error('jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <input type="number" name="harga"
                        class="form-control @error('harga') is-invalid @enderror"
                        placeholder="Harga (Rp)" min="0" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <input type="file" name="foto"
                        class="form-control @error('foto') is-invalid @enderror"
                        accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Menu Tersedia --}}
    <h4 class="section-title">✅ Menu Tersedia</h4>
    <div class="table-responsive mb-5">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama Menu</th>
                    <th>Jenis</th>
                    <th>Harga (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $available = $menus->filter(fn($m) => !$m->is_soldout); @endphp
                @forelse($available as $menu)
                    <tr>
                        <td>{{ $menu->idmenu }}</td>
                        <td>
                            @if($menu->foto)
                                <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            @else
                                <div style="width: 50px; height: 50px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    📷
                                </div>
                            @endif
                        </td>
                        <td>{{ $menu->nama_menu }}</td>
                        <td class="text-muted text-uppercase" style="font-size:12px">{{ $menu->jenis ?? '-' }}</td>
                        <td>{{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning me-1 btn-edit"
                                data-id="{{ $menu->idmenu }}"
                                data-nama="{{ $menu->nama_menu }}"
                                data-jenis="{{ $menu->jenis ?? '' }}"
                                data-harga="{{ $menu->harga }}">
                                Edit
                            </button>

                            <form action="{{ route('menu.destroy', $menu->idmenu) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                    class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>

                            <form action="{{ route('menu.toggleSoldOut', $menu->idmenu) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-secondary">
                                    🚫 Tandai Sold Out
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada menu tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Daftar Menu Sold Out --}}
    <h4 class="section-title">❌ Menu Sold Out</h4>
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nama Menu</th>
                    <th>Harga (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $sold = $menus->filter(fn($m) => $m->is_soldout); @endphp
                @forelse($sold as $menu)
                    <tr class="table-light">
                        <td>{{ $menu->idmenu }}</td>
                        <td>
                            @if($menu->foto)
                                <img src="{{ asset($menu->foto) }}" alt="{{ $menu->nama_menu }}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; opacity: 0.6;">
                            @else
                                <div style="width: 50px; height: 50px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; opacity: 0.6;">
                                    📷
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $menu->nama_menu }}
                            <span class="badge-soldout ms-2">SOLD OUT</span>
                        </td>
                        <td>{{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <form action="{{ route('menu.toggleSoldOut', $menu->idmenu) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-primary">
                                    ✅ Tandai Tersedia
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada menu sold out.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit Menu --}}
<div class="modal fade" id="modalEditMenu" tabindex="-1" aria-labelledby="modalEditMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="formEditMenu" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalEditMenuLabel">✏️ Edit Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNamaMenu" class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" id="editNamaMenu" name="nama_menu" required>
                    </div>
                    <div class="mb-3">
                        <label for="editJenisMenu" class="form-label">Jenis</label>
                        <select class="form-select" id="editJenisMenu" name="jenis" required>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editHargaMenu" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="editHargaMenu" name="harga" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="editFotoMenu" class="form-label">Foto Menu</label>
                        <input type="file" class="form-control" id="editFotoMenu" name="foto" accept="image/*">
                        <div class="form-text">Kosongkan jika tidak ingin mengubah foto</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEditMenu'));
        const formEdit = document.getElementById('formEditMenu');
        const inputNama = document.getElementById('editNamaMenu');
        const inputHarga = document.getElementById('editHargaMenu');
        const selectJenis = document.getElementById('editJenisMenu');

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                inputNama.value = btn.dataset.nama;
                inputHarga.value = btn.dataset.harga;
                selectJenis.value = btn.dataset.jenis || 'makanan';
                formEdit.action = `/menu/${id}`;
                modalEdit.show();
            });
        });
    });
</script>

</body>
</html>
