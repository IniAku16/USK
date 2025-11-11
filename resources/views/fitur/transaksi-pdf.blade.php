<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .restaurant-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .restaurant-address {
            font-size: 10px;
            color: #666;
        }
        
        .transaction-info {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .items-table .text-right {
            text-align: right;
        }
        
        .items-table .text-center {
            text-align: center;
        }
        
        .total-section {
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .total-label {
            font-weight: bold;
        }
        
        .total-amount {
            font-weight: bold;
            font-size: 14px;
        }
        
        .status-section {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .status-lunas {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-belum-lunas {
            color: #ffc107;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="restaurant-name">RESTORAN BILSKY</div>
        <div class="restaurant-address">Jl. kenangan bersamanya tak akan terlupakan</div>
        <div class="restaurant-address">Telp: (021) 1234-5678</div>
    </div>

    <div class="transaction-info">
        <div class="info-row">
            <span class="info-label">No. Transaksi:</span>
            <span>#{{ $transaksi->idtransaksi }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal:</span>
            <span>{{ date('d/m/Y H:i', strtotime($transaksi->created_at)) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Pelanggan:</span>
            <span>{{ $transaksi->nama_pelanggan }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Meja:</span>
            <span>{{ $transaksi->id_meja }}</span>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_menu }}</td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($item->total / $item->jumlah, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <span class="total-label">Total Pesanan:</span>
            <span class="total-amount">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
        </div>
        
        @if($total_bayar > 0)
            <div class="total-row">
                <span class="total-label">Dibayar:</span>
                <span class="total-amount">Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span class="total-label">Kembalian:</span>
                <span class="total-amount">Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    <div class="status-section">
        <div class="info-row">
            <span class="info-label">Status Pembayaran:</span>
            <span class="{{ $is_lunas ? 'status-lunas' : 'status-belum-lunas' }}">
                {{ $is_lunas ? 'LUNAS' : 'BELUM LUNAS' }}
            </span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima kasih telah berkunjung!</p>
        <p>Struk ini adalah bukti transaksi yang sah</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
