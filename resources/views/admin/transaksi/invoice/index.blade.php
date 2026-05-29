@extends('template')

@section('title', 'Invoice')

@section('content')

<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-6">
        Invoice
    </h1>

    <div class="bg-white rounded-xl border p-5">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3 text-left">
                        No Invoice
                    </th>

                    <th class="px-4 py-3 text-left">
                        Customer
                    </th>

                    <th class="px-4 py-3 text-left">
                        Total
                    </th>

                    <th class="px-4 py-3 text-left">
                        Status
                    </th>

                    <th class="px-4 py-3 text-center">
                        Action
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($invoices as $invoice)

                    <tr class="border-t">

                        <td class="px-4 py-3">
                            {{ $invoice->nomor_invoice }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $invoice->customer->nama_customer }}
                        </td>

                        <td class="px-4 py-3">
                            Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">

                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">

                                {{ $invoice->status }}

                            </span>

                        </td>

                        <td class="px-4 py-3 text-center">

                            <a
                                href="{{ route('invoice.print', $invoice->id) }}"
                                target="_self"
                                class="text-blue-600 hover:underline">

                                Print

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection