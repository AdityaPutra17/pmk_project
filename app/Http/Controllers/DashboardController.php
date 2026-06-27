<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Invoice;
use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use App\Models\PurchaseOrder;
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

        $piutangProgress = $totalSalesOrder
            ? round(min(100, ($totalPiutang / $totalSalesOrder) * 100))
            : 0;

        $deliveryProgress = $totalSO
            ? round(min(100, ($totalDO / $totalSO) * 100))
            : 0;

        $invoiceProgress = $totalSO
            ? round(min(100, ($totalInvoice / $totalSO) * 100))
            : 0;

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
                'piutangProgress',
                'deliveryProgress',
                'invoiceProgress',
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

    public function dashboardPO()
    {
        // totals
        $totalPo = PurchaseOrder::count();
        $totalValue = PurchaseOrder::sum('grand_total');

        // group by status (if empty status will be shown as null)
        $byStatus = PurchaseOrder::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // monthly counts (last 6 months)
        $months = [];
        $counts = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $label = $m->format('Y-m');
            $months[] = $label;
            $counts[] = PurchaseOrder::whereYear('po_date', $m->year)
                ->whereMonth('po_date', $m->month)
                ->count();
        }

        // recent POs
        $recent = PurchaseOrder::with(['supplier', 'customer'])
            ->latest()->take(10)->get();

        return view('admin.po.dashboard', compact(
            'totalPo',
            'totalValue',
            'byStatus',
            'months',
            'counts',
            'recent'
        ));
    }
}