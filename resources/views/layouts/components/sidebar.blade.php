<!-- Modal -->
<div id="logoutModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 text-sm fade-in">
    <!-- Modal Content -->
    <div class="bg-[--secondary-bg-color] rounded-xl shadow-lg w-full max-w-lg p-6 relative">
        <!-- Close Button -->
        <button onclick="closeModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all 0.3s ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Modal Body -->
        <div class="modal_body flex items-start">
            <div class="w-1/5 h-1/5">
                <img src="{{ asset('storage/uploads/images/error_icon.png') }}" alt=""
                    class="w-full h-full object-cover">
            </div>
            <div class="content ml-5">
                <h2 class="text-xl font-semibold text-[--text-color]">Logout Account</h2>
                <p class="text-sm text-[--secondary-text] mt-2 mb-6">Are you sure you want to logout? All of your data
                    will be permanently removed. This action cannot be undone.</p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3">
            <!-- Cancel Button -->
            <button onclick="closeModal()"
                class="px-4 py-2 bg-[--secondary-bg-color] border text-[--secondary-text] rounded-md hover:bg-[--bg-color] transition-all 0.3s ease-in-out">Cancel</button>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-[--danger-color] text-white rounded-md hover:bg-[--h-danger-color] transition-all 0.3s ease-in-out">Logout</button>
            </form>
        </div>
    </div>
</div>
<!-- Sidebar -->
<aside class="bg-[--secondary-bg-color] w-16 flex flex-col items-center py-5 h-screen shadow-lg z-40 fade-in">
    <a href="/home"
        class="mb-4 text-[--text-color] p-3 w-10 h-10 flex items-center justify-center group cursor-normal relative">
        <h1 class="font-bold text-2xl text-[--primary-color] m-0">TP</h1>
        <span
            class="absolute text-nowrap shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Track
            Point</span>
    </a>
    <nav class="space-y-5">
        <a href="/home"
            class="nav-link home text-[--text-color] p-3 rounded-full hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center group relative">
            <i class="fas fa-home group-hover:text-[--primary-color]"></i>
            <span
                class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Home</span>
        </a>
        @if (auth()->user()->role == 'admin')
            <div class="relative group">
                <!-- Main Button -->
                <a id="trigger1"
                    class="nav-link user dropdown-trigger text-[--text-color] p-3 rounded-full group-hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center cursor-pointer">
                    <i class="fas fa-user group-hover:text-[--primary-color]"></i>
                    <span
                        class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Users</span>
                </a>
                <!-- Dropdown Menu -->
                <div id="menu1"
                    class="dropdownMenu text-sm absolute top-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('users.index') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">Show
                                Users</a>
                        </li>
                        <li>
                            <a href="{{ route('users.create') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">Add
                                User</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative group">
                <!-- Main Button -->
                <a id="trigger2"
                    class="nav-link customer dropdown-trigger text-[--text-color] p-3 rounded-full group-hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center cursor-pointer">
                    <i class="fas fa-people-arrows group-hover:text-[--primary-color]"></i>
                    <span
                        class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Customer</span>
                </a>
                <!-- Dropdown Menu -->
                <div id="menu2"
                    class="dropdownMenu text-sm absolute top-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('customer.index') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">Show
                                Customer</a>
                        </li>
                        <li>
                            <a href="{{ route('customer.create') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">Add
                                Customer</a>
                        </li>
                        <li>
                            <a href="{{ route('customer-statement') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">Customer
                                Statment</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative group">
                <!-- Main Button -->
                <a id="trigger3"
                    class="nav-link article dropdown-trigger text-[--text-color] p-3 rounded-full group-hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center cursor-pointer">
                    <i class="fas fa-tshirt group-hover:text-[--primary-color]"></i>
                    <span
                        class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">
                        Article
                    </span>
                </a>
                <!-- Dropdown Menu -->
                <div id="menu3"
                    class="dropdownMenu text-sm absolute top-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('article.index') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Show Article
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('article.create') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Add Article
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('article-track') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Article Track
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative group">
                <!-- Main Button -->
                <a id="trigger2"
                    class="nav-link invoice dropdown-trigger text-[--text-color] p-3 rounded-full group-hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center cursor-pointer">
                    <i class="fas fa-receipt group-hover:text-[--primary-color]"></i>
                    <span
                        class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">
                        Invoices
                    </span>
                </a>
                <!-- Dropdown Menu -->
                <div id="menu2"
                    class="dropdownMenu text-sm absolute top-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('invoice.index') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Show Invoices
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoice.create') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Create Invoice
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="relative group">
                <!-- Main Button -->
                <a id="trigger2"
                    class="nav-link payment dropdown-trigger text-[--text-color] p-3 rounded-full group-hover:bg-[--h-bg-color] transition-all 0.3s ease-in-out w-10 h-10 flex items-center justify-center cursor-pointer">
                    <i class="fas fa-money-bill group-hover:text-[--primary-color]"></i>
                    <span
                        class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">
                        Payments
                    </span>
                </a>
                <!-- Dropdown Menu -->
                <div id="menu2"
                    class="dropdownMenu text-sm absolute top-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <a href="{{ route('payment.index') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Show Payments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('payment.create') }}"
                                class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                Add Payment
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif

    </nav>
    <div class="relative group pt-3 mt-auto">
        <!-- User Avatar -->
        <button id="trigger999"
            class="dropdown-trigger w-10 h-10 flex items-center justify-center rounded-full cursor-pointer border-transparent hover:border-[--primary-color] transition-all 0.3s ease-in-out bg-[--primary-color] text-white font-semibold text-lg overflow-hidden">
            <img src="{{ asset('storage/uploads/images/' . auth()->user()->profile_picture) }}"
                class="w-full h-full object-cover" alt="Avatar">
            <span
                class="absolute shadow-xl left-16 top-1/2 transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">
                {{ Auth::user()->name }}
            </span>
        </button>

        <!-- Dropdown Menu -->
        <div id="menu999"
            class="dropdownMenu text-sm absolute bottom-0 left-16 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all 0.3s ease-in-out z-50">
            <ul class="p-2">
                <!-- Add Setups -->
                <li>
                    <a href="{{ route('addSetups') }}"
                        class="block px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                        <i class="fas fa-cog text-[--secondary-color] mr-3"></i>
                        Setups
                    </a>
                </li>
                <!-- Theme Toggle -->
                <li>
                    <button id="themeToggle"
                        class="flex items-center w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                        <i class="fas fa-moon text-[--secondary-color] mr-3"></i>
                        Theme
                    </button>
                </li>
                <!-- Logout Button -->
                <li>
                    <button onclick="openModal()"
                        class="block w-full text-left px-4 py-2 text-[--border-error] hover:bg-[--bg-error] hover:text-[--text-error] rounded-md transition-all duration-200 ease-in-out">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </li>
            </ul>
        </div>
    </div>
</aside>

<script>
    const url = window.location.href; // Get the current URL
    if (url.includes("home")) {
        document.querySelector(".nav-link.home").classList.add("active");
    } else if (url.includes("user")) {
        document.querySelector(".nav-link.user").classList.add("active");
    } else if (url.includes("customer")) {
        document.querySelector(".nav-link.customer").classList.add("active");
    } else if (url.includes("article")) {
        document.querySelector(".nav-link.article").classList.add("active");
    } else if (url.includes("invoice")) {
        document.querySelector(".nav-link.invoice").classList.add("active");
    } else if (url.includes("payment")) {
        document.querySelector(".nav-link.payment").classList.add("active");
    }
</script>
