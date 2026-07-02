
<!DOCTYPE html>
<html>
<head>
    <title>
        Invoice {{ $invoice->nomor_invoice }}
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
                            <td width="90">
                                <img
                                    src="{{asset('images/logopmknew.png')}}"
                                    class="logo">
                            </td>
                            <td>
                                <div class="company-name">
                                    PANCA MEDIA KREASI, PT
                                </div>
                                <div>
                                    Jl. Raya Parpostel No. 101
                                </div>
                                <div>
                                    Kel. Jatiluhur, Kec. Jatiasih
                                </div>
                                <div>
                                    Bekasi
                                </div>
                                <div>
                                    Telepon: 021-38711424
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="40%">
                    <div class="invoice-title">
                        SALES INVOICE
                    </div>
                    <div class="invoice-subtitle">
                        FAKTUR PENJUALAN
                    </div>
                    <br>
                    <table style="margin-left: 30px">
                        <tr>
                            <td width="80">
                                Nomor
                            </td>

                            <td>
                                :
                                {{ $invoice->nomor_invoice }}
                            </td>

                        </tr>

                        <tr>

                            <td>
                                Tanggal
                            </td>

                            <td>
                                :
                                {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d-M-y') }}
                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        {{-- CUSTOMER --}}
        <table>

            <tr>

                <td width="65%" class="section">

                    <div>
                        Kepada:
                    </div>

                    <div class="bold" style="font-size:16px;">
                        {{ $invoice->customer->nama_customer }}
                    </div>

                    <div>
                        {{ $invoice->customer->alamat ?? '-' }}
                    </div>

                    <br>

                    <div>
                        Telepon:
                        {{ $invoice->customer->telepon ?? '-' }}
                    </div>

                </td>

                <td width="35%" class="section">

                    <table>

                        <tr>

                            <td width="80">
                                No. SO
                            </td>

                            <td>
                                :

                                {{ $invoice->deliveryOrders
                                        ->pluck('sales_order.nomor_so')
                                        ->unique()
                                        ->implode(', ')
                                }}
                            </td>

                        </tr>

                        <tr>

                            <td>
                                No. PO
                            </td>

                            <td>
                                :
                                {{ $invoice->deliveryOrders
                                        ->pluck('nomor_po')
                                        ->unique()
                                        ->implode(', ')
                                }}
                            </td>

                        </tr>

                    </table>

                </td>

            </tr>

        </table>

        {{-- ITEM TABLE --}}
        <table class="items-table">

            <thead>

                <tr>

                    <th width="5%">
                        No.
                    </th>

                    <th width="40%">
                        Deskripsi Item
                    </th>

                    <th width="15%">
                        No. DO
                    </th>

                    <th width="15%">
                        Harga/Pcs
                    </th>

                    <th width="10%">
                        Quantity
                    </th>

                    <th width="15%">
                        Total Harga
                    </th>

                </tr>

            </thead>

            <tbody>
                @foreach($invoice->details as $detail)

                <tr>

                    <td align="center">
                        {{ $loop->iteration }}
                    </td>

                    <td align="center">
                        {{ $detail->salesOrderDetail->item->deskripsi }}
                    </td>

                    <td align="center">

                        {{ $detail->deliveryOrderDetail->deliveryOrder->nomor_do }}

                    </td>

                    <td align="center">
                        Rp {{ number_format($detail->harga) }}
                    </td>

                    <td align="center">
                        {{ $detail->qty }}
                    </td>

                    <td align="center">
                        Rp {{ number_format($detail->subtotal) }}
                    </td>

                </tr>

                @endforeach

                {{-- EMPTY SPACE --}}
                <tr>

                    <td colspan="6" style="height:250px;"></td>

                </tr>

            </tbody>

        </table>

        {{-- TOTAL --}}
        <table class="summary">

            <tr>

                <td>
                    Total
                </td>

                <td width="20">
                    Rp
                </td>

                <td class="text-right">

                    {{ number_format($invoice->total_dpp, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <td>
                    PPN 11%
                </td>

                <td>
                    Rp
                </td>

                <td class="text-right">

                    {{ number_format($invoice->ppn_total, 0, ',', '.') }}

                </td>

            </tr>

            <tr class="bold">

                <td>
                    Total + PPN
                </td>

                <td>
                    Rp
                </td>

                <td class="text-right">

                    {{ number_format($invoice->grand_total, 0, ',', '.') }}

                </td>

            </tr>

            <tr>
                <td>
                    Total Pembayaran
                </td>

                <td>
                    Rp
                </td>

                <td class="text-right">

                    {{ number_format($totalDibayar, 0, ',', '.') }}

                </td>
            </tr>

            <tr class="bold">

                <td>
                    Sisa Tagihan
                </td>

                <td>
                    Rp
                </td>

                <td class="text-right">

                    {{ number_format($sisaTagihan, 0, ',', '.') }}

                </td>

            </tr>

        </table>

        {{-- FOOTER --}}
        <div class="footer">

            <table>

                <tr>

                    <td width="60%">

                        <div class="bold">
                            Catatan:
                        </div>

                        <div class="mt-20">

                            Pembayaran Mohon di Transfer ke Rekening
                            Panca Media Kreasi

                            <br>

                            <span class="bold">
                                Bank Mandiri KCP Cyber 2 Tower
                                124-0011976801
                            </span>

                        </div>

                    </td>

                    <td width="40%">

                        <div class="signature">

                            Hormat kami,

                            <br><br><br><br>

                            <div class="bold">

                                HARMOKO COKRO Y.
                                {{-- {{ $invoice->deliveryOrder->sales_order->sales->name ?? '-' }} --}}

                            </div>

                        </div>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</body>
</html>
