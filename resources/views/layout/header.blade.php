<header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 bg-gradient-to-tr from-indigo-600 to-blue-500 rounded-lg flex items-center justify-center">
                <i data-lucide="zap" class="h-4 w-4 text-white"></i>
            </div>
            <span class="text-lg font-bold text-gray-800 hidden sm:block">Sales Automation</span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <!-- Search -->
        <div class="relative hidden md:block">
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"></i>
            <input type="text" placeholder="Search..." class="pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 w-64">
        </div>
        <!-- Notifications -->
        <button class="relative p-2 text-gray-500 hover:bg-gray-100 rounded-lg transition-colors">
            <i data-lucide="bell" class="h-5 w-5"></i>
            <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
        </button>
        <!-- Profile -->
        <div class="flex items-center gap-2 pl-2 border-l border-gray-200">
            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                <span class="text-sm font-medium text-indigo-600">AD</span>
            </div>
            <div class="hidden sm:block">
                <p class="text-sm font-medium text-gray-800">Admin User</p>
                <p class="text-xs text-gray-500">admin@sales.com</p>
            </div>
        </div>
    </div>
</header>