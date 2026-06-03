<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | KPI CARDS
        |--------------------------------------------------------------------------
        */

        $totalSalesOrder = Sales_orders::sum('grand_total');

        $totalCustomer = Customer::count();

        $totalItem = Item::count();

        $totalSO = Sales_orders::count();

        $totalDO = Delivery_orders::count();

        $totalInvoice = Invoice::count();

        $pendingDelivery = Sales_order_details::whereColumn(
            'qty_delivered',
            '<',
            'qty'
        )->count();

        $invoiceBelumLunas = Invoice::whereIn(
            'status',
            ['unpaid', 'partial']
        )->count();

        $totalPiutang = Invoice::whereIn(
            'status',
            ['unpaid', 'partial']
        )->sum('grand_total');

        /*
        |--------------------------------------------------------------------------
        | SALES ORDER CHART
        |--------------------------------------------------------------------------
        */

        $salesChart = Sales_orders::selectRaw("
                MONTH(tanggal_so) as bulan,
                SUM(grand_total) as total
            ")
            ->whereYear('tanggal_so', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $chartLabels = [];
        $chartData = [];

        foreach ($salesChart as $row) {

            $chartLabels[] = date(
                'M',
                mktime(0, 0, 0, $row->bulan, 1)
            );

            $chartData[] = $row->total;
        }

        /*
        |--------------------------------------------------------------------------
        | INVOICE STATUS CHART
        |--------------------------------------------------------------------------
        */

        $invoiceStatus = [

            'lunas' => Invoice::where(
                'status',
                'lunas'
            )->count(),

            'partial' => Invoice::where(
                'status',
                'partial'
            )->count(),

            'unpaid' => Invoice::where(
                'status',
                'unpaid'
            )->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | RECENT SALES ORDER
        |--------------------------------------------------------------------------
        */

        $recentSO = Sales_orders::with([
            'customer',
            'sales'
        ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT DELIVERY ORDER
        |--------------------------------------------------------------------------
        */

        $recentDO = Delivery_orders::with([
            'customer'
        ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP CUSTOMER
        |--------------------------------------------------------------------------
        */

        $topCustomers = Customer::select(
            'customers.nama_customer',
            DB::raw(
                'SUM(sales_orders.grand_total) as total'
            )
        )
            ->join(
                'sales_orders',
                'customers.id',
                '=',
                'sales_orders.customer_id'
            )
            ->groupBy(
                'customers.id',
                'customers.nama_customer'
            )
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | TOP PRODUCTS
        |--------------------------------------------------------------------------
        */

        $topProducts = DB::table('sales_order_details')
            ->join(
                'items',
                'sales_order_details.item_id',
                '=',
                'items.id'
            )
            ->select(
                'items.deskripsi',
                DB::raw(
                    'SUM(sales_order_details.qty) as total_qty'
                )
            )
            ->groupBy(
                'items.id',
                'items.deskripsi'
            )
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view(
            'dashboard',
            compact(
                'totalSalesOrder',
                'totalCustomer',
                'totalItem',
                'totalSO',
                'totalDO',
                'totalInvoice',
                'pendingDelivery',
                'invoiceBelumLunas',
                'totalPiutang',
                'chartLabels',
                'chartData',
                'invoiceStatus',
                'recentSO',
                'recentDO',
                'topCustomers',
                'topProducts'
            )
        );
    }
}