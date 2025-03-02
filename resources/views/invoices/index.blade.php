@extends('layouts.app')
@section('title', 'Show Invoice | Track Point')
@section('content')
@php $authLayout = Auth::user()->layout; @endphp
    <!-- Modal -->
    <div id="InvoiceModal"
        class="mainModal hidden fixed flex-col space-y-4 inset-0 z-50 items-center justify-center bg-black bg-opacity-50 fade-in">
    <!-- Modal Content -->
        <div class="bg-white rounded-xl shadow-lg relative">
            <!-- Close Button -->
            <button id="close"
                class="absolute z-[10] top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Body -->
            <div id="modal_body" class="modal_body px-12 pt-4 pb-8 flex items-start gap-6 w-full text-black h-[45rem] overflow-y-auto my-scroller-2">
                <div id="invoice-container" class="w-[210mm] h-[297mm] mx-auto overflow-hidden relative">
                    <div id="invoice" class="invoice flex flex-col h-full">
                        <h1 class="text-[--danger-color] font-medium text-center mt-5">No Preview avalaible.</h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modal-action"
            class="bg-[--secondary-bg-color] rounded-2xl shadow-lg max-w-3xl w-auto p-5 relative text-sm">
            <div class="flex gap-4">
                <div class="btns flex gap-3">
                    <button id="printInvoice" type="button"
                        class="w-full px-5 py-2 text-nowrap text-center border border-gray-600 hover:bg-[--h-bg-color] rounded-lg transition-all 0.3s ease-in-out">Print
                        Invoice</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]">
                Show Invoice
            </h1>

            <!-- Search Form -->
            <form id="search-form" method="GET" action="{{ route('invoice.index') }}"
                class="search-box w-[80%] mx-auto my-5 flex items-center gap-4">
                <!-- Search Input -->
                <div class="search-input relative flex-1">
                    <input type="text" name="search" id="search" placeholder="Search Invoice Number" autocomplete="off"
                        class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                </div>

                <!-- Filters -->
                <div class="filter-box flex flex-1 items-center gap-4">
                    {{-- customer Filter --}}
                    <div class="filter-select relative w-full">
                        <select name="customer" id="customer"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Customer</option>
                            @if (isset($customers))
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->id}}">{{$customer->customer}} | {{$customer->city}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </form>

            <section class="text-center mx-auto">
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

                    @if (count($invoices) > 0)
                        <div
                            class="add-new-article-btn absolute bottom-8 right-5 hover:scale-105 hover:bottom-9 transition-all group duration-300 ease-in-out">
                            <a href="{{ route('invoice.create') }}"
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
                                        @foreach ($invoices as $invoice)
                                            <div data-invoice="{{ $invoice }}"
                                                class="contextMenuToggle toggleModal card relative border border-gray-600 shadow rounded-xl min-w-[100px] h-[8rem] flex gap-3 p-3 cursor-pointer overflow-hidden fade-in">
                                                <div class="img aspect-square h-full rounded overflow-hidden p-3">
                                                    <img src="{{ asset('storage/uploads/images/invoice_icon.png') }}" alt=""
                                                        class="w-full h-full object-cover">
                                                    <div class="absolute top-0 right-0 group w-full h-full z-[1]">
                                                        <div
                                                            class="invoice_dot absolute right-2 top-2 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                        </div>
                                                        <div
                                                            class="text-xs absolute opacity-0 right-2 top-1 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                            Invoice</div>
                                                    </div>
                                                </div>
                                                <div class="text-start">
                                                    <h5 class="text-2xl mt-1 text-[--text-color] font-semibold">
                                                        {{ $invoice->invoice_no }}
                                                    </h5>
                                                    <p class="text-[--secondary-text] text-sm"><strong
                                                            class="font-medium">Date:</strong> <span
                                                            class="season">{{ $invoice->date }}</span></p>
                                                    <p class="text-[--secondary-text] text-sm"><strong
                                                            class="font-medium">Customer:</strong> <span
                                                            class="size">{{ $invoice->customer->customer }}</span></p>
                                                    <p class="text-[--secondary-text] text-sm mt-"><strong
                                                            class="font-medium">Net Amount:</strong> <span
                                                            class="sales-rate">{{ $invoice->net_amount }}</span></p>
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
                                            <div class="p-2">Invoice No</div>
                                            <div class="p-2">Date</div>
                                            <div class="p-2">Customer</div>
                                            <div class="p-2">Net Amount</div>
                                        </div>
                                        @foreach ($invoices as $invoice)
                                            <div data-invoice="{{ $invoice }}"
                                                class="contextMenuToggle toggleModal relative group grid grid-cols-5 text-center border-b border-gray-600 items-center py-0.5 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all fade-in ease-in-out"
                                                onclick="toggleDetails(this)">
                                                @if ($invoice->image == 'no_image_icon.png')
                                                    <div
                                                        class="warning_dot absolute top-4 left-3 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                    </div>
                                                    <div
                                                        class="text-xs absolute opacity-0 top-3 left-3 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                        No Image</div>
                                                @endif
                                                <div class="p-2">{{ $invoice->invoice_no }}</div>
                                                <div class="p-2">{{ $invoice->date }}</div>
                                                <div class="p-2">{{ $invoice->customer->customer }}</div>
                                                <div class="p-2">{{ $invoice->net_amount }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="no-article-message w-full h-full flex flex-col items-center justify-center gap-2">
                            <h1 class="text-md text-[--secondary-text] capitalize">No Invoices yet</h1>
                            <a href="{{ route('invoice.create') }}"
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
                                <button id="print-invoice-context" type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Print
                                    Invoice</button>
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
        let isInvoiceModalOpened = false;

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
            let Invoice = JSON.parse(item.dataset.invoice);

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
                    generateInvoiceModal(item, 'openModal');
                };
            });

            document.addEventListener('click', (e) => {
                if (e.target.id === "print-invoice-context") {
                    generateInvoiceModal(item, 'context')
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
        
        let searchInp = document.querySelector('#search');
        let customerSelect = document.getElementById("customer");

        function fetchInvoices() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const query = searchInp ? searchInp.value : "";
        const customerId = customerSelect ? customerSelect.value : "";

        let formData = $('#search-form').serialize(); // Serialize form data
        let formAction = $('#search-form').attr('action'); // Get form action URL

            $.ajax({
                url: formAction,
                method: "GET",
                headers: {
                    "X-CSRF-TOKEN": csrfToken
                },
                data: {
                    query: query,
                    customer_id: customerId
                },
                success: function (response) {
                    let details = $(response).find('.details').html(); // Extract relevant HTML

                    if (!details || details.trim() === "") {
                        $('.details').html(
                            '<div class="text-center text-[--border-error] pt-5 col-span-4">Invoice Not Found</div>'
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
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        if (searchInp) {
            searchInp.addEventListener("input", function (e) {
                e.preventDefault();
                fetchInvoices();
            });
        }

        // Trigger search when changing the customer dropdown
        if (customerSelect) {
            customerSelect.addEventListener("change", function (e) {
                e.preventDefault();
                fetchInvoices();
            });
        }

        const close = document.getElementById('close');

        function addListnerToCard() {
            let card = document.querySelectorAll('.toggleModal')
            isInvoiceModalOpened = false;

            card.forEach(item => {
                item.addEventListener('click', () => {
                    generateInvoiceModal(item, 'openModal');
                })
            })
        }
        addListnerToCard()

        function openInvoiceModal() {
            document.getElementById('InvoiceModal').classList.remove('hidden');
            document.getElementById('InvoiceModal').classList.add('flex');
            isInvoiceModalOpened = true;
            closeAllDropdowns();
            closeContextMenu()
        }

        function closeInvoiceModal() {
            document.getElementById('InvoiceModal').classList.add('hidden');
            document.getElementById('InvoiceModal').classList.remove('flex');
        }

        close.addEventListener('click', () => {
            closeInvoiceModal()
        })

        document.getElementById('InvoiceModal').addEventListener('click', (e) => {
            if (e.target.id === 'InvoiceModal') {
                closeInvoiceModal()
            }
        })

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isInvoiceModalOpened) {
                closeInvoiceModal()
            }
            closeContextMenu()
        })

        function generateInvoiceModal(item, context) {
            
            let invoiceDom = document.getElementById('invoice');
            let invoice = JSON.parse(item.dataset.invoice);
            console.log(invoice);

            let totalAmount = 0;
            let totalQuantity = 0;
            let articlesArray = JSON.parse(invoice.articles_array)

            invoiceDom.innerHTML = `
                <div id="invoice-banner" class="invoice-banner w-full flex justify-between mt-8 px-5">
                    <div class="left w-50">
                        <div class="invoice-logo">
                            <img src="{{ asset('storage/uploads/images/Spark-Pair1.png') }}" alt="Track Point"
                                class="w-[150px]" />
                        </div>
                    </div>
                    <div class="right w-50 my-auto pr-3">
                        <div class="invoice-date text-sm text-gray-400">Date: ${invoice.date}</div>
                        <div class="invoice-number text-sm text-gray-400">Invoice No.: ${invoice.invoice_no}</div>
                        <div class="invoice-copy text-sm text-gray-400">Invoice Copy: Customer</div>
                    </div>
                </div>
                <hr class="w-100 my-5 border-gray-600">
                <div id="invoice-header" class="invoice-header w-full flex justify-between px-5">
                    <div class="left w-50">
                        <div class="invoice-to text-sm text-gray-400">Invoice to:</div>
                        <div class="invoice-customer text-lg">${invoice.customer.customer}</div>
                        <div class="invoice-person text-md">${invoice.customer.person_name}</div>
                        <div class="invoice-address text-md">${invoice.customer.address}, ${invoice.customer.city}</div>
                        <div class="invoice-phone text-md">${invoice.customer.phone.replace(/(\d{4})(\d{7})/, '$1-$2')}</div>
                    </div>
                    <div class="right w-50">
                        <div class="invoice-from text-sm text-gray-400">Invoice from:</div>
                        <div class="invoice-customer text-lg">M/s Track Point</div>
                        <div class="invoice-person text-md">Mr. Hasan</div>
                        <div class="invoice-address text-md">Meetha Dar, Karachi</div>
                        <div class="invoice-phone text-md">0312-5214864</div>
                    </div>
                </div>
                <hr class="w-100 mt-5 mb-5 border-gray-600">
                <div id="invoice-body" class="invoice-body w-[95%] grow mx-auto">
                    <div class="invoice-table w-full">
                        <div class="table w-full border border-gray-600 rounded-md pb-4 overflow-hidden">
                            <div class="thead w-full">
                                <div class="tr flex justify-between w-full px-4 py-2 bg-[--primary-color] text-white">
                                    <div class="th text-sm font-medium w-[6%]">#.</div>
                                    <div class="th text-sm font-medium w-1/6">Artical No.</div>
                                    <div class="th text-sm font-medium grow">Description.</div>
                                    <div class="th text-sm font-medium w-1/6">Quantity/Pcs.</div>
                                    <div class="th text-sm font-medium w-1/6">Rate/Pcs.</div>
                                    <div class="th text-sm font-medium w-[12%]">Total.</div>
                                </div>
                            </div>
                            <div id="tbody" class="tbody w-full">
                                ${articlesArray.map((article, index) => {
                                    totalAmount += article.amount;
                                    totalQuantity += parseFloat(article.quantity);
                                    if (index == 0) {
                                        return `
                                                    <div>
                                                        <hr class="w-full mb-3 border-gray-600">
                                                        <div class="tr flex justify-between w-full px-4">
                                                            <div class="td text-sm font-semibold w-[6%]">${index + 1}.</div>
                                                            <div class="td text-sm font-semibold w-1/6">#${article.articleNo}</div>
                                                            <div class="td text-sm font-semibold grow">${article.description}</div>
                                                            <div class="td text-sm font-semibold w-1/6">${article.quantity}</div>
                                                            <div class="td text-sm font-semibold w-1/6">${article.salesRate}</div>
                                                            <div class="td text-sm font-semibold w-[12%]">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(article.amount)}</div>
                                                        </div>
                                                    </div>
                                                `;
                                    } else {
                                        return `
                                                    <div>
                                                        <hr class="w-full my-3 border-gray-600">
                                                        <div class="tr flex justify-between w-full px-4">
                                                            <div class="td text-sm font-semibold w-[6%]">${index + 1}.</div>
                                                            <div class="td text-sm font-semibold w-1/6">#${article.articleNo}</div>
                                                            <div class="td text-sm font-semibold grow">${article.description}</div>
                                                            <div class="td text-sm font-semibold w-1/6">${article.quantity}</div>
                                                            <div class="td text-sm font-semibold w-1/6">${article.salesRate}</div>
                                                            <div class="td text-sm font-semibold w-[12%]">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(article.amount)}</div>
                                                        </div>
                                                    </div>
                                                `;
                                    }
                                }).join('')}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="w-full my-4 border-gray-600">
                <div class="flex flex-col space-y-2">
                    <div id="invoice-total" class="tr flex justify-between w-full px-2 gap-2 text-sm">
                        <div class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Total Quantity - Pcs</div>
                            <div class="w-1/4 text-right grow">${totalQuantity}</div>
                        </div>
                        <div class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Total Amount</div>
                            <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(totalAmount)}</div>
                        </div>
                        <div class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Discount - %</div>
                            <div class="w-1/4 text-right grow">${invoice.discount}</div>
                        </div>
                    </div>
                    <div id="invoice-total" class="tr flex justify-between w-full px-2 gap-2 text-sm">
                        <div class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Previous Balance</div>
                            <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(invoice.previous_balance)}</div>
                        </div>
                        <div
                            class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Net Amount</div>
                            <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(invoice.net_amount)}</div>
                        </div>
                        <div
                            class="total flex justify-between items-center border border-gray-600 rounded-md py-2 px-4 w-full">
                            <div class="text-nowrap">Current Balance</div>
                            <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(parseFloat(parseFloat(invoice.previous_balance) + parseFloat(invoice.net_amount)))}</div>
                        </div>
                    </div>
                </div>
                <hr class="w-full my-4 border-gray-600">
                <div class="tfooter flex w-full text-sm px-4 justify-between mb-4">
                    <P>Company Name</P>
                    <p>&copy; Track Point | sparkpair.com | Spark Pair 2025.</p>
                </div>
            `;
            
            if (context == 'context'){
                document.getElementById('printInvoice').click();
            } else {
                openInvoiceModal()
            }
        }

        // document.getElementById('printInvoice').addEventListener('click', (e) => {
        //     e.preventDefault();
        //     const invoice = document.getElementById('invoice-container'); // Invoice content
        //     const printWindow = window.open('', '_blank', 'width=1500,height=800'); // Open new print window

        //     if (!printWindow) {
        //         alert('Popup blocked! Please allow popups for this website.');
        //         return;
        //     }

        //     const headContent = document.head.innerHTML; // Get head content (styles & meta tags)
            
        //     printWindow.document.write(`
        //         <html>
        //             <head>
        //                 <title>Print Invoice</title>
        //                 ${headContent} <!-- Copy current styles -->
        //                 <style>
        //                     @media print {
        //                         @page {
        //                             size: A4; /* Set paper size to A4 */
        //                             margin: defaul; /* Set 20mm margin on all sides */
        //                         }

        //                         body {
        //                             margin: 0;
        //                             padding: 0;
        //                             width: 210mm; /* A4 width */
        //                             height: 297mm; /* A4 height */
        //                         }

        //                         .invoice-container, .invoice-container * {
        //                             page-break-inside: avoid;
        //                         }
        //                     }
        //                 </style>
        //             </head>
        //             <body>
        //                 <div class="invoice-container">${invoice.innerHTML}</div> <!-- Add the invoice content, only innerHTML -->
        //                 <div id="invoice-container" class="invoice-container">${invoice.innerHTML}</div> <!-- Add the invoice content, only innerHTML -->
        //             </body>
        //         </html>
        //     `);

        //     printWindow.document.close();
        //     printWindow.focus();

        //     printWindow.onload = () => {
                
        //         // Select the invoice-copy div and update its text
        //         let invoiceCopy = printWindow.document.querySelector('#invoice-container .invoice-copy');
        //         if (invoiceCopy) {
        //             invoiceCopy.textContent = "Invoice Copy: Office"; // Change text to "Invoice Copy: Office"
        //         }

        //         setTimeout(() => {
        //             printWindow.print();
        //             printWindow.close();
        //         }, 1000); // 1 sec delay to load styles
        //     };
        // });

        document.getElementById('printInvoice').addEventListener('click', (e) => {
            e.preventDefault();
            closeAllDropdowns();
            const invoice = document.getElementById('invoice-container'); // Invoice content

            // Pehle se agar koi iframe hai to usko remove karein
            let oldIframe = document.getElementById('printIframe');
            if (oldIframe) {
                oldIframe.remove();
            }

            // Naya iframe banayein
            let printIframe = document.createElement('iframe');
            printIframe.id = "printIframe";
            printIframe.style.position = "absolute";
            printIframe.style.width = "0px";
            printIframe.style.height = "0px";
            printIframe.style.border = "none";
            printIframe.style.display = "none"; // ✅ Hide iframe

            // Iframe ko body me add karein
            document.body.appendChild(printIframe);

            let printDocument = printIframe.contentDocument || printIframe.contentWindow.document;
            printDocument.open();

            // ✅ Current page ke CSS styles bhi iframe me inject karenge
            const headContent = document.head.innerHTML;

            printDocument.write(`
                <html>
                    <head>
                        <title>Print Invoice</title>
                        ${headContent} <!-- Copy current styles -->
                        <style>
                            @media print {

                                body {
                                    margin: 0;
                                    padding: 0;
                                    width: 210mm; /* A4 width */
                                    height: 297mm; /* A4 height */
                                }

                                .invoice-container, .invoice-container * {
                                    page-break-inside: avoid;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="invoice-container">${invoice.innerHTML}</div> <!-- Add the invoice content, only innerHTML -->
                        <div id="invoice-container" class="invoice-container">${invoice.innerHTML}</div> <!-- Add the invoice content, only innerHTML -->
                    </body>
                </html>
            `);

            printDocument.close();

            // Wait for iframe to load and print
            printIframe.onload = () => {

                // Select the invoice-copy div and update its text
                let invoiceCopy = printDocument.querySelector('#invoice-container .invoice-copy');

                if (invoiceCopy) {
                    invoiceCopy.textContent = "Invoice Copy: Office"; // Change text to "Invoice Copy: Office"
                }

                setTimeout(() => {
                    printIframe.contentWindow.focus();
                    printIframe.contentWindow.print();
                    document.body.removeChild(printIframe); // Remove iframe after printing
                }, 1000);
            };
        });
    </script>
@endsection