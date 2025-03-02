@extends('layouts.app')
@section('title', 'Show Payments | Track Point')
@section('content')
    @php $authLayout = Auth::user()->layout; @endphp
    <!-- Modal -->
    <div id="paymentModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center text-sm bg-black bg-opacity-50 fade-in">
        <!-- Modal Content -->
        <div class="bg-[--secondary-bg-color] rounded-2xl shadow-lg w-[1024px] h-[450px] p-5 relative">
            <!-- Close Button -->
            <button id="close"
                class="absolute z-[10] top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div id="modal_body" class="modal_body flex items-start gap-6 w-full h-full">
                <div class="flex rounded-lg aspect-square overflow-hidden relative h-full p-5">
                    <img id="paymentImage" src="{{ asset('/storage/uploads/images/payment_icon.png') }}" alt=""
                        class="h-full w-full object-cover">
                    <div id="pending_dot"
                        class="pending_dot absolute top-2 left-2 w-[0.7rem] h-[0.7rem] bg-[--border-warning] rounded-full shadow-md">
                    </div>
                </div>
                <div id="modalContent" class="content grow overflow-y-auto h-full my-scroller-2">
                    <h5
                        class="text-4xl mt-1 mb-3 text-[--text-color] capitalize font-semibold sticky top-0 bg-[--secondary-bg-color] py-2">
                        #185</h5>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Category:</strong> <span>1 pcs</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Season:</strong> <span>Half</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Size:</strong> <span>SML</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Sales Rate:</strong> <span>250.00</span></p>
                    <hr class="my-3 mx-auto border-gray-600">
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Fabric Type:</strong> <span>Cotton</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Quantity/Dz:</strong> <span>250</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Ready Date:</strong> <span>12-05-2025</span></p>
                    <hr class="my-3 mx-auto border-gray-600">

                    <div class="w-full text-left grow">
                        <div class="flex justify-between items-center bg-[--h-bg-color] rounded-md py-2 px-4 mb-4">
                            <div class="w-1/5">#</div>
                            <div class="grow ml-5">Title</div>
                            <div class="w-1/4">Rate</div>
                        </div>
                        <div id="modal-rate-list" class="overflow-y-auto my-scroller-2">
                            <div class="flex justify-between items-center border-t border-gray-600 py-2 px-4">
                                <div class="w-1/5">1</div>
                                <div class="grow ml-5">Hello</div>
                                <div class="w-1/4">50</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]">
                Show Payments
            </h1>

            <!-- Search Form -->
            <form id="search-form" method="GET" action="{{ route('payment.index') }}"
                class="search-box w-[80%] mx-auto my-5 flex items-center gap-4">

                <!-- Filters -->
                <div class="filter-box flex flex-1 items-center gap-4">
                    {{-- customer Filter --}}
                    <div class="filter-select relative w-full">
                        <select name="customer" id="customer"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Customers</option>
                            @if (isset($customers))
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->customer}} | {{$customer->city}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    {{-- type Filter --}}
                    <div class="filter-select relative w-full">
                        <select name="type" id="search-type"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Types</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                            <option value="slip">Slip</option>
                            <option value="online">Online</option>
                            <option value="adjustment">Adjustment</option>
                        </select>
                    </div>
                    
                    {{-- status Filter --}}
                    <div class="filter-select relative w-full">
                        <select name="status" id="search-status"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="cleared">Cleared</option>
                        </select>
                    </div>
                </div>
            </form>

            <section class="text-center mx-auto ">
                <div
                    class="show-box mx-auto w-[80%] h-[70vh] bg-[--secondary-bg-color] rounded-xl shadow overflow-y-auto @if ($authLayout == 'grid') pt-7 pr-2 @endif relative">
                    @if ($authLayout == 'grid')
                        <div
                            class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-sm">
                            <h4>Show Articles</h4>
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
                                            class="absolute shadow-md text-nowrap border border-gray-600 z-10 -right-1 top-8 bg-[--h-secondary-bg-color] text-[--text-color] text-[12px] rounded px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">List</span>
                                    </button>
                                @else
                                    <button type="submit" class="group cursor-pointer">
                                        <i class='bx bx-grid-horizontal text-2xl text-white'></i>
                                        <span
                                            class="absolute shadow-md text-nowrap border border-gray-600 z-10 -right-1 top-8 bg-[--h-secondary-bg-color] text-[--text-color] text-[12px] rounded px-3 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">Grid</span>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>

                    @if (count($payments) > 0)
                        <div
                            class="add-new-article-btn absolute bottom-8 right-5 hover:scale-105 hover:bottom-9 transition-all group duration-300 ease-in-out">
                            <a href="{{ route('payment.create') }}"
                                class="bg-[--primary-color] text-[--text-color] px-3 py-2 rounded-full hover:bg-[--h-primary-color] transition-all duration-300 ease-in-out"><i
                                    class="fas fa-plus"></i></a>
                            <span
                                class="absolute shadow-xl right-7 top-0 border border-gray-600 transform -translate-x-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                Add
                            </span>
                        </div>


                        <div class="details h-full">
                            <div class="container-parent h-full overflow-y-auto my-scroller">
                                @if ($authLayout == 'grid')
                                    <div
                                        class="card_container p-5 pr-3 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                                        @foreach ($payments as $payment)
                                            <div data-payment="{{ $payment }}"
                                                class="contextMenuToggle toggleModal card relative border border-gray-600 shadow rounded-xl min-w-[100px] h-[8rem] flex gap-3 p-3 cursor-pointer overflow-hidden fade-in">
                                                <div class="img aspect-square h-full rounded overflow-hidden p-3">
                                                    <img src="{{ asset('storage/uploads/images/payment_icon.png') }}"
                                                        alt="" class="w-full h-full object-cover">
                                                    @if ($payment->type == 'cheque' || $payment->type == 'slip' && $payment->clear_date == 'Pending')
                                                        <div class="absolute top-0 right-0 group w-full h-full z-[1]">
                                                            <div
                                                                class="pending_dot absolute right-2 top-2 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                            </div>
                                                            <div
                                                                class="text-xs absolute opacity-0 right-2 top-1 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                                Pending</div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="details text-start">
                                                    <h5 class="text-2xl mt-1 text-[--text-color] font-semibold">
                                                        {{ $payment->customer->customer }}
                                                    </h5>
                                                    <p class="text-[--secondary-text] text-sm"><strong
                                                            class="font-medium">Date:</strong> <span
                                                            class="season">{{ $payment->date }}</span></p>
                                                    <p class="text-[--secondary-text] text-sm capitalize"><strong
                                                            class="font-medium">Type:</strong> <span
                                                            class="size">{{ $payment->type }}</span></p>
                                                    <p class="text-[--secondary-text] text-sm mt-"><strong
                                                            class="font-medium">Amount:</strong> <span
                                                            class="sales-rate">{{ $payment->amount }}</span></p>
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
                                            <div class="p-2">Date</div>
                                            <div class="p-2">Type</div>
                                            <div class="p-2">Amount</div>
                                        </div>
                                        @foreach ($payments as $payment)
                                            <div data-payment="{{ $payment }}"
                                                class="contextMenuToggle toggleModal relative group grid grid-cols-5 text-center border-b border-gray-600 items-center py-0.5 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all fade-in ease-in-out"
                                                onclick="toggleDetails(this)">
                                                @if ($payment->image == 'no_image_icon.png')
                                                    <div
                                                        class="warning_dot absolute top-4 left-3 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                    </div>
                                                    <div
                                                        class="text-xs absolute opacity-0 top-3 left-3 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                        No Image</div>
                                                @endif
                                                <div class="p-2">{{ $payment->customer->customer }}</div>
                                                <div class="p-2">{{ $payment->date }}</div>
                                                <div class="p-2 capitalize">{{ $payment->type }}</div>
                                                <div class="p-2">{{ $payment->amount }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="no-article-message w-full h-full flex flex-col items-center justify-center gap-2">
                            <h1 class="text-md text-[--secondary-text] capitalize">No Invoices yet</h1>
                            <a href="{{ route('payment.create') }}"
                                class="text-md bg-[--primary-color] text-[--text-color] px-4 py-2 rounded-md hover:bg-blue-600 transition-all duration-300 ease-in-out uppercase font-semibold">Add
                                New</a>
                        </div>
                    @endif
                </div>

                <div class="context-menu absolute top-0 text-sm z-50" style="display: none;">
                    <div
                        class="border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-md rounded-xl transform transition-all 0.3s ease-in-out z-50">
                        <ul class="p-2">
                            <li>
                                <button id="show-details" type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Show
                                    Details</button>
                            </li>
                            <li>
                                <button id="print-payment-context" type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Print
                                    payment</button>
                            </li>
                            <li>
                                <a id="track-article" href="{{ route('article-track') }}"
                                    class="flex w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Track
                                    Article</a>
                            </li>
                            <li id="add-img-in-context">
                                <button id="add-img-in-context-btn"
                                    class="font-medium text-[--border-warning] w-full px-4 py-2 text-left hover:bg-[--bg-warning] hover:text-[--text-warning] rounded-md transition-all 0.3s ease-in-out">Add
                                    Image</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script>
        let contextMenu = document.querySelector('.context-menu');
        let isContextMenuOpened = false;
        let isPaymentModalOpened = false;

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
            let item = e.target.closest('.toggleModal');
            let payment = JSON.parse(item.dataset.payment);

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

            openContextMenu();

            document.addEventListener('click', (e) => {
                if (e.target.id === "show-details") {
                    generatePaymentModal(item, 'openModal');
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

        let customerSelect = document.getElementById("customer");
        let searchTypeDom = document.getElementById("search-type");
        let searchStatusDom = document.getElementById("search-status");

        function fetchPayments() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const customerId = customerSelect ? customerSelect.value : "";
            const searchType = searchTypeDom ? searchTypeDom.value : "";
            const searchStatus = searchStatusDom ? searchStatusDom.value : "";

            let formData = $('#search-form').serialize(); // Serialize form data
            let formAction = $('#search-form').attr('action'); // Get form action URL

            $.ajax({
                url: formAction,
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    customer_id: customerId,
                    type: searchType,
                    status: searchStatus
                },
                success: function(response) {
                    let details = $(response).find('.details').html(); // Extract relevant HTML

                    if (!details || details.trim() === "") {
                        $('.details').html(
                            '<div class="text-center text-[--border-error] pt-5 col-span-4">Payment Not Found</div>'
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
                    console.error("Error:", error);
                }
            });
        }

        $('#search-form').on('change', 'select', function(e) {
            e.preventDefault();
            fetchPayments();
        });

        const close = document.getElementById('close');

        function addListnerToCard() {
            let card = document.querySelectorAll('.toggleModal')
            isPaymentModalOpened = false;

            card.forEach(item => {
                item.addEventListener('click', () => {
                    generatePaymentModal(item, 'openModal');
                })
            })
        }
        addListnerToCard()

        function openInvoiceModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            isPaymentModalOpened = true;
            closeAllDropdowns();
            closeContextMenu()
        }

        function closeInvoiceModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        close.addEventListener('click', () => {
            closeInvoiceModal()
        })

        document.getElementById('paymentModal').addEventListener('click', (e) => {
            if (e.target.id === 'paymentModal') {
                closeInvoiceModal()
            }
        })

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isPaymentModalOpened) {
                closeInvoiceModal()
            }
            closeContextMenu()
        })

        let modalContent = document.querySelector('#modalContent');

        function generatePaymentModal(item, context) {
            let payment = JSON.parse(item.dataset.payment)
            document.querySelector('#pending_dot').classList.add('hidden')

            if (payment.clear_date == "Pending") {
                document.querySelector('#pending_dot').classList.remove('hidden')
            }

            document.getElementById('paymentModal').classList.remove('hidden')
            modalContent.innerHTML = `
                <h5 class="text-4xl mt-1 mb-3 text-[--text-color] capitalize font-semibold sticky top-0 bg-[--secondary-bg-color] py-2">${payment.customer.customer}</h5>
                <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Date:</strong> <span>${payment.date}</span></p>
                <p class="text-[--secondary-text] mb-1 tracking-wide capitalize text-md"><strong>Type:</strong> <span>${payment.type}</span></p>
                <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Amount:</strong> <span>${payment.amount}</span></p>
                <hr class="my-3 mx-auto border-gray-600">`
                if (payment.type == 'cheque') {
                    modalContent.innerHTML += `
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Cheque No:</strong> <span>${payment.cheque_no}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Bank Name:</strong> <span>${payment.bank}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Issue Date:</strong> <span>${payment.issue_date}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Clear Date:</strong> <span>${payment.clear_date}</span></p>
                        <hr class="my-3 mx-auto border-gray-600">
                    `;
                } else if (payment.type == 'slip') {
                    modalContent.innerHTML += `
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Slip No:</strong> <span>${payment.slip_no}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Party Name:</strong> <span>${payment.party}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Issue Date:</strong> <span>${payment.issue_date}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Clear Date:</strong> <span>${payment.clear_date}</span></p>
                        <hr class="my-3 mx-auto border-gray-600">
                    `;
                } else if (payment.type == 'online') {
                    modalContent.innerHTML += `
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Transaction ID:</strong> <span>${payment.t_id}</span></p>
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Bank Name:</strong> <span>${payment.bank}</span></p>
                        <hr class="my-3 mx-auto border-gray-600">
                    `;
                } else if (payment.type == 'adjustment') {
                    modalContent.innerHTML += `
                        <p class="text-[--secondary-text] mb-1 tracking-wide text-md"><strong>Remarks:</strong> <span>${payment.remarks}</span></p>
                        <hr class="my-3 mx-auto border-gray-600">
                    `;
                }
            ;

            if (context == 'context') {
                document.getElementById('printInvoice').click();
            } else {
                openInvoiceModal()
            }
        }
    </script>
@endsection
