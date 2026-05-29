<!DOCTYPE html>
<html>
<head>
    <title>
        Delivery Order {{ $do->nomor_do }}
    </title>

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

        .do-box {
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

        .do-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .do-subtitle {
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

        .signature {
            text-align: center;
            margin-top: 40px;
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

    <div class="do-box">

        {{-- HEADER --}}
        <table class="header">

            <tr>

                <td width="60%">

                    <table>

                        <tr>

                            <td width="90">

                                <img
                                    src="{{ asset('images/logopmk.png') }}"
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

                    <div class="do-title">
                        DELIVERY ORDER
                    </div>

                    <div class="do-subtitle">
                        SURAT KIRIM
                    </div>

                    <br>

                    <table>

                        <tr>

                            <td width="80">
                                Nomor
                            </td>

                            <td>
                                :
                                {{ $do->nomor_do }}
                            </td>

                        </tr>

                        <tr>

                            <td>
                                Tanggal
                            </td>

                            <td>
                                :
                                {{ \Carbon\Carbon::parse($do->tanggal_do)->format('d-M-y') }}
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
                        {{ $do->customer->nama_customer }}
                    </div>

                    <div>
                        {{ $do->customer->alamat ?? '-' }}
                    </div>

                    <br>

                    <div>
                        Telepon:
                        {{ $do->customer->telepon ?? '-' }}
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
                                {{ $do->sales_order->nomor_so ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                No. PO
                            </td>
                            <td>
                                :
                                {{ $do->nomor_po ?? '-' }}
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
                    <th width="60%">
                        Deskripsi Item
                    </th>
                    <th width="15%">
                        Satuan
                    </th>
                    <th width="20%">
                        Qty
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach($do->details as $detail)
                    <tr>
                        <td align="center">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $detail->item->deskripsi }}
                        </td>
                        <td align="center">
                            {{ $detail->item->satuan ?? '-' }}
                        </td>
                        <td class="text-right">
                            {{ number_format($detail->qty, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                {{-- EMPTY SPACE --}}
                <tr>
                    <td colspan="4" style="height:250px;"></td>
                </tr>
            </tbody>
        </table>
        {{-- FOOTER --}}
        <div class="footer">
            <table>
                <tr>
                    <td width="50%">
                        <div class="bold">
                            Catatan:
                        </div>
                        <div class="mt-20">
                        </div>
                        <div style="margin-top:60px;">
                            Penerima,
                            <br><br><br><br>
                            ____________________
                            <br>
                            Nama jelas, cap, tanda tangan
                        </div>
                    </td>
                    <td width="50%">
                        <div class="signature">
                            Hormat kami,
                            <br><br><br><br>
                            <div class="bold">
                                {{ $do->sales_order->sales->name ?? '-' }}
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>