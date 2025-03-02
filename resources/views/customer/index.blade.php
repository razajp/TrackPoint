@extends('layouts.app')
@section('title', 'Show Customers | Track Point')
@section('content')
    @php $authLayout = Auth::user()->layout; @endphp
    <!-- Modal -->
    <div id="customerModal"
        class="mainModal hidden fixed flex-col space-y-4 inset-0 z-50 items-center justify-center bg-black bg-opacity-50 fade-in">

        <form id="customerModalForm" method="POST" action="{{ route('update-customer-status') }}" class="w-full h-full flex flex-col space-y-4 items-center justify-center">
            @csrf
            <!-- Modal Content -->
            <div class="bg-[--secondary-bg-color] rounded-xl shadow-lg w-full max-w-2xl p-6 relative flex">
                <!-- Close Button -->
                <button onclick="closeCustomerModal()" type="button"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all 0.3s ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex text-[--border-error] rounded-full h-[15rem] aspect-square overflow-hidden">
                    <div id="active_inactive_dot_modal"
                        class="active_inactive_dot absolute top-3 left-3 w-[0.7rem] h-[0.7rem] bg-[--border-success] rounded-full">
                    </div>
                    <img id="customerImage" src="{{ asset('/storage/uploads/images/default_avatar.png') }}" alt=""
                        class="w-full h-full object-cover">
                </div>

                <!-- Modal Content -->
                <div id="modal-contant" class="grow h-[15rem] flex flex-col justify-between">
                    <!-- Modal Body -->
                    <div id="modal_body" class="modal_body flex items-start ml-2">
                        <div class="content ml-5">
                            <h5 id="customer" class="text-2xl my-1 text-[--text-color] capitalize font-semibold">Hasan Raza
                            </h5>
                            <p class="text-[--secondary-text] mb-1 tracking-wide">
                                <strong>Person Name:</strong>
                                <span id="person_name" class="person_name">Salaried-staff</span>
                            </p>
                            <p class="text-[--secondary-text] mb-1 tracking-wide">
                                <strong>Address:</strong>
                                <span id="address" class="address">Karachi New Karachi</span>
                            </p>
                            <p class="text-[--secondary-text] mb-1 tracking-wide">
                                <strong>City:</strong>
                                <span id="city" class="city">Karachi</span>
                            </p>
                            <p class="text-[--secondary-text] mb-1 tracking-wide">
                                <strong>Phone:</strong>
                                <span id="phone" class="phone">00000000000</span>
                            </p>
                            <p class="text-[--secondary-text] mb-1 tracking-wide">
                                <strong>Balance:</strong>
                                <span id="balance" class="balance">00.00</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="modal-action"
                class="bg-[--secondary-bg-color] rounded-2xl shadow-lg max-w-3xl w-auto p-3 relative text-sm">
                <div class="flex gap-4">
                    <div class="btns flex gap-3">
                        <!-- Cancel Button -->
                        <a id="show-statement-modal" href="{{ route('customer-statement') }}"
                            class="px-4 py-2 bg-[--secondary-bg-color] border text-[--secondary-text] rounded-lg hover:bg-[--bg-color] transition-all 0.3s ease-in-out">Show
                            Statement</a>
                            <input type="hidden" id="customer_id" name="customer_id" value="">
                            <input type="hidden" id="customer_status" name="status" value="">
                            <button id="ac_in_btn" type="submit"
                                class="px-4 py-2 bg-[--danger-color] text-white rounded-lg hover:bg-[--h-danger-color] transition-all 0.3s ease-in-out">In
                                Active</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color] fade-in"> Show Customers </h1>

            <!-- Search Form -->
            <form id="search-form" method="GET" action="{{ route('customer.index') }}"
                class="search-box w-[80%] mx-auto my-5 flex items-center text-sm gap-4">
                <!-- Search Input -->
                <div class="search-input relative flex-1">
                    <input type="text" id="customer_input" name="customer" placeholder="Enter Customer."
                        list="customer_list" autocomplete="off" value="{{ request('search') }}"
                        class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">

                    <datalist id="customer_list">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->customer }}"></option>
                        @endforeach
                    </datalist>
                </div>

                <!-- Filters -->
                <div class="filter-box flex flex-1 items-center gap-4">
                    <!-- city Filter -->
                    <div class="filter-select relative w-full">
                        <select name="city" id="city"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Cities</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- status Filter -->
                    <div class="filter-select relative w-full">
                        <select name="status" id="status"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="in_active">In Active</option>
                        </select>
                    </div>
                </div>
            </form>

            <section class="text-center mx-auto fade-in">
                <div
                    class="show-box mx-auto w-[80%] h-[70vh] bg-[--secondary-bg-color] rounded-xl text-sm shadow overflow-y-auto @if (Auth::user()->layout == 'grid') pt-7 pr-2 @endif relative">
                    @if (Auth::user()->layout == 'grid')
                        <div
                            class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-sm">
                            <h4>Show Customers</h4>
                        </div>
                    @endif

                    <div class="buttons absolute {{ $authLayout == 'grid' ? 'top-0' : 'top-0.5' }} right-4 text-sm">
                        <div class="relative group">
                            <form method="POST" action="{{ route('update-user-layout') }}">
                                @csrf
                                <input type="hidden" name="layout" value="{{ $authLayout }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                @if ($authLayout == 'grid')
                                    <button type="submit" class="group cursor-pointer">
                                        <i class='bx bx-list-ul text-xl text-white'></i>
                                        <span
                                            class="absolute shadow-md text-nowrap border border-gray-600 -right-1 top-8 bg-[--h-secondary-bg-color] text-[--text-color] text-[12px] rounded px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">List</span>
                                    </button>
                                @else
                                    <button type="submit" class="group cursor-pointer">
                                        <i class='bx bx-grid-horizontal text-2xl text-white'></i>
                                        <span
                                            class="absolute shadow-md text-nowrap border border-gray-600 -right-1 top-8 bg-[--h-secondary-bg-color] text-[--text-color] text-[12px] rounded px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Grid</span>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>

                    @if (count($customers) > 0)
                        <div
                            class="add-new-article-btn absolute bottom-8 right-5 hover:scale-105 hover:bottom-9 transition-all group 0.3s ease-in-out">
                            <a href="{{ route('customer.create') }}"
                                class="bg-[--primary-color] text-[--text-color] px-3 py-2.5 rounded-full hover:bg-[--h-primary-color] transition-all 0.3s ease-in-out">
                                <i class='bx bx-plus-medical'></i>
                            </a>
                            <span
                                class="absolute shadow-xl right-7 top-0 border border-gray-600 transform -translate-x-1/2 bg-[--h-secondary-bg-color] text-[--text-color] text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Add</span>
                        </div>

                        <div class="details h-full">
                            <div class="container-parent h-full overflow-y-auto my-scroller">
                                @if (Auth::user()->layout == 'grid')
                                    <div
                                        class="card_container p-5 pr-3 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                                        @foreach ($customers as $customer)
                                            <div data-customer="{{ $customer }}"
                                                class="contextMenuToggle modalToggle card relative border border-gray-600 shadow rounded-xl min-w-[100px] h-[8rem] flex gap-4 p-4 cursor-pointer overflow-hidden fade-in">
                                                <div class="img aspect-square h-full rounded-full overflow-hidden">
                                                    <img src="{{ asset('storage/uploads/images/' . $customer->image) }}"
                                                        alt="" class="w-full h-full object-cover">
                                                    @if ($customer->status === 'active')
                                                        <div
                                                            class="active_inactive_dot absolute top-2 right-2 w-[0.5rem] h-[0.5rem] bg-[--border-success] rounded-full">
                                                        </div>
                                                        <div
                                                            class="active_inactive absolute text-xs text-[--border-success] top-1 right-2 h-[1rem]">
                                                            Active</div>
                                                    @else
                                                        <div
                                                            class="active_inactive_dot absolute top-2 right-2 w-[0.5rem] h-[0.5rem] bg-[--border-error] rounded-full">
                                                        </div>
                                                        <div
                                                            class="active_inactive absolute text-xs text-[--border-error] top-1 right-2 h-[1rem]">
                                                            In Active</div>
                                                    @endif
                                                </div>
                                                <div class="text-start">
                                                    <h5 class="text-xl my-1 text-[--text-color] capitalize font-semibold">
                                                        {{ $customer->customer }}</h5>
                                                    <p class="text-[--secondary-text] tracking-wide text-sm">
                                                        <strong>City:</strong>
                                                        <span class="person_name">{{ $customer->city }}</span>
                                                    </p>
                                                    <p class="text-[--secondary-text] tracking-wide text-sm capitalize">
                                                        <strong>Phone:</strong> <span
                                                            class="phone">{{$customer->phone}}</span>
                                                    </p>
                                                    <p class="text-[--secondary-text] tracking-wide text-sm capitalize">
                                                        <strong>Balance:</strong> <span
                                                            class="phone">{{ $customer->balance }}</span>
                                                    </p>
                                                </div>
                                                <button
                                                    class="absolute bottom-0 right-0 rounded-full w-[22%] aspect-square flex items-center justify-center bg-[--h-bg-color] text-lg translate-x-1/4 translate-y-1/4">
                                                    <i class='bx bx-right-arrow-alt text-3xl -rotate-45'></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="table_container rounded-tl-lg rounded-tr-lg overflow-hidden text-sm">
                                        <div class="grid grid-cols-5 bg-[--primary-color] font-medium">
                                            <div class="p-2">Customer</div>
                                            <div class="p-2">City</div>
                                            <div class="p-2">Phone</div>
                                            <div class="p-2">Balance</div>
                                            <div class="p-2">Status</div>
                                        </div>
                                        @foreach ($customers as $customer)
                                            <div data-customer="{{ $customer }}"
                                                class="contextMenuToggle modalToggle grid grid-cols-5 text-center border-b border-gray-600 items-center py-0.5 cursor-pointer hover:bg-[--h-secondary-bg-color] fade-in transition-all 0.3s ease-in-out">
                                                <div class="p-2">{{ $customer->customer }}</div>
                                                <div class="p-2">{{ $customer->city }}</div>
                                                <div class="p-2">
                                                    {{$customer->phone}}
                                                </div>
                                                <div class="p-2">{{ $customer->balance }}</div>
                                                <div class="p-2">
                                                    @if ($customer->status === 'active')
                                                        <span class="text-[--border-success]">Active</span>
                                                    @else
                                                        <span class="text-[--border-error]">In Active</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="no-article-message w-full h-full flex flex-col items-center justify-center gap-2">
                            <h1 class="text-md text-[--secondary-text] capitalize">No customer yet</h1>
                            <a href="{{ route('customer.create') }}"
                                class="text-md bg-[--primary-color] text-[--text-color] px-4 py-2 rounded-md hover:bg-blue-600 transition-all 0.3s ease-in-out uppercase font-semibold">Add
                                New</a>
                        </div>
                    @endif
                </div>
            </section>

            <div class="context-menu absolute top-0 text-sm" style="display: none;">
                <div
                    class="border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl transform transition-all 0.3s ease-in-out z-50">
                    <ul class="p-2">
                        <li>
                            <button id="show-details" type="button"
                                class="flex items-center w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Show
                                Details</button>
                        </li>
                        <li>
                            <a id="show-statment" href="{{ route('customer-statement') }}"
                                class="flex items-center w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Show
                                Statement</a>
                        </li>
                        <li id="ac_in_context" class="hidden">
                            <form method="POST" action="{{ route('update-customer-status') }}">
                                @csrf
                                <input type="hidden" id="customer_id_context" name="customer_id" value="">
                                <input type="hidden" id="customer_status_context" name="status" value="">
                                <button id="ac_in_btn_context" type="submit"
                                    class="flex w-full items-center text-left px-4 py-2 font-medium rounded-md transition-all 0.3s ease-in-out">In
                                    Active</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <script>
        $('#customer_input').on('input', function(e) {
            e.preventDefault(); // Stop default form submission
            console.log("Enter pressed, submitting AJAX request...");

            $(this).blur();

            submitForm();

            setTimeout(() => {
                $(this).focus();
            }, 100);
        });

        // Also trigger search on input change
        $('#search-form').on('change', 'select', function() {
            submitForm();
        });

        // Function to submit the form via AJAX
        function submitForm() {
            let formData = $('#search-form').serialize(); // Serialize form data
            let formAction = $('#search-form').attr('action'); // Get form action URL

            $.ajax({
                url: formAction, // Use dynamic form action
                method: 'GET', // Ensure correct method (GET or POST)
                data: formData,
                success: function(response) {
                    let details = $(response).find('.details').html(); // Extract relevant HTML

                    if (!details || details.trim() === "") {
                        $('.details').html(
                                '<div class="text-center text-[--border-error] pt-5 col-span-4">Customer Not Found</div>'
                        );
                    } else {
                        $('.details').html(details);
                    };

                    // Ensure these functions exist before calling them
                    if (typeof addListnerToCard === "function") {
                        addListnerToCard();
                    };

                    if (typeof addListnerToContextMenu === "function") {
                        addListnerToContextMenu();
                    };
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error); // Log errors
                    alert('Error submitting form'); // User-friendly error message
                }
            });
        };

        let contextMenu = document.querySelector('.context-menu');
        let isContextMenuOpened = false;
        let isCustomerModalOpened = false;

        function closeContextMenu() {
            contextMenu.classList.remove('fade-in');
            contextMenu.style.display = 'none';
            isContextMenuOpened = false;
        };

        function openContextMenu() {
            closeAllDropdowns()
            contextMenu.classList.add('fade-in');
            contextMenu.style.display = 'block';
            isContextMenuOpened = true;
        };

        function addListnerToCard() {
            let card = document.querySelectorAll('.modalToggle')

            card.forEach(item => {
                item.addEventListener('click', () => {
                    if (!isContextMenuOpened) {
                        generateModal(item);
                    };
                });
            });
        };

        addListnerToCard();

        function openCustomerModal() {
            document.getElementById('customerModal').classList.remove('hidden');
            document.getElementById('customerModal').classList.add('flex');
            closeAllDropdowns();
            isCustomerModalOpened = true;
            closeContextMenu();
        };

        function closeCustomerModal() {
            document.getElementById('customerModal').classList.add('hidden');
            document.getElementById('customerModal').classList.remove('flex');
        };

        document.getElementById('customerModalForm').addEventListener('click', (e) => {
            if (e.target.id === 'customerModalForm') {
                closeCustomerModal();
            };
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isCustomerModalOpened) {
                closeCustomerModal();
            };
            closeContextMenu();
        });

        function addListnerToContextMenu() {
            let contextMenuToggle = document.querySelectorAll('.contextMenuToggle');

            contextMenuToggle.forEach(toggle => {
                toggle.addEventListener('contextmenu', (e) => {
                    generateContextMenu(e);
                });
            });
        };

        addListnerToContextMenu();

        function generateContextMenu(e) {
            contextMenu.classList.remove('fade-in');
            console.log(e);

            let ac_in_btn_context = document.getElementById('ac_in_btn_context');
            let ac_in_context = document.getElementById('ac_in_context');
            let item = e.target.closest('.modalToggle');
            let customer = JSON.parse(item.dataset.customer);

            ac_in_context.classList.add('hidden');

            if (ac_in_btn_context) {
                if (customer.status === 'active') {
                    if (customer.balance == 0) {
                        ac_in_context.classList.remove('hidden');
                        ac_in_btn_context.classList.remove('text-[--border-success]');
                        ac_in_btn_context.classList.remove('hover:text-[--text-success]');
                        ac_in_btn_context.classList.remove('hover:bg-[--bg-success]');
                        ac_in_btn_context.classList.add('text-[--border-error]');
                        ac_in_btn_context.classList.add('hover:text-[--text-error]');
                        ac_in_btn_context.classList.add('hover:bg-[--bg-error]');
                        ac_in_btn_context.textContent = 'In Active';
                    };
                } else {
                    ac_in_context.classList.remove('hidden');
                    ac_in_btn_context.classList.remove('text-[--border-error]');
                    ac_in_btn_context.classList.remove('hover:text-[--text-error]');
                    ac_in_btn_context.classList.remove('hover:bg-[--bg-error]');
                    ac_in_btn_context.classList.add('text-[--border-success]');
                    ac_in_btn_context.classList.add('hover:text-[--text-success]');
                    ac_in_btn_context.classList.add('hover:bg-[--bg-success]');
                    ac_in_btn_context.textContent = 'Active';
                };
            };

            const wrapper = document.querySelector(".wrapper"); // Replace with your wrapper's ID

            if (!contextMenu || !wrapper) return;

            const wrapperRect = wrapper.getBoundingClientRect(); // Get wrapper's position

            let x = e.clientX - wrapperRect.left; // Adjust X relative to wrapper
            let y = e.clientY - wrapperRect.top; // Adjust Y relative to wrapper

            // Prevent right edge overflow
            if (x + contextMenu.offsetWidth > wrapperRect.width) {
                x -= contextMenu.offsetWidth;
            }

            // Prevent bottom edge overflow
            if (y + contextMenu.offsetHeight > wrapperRect.height) {
                y -= contextMenu.offsetHeight;
            }

            contextMenu.style.left = `${x}px`;
            contextMenu.style.top = `${y}px`;

            let showStatement = document.getElementById('show-statment');
            showStatement.href = `/customer-statement?c_id=${customer.id}`;

            openContextMenu();

            document.addEventListener('click', (e) => {
                if (e.target.id === "show-details") {
                    generateModal(item);
                };
            });

            document.addEventListener('click', (e) => {
                if (e.target.id === "show-statment") {
                    return;
                };
            });

            document.addEventListener('click', (e) => {
                if (e.target.id === "ac_in_btn_context") {
                    customer_id_context = document.getElementById('customer_id_context');
                    customer_status_context = document.getElementById('customer_status_context');
                    customer_id_context.value = customer.id;
                    customer_status_context.value = customer.status;
                    ac_in_btn_context.click();
                };
            });

            // Function to remove context menu
            const removeContextMenu = (event) => {
                if (!contextMenu.contains(event.target)) {
                    closeContextMenu();
                    document.removeEventListener('click', removeContextMenu);
                    document.removeEventListener('contextmenu', removeContextMenu);
                };
            };

            // Wait for a small delay before attaching event listeners to avoid immediate removal
            setTimeout(() => {
                document.addEventListener('click', removeContextMenu);
            }, 10);
        };

        function generateModal(item) {
            console.log(item);

            let Dataset = JSON.parse(item.dataset.customer);
            let customerImage = document.getElementById('customerImage')
            let customer = document.getElementById('customer')
            let personName = document.getElementById('person_name')
            let phone = document.getElementById('phone')
            let balance = document.getElementById('balance')
            let city = document.getElementById('city')
            let address = document.getElementById('address')
            let ac_in_btn = document.getElementById('ac_in_btn')
            let show_statement_modal = document.getElementById('show-statement-modal')
            let customer_id = document.getElementById('customer_id')
            let customer_status = document.getElementById('customer_status')
            let active_inactive_dot_modal = document.getElementById('active_inactive_dot_modal')

            if (Dataset.image) {
                customerImage.src = `/storage/uploads/images/${Dataset.image}`
            }

            if (Dataset.status === 'active') {
                if (Dataset.balance == 0) {
                    ac_in_btn.classList.remove('hidden')
                    ac_in_btn.classList.add('bg-[--danger-color]')
                    ac_in_btn.classList.remove('bg-[--success-color]')
                    ac_in_btn.classList.add('hover:bg-[--h-danger-color]')
                    ac_in_btn.classList.remove('hover:bg-[--h-success-color]')
                    ac_in_btn.textContent = 'In Active'
                    active_inactive_dot_modal.classList.remove('bg-[--border-error]')
                    active_inactive_dot_modal.classList.add('bg-[--border-success]')
                } else {
                    ac_in_btn.classList.add('hidden')
                }
            } else {
                ac_in_btn.classList.remove('bg-[--danger-color]')
                ac_in_btn.classList.remove('hover:bg-[--h-danger-color]')
                ac_in_btn.classList.add('hover:bg-[--h-success-color]')
                ac_in_btn.classList.add('bg-[--success-color]')
                ac_in_btn.textContent = 'Active'
                active_inactive_dot_modal.classList.add('bg-[--border-error]')
                active_inactive_dot_modal.classList.remove('bg-[--border-success]')
            }


            show_statement_modal.href = `/customer-statement?c_id=${Dataset.id}`;

            customer_id.value = Dataset.id
            customer_status.value = Dataset.status
            customer.textContent = Dataset.customer
            personName.textContent = Dataset.person_name
            phone.textContent = Dataset.phone.replace(/(\d{4})(\d{7})/, '$1-$2')
            balance.textContent = Dataset.balance
            city.textContent = Dataset.city
            address.textContent = Dataset.address
            openCustomerModal()
        }
    </script>
@endsection
