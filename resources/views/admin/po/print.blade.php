<!DOCTYPE html>
<html>
<head>
    <title>
        Purchase Order {{ $po->po_number }}
    </title>

    <link rel="icon" type="image/png" href="{{ asset('images/logopmknew.png') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            width: 100%;
            border: 1px solid #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: top;
            padding: 6px;
        }

        .logo {
            width: 80px;
        }

        .company-name {
            padding-top: 6px;
            font-size: 16px;
            font-weight: bold;
        }

        .invoice-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .invoice-subtitle {
            text-align: center;
            margin-top: 5px;
        }

        .section {
            padding: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .items-table th {
            text-align: center;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            width: 40%;
            margin-left: auto;
            margin-top: 10px;
        }

        .summary td {
            padding: 3px;
        }

        .signature {
            text-align: center;
            margin-top: 15px;
        }

        .footer {
            border-top: 1px solid #000;
            padding: 10px;
        }

        .bold {
            font-weight: bold;
        }

        .mt-20 {
            margin-top: 20px;
        }

        ol {
            margin: 5px 0 0 15px;
            padding: 0;
        }

        ol li {
            margin-bottom: 3px;
        }

        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="invoice-box">

        {{-- HEADER --}}
        <table>
            <tr>
                <td width="60%" class="section">
                    <table>
                        <tr>
                            <td width="90" style="vertical-align: top;">
                                <img src="{{ asset('images/logopmknew.png') }}" class="logo">
                            </td>
                            <td>
                                <div class="company-name">PANCA MEDIA KREASI, PT</div>
                                <div>Jl. Raya Parpostel No. 101</div>
                                <div>Kel. Jatiluhur, Kec. Jatiasih</div>
                                <div>Bekasi</div>
                                <div>Telepon: 021-38711424</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%" style="padding-top: 15px; vertical-align: top;">
                    <div class="invoice-title">PURCHASE ORDER</div>
                    <div class="invoice-subtitle">PESANAN PEMBELIAN</div>
                    <br>
                    <table style="margin-left: 35px;">
                        <tr>
                            <td width="80">Nomor</td>
                            <td>: {{ $po->po_number }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: {{ \Carbon\Carbon::parse($po->po_date)->format('d-M-y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- CUSTOMER --}}
        <table>
            <tr>
                <td width="100%" class="section">
                    <div>Kepada:</div>
                    <div class="bold" style="font-size:14px;">{{ $po->supplier->name }}</div>
                    <div>{{ $po->supplier->address ?? '-' }}</div>
                    <div style="margin-top: 5px;">Telepon: {{ $po->supplier->phone ?? '-' }}</div>
                </td>
            </tr>
        </table>

        {{-- ITEM TABLE --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">NO.</th>
                    <th width="45%">DESKRIPSI ITEM</th>
                    <th width="15%">HARGA/PCS</th>
                    <th width="15%">QUANTITY</th>
                    <th width="20%">TOTAL HARGA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po->details as $detail)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $detail->item->description ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ number_format($detail->qty, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach

                {{-- Spacing penyeimbang tinggi tabel jika item sedikit --}}
                <tr>
                    <td colspan="5" style="height: 80px;"></td>
                </tr>
            </tbody>
        </table>

        {{-- INFO & SUMMARY --}}
        <div style="display: flex; margin: 10px;">
            {{-- Term of payment --}}
            <table style="width: 60%; vertical-align: top;">
                <tr>
                    <td width="120">Term of Payment</td>
                    <td>: {{ $po->top->description ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Permintaan Kirim</td>
                    <td>: {{ \Carbon\Carbon::parse($po->delivery_date)->format('d-M-y') }} (Franco {{ $po->franco->name ?? '-' }})</td>
                </tr>
            </table>
    
            {{-- TOTAL --}}
            <table class="summary" style="width: 40%; margin-top: 0;">
                <tr>
                    <td>Total</td>
                    <td width="20">Rp</td>
                    <td class="text-right">{{ number_format($po->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PPN 11%</td>
                    <td>Rp</td>
                    <td class="text-right">{{ number_format($po->tax, 0, ',', '.') }}</td>
                </tr>
                <tr class="bold">
                    <td>Total + PPN</td>
                    <td>Rp</td>
                    <td class="text-right">{{ number_format($po->grand_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- CATATAN / S&K --}}
        <div class="footer">
            <div class="bold">Catatan:</div>
            <ol>
                <li>Produk yang dikirim harus memenuhi persyaratan spesifikasi teknis yang sesuai dengan pesanan dan kesepakatan spesifikasi yang disetujui sebelumnya oleh PT Panca Media Kreasi</li>
                <li>Apabila produk yang diterima mengalami cacat atau dalam keadaan tidak baik maka PT Panca Media Kreasi berhak melakukan retur barang</li>
                <li>Cara pembayaran melalui transfer bank sesuai dengan kesepakatan term of payment dan PT Panca Media Kreasi sudah menerima seluruh dokumen tagihan beserta kelengkapannya</li>
                <li>Kelengkapan tagihan adalah invoice bermaterai, surat jalan/tanda terima yang asli, dan copy PO yang sudah ditandatangani</li>
                <li>Tagihan ditujukan ke PT Panca Media Kreasi</li>
            </ol>
            @if($po->notes)
                <div class="mt-20" style="white-space: pre-line;">
                    <strong>Notes Tambahan:</strong><br>{{ $po->notes }}
                </div>
            @endif
        </div>

        {{-- SIGNATURES --}}
        <div class="footer" style="padding: 0;">
            <table style="width: 100%; text-align: center; border-collapse: collapse;">
                <tr>
                    <td width="33%" style="border-right: 1px solid #000; padding: 10px; vertical-align: top;">
                        <div class="bold">{{ $po->supplier->name }}</div>
                        <div class="signature">
                            Diterima
                            <br><br><br><br><br>
                            <div style="border-bottom: 1px dashed #000; width: 80%; margin: 0 auto;"></div>
                        </div>
                    </td>
                    <td width="67%" colspan="2" style="padding: 10px; vertical-align: top;">
                        <div class="bold">PANCA MEDIA KREASI, PT</div>
                        <table style="width: 100%; margin-top: 15px;">
                            <tr>
                                <td width="50%">
                                    <div>Disetujui</div>
                                    <br><br><br><br>
                                    <div class="bold">Buana Hegar Manah</div>
                                </td>
                                <td width="50%">
                                    <div>Dibuat</div>
                                    <br><br><br><br>
                                    <div class="bold">Chairul Rijal</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>