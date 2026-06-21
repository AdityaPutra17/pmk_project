<style>
    /* Custom scrollbar */
    .sidebar-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Transition for submenu */
    .submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    .submenu.active {
        max-height: 500px;
    }
</style>

<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50 flex flex-col">
    
    <!-- Logo Header -->
    <div class="h-16 flex items-center justify-center border-b border-gray-200 bg-white">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 rounded-lg flex items-center justify-center">
               <img src="{{asset('images/logopmknew.png')}}" alt="">
            </div>
            <span class="text-lg font-bold text-gray-800">Panca Media Kreasi</span>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto sidebar-scroll py-4">
        
        <!-- DASHBOARD -->
        <a href="/" class="flex items-center gap-3 px-4 mx-2 py-2.5 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
            <span class="font-bold">Dashboard</span>
        </a>

        <!-- MASTER DATA (Parent with Submenu) -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('master-data')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="database" class="h-5 w-5"></i>
                    <span class="font-bold">Master Data</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-master-data"></i>
            </button>
            
            <!-- Submenu -->
            <div id="submenu-master-data" class="submenu ml-8 mt-1 space-y-1">
                <a href="/area" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                    <span>Area</span>
                </a>
                <a href="/sales" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    <span>Sales</span>
                </a>
                <a href="/customers" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="user-check" class="h-4 w-4"></i>
                    <span>Customer</span>
                </a>
                <a href="/item-categories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="folder" class="h-4 w-4"></i>
                    <span>Jenis Item</span>
                </a>
                <a href="/items" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="package" class="h-4 w-4"></i>
                    <span>Item</span>
                </a>
            </div>
        </div>
        
        <!-- TRANSACTION -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('transaction')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="repeat" class="h-5 w-5"></i>
                    <span class="font-bold">Transaction</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-transaction"></i>
            </button>
            
            <div id="submenu-transaction" class="submenu ml-8 mt-1 space-y-1">
                <a href="/sales-orders" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="shopping-cart" class="h-4 w-4"></i>
                    <span>Sales Order</span>
                </a>
                <a href="/delivery-orders" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="truck" class="h-4 w-4"></i>
                    <span>Delivery Order</span>
                </a>
                <a href="/invoice" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    <span>Invoice</span>
                </a>
                <a href="/historytransaction" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    <span>History Transaction</span>
                </a>
            </div>
        </div>

        @if(Auth::check() && Auth::user()->role == 'admin')

         <!-- PO -->
        <div class="px-2 mt-2">

            <!-- MENU UTAMA -->
            <button onclick="toggleSubmenu('po')"
                class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">

                <div class="flex items-center gap-3">
                    <i data-lucide="repeat" class="h-5 w-5"></i>
                    <span class="font-bold">Purchase Order</span>
                </div>

                <i data-lucide="chevron-down" class="h-4 w-4" id="icon-po"></i>
            </button>

            <div id="submenu-po" class="submenu ml-4 mt-1 space-y-1">

                <!-- Dashboard -->
                <a href="/dashboardpo"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm">
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    <span class="font-medium">Dashboard PO</span>
                </a>

                <!-- MASTER DATA -->
                <button onclick="toggleSubmenu('masterdata')"
                    class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm">

                    <div class="flex items-center gap-3">
                        <i data-lucide="database" class="h-4 w-4"></i>
                        <span class="font-medium">Master Data</span>
                    </div>

                    <i data-lucide="chevron-down" class="h-4 w-4" id="icon-masterdata"></i>
                </button>

                <div id="submenu-masterdata" class="submenu ml-6 space-y-1  px-6">
                    <a href="/suppliers" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Supplier</a>
                    <a href="/customerpos" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Customer</a>
                    <a href="/jenis-item" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Jenis Item</a>
                    <a href="/item-po" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Item PO</a>
                    <a href="/franco" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Franco</a>
                    <a href="/top" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">TOP (Term of Payment)</a>
                </div>

                <!-- PURCHASE ORDER -->
                <button onclick="toggleSubmenu('purchaseorder')"
                    class="w-full flex items-center justify-between px-4 py-2 rounded-lg text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 text-sm">

                    <div class="flex items-center gap-3">
                        <i data-lucide="shopping-cart" class="h-4 w-4"></i>
                        <span class="font-medium">Purchase Order</span>
                    </div>

                    <i data-lucide="chevron-down" class="h-4 w-4" id="icon-purchaseorder"></i>
                </button>

                <div id="submenu-purchaseorder" class="submenu ml-6 space-y-1 px-6">
                    <a href="/po/create" class="block px-4 py-2 text-sm text-gray-600 hover:text-indigo-600">Create PO</a>
                </div>

            </div>
        </div>

        <!-- USER MANAGEMENT -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('user-management')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="h-5 w-5"></i>
                    <span class="font-bold">User Management</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-user-management"></i>
            </button>
            
            <div id="submenu-user-management" class="submenu ml-8 mt-1 space-y-1">
                <a href="/users" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="user" class="h-4 w-4"></i>
                    <span>Users</span>
                </a>
            </div>
        </div>

        @endif

    </div>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-2">
            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-sm font-bold text-indigo-600">AD</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

<!-- Toggle Button (Mobile) -->
<button onclick="toggleSidebar()" class="fixed bottom-4 left-4 z-50 lg:hidden bg-indigo-600 text-white p-3 rounded-full shadow-lg">
    <i data-lucide="menu" class="h-6 w-6"></i>
</button>

<!-- Initialize Lucide Icons -->
<script>
    // Initialize all icons
    lucide.createIcons();

    // Toggle Sidebar (Mobile)
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    // Toggle Submenu
    function toggleSubmenu(id) {
        const submenu = document.getElementById('submenu-' + id);
        const icon = document.getElementById('icon-' + id);
        
        if (submenu.classList.contains('active')) {
            submenu.classList.remove('active');
            icon.classList.remove('rotate-180');
        } else {
            submenu.classList.add('active');
            icon.classList.add('rotate-180');
        }
    }
</script>