@extends('template')
@section('title', 'Dashboard')
@section('content')
<!-- Main Content -->
<main>    

    <!-- Dashboard Content -->
    <div class="p-3">
        
        <!-- Page Title -->
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Welcome back! Here's what's happening today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Total Sales -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Sales</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">Rp 125.5jt</p>
                    </div>
                    <div class="h-12 w-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="shopping-cart" class="h-6 w-6 text-indigo-600"></i>
                    </div>
                </div>
                <div class="flex items-center gap-1 mt-3 text-sm">
                    <span class="text-green-500 flex items-center gap-0.5">
                        <i data-lucide="trending-up" class="h-4 w-4"></i>
                        +12.5%
                    </span>
                    <span class="text-gray-400">vs last month</span>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">1,284</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="clipboard-list" class="h-6 w-6 text-blue-600"></i>
                    </div>
                </div>
                <div class="flex items-center gap-1 mt-3 text-sm">
                    <span class="text-green-500 flex items-center gap-0.5">
                        <i data-lucide="trending-up" class="h-4 w-4"></i>
                        +8.2%
                    </span>
                    <span class="text-gray-400">vs last month</span>
                </div>
            </div>

            <!-- Customers -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Customers</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">456</p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="users" class="h-6 w-6 text-green-600"></i>
                    </div>
                </div>
                <div class="flex items-center gap-1 mt-3 text-sm">
                    <span class="text-green-500 flex items-center gap-0.5">
                        <i data-lucide="trending-up" class="h-4 w-4"></i>
                        +5.1%
                    </span>
                    <span class="text-gray-400">vs last month</span>
                </div>
            </div>

            <!-- Pending Delivery -->
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Pending DO</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">23</p>
                    </div>
                    <div class="h-12 w-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i data-lucide="truck" class="h-6 w-6 text-orange-600"></i>
                    </div>
                </div>
                <div class="flex items-center gap-1 mt-3 text-sm">
                    <span class="text-orange-500 flex items-center gap-0.5">
                        <i data-lucide="alert-circle" class="h-4 w-4"></i>
                        Need attention
                    </span>
                </div>
            </div>
        </div>

        <!-- Chart & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-4">
            <!-- Sales Chart (Placeholder) -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Sales Overview</h3>
                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>This Month</option>
                        <option>Last Month</option>
                        <option>This Year</option>
                    </select>
                </div>
                <!-- Chart Area (Visual Only) -->
                <div class="h-64 flex flex-col justify-end gap-2">
                    <!-- Y-Axis Labels -->
                    <div class="flex items-end h-full gap-3 px-2">
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 45%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[60%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">Jan</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 65%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[75%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">Feb</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 55%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[50%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">Mar</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 80%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[85%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">Apr</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 70%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[70%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">May</span>
                        </div>
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-full bg-indigo-100 rounded-t-lg relative" style="height: 90%">
                                <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-lg h-[95%]"></div>
                            </div>
                            <span class="text-xs text-gray-400">Jun</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Recent Orders</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-700">View All</a>
                </div>
                <div class="space-y-4">
                    <!-- Order Item -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="shopping-cart" class="h-5 w-5 text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">SO-001</p>
                                <p class="text-xs text-gray-500">PT Maju Jaya</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 2.5jt</p>
                            <span class="text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Completed</span>
                        </div>
                    </div>
                    <!-- Order Item -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="truck" class="h-5 w-5 text-orange-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">DO-002</p>
                                <p class="text-xs text-gray-500">CV Sejahtera</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 5.2jt</p>
                            <span class="text-xs text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Pending</span>
                        </div>
                    </div>
                    <!-- Order Item -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="file-text" class="h-5 w-5 text-indigo-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">INV-003</p>
                                <p class="text-xs text-gray-500">Toko Bersama</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 1.8jt</p>
                            <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Paid</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 mb-4">
            <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="#" class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all group">
                    <div class="h-12 w-12 bg-gray-100 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition-colors">
                        <i data-lucide="plus-circle" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">New Order</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all group">
                    <div class="h-12 w-12 bg-gray-100 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition-colors">
                        <i data-lucide="user-plus" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">Add Customer</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all group">
                    <div class="h-12 w-12 bg-gray-100 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition-colors">
                        <i data-lucide="package-plus" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">Add Item</span>
                </a>
                <a href="#" class="flex flex-col items-center gap-2 p-4 border border-gray-200 rounded-xl hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition-all group">
                    <div class="h-12 w-12 bg-gray-100 group-hover:bg-indigo-100 rounded-xl flex items-center justify-center transition-colors">
                        <i data-lucide="file-bar-chart" class="h-6 w-6 text-gray-600 group-hover:text-indigo-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600">View Report</span>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-400 py-4 bottom-0">
            &copy; 2026 Panca Media Kreasi. All rights reserved.
        </div>
    </div>
</main>

<script>
    lucide.createIcons();
</script>
@endsection