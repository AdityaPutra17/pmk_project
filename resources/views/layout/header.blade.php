<header class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 flex items-center justify-between sticky top-0 z-30">
    <div class="flex items-center gap-4">
        <div class="flex items-center gap-2">
            <div class="h-8 w-8 rounded-lg flex items-center justify-center">
               <img src="{{asset('images/logopmknew.png')}}" alt="">
            </div>
            <span class="text-lg font-bold text-gray-800 hidden sm:block">Sales Automation</span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        
        <!-- Profile -->
        <div class="relative">
            <button
                id="profileBtn"
                type="button"
                class="flex items-center gap-2 pl-2 border-l border-gray-200 hover:bg-gray-50 rounded-lg px-2 py-1 transition">

                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                    <span class="text-sm font-medium text-indigo-600">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </span>
                </div>

                <div class="hidden sm:block text-left">
                    <p class="text-sm font-medium text-gray-800">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>

                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500"></i>
            </button>

            <!-- Dropdown -->
            <div
                id="profileDropdown"
                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50">

                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-800">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ Auth::user()->email }}
                    </p>
                </div>

                <a
                    href=""
                    class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">

                    <i data-lucide="user" class="w-4 h-4"></i>
                    Profile
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50">

                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</header>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('profileBtn');
    const dropdown = document.getElementById('profileDropdown');

    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function () {
        dropdown.classList.add('hidden');
    });

});
</script>