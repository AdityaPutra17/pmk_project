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
               <img src="{{asset('images/logopmk.png')}}" alt="">
            </div>
            <span class="text-lg font-bold text-gray-800">Panca Media Kreasi</span>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto sidebar-scroll py-4">
        
        <!-- DASHBOARD -->
        <a href="/" class="flex items-center gap-3 px-4 mx-2 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors">
            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- MASTER DATA (Parent with Submenu) -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('master-data')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="database" class="h-5 w-5"></i>
                    <span class="font-medium">Master Data</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-master-data"></i>
            </button>
            
            <!-- Submenu -->
            <div id="submenu-master-data" class="submenu ml-8 mt-1 space-y-1">
                <a href="/area" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="map-pin" class="h-4 w-4"></i>
                    <span>Area</span>
                </a>
                <a href="/sales" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="users" class="h-4 w-4"></i>
                    <span>Sales</span>
                </a>
                <a href="/customers" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="user-check" class="h-4 w-4"></i>
                    <span>Customer</span>
                </a>
                <a href="/item-categories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="folder" class="h-4 w-4"></i>
                    <span>Jenis Item</span>
                </a>
                <a href="/items" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="package" class="h-4 w-4"></i>
                    <span>Item</span>
                </a>
            </div>
        </div>

        <!-- TRANSACTION -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('transaction')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="repeat" class="h-5 w-5"></i>
                    <span class="font-medium">Transaction</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-transaction"></i>
            </button>
            
            <div id="submenu-transaction" class="submenu ml-8 mt-1 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="shopping-cart" class="h-4 w-4"></i>
                    <span>Sales Order</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="truck" class="h-4 w-4"></i>
                    <span>Delivery Order</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="file-text" class="h-4 w-4"></i>
                    <span>Invoice</span>
                </a>
            </div>
        </div>

        <!-- REPORT -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('report')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="bar-chart-2" class="h-5 w-5"></i>
                    <span class="font-medium">Report</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-report"></i>
            </button>
            
            <div id="submenu-report" class="submenu ml-8 mt-1 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="file-bar-chart" class="h-4 w-4"></i>
                    <span>Rekap Sales Order</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="truck" class="h-4 w-4"></i>
                    <span>Rekap Delivery Order</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="file-spreadsheet" class="h-4 w-4"></i>
                    <span>Rekap Invoice</span>
                </a>
            </div>
        </div>

        <!-- USER MANAGEMENT -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('user-management')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="h-5 w-5"></i>
                    <span class="font-medium">User Management</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-user-management"></i>
            </button>
            
            <div id="submenu-user-management" class="submenu ml-8 mt-1 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="user" class="h-4 w-4"></i>
                    <span>Users</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="shield" class="h-4 w-4"></i>
                    <span>Roles</span>
                </a>
            </div>
        </div>

        <!-- SETTINGS -->
        <div class="px-2 mt-2">
            <button onclick="toggleSubmenu('settings')" class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors group">
                <div class="flex items-center gap-3">
                    <i data-lucide="settings" class="h-5 w-5"></i>
                    <span class="font-medium">Settings</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 transition-transform group-data-[open=true]:rotate-180" id="icon-settings"></i>
            </button>
            
            <div id="submenu-settings" class="submenu ml-8 mt-1 space-y-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="user-circle" class="h-4 w-4"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 text-sm transition-colors">
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-2">
            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-sm font-medium text-indigo-600">AD</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">{{ Auth::user()->name }}</p>
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