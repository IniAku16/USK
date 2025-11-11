<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pelanggan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom right, #EAF4FF, #CFE5FF);
      font-family: 'Poppins', sans-serif;
      color: #2d3748;
      min-height: 100vh;
      padding: 50px 20px;
    }

    .container-custom {
      max-width: 1100px;
      margin: 0 auto;
      background: #ffffffcc;
      backdrop-filter: blur(8px);
      border-radius: 18px;
      box-shadow: 0 8px 30px rgba(90, 150, 255, 0.12);
      padding: 40px 50px;
    }

    h2 {
      color: #2D6EE0;
      font-weight: 700;
      text-align: center;
      margin-bottom: 15px;
      text-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .subtitle {
      color: #64748b;
      text-align: center;
      margin-bottom: 40px;
    }

    .form-section {
      background: white;
      border-radius: 16px;
      padding: 25px 30px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      margin-bottom: 35px;
    }

    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid #d0e3ff;
      background-color: #f8fbff;
      transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: #5EB8FF;
      box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
    }

    .btn-primary {
      background: linear-gradient(135deg, #5EB8FF, #4A90E2);
      border: none;
      color: #fff;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(74, 144, 226, 0.3);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #4A90E2, #357ABD);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
    }

    .btn-outline-secondary {
      border-color: #4A90E2;
      color: #4A90E2;
      font-weight: 500;
      border-radius: 8px;
    }

    .btn-outline-secondary:hover {
      background: #4A90E2;
      color: white;
    }

    .table-wrapper {
      background: white;
      border-radius: 16px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
      overflow: hidden;
    }

    table {
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 0;
    }

    thead th {
      background: linear-gradient(90deg, #5EB8FF, #4A90E2);
      color: #fff;
      border: none;
      text-align: center;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: #F9FBFF;
    }

    .table-hover tbody tr:hover {
      background-color: rgba(74, 144, 226, 0.08);
    }

    .btn-success {
      background-color: #86EFAC;
      border: none;
      color: #064E3B;
      border-radius: 6px;
    }

    .btn-danger {
      background-color: #F45B69;
      border: none;
      color: white;
      border-radius: 6px;
    }

    .alert {
      border-radius: 12px;
      font-size: 0.95rem;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #94A3B8;
      margin-top: 50px;
    }
  </style>
</head>

<body>
  <div class="container-custom fade-in">
    <h2>Manajemen Pelanggan</h2>
    <p class="subtitle">Silahkan Mengisi Data Pelanggan dengan Benar</p>

    @include('partials.back-to-dashboard')

    @if (session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="form-section">
      <h5 class="mb-3 text-primary fw-semibold">Tambah Pelanggan</h5>
      <form action="{{ route('pelanggan.store') }}" method="POST" class="row g-3 align-items-center">
        @csrf
        <div class="col-md-3">
          <input type="text" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" required>
        </div>
        <div class="col-md-2">
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">Gender</option>
            <option value="1">Laki-laki</option>
            <option value="0">Perempuan</option>
          </select>
        </div>
        <div class="col-md-2">
          <input type="text" name="no_hp" class="form-control" placeholder="No HP">
        </div>
        <div class="col-md-3">
          <input type="text" name="alamat" class="form-control" placeholder="Alamat">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Tambah</button>
        </div>
      </form>
    </div>

    <div class="table-wrapper mt-4">
      <table class="table table-striped table-hover align-middle text-center mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Gender</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th style="width: 150px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pelanggan as $index => $p)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td><input type="text" name="nama_pelanggan" value="{{ $p->nama_pelanggan }}" class="form-control form-control-sm text-center" form="update-{{ $p->idpelanggan }}"></td>
              <td>
                <select name="jenis_kelamin" class="form-select form-select-sm text-center" form="update-{{ $p->idpelanggan }}">
                  <option value="1" {{ $p->jenis_kelamin == 1 ? 'selected' : '' }}>L</option>
                  <option value="0" {{ $p->jenis_kelamin == 0 ? 'selected' : '' }}>P</option>
                </select>
              </td>
              <td><input type="text" name="no_hp" value="{{ $p->no_hp }}" class="form-control form-control-sm text-center" form="update-{{ $p->idpelanggan }}"></td>
              <td><input type="text" name="alamat" value="{{ $p->alamat }}" class="form-control form-control-sm text-center" form="update-{{ $p->idpelanggan }}"></td>
              <td>
                <form id="update-{{ $p->idpelanggan }}" action="{{ route('pelanggan.update', $p->idpelanggan) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
                <form action="{{ route('pelanggan.destroy', $p->idpelanggan) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pelanggan ini?')">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-muted">Belum ada data pelanggan.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
