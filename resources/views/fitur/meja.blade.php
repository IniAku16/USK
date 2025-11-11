<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Meja</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
        background: linear-gradient(to bottom right, #EAF4FF, #CFE5FF);
        font-family: 'Poppins', sans-serif;
        color: #2d3748;
        min-height: 100vh;
    }

    h2 {
        color: #2D6EE0;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        background-color: #ffffff;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #5EB8FF, #4A90E2);
        color: white !important;
        font-weight: 600;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    /* Tombol utama */
    .btn-primary {
        background: linear-gradient(135deg, #5EB8FF, #4A90E2);
        border: none;
        color: #fff;
        font-weight: 500;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(74, 144, 226, 0.3);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #4A90E2, #357ABD);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        color: #fff;
        transform: scale(1.03);
    }

    /* Tombol lain */
    .btn-outline-danger {
        border-radius: 10px;
        border-color: #F45B69;
        color: #F45B69;
        font-weight: 500;
    }

    .btn-outline-danger:hover {
        background-color: #F45B69;
        color: white;
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

    .form-control {
        border-radius: 10px;
        border: 1px solid #cfe1ff;
        background-color: #f8fafc;
        color: #334155;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #5EB8FF;
        box-shadow: 0 0 0 0.25rem rgba(94, 184, 255, 0.25);
    }

    /* Warna tabel */
    .table thead th {
        background: linear-gradient(90deg, #5EB8FF, #4A90E2);
        color: #fff;
        border: none;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.1);
    }

    .alert-success {
        background-color: #ecfdf5;
        border: 1px solid #6ee7b7;
        color: #065f46;
        border-radius: 10px;
    }

    /* Layout visual meja */
    .layout-meja {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 30px;
        margin-top: 20px;
        justify-items: center;
        padding: 30px;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 20px;
        border: 2px dashed #cbd5e1;
        min-height: 300px;
    }

    .meja-container {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 15px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        border: 2px solid transparent;
    }

    .meja-container:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        border-color: #5EB8FF;
    }

    .meja-container.selected {
        transform: translateY(-5px) scale(1.05);
        border-color: #4A90E2;
        box-shadow: 0 10px 25px rgba(74, 144, 226, 0.3);
    }

    .meja-bulat {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border: 4px solid;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        margin-bottom: 15px;
    }

    .meja-bulat.tersedia {
        border-color: #10b981;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    }

    .meja-bulat.tersedia:hover {
        box-shadow: 0 12px 25px rgba(16, 185, 129, 0.3);
    }

    .meja-bulat.tidak-tersedia {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2, #fecaca);
    }

    .meja-bulat.tidak-tersedia:hover {
        box-shadow: 0 12px 25px rgba(239, 68, 68, 0.3);
    }

    .meja-info {
        text-align: center;
        margin-bottom: 15px;
    }

    .meja-nomor {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .meja-kapasitas {
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 500;
    }

    .meja-status {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .meja-status.tersedia {
        background-color: #10b981;
    }

    .meja-status.tidak-tersedia {
        background-color: #ef4444;
    }

    /* Kursi di sekeliling meja */
    .kursi {
        position: absolute;
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .kursi:hover {
        transform: scale(1.2);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    /* Tombol aksi yang muncul saat meja dipilih */
    .meja-actions {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        padding: 20px;
        margin-top: 15px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 10;
        min-width: 180px;
        border: 2px solid #e2e8f0;
    }

    .meja-container.selected .meja-actions {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    .meja-actions .btn {
        margin: 3px;
        font-size: 0.85rem;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        width: 100%;
    }

    /* Animasi untuk kursi */
    @keyframes kursiPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .kursi.animate {
        animation: kursiPulse 1s ease-in-out infinite;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .layout-meja {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        
        .meja-container {
            padding: 10px;
        }
        
        .meja-bulat {
            width: 100px;
            height: 100px;
        }
        
        .meja-actions {
            min-width: 150px;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .layout-meja {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            padding: 15px;
        }
        
        .meja-bulat {
            width: 80px;
            height: 80px;
        }
        
        .meja-nomor {
            font-size: 1rem;
        }
        
        .meja-kapasitas {
            font-size: 0.8rem;
        }
    }

    /* Preview meja di SweetAlert */
    .swal2-html-container .preview-meja-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 2px dashed #cbd5e1;
    }

    .preview-meja {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        transition: all 0.3s ease;
    }

    .preview-meja.tersedia {
        border-color: #10b981;
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    }

    .preview-meja.tidak-tersedia {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2, #fecaca);
    }

    .preview-kursi {
        position: absolute;
        width: 16px;
        height: 16px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .preview-meja-info {
        text-align: center;
        margin-top: 8px;
    }

    .preview-meja-nomor {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1f2937;
    }

    .preview-meja-kapasitas {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .preview-status-dot {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .preview-status-dot.tersedia {
        background-color: #10b981;
    }

    .preview-status-dot.tidak-tersedia {
        background-color: #ef4444;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>

<body>
  <div class="container mt-5 fade-in">
    <h2 class="text-center mb-4">Manajemen Meja</h2>

    <div class="text-center mb-4">
      @include('partials.back-to-dashboard')
    </div>

    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <!-- Form Tambah Meja -->
    <div class="card mb-4">
      <div class="card-header">Tambah Meja Baru</div>
      <div class="card-body">
        <form action="{{ route('meja.store') }}" method="POST" class="row g-3">
          @csrf
          <div class="col-md-5">
            <label for="nomor_meja" class="form-label">Nomor Meja</label>
            <input type="text" name="nomor_meja" id="nomor_meja" class="form-control" placeholder="Contoh: A1" required>
          </div>
          <div class="col-md-5">
            <label for="kapasitas" class="form-label">Kapasitas</label>
            <input type="number" name="kapasitas" id="kapasitas" class="form-control" placeholder="Contoh: 4" min="1" required>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Tambah</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Daftar Meja -->
    <div class="card mb-4">
      <div class="card-header">Daftar Meja</div>
      <div class="card-body">
        <table class="table table-bordered text-center align-middle table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nomor Meja</th>
              <th>Kapasitas</th>
              <th>Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($meja as $index => $m)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $m['nomor_meja'] }}</td>
                <td>{{ $m['kapasitas'] }}</td>
                <td>{{ $m['created_at'] }}</td>
                <td>
                  <a href="{{ route('meja.destroy', $m['id']) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus meja ini?')">Hapus</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-muted">Belum ada data meja.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Layout Visual Meja -->
    <div class="card mb-5">
      <div class="card-header">Layout Meja</div>
      <div class="card-body">
        <div class="layout-meja">
          @forelse($meja as $m)
            @php
              // Simulasi status meja - dalam implementasi nyata, ini bisa dari database
              $statusMeja = rand(0, 1) ? 'tersedia' : 'tidak-tersedia';
            @endphp
            <div class="meja-container" data-meja-id="{{ $m['id'] }}" data-nomor="{{ $m['nomor_meja'] }}" data-kapasitas="{{ $m['kapasitas'] }}" data-status="{{ $statusMeja }}" onclick="selectMeja(this)">
              <div class="meja-bulat {{ $statusMeja }}">
                <div class="meja-status {{ $statusMeja }}"></div>
                
                <!-- Kursi di sekeliling meja -->
                @for($i = 0; $i < $m['kapasitas']; $i++)
                  @php
                    $angle = ($i * 360) / $m['kapasitas'];
                    $radian = deg2rad($angle);
                    $x = 50 + 40 * cos($radian);
                    $y = 50 + 40 * sin($radian);
                  @endphp
                  <div class="kursi" style="left: {{ $x }}%; top: {{ $y }}%;"></div>
                @endfor
                
                <div class="meja-info">
                  <div class="meja-nomor">{{ $m['nomor_meja'] }}</div>
                  <div class="meja-kapasitas">{{ $m['kapasitas'] }} kursi</div>
                </div>
              </div>
              
              <!-- Tombol aksi yang muncul saat meja dipilih -->
              <div class="meja-actions">
                @if($statusMeja === 'tersedia')
                  <a href="{{ route('pesanan.index', ['id_meja' => $m['id']]) }}" class="btn btn-primary btn-sm w-100 mb-2">
                    <i class="fas fa-utensils"></i> Pesan
                  </a>
                @else
                  <button class="btn btn-secondary btn-sm w-100 mb-2" disabled>
                    <i class="fas fa-ban"></i> Terisi
                  </button>
                @endif
                <button class="btn btn-outline-warning btn-sm w-100 mb-2" onclick="editMeja({{ $m['id'] }}, '{{ $m['nomor_meja'] }}', {{ $m['kapasitas'] }}, '{{ $statusMeja }}')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <a href="{{ route('meja.destroy', $m['id']) }}" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Hapus meja ini?')">
                  <i class="fas fa-trash"></i> Hapus
                </a>
              </div>
            </div>
          @empty
            <p class="text-muted text-center w-100">Belum ada meja ditambahkan.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <script>
    function selectMeja(element) {
      // Hapus class selected dari semua meja
      document.querySelectorAll('.meja-container').forEach(meja => {
        meja.classList.remove('selected');
      });
      
      // Tambah class selected ke meja yang diklik
      element.classList.add('selected');
      
      // Tambahkan animasi pada kursi
      const kursi = element.querySelectorAll('.kursi');
      kursi.forEach((k, index) => {
        setTimeout(() => {
          k.classList.add('animate');
          setTimeout(() => {
            k.classList.remove('animate');
          }, 1000);
        }, index * 100);
      });
    }

    function editMeja(id, nomor, kapasitas, status) {
      // Fungsi untuk membuat preview meja
      function createPreviewMeja(nomor, kapasitas, status) {
        let kursiHtml = '';
        for (let i = 0; i < kapasitas; i++) {
          const angle = (i * 360) / kapasitas;
          const radian = (angle * Math.PI) / 180;
          const x = 50 + 35 * Math.cos(radian);
          const y = 50 + 35 * Math.sin(radian);
          kursiHtml += `<div class="preview-kursi" style="left: ${x}%; top: ${y}%;"></div>`;
        }

        return `
          <div class="preview-meja-container">
            <div class="preview-meja ${status}">
              <div class="preview-status-dot ${status}"></div>
              ${kursiHtml}
              <div class="preview-meja-info">
                <div class="preview-meja-nomor">${nomor}</div>
                <div class="preview-meja-kapasitas">${kapasitas} kursi</div>
              </div>
            </div>
          </div>
        `;
      }

      // Fungsi untuk update preview
      function updatePreview() {
        const nomor = document.getElementById('edit-nomor').value;
        const kapasitas = parseInt(document.getElementById('edit-kapasitas').value);
        const status = document.getElementById('edit-status').value;
        
        const previewContainer = document.querySelector('.preview-meja-container');
        if (previewContainer) {
          previewContainer.innerHTML = createPreviewMeja(nomor, kapasitas, status).replace('<div class="preview-meja-container">', '').replace('</div>', '');
        }
      }

      Swal.fire({
        title: 'Edit Meja',
        html: `
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit-nomor" class="form-label">Nomor Meja</label>
                <input type="text" id="edit-nomor" class="form-control" value="${nomor}">
              </div>
              <div class="mb-3">
                <label for="edit-kapasitas" class="form-label">Kapasitas</label>
                <input type="number" id="edit-kapasitas" class="form-control" value="${kapasitas}" min="1" max="12">
              </div>
              <div class="mb-3">
                <label for="edit-status" class="form-label">Status</label>
                <select id="edit-status" class="form-select">
                  <option value="tersedia" ${status === 'tersedia' ? 'selected' : ''}>Tersedia</option>
                  <option value="tidak-tersedia" ${status === 'tidak-tersedia' ? 'selected' : ''}>Tidak Tersedia</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              ${createPreviewMeja(nomor, kapasitas, status)}
            </div>
          </div>
        `,
        width: '700px',
        showCancelButton: true,
        confirmButtonText: 'Simpan Perubahan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#4A90E2',
        cancelButtonColor: '#6c757d',
        didOpen: () => {
          // Event listeners untuk update preview real-time
          document.getElementById('edit-nomor').addEventListener('input', updatePreview);
          document.getElementById('edit-kapasitas').addEventListener('input', updatePreview);
          document.getElementById('edit-status').addEventListener('change', updatePreview);
        },
        preConfirm: () => {
          const nomor = document.getElementById('edit-nomor').value;
          const kapasitas = parseInt(document.getElementById('edit-kapasitas').value);
          const status = document.getElementById('edit-status').value;

          if (!nomor.trim()) {
            Swal.showValidationMessage('Nomor meja tidak boleh kosong');
            return false;
          }

          if (kapasitas < 1 || kapasitas > 12) {
            Swal.showValidationMessage('Kapasitas harus antara 1-12 kursi');
            return false;
          }

          return {
            nomor: nomor.trim(),
            kapasitas: kapasitas,
            status: status
          };
        }
      }).then((result) => {
        if (result.isConfirmed) {
          // Simulasi update meja (dalam implementasi nyata, ini akan mengirim request ke server)
          const mejaElement = document.querySelector(`[data-meja-id="${id}"]`);
          if (mejaElement) {
            // Update data attributes
            mejaElement.setAttribute('data-nomor', result.value.nomor);
            mejaElement.setAttribute('data-kapasitas', result.value.kapasitas);
            mejaElement.setAttribute('data-status', result.value.status);

            // Update tampilan meja
            const mejaBulat = mejaElement.querySelector('.meja-bulat');
            const mejaStatus = mejaElement.querySelector('.meja-status');
            const mejaNomor = mejaElement.querySelector('.meja-nomor');
            const mejaKapasitas = mejaElement.querySelector('.meja-kapasitas');

            // Update class status
            mejaBulat.className = `meja-bulat ${result.value.status}`;
            mejaStatus.className = `meja-status ${result.value.status}`;

            // Update info
            mejaNomor.textContent = result.value.nomor;
            mejaKapasitas.textContent = `${result.value.kapasitas} kursi`;

            // Update kursi
            const kursiContainer = mejaBulat;
            const existingKursi = kursiContainer.querySelectorAll('.kursi');
            existingKursi.forEach(kursi => kursi.remove());

            // Tambahkan kursi baru
            for (let i = 0; i < result.value.kapasitas; i++) {
              const angle = (i * 360) / result.value.kapasitas;
              const radian = (angle * Math.PI) / 180;
              const x = 50 + 40 * Math.cos(radian);
              const y = 50 + 40 * Math.sin(radian);
              
              const kursi = document.createElement('div');
              kursi.className = 'kursi';
              kursi.style.left = `${x}%`;
              kursi.style.top = `${y}%`;
              kursiContainer.appendChild(kursi);
            }

            // Update tombol aksi
            const actionsContainer = mejaElement.querySelector('.meja-actions');
            const pesanButton = actionsContainer.querySelector('.btn-primary, .btn-secondary');
            
            if (result.value.status === 'tersedia') {
              pesanButton.className = 'btn btn-primary btn-sm w-100 mb-2';
              pesanButton.innerHTML = '<i class="fas fa-utensils"></i> Pesan';
              pesanButton.disabled = false;
            } else {
              pesanButton.className = 'btn btn-secondary btn-sm w-100 mb-2';
              pesanButton.innerHTML = '<i class="fas fa-ban"></i> Terisi';
              pesanButton.disabled = true;
            }
          }

          Swal.fire({
            title: 'Berhasil!',
            text: 'Meja berhasil diperbarui',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
          });
        }
      });
    }

    // Klik di luar meja untuk menutup aksi
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.meja-container')) {
        document.querySelectorAll('.meja-container').forEach(meja => {
          meja.classList.remove('selected');
        });
      }
    });

    // Animasi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      const mejaContainers = document.querySelectorAll('.meja-container');
      mejaContainers.forEach((meja, index) => {
        setTimeout(() => {
          meja.style.opacity = '0';
          meja.style.transform = 'translateY(20px)';
          meja.style.transition = 'all 0.5s ease';
          
          setTimeout(() => {
            meja.style.opacity = '1';
            meja.style.transform = 'translateY(0)';
          }, 50);
        }, index * 100);
      });
    });
  </script>
</body>
</html>
