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
            padding: 10px;
        }

        .logo {
            width: 80px;
        }

        .company-name {
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
            margin-top: 30px;
        }

        .footer {
            border-top: 1px solid #000;
            padding: 10px;
            margin-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        .mt-20 {
            margin-top: 20px;
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
        <table class="header">
            <tr>
                <td width="60%">
                    <table>
                        <tr>
                            {{-- <td width="90">
                                <img
                                    src="{{asset('images/logopmknew.png')}}"
                                    class="logo">
                            </td> --}}
                            <td>
                                <div class="company-name">
                                    HARMOKO COKRO YUWONO
                                </div>
                                <div>
                                    Perumahan Ciluar Residence RT 02/RW 14 Blok D2 No. 2
                                </div>
                                <div>
                                    Desa Cijujung, Kecamatan Sukaraja
                                </div>
                                <div>
                                    Kabupaten Bogor 16710
                                </div>
                                <div>
                                    Telepon: 0821-9408-0070
                                </div>
                            </td>
                        </tr>
                    </table>    
                </td>
                <td width="40%">
                    <div class="invoice-title">
                        PURCHASE ORDER
                    </div>
                    <div class="invoice-subtitle">
                        SURAT PESANAN
                    </div>
                    <br>
                    <table style="margin-left: 30px">
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
                <td width="65%" class="section">
                    <div>Kepada:</div>
                    <div class="bold" style="font-size:16px;">{{ $po->supplier->name }}</div>
                    <div>{{ $po->supplier->address ?? '-' }}</div>
                    <br>
                    <div>Telepon: {{ $po->supplier->phone ?? '-' }}</div>
                </td>

                <td width="35%" class="section">
                    <table>
                        <tr>
                            <td width="80">Supplier</td>
                            <td>: {{ $po->supplier->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>TOP</td>
                            <td>: {{ $po->top->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Franco</td>
                            <td>: {{ $po->franco->name ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- ITEM TABLE --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="50%">Deskripsi Item</th>
                    <th width="15%">Harga/Pcs</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po->details as $detail)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $detail->item->description ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->price,0,',','.') }}</td>
                    <td align="center">{{ $detail->qty }}</td>
                    <td class="text-right">Rp {{ number_format($detail->qty * $detail->price,0,',','.') }}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="5" style="height:200px;"></td>
                </tr>
            </tbody>
        </table>


        <div class="row" style="display:flex; margin-top: 10px;">

            {{-- Term of payment --}}
            <table style="margin-top: 10px;">
                <tr>
                    <td width="120">Term of Payment</td>
                    <td>: {{ $po->top->description ?? '-' }}</td>
                </tr>
                <tr>
                    <td width="120">Permintaan Kirim</td>
                    <td>: {{ \Carbon\Carbon::parse($po->delivery_date)->format('d-M-y') }}</td>
                </tr>
                <tr>
                    <td>Franco</td>
                    <td>: {{ $po->franco->name ?? '-' }}</td>
                </tr>
            </table>
    
            {{-- TOTAL --}}
            <table class="summary">
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


        {{-- FOOTER --}}
        <div class="footer">
            <table>
                <tr>
                    <td width="60%">
                        <div class="bold">Catatan:</div>
                        <div class="mt-20">
                            {{ $po->notes ?? '—' }}
                        </div>
                    </td>
                    <td width="40%">
                        <div class="signature">
                            Hormat kami,
                            <br><br><br><br>
                            <div class="bold">PANCA MEDIA KREASI, PT</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>