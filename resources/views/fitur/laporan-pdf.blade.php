<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Transaksi</title>
<style>
  @page { margin: 24px; }
  body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #222; }
  .header { text-align: center; margin-bottom: 12px; }
  .header .title { font-size: 18px; font-weight: 700; }
  .meta { text-align: center; font-size: 11px; color: #555; margin-bottom: 14px; }
  .grid { width: 100%; border-collapse: collapse; }
  .grid th, .grid td { border: 1px solid #999; padding: 6px 8px; }
  .grid thead th { background: #efefef; font-weight: 700; }
  .section { margin-top: 16px; }
  .kpi { width: 100%; border-collapse: collapse; margin-top: 4px; }
  .kpi td { border: 1px solid #bbb; padding: 8px; }
  .kpi .label { background: #f6f6f6; font-weight: 600; width: 45%; }
  .right { text-align: right; }
  .center { text-align: center; }
  .small { font-size: 11px; color: #666; }
</style>
</head>
<body>
  <div class="header">
    <div class="title">Laporan BilSky Restoran</div>
  </div>
  <div class="meta">
    Periode: {{ $from ?: '-' }} s/d {{ $to ?: '-' }} · Dicetak: {{ date('d/m/Y H:i') }}
  </div>

  <div class="section">
    <table class="kpi">
      <tr>
        <td class="label">Omzet Diterima (uang masuk)</td>
        <td class="right">Rp {{ number_format($omzetDiterima ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Total Tagihan (semua pesanan)</td>
        <td class="right">Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Piutang (belum dibayar)</td>
        <td class="right">Rp {{ number_format($piutang ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">HPP ({{ (float)($hppPercent ?? 0) }}%)</td>
        <td class="right">Rp {{ number_format($hpp ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Biaya Operasional</td>
        <td class="right">Rp {{ number_format($biayaOperasional ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Laba Kotor (Total Tagihan - HPP)</td>
        <td class="right">Rp {{ number_format($labaKotor ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Laba Bersih (Laba Kotor - Opex)</td>
        <td class="right">Rp {{ number_format($labaBersih ?? 0, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td class="label">Ringkasan Transaksi (Lunas / Belum / Total)</td>
        <td class="right">{{ (int)($jumlahLunas ?? 0) }} / {{ (int)($jumlahBelum ?? 0) }} / {{ (int)($jumlahItem ?? 0) }}</td>
      </tr>
    </table>
  </div>

  <div class="section">
    <div class="small" style="margin-bottom:6px; font-weight:600;">Menu Paling Favorit</div>
    <table class="grid">
      <thead>
        <tr>
          <th class="center" style="width:36px;">#</th>
          <th>Menu</th>
          <th class="center" style="width:80px;">Qty</th>
          <th class="right" style="width:140px;">Omzet Diterima</th>
        </tr>
      </thead>
      <tbody>
        @php $i=1; @endphp
        @forelse(($menuFavorit ?? []) as $fav)
        <tr>
          <td class="center">{{ $i++ }}</td>
          <td>{{ $fav['nama_menu'] }}</td>
          <td class="center">{{ (int)$fav['qty'] }}</td>
          <td class="right">Rp {{ number_format($fav['omzet_diterima'], 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="center small">Tidak ada data.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="section">
    <div class="small" style="margin-bottom:6px; font-weight:600;">Rincian Transaksi</div>
    <table class="grid">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th class="center" style="width:50px;">Meja</th>
          <th class="center" style="width:70px;">Pelanggan</th>
          <th>Menu</th>
          <th class="center" style="width:60px;">Qty</th>
          <th class="right" style="width:100px;">Harga</th>
          <th class="right" style="width:120px;">Subtotal</th>
          <th class="right" style="width:120px;">Bayar</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $r)
        <tr>
          <td>{{ $r->created_at }}</td>
          <td class="center">{{ $r->id_meja }}</td>
          <td class="center">{{ $r->idpelanggan }}</td>
          <td>{{ $r->nama_menu }}</td>
          <td class="center">{{ (int)$r->jumlah }}</td>
          <td class="right">Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
          <td class="right">Rp {{ number_format($r->total, 0, ',', '.') }}</td>
          <td class="right">{!! ($r->bayar && $r->bayar>0) ? 'Rp '.number_format($r->bayar,0,',','.') : '-' !!}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
