@extends('template')

@section('title', 'Create Invoice')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">
        Create Invoice
    </h1>

    <form
        method="POST"
        action="{{ route('invoice.store') }}"
        class="bg-white p-6 rounded-xl shadow"
    >

        @csrf

        {{-- Header --}}
        <div class="grid grid-cols-2 gap-4 mb-6">

            <div>

                <label class="block mb-1">
                    Tanggal Invoice
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border rounded px-3 py-2"
                    required
                >

            </div>

            <div>

                <label class="block mb-1">
                    Jenis Invoice
                </label>

                <select
                    name="jenis_invoice"
                    class="w-full border rounded px-3 py-2"
                >

                    <option value="standar">
                        Standar
                    </option>

                    <option value="dp">
                        Uang Muka (DP)
                    </option>
                    <option value="cicilan">
                        Cicilan
                    </option>

                    <option value="pelunasan">
                        Pelunasan
                    </option>

                </select>

            </div>

        </div>

        {{-- Delivery Order --}}
        <div class="grid grid-cols-2 gap-4 mb-6">

            <div>

                <label class="block mb-1">
                    Delivery Order
                </label>

                <select
                    id="delivery_order"
                    name="delivery_order_id"
                    class="w-full border rounded px-3 py-2"
                    required
                >

                    <option value="">
                        Pilih Delivery Order
                    </option>

                    @foreach($deliveryOrders as $do)

                        <option
                            value="{{ $do->id }}"
                            data-do='@json($do)'
                        >

                            {{ $do->nomor_do }}
                            -
                            {{ $do->customer->nama_customer }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="block mb-1">
                    Customer
                </label>

                <input
                    type="text"
                    id="customer_name"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly
                >

            </div>

        </div>

        <input
            type="hidden"
            name="customer_id"
            id="customer_id"
        >

        {{-- Detail Item --}}
        <div class="mb-6">

            <table class="w-full border">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="border p-2">
                            Item
                        </th>

                        <th class="border p-2">
                            Qty
                        </th>

                        <th class="border p-2">
                            Harga
                        </th>

                        <th class="border p-2">
                            Subtotal
                        </th>

                    </tr>

                </thead>

                <tbody id="invoice_items">

                    <tr>

                        <td
                            colspan="4"
                            class="text-center p-4"
                        >
                            Pilih Delivery Order
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- DP --}}
        <div class="grid grid-cols-2 gap-4 mb-6">

            <div>

                <label>
                    Nominal Pembayaran
                </label>

                <input
                    type="number"
                    name="nominal_dp"
                    id="nominal_dp"
                    value="0"
                    min="0"
                    class="w-full border rounded px-3 py-2"
                >

            </div>

            <div>

                <label>
                    Sisa Tagihan
                </label>

                <input
                    type="text"
                    id="sisa_tagihan_view"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly
                >

            </div>

        </div>

        {{-- Total --}}
        <div class="grid grid-cols-3 gap-4 mb-6">

            <div>

                <label>
                    DPP
                </label>

                <input
                    type="text"
                    id="total_dpp_view"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly
                >

                <input
                    type="hidden"
                    name="total_dpp"
                    id="total_dpp"
                >

            </div>

            <div>

                <label>
                    PPN 11%
                </label>

                <input
                    type="text"
                    id="ppn_total_view"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly
                >

                <input
                    type="hidden"
                    name="ppn_total"
                    id="ppn_total"
                >

            </div>

            <div>

                <label>
                    Grand Total
                </label>

                <input
                    type="text"
                    id="grand_total_view"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    readonly
                >

                <input
                    type="hidden"
                    name="grand_total"
                    id="grand_total"
                >

            </div>

        </div>

        {{-- Catatan --}}
        <div class="mb-6">

            <label>
                Catatan
            </label>

            <textarea
                name="catatan"
                rows="3"
                class="w-full border rounded px-3 py-2"
            ></textarea>

        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded"
        >
            Simpan Invoice
        </button>

    </form>

</div>

<script>

currentTotal = 0;
let totalTerbayar = 0;

document
.getElementById('delivery_order')
.addEventListener('change', function(){

    let selected =
        this.options[this.selectedIndex];

    if(!selected.dataset.do)
    {
        return;
    }

    let data =
        JSON.parse(selected.dataset.do);
    
    if(data.invoices)
    {
        data.invoices.forEach(inv => {

            totalTerbayar += Number(
                inv.nominal_dp ?? 0
            );

        });
    }

    document
        .getElementById('customer_name')
        .value =
        data.customer.nama_customer;

    document
        .getElementById('customer_id')
        .value =
        data.customer.id;

    let tbody =
        document.getElementById(
            'invoice_items'
        );

    tbody.innerHTML = '';

    currentTotal = 0;

    data.details.forEach((item,index)=>{

        let harga =
            item.sales_order_detail.harga;

        let subtotal =
            item.sales_order_detail.subtotal;

        currentTotal += Number(subtotal);

        tbody.innerHTML += `

        <tr>

            <td class="border p-2">

                ${item.item.deskripsi}

                <input
                    type="hidden"
                    name="items[${index}][do_detail_id]"
                    value="${item.id}"
                >

                <input
                    type="hidden"
                    name="items[${index}][so_detail_id]"
                    value="${item.sales_order_detail.id}"
                >

            </td>

            <td class="border p-2">

                ${item.qty}

                <input
                    type="hidden"
                    name="items[${index}][qty]"
                    value="${item.qty}"
                >

            </td>

            <td class="border p-2">

                ${harga}

                <input
                    type="hidden"
                    name="items[${index}][harga]"
                    value="${harga}"
                >

            </td>

            <td class="border p-2">

                ${subtotal}

                <input
                    type="hidden"
                    name="items[${index}][subtotal]"
                    value="${subtotal}"
                >

            </td>

        </tr>

        `;
    });

    calculateTotal();

});

document
.getElementById('nominal_dp')
.addEventListener(
    'keyup',
    calculateTotal
);

function calculateTotal()
{
    let dpp = currentTotal;

    let ppn = dpp * 0.11;

    let grand = dpp + ppn;

    let pembayaranBaru =
        parseFloat(
            document
            .getElementById('nominal_dp')
            .value || 0
        );

    let sisaSebelumnya =
        grand - totalTerbayar;

    let sisaSetelahBayar =
        sisaSebelumnya - pembayaranBaru;

    if(sisaSetelahBayar < 0)
    {
        sisaSetelahBayar = 0;
    }

    document
        .getElementById('total_dpp')
        .value = dpp;

    document
        .getElementById('ppn_total')
        .value = ppn;

    document
        .getElementById('grand_total')
        .value = grand;

    document
        .getElementById('total_dpp_view')
        .value =
        dpp.toLocaleString('id-ID');

    document
        .getElementById('ppn_total_view')
        .value =
        ppn.toLocaleString('id-ID');

    document
        .getElementById('grand_total_view')
        .value =
        grand.toLocaleString('id-ID');

    document
        .getElementById('sisa_tagihan_view')
        .value =
        sisaSetelahBayar.toLocaleString('id-ID');
}

</script>

@endsection