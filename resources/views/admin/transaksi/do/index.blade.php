@extends('template')

@section('title', 'Delivery Order')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">
        Delivery Order
    </h1>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">

        <form action="{{ route('delivery-orders.store') }}" method="POST">

            @csrf

            <!-- Header -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

                <!-- SO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sales Order
                    </label>

                    <select
                        id="sales_order_id"
                        class="w-full px-4 py-2.5 border rounded-lg bg-gray-50"
                        required>

                        <option value="">
                            -- Select SO --
                        </option>

                        @foreach($salesOrders as $so)

                            <option
                                value="{{ $so->id }}"
                                data-so='@json($so)'
                            >
                                {{ $so->nomor_so }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <!-- Customer -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Customer
                    </label>

                    <input
                        type="text"
                        id="customer_name"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                </div>

                <!-- Nomor PO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor PO
                    </label>

                    <input
                        type="text"
                        id="nomor_po"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                </div>

            </div>

            <!-- Item -->
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Item SO
                </label>

                <select
                    name="sales_order_detail_id"
                    id="detail_so"
                    class="w-full px-4 py-2.5 border rounded-lg bg-gray-50"
                    required>

                    <option value="">
                        -- Select Item --
                    </option>

                </select>

            </div>

            <!-- Detail Item -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

                <input type="hidden" name="sales_order_id" id="input_sales_order_id">

                <input type="hidden" name="customer_id" id="input_customer_id">

                <input type="hidden" name="item_id" id="item_id">

                <!-- Kode Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Item
                    </label>

                    <input
                        type="text"
                        id="kode_item"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                </div>

                <!-- Satuan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Satuan
                    </label>

                    <input
                        type="text"
                        id="satuan"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                </div>

                <!-- Qty SO -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Qty SO
                    </label>

                    <input
                        type="text"
                        id="qty_so"
                        readonly
                        class="w-full px-4 py-2.5 bg-gray-100 border rounded-lg">
                </div>

                <!-- Qty Kirim -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Qty Kirim
                    </label>

                    <input
                        type="number"
                        name="qty"
                        step="0.01"
                        min="1"
                        required
                        class="w-full px-4 py-2.5 border rounded-lg">
                </div>

            </div>

            <!-- Catatan -->
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan
                </label>

                <textarea
                    name="catatan"
                    rows="3"
                    class="w-full px-4 py-2.5 border rounded-lg"></textarea>

            </div>

            <!-- Submit -->
            <div class="flex justify-end">

                <button
                    type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                    Save Delivery Order

                </button>

            </div>

        </form>

    </div>

</div>

<script>

    // pilih SO
    document.getElementById('sales_order_id')
    .addEventListener('change', function () {

        let selected =
            this.options[this.selectedIndex];

        if (!selected.value) return;

        // ambil seluruh data SO
        let so =
            JSON.parse(selected.dataset.so);

        // customer
        document.getElementById('customer_name').value =
            so.customer.nama_customer;

        // nomor po
        document.getElementById('nomor_po').value =
            so.nomor_po ?? '';

        // hidden
        document.getElementById('input_sales_order_id').value =
            so.id;

        document.getElementById('input_customer_id').value =
            so.customer.id;

        // item select
        let detailSelect =
            document.getElementById('detail_so');

        detailSelect.innerHTML =
            '<option value="">-- Select Item --</option>';

        so.details.forEach((detail) => {

            let sisaQty =
                detail.qty - detail.qty_delivered;

            detailSelect.innerHTML += `
                <option
                    value="${detail.id}"
                    data-item-id="${detail.item.id}"
                    data-kode="${detail.item.kode_item}"
                    data-satuan="${detail.item.satuan}"
                    data-qty="${detail.qty}"
                    data-sisa="${sisaQty}"
                >
                    ${detail.item.deskripsi}
                    - Sisa: ${sisaQty}
                </option>
            `;
        });

    });

    // pilih item
    document.getElementById('detail_so')
    .addEventListener('change', function () {

        let selected =
            this.options[this.selectedIndex];

        if (!selected.value) return;

        document.getElementById('item_id').value =
            selected.dataset.itemId;

        document.getElementById('kode_item').value =
            selected.dataset.kode;

        document.getElementById('satuan').value =
            selected.dataset.satuan;

        document.getElementById('qty_so').value =
            selected.dataset.qty;
    });

</script>

@endsection
