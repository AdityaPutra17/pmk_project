<table border="1">
    <thead>
        <tr style="background:#f3f4f6;font-weight:bold;">
            <th>No Invoice</th>
            <th>Customer</th>
            <th>Tanggal</th>
            <th>Total DPP</th>
            <th>PPN</th>
            <th>Grand Total</th>
            <th>Status</th>
            <th>Dibayar</th>
            <th>Sisa</th>
        </tr>
    </thead>

    <tbody>
        @foreach($invoices as $inv)
            <tr>
                <td>{{ $inv->nomor_invoice }}</td>
                <td>{{ $inv->customer->nama_customer ?? '-' }}</td>
                <td>{{ $inv->tanggal_invoice }}</td>
                <td>{{ number_format($inv->total_dpp, 0, ',', '.') }}</td>
                <td>{{ number_format($inv->ppn_total, 0, ',', '.') }}</td>
                <td>{{ number_format($inv->grand_total, 0, ',', '.') }}</td>
                <td>{{ $inv->status }}</td>
                <td>{{ number_format($inv->nominal_dp, 0, ',', '.') }}</td>
                <td>
                    {{ number_format($inv->grand_total - $inv->nominal_dp, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>