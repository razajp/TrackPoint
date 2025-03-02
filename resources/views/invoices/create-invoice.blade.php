@extends('layouts.app')
@section('title', 'Create Invoice | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]">
                Create Invoice
            </h1>

            <!-- Progress Bar -->
            <div class="mb-5 max-w-4xl mx-auto ">
                <div class="flex justify-between mb-2 progress-indicators">
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--primary-color] transition-all 0.3s ease-in-out cursor-pointer"
                        id="step1-indicator" onclick="gotoStep(1)">
                        Enter Details
                    </span>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--h-bg-color] transition-all 0.3s ease-in-out cursor-pointer"
                        id="step2-indicator" onclick="gotoStep(2)">
                        Preview
                    </span>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden bg-[--h-bg-color] rounded-full">
                    <div class="transition-all duration-500 ease-in-out w-1/2 bg-[--primary-color]" id="progress-bar"></div>
                </div>
            </div>
            
            <!-- Form -->
            <form id="form" action="{{ route('invoice.store') }}" method="post" enctype="multipart/form-data"
                class="bg-[--secondary-bg-color] rounded-xl rounded-tl-2xl rounded-tr-2xl shadow-xl border border-[--h-bg-color] max-w-4xl mx-auto relative">
                @csrf
                <div
                    class="form-title absolute top-0 left-0 w-full bg-[--primary-color] py-1 rounded-tl-xl rounded-tr-xl shadow-lg">
                    <h4 class="text-center uppercase font-semibold text-xs">Create Invoice</h4>
                    <div id="btn-in-form" class="hidden buttons absolute top-0.5 right-2 flex gap-3">
                        <div class="relative group">
                            <!-- Main Button -->
                            <a id="trigger1" class="dropdown-trigger group cursor-pointer">
                                <i class="bx bxs-file-export text-sm"></i>
                                <span
                                    class="absolute shadow-xl left-12 top-1/2 border border-gray-600 text-xs transform -translate-y-1/2 bg-[--secondary-bg-color] text-[--text-color] text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                    Export
                                </span>
                            </a>
                            <div id="menu1"
                                class="dropdownMenu text-sm absolute -top-1/2 left-12 hidden border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-lg rounded-xl opacity-0 transform scale-95 transition-all duration-300 ease-in-out z-50">
                                <ul class="p-2">
                                    <li>
                                        <button id="printInvoice" type="button"
                                            class="block w-full text-left px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                            Print
                                        </button>
                                    </li>
                                    <li>
                                        <button id="exportPDF" type="button"
                                            class="block w-full text-left px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                            Export PDF
                                        </button>
                                    </li>
                                    <li>
                                        <button id="exportExcel" type="button"
                                            class="block w-full text-left px-4 py-2 hover:bg-[--h-bg-color] rounded-md transition-all duration-200 ease-in-out">
                                            Export Excel
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step : Information -->
                <div id="step1" class="step1 space-y-4 p-8">
                    <div class="article_image absolute -left-[17rem] top-0 bg-[--secondary-bg-color] rounded-xl shadow-xl border border-gray-600 p-4 overflow-hidden max-w-sm w-[15rem] transition-all 0.3s ease-in-out opacity-0">
                        <div class="img aspect-square h-full rounded-md overflow-hidden">
                            <img src="{{ asset('storage/uploads/images/invoice_icon.png') }}" alt=""
                                class="w-full h-full object-cover">
                            <div class="error hidden h-full flex flex-col items-center justify-center">
                                <img src="{{ asset('storage/uploads/images/error_icon.png') }}" alt=""
                                class="w-1/2 h-1/2 object-cover">
                                <span class="mt-3">Article Not Found!</span>
                            </div>
                            <div class="absolute top-0 right-0 group w-full h-full z-[1]">
                                <div
                                    class="img_dot absolute left-3 top-3 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                </div>
                                <div
                                    class="img_dot_text text-xs absolute opacity-0 left-3 top-2 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                    No Image</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between gap-4">
                        <div class="form-group grow">
                            <div class="relative">
                                <select id="customer" name="customer_id"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.3s ease-in-out">
                                    <option value="">-- select customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ str_replace(' ', '-', $customer->id) }}" last-invoice="{{ $last_invoice }}"
                                            person-name="{{ $customer->person_name }}" customer-data="{{ $customer }}">
                                            {{ $customer->customer }} |
                                            {{ $customer->city }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="customer-error" class="text-[--border-error] text-xs mt-1 hidden">Customer selection is required. Please choose a customer to proceed.</div>
                            </div>
                        </div>
                        <div class="form-group w-1/3">
                            <input id="selected_person" type="text" disabled
                                class="w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.3s ease-in-out"
                                placeholder="Select Customer First." />
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between gap-4">
                            <div class="form-group grow relative">
                                <input id="article_no" type="text" list="article_list"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.3s ease-in-out"
                                    placeholder="Enter Article No." autocomplete="off"/>
                                
                                <datalist id="article_list">
                                    @foreach($articlesNo as $articleNo)
                                        <option value="{{ $articleNo->article_no }}"></option>
                                    @endforeach
                                </datalist>
                            </div>          
                            <div class="form-group w-1/3 relative">
                                <input id="quantity" type="number"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.3s ease-in-out"
                                    placeholder="Enter Quantity" />
                                <span
                                    class="absolute right-3 bg-[--h-bg-color] top-1/2 transform -translate-y-1/2 text-gray-400 transition-all 0.3s ease-in-out">/Pcs</span>
                            </div>
                            <div class="form-group w-1/3 relative">
                                <input id="quantity_in_stock" type="text" disabled placeholder="Stock"
                                    class="w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.3s ease-in-out" />
                                <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">/Pcs</span>
                            </div>
                            <div class="form-group flex w-10 shrink-0">
                                <input id="addArticleBtn" type="button" value="+"
                                    class="w-full bg-[--primary-color] text-[--text-color] rounded-lg cursor-pointer border border-[--primary-color] hover:bg-[--h-primary-color] transition-all 0.3s ease-in-out"
                                    onclick="addArticle()" />
                            </div>
                        </div>
                        <div id="article-error" class="text-[--border-error] text-xs mt-1 hidden">An article is required. Please add one before proceeding.</div>
                    </div>
                    <div id="rate-table" class="w-full text-left">
                        <div class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-5 mb-4">
                            <div class="w-[10%]">Article No.</div>
                            <div class="w-1/6">Description</div>
                            <div class="w-[10%]">Quantity/Pcs</div>
                            <div class="w-1/6 text-center">Rate/Pcs</div>
                            <div class="w-1/6 text-center">Total</div>
                            <div class="w-[10%] text-right">Action</div>
                        </div>
                        <div id="article-list" class="space-y-4 h-[250px] overflow-y-auto my-scroller-2">
                            <div class="text-center bg-[--h-bg-color] rounded-lg py-2 px-5">
                                No Article Added
                            </div>
                        </div>
                    </div>
                    <div id="calc-bottom" class="flex w-full gap-4">
                        <div class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                            <div class="text-nowrap">Total Qty - Pcs.</div>
                            <div class="grow text-right">0</div>
                        </div>
                        <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                            <div class="text-nowrap">Total.</div>
                            <div id="total-amount" class="grow text-right">0.00</div>
                        </div>
                        <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                            <div class="text-nowrap">Off - %.</div>
                            <input type="number" oninput="calculateNetAmount(this.value)" name="discount" id="discount-inp"
                                class="text-right bg-transparent outline-none border-none w-full" min="0" max="100" placeholder="Enter here"/>   
                        </div>
                        @error('discount')
                            <!-- Display error message for 'discount' -->
                            <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                        @enderror
                        <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                            <div class="text-nowrap">Net.</div>
                            <div id="net-amount" class="grow text-right">0.00</div>
                        </div>
                    </div>
                    <input type="hidden" name="articles_array" id="articles_array" value="[]" />
                    <input type="hidden" name="date" id="invoice-date"/>
                    <input type="hidden" name="invoice_no" id="invoice-no"/>
                    <input type="hidden" name="total_quantity" id="total-quantity-inp"/>
                    <input type="hidden" name="total_amount" id="total-amount-inp"/>
                    <input type="hidden" name="net_amount" id="net-amount-inp"/>
                </div>
                <!-- Step 2 : Preview -->
                <div id="step2"
                    class="step2 mt-6 hidden space-y-6  text-black h-[35rem] overflow-y-auto my-scroller-2">
                    <div id="invoice-container" class="w-[210mm] h-[297mm] mx-auto overflow-hidden relative">
                        <div id="invoice" class="invoice flex flex-col h-full">
                            <h1 class="text-[--danger-color] font-medium text-center mt-5">No Preview avalaible.</h1>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        let customerDom = document.getElementById('customer');
        let customerError = document.querySelector('#customer-error');
        let selectedPersonDom = document.getElementById('selected_person');
        let articleNoDom = document.getElementById('article_no');
        let quantityDom = document.getElementById('quantity');
        let quantityInStockDom = document.getElementById('quantity_in_stock');
        let articleError = document.querySelector('#article-error');
        let calcBottom = document.querySelector('#calc-bottom');
        let articlesArrayDom = document.getElementById('articles_array');
        let articleList = document.querySelector('#article-list');
        let invoiceNoDom = document.getElementById('invoice-no');
        let invoiceDateDom = document.getElementById('invoice-date');
        let totalAmountInpDom = document.getElementById('total-amount-inp');
        let netAmountInpDom = document.getElementById('net-amount-inp');
        let totalQuantityInpDom = document.getElementById('total-quantity-inp');

        let step1 = document.getElementById('step1');

        if (step1.classList.contains('hidden')) {
            console.log("sfasf");
        }

        let salesRate = 0;
        let articleCount = 0;
        let description;

        let totalarticle = 0;

        let articlesArray = [];

        let totalQuantity = 0;
        let totalAmount = 0;
        let discount = 0;
        let netAmount = 0;

        customerDom.addEventListener('change', function() {
            let selectedCustomer = customerDom.value;
            let personName = customerDom.options[customerDom.selectedIndex].getAttribute('person-name');
            selectedPersonDom.value = personName;
            if (selectedCustomer != "selected") {
                customerError.classList.add('hidden');
                customerDom.classList.remove("border-[--border-error]");
            }
        })

        articleNoDom.addEventListener("input", function () {
            let selectedValue = articleNoDom.value;
            let options = document.querySelectorAll("#article_list option");
            let matchFound = false;

            options.forEach((option) => {
                if (option.value === selectedValue) {
                    matchFound = true;
                }
            });

            // if inpt is not empty,
            if (selectedValue != "") {
                fetchArticleDetails();
            } else {
                articleImage.classList.add("opacity-0");
            }
        });

        articleNoDom.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault(); // Prevent form submission or focus shift
                fetchArticleDetails();
            }
        });

        let articleImage = document.querySelector(".article_image");
        let articleImageTag = document.querySelector(".article_image img");
        let articleImageError = document.querySelector(".article_image .error");
        let imgDot = document.querySelector(".img_dot");
        let imgDotText = document.querySelector(".img_dot_text");
        function fetchArticleDetails() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            articleImage.classList.add("opacity-0");

            $.ajax({
                url: "/get-article-details",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                data: {
                    article_no: articleNoDom.value,
                },
                success: function (response) {
                    if (response && response.quantity_in_stock !== undefined) {
                        articleNoDom.classList.remove("border-[--border-error]");
                        articleError.textContent = 'Please enter a quantity before proceeding.'
                        quantityInStockDom.value = response.quantity_in_stock;
                        articleImage.classList.remove("opacity-0");
                        articleImageTag.src = `/storage/uploads/images/${response.image}`;

                        articleImageError.classList.add("hidden");
                        articleImageTag.classList.remove("hidden");
                        
                        description = response.description;

                        if (response.image !== "no_image_icon.png") {
                            imgDot.classList.add("bg-transparent");
                            imgDotText.classList.add("text-transparent");
                            imgDot.classList.remove("bg-[--border-warning]");
                            imgDot.classList.remove("bg-[--border-error]");
                            imgDotText.classList.remove("text-[--border-warning]");
                            imgDotText.classList.remove("text-[--border-error]");
                        } else {
                            imgDot.classList.remove("bg-transparent");
                            imgDot.classList.remove("bg-[--border-error]");
                            imgDotText.classList.remove("text-transparent");
                            imgDotText.classList.remove("text-[--border-error]");
                            imgDot.classList.add("bg-[--border-warning]");
                            imgDotText.classList.add("text-[--border-warning]");
                            imgDotText.textContent = "No Image";
                        }
                    } else {
                        quantityInStockDom.value = "";
                        alert("Article not found or invalid");
                    }

                    salesRate = response.sales_rate;
                },
                error: function () {
                    quantityInStockDom.value = "Article not found.";
                    articleImage.classList.remove("opacity-0");

                    articleImageError.classList.remove("hidden");
                    articleImageTag.classList.add("hidden");
                    
                    imgDot.classList.remove("bg-transparent", "bg-[--border-warning]");
                    imgDotText.classList.remove("text-transparent", "text-[--border-warning]");
                    imgDot.classList.add("bg-[--border-error]");
                    imgDotText.classList.add("text-[--border-error]");
                    imgDotText.textContent = "Article Not Found";
                },
            });
        }

        quantityDom.addEventListener("input", function () {
            let stock = parseInt(quantityInStockDom.value, 10);
            let quantityValue = parseInt(quantityDom.value, 10) || 0;

            // Set max attribute to prevent higher values
            quantityDom.setAttribute("max", stock);

            if (quantityValue > stock) {
                quantityDom.value = stock; // Reset to max stock
                articleError.classList.remove("hidden");
                articleError.textContent = `Maximum stock available: ${stock} Pcs.`;
            } else {
                articleError.classList.add("hidden");
            }
        });


        function addArticle() {
            articleNoDom.classList.remove("border-[--border-error]");
            quantityDom.classList.remove("border-[--border-error]");
            articleError.classList.add("hidden");

            articleImage.classList.add("opacity-0");
            quantityInStockDom.value = '';
            let article = articleNoDom.value.replace('#', '');
            let quantity = quantityDom.value;

            let filterdArticle = articlesArray.filter(item => item.articleNo === article)

            if (article && quantity) {
                if (filterdArticle.length > 0) {
                    filterdArticle.forEach(article => {
                        if (article.articleNo === articleNoDom.value.replace('#', '')) {
                            article.quantity = parseFloat(article.quantity) + parseFloat(quantity)
                            let duplicateDiv = document.getElementById(`${articleNoDom.value}`)
                            duplicateDiv.children[2].textContent = parseFloat(duplicateDiv.children[2]
                                .textContent) + parseFloat(quantity)

                            duplicateDiv.children[4].textContent = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(parseFloat((parseFloat(salesRate).toFixed(2)) * parseFloat(
                                duplicateDiv.children[2]
                                .textContent)))

                            totalQuantity += parseFloat(quantity);

                            totalAmount += parseFloat((parseFloat(salesRate).toFixed(2)) * quantity);
                            article.amount = parseFloat(article.amount) + parseFloat((parseFloat(salesRate).toFixed(2)) * quantity);
                        }
                    });
                } else {
                    if (articleCount === 0) {
                        articleList.innerHTML = '';
                    }

                    if (articleCount < 13) {
                        articleCount++;
                        let articleRow = document.createElement('div');
                        articleRow.setAttribute('id', `${article}`);
                        articleRow.classList.add('flex', 'justify-between', 'items-center', 'bg-[--h-bg-color]',
                            'rounded-lg',
                            'py-2',
                            'px-4');
                        articleRow.innerHTML = `
                            <div class="w-[10%]">#${article}</div>
                            <div class="w-1/6 text-nowrap">${description}</div>
                            <div class="w-[10%]">${quantity}</div>
                            <div class="w-1/6 text-center">${parseFloat(salesRate).toFixed(2)}</div>
                            <div class="w-1/6 text-center">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(parseFloat((parseFloat(salesRate).toFixed(1)) * quantity))}</div>
                            <div class="w-[10%] text-center">
                                <button onclick="deleteRate(this)" type="button" class="text-[--danger-color] text-sm px-2 py-1 rounded-lg hover:text-[--h-danger-color] transition-all 0.3s ease-in-out">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                        articleList.insertBefore(articleRow, articleList.firstChild);

                        totalQuantity += parseFloat(quantity);
                        totalAmount += parseFloat((parseFloat(salesRate).toFixed(2)) * quantity);

                        articlesArray.push({
                            articleNo: article,
                            description: description,
                            quantity: quantity,
                            salesRate: parseFloat(salesRate).toFixed(2),
                            amount: parseFloat((parseFloat(salesRate).toFixed(1)) * quantity)
                        });
                    } else {
                        alert('Maximum of 13 articles can be added.');
                    }
                }

                articleNoDom.value = '';
                quantityDom.value = '';

                articleNoDom.focus();

                updateRates();
                generateInvoice()
            }
        }

        function deleteRate(element) {
            element.parentElement.parentElement.remove();
            articleCount--;
            if (articleCount === 0) {
                let articleList = document.querySelector('#article-list');
                articleList.innerHTML = `
                    <div class="text-center bg-[--h-bg-color] rounded-lg py-2 px-4">
                        No Articles Added
                    </div>
                `;
            }

            articleNoDom.focus();

            let quantity = parseFloat(element.parentElement.parentElement.children[2].innerText);
            totalQuantity -= quantity;

            let amount = parseFloat(element.parentElement.parentElement.children[4].innerText.replace(',', ''));
            totalAmount -= amount;

            let article = (element.parentElement.parentElement.children[0].textContent).replace('#', '');
            articlesArray = articlesArray.filter(item => item.articleNo !== article);

            updateRates();
        }

        function updateRates() {
            calculateNetAmount(0);

            calcBottom.innerHTML = `
                <div class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="text-nowrap">Total Qty - Pcs.</div>
                    <div class="grow text-right">${totalQuantity}</div>
                </div>
                <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="text-nowrap">Total.</div>
                    <div id="total-amount" class="grow text-right">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(totalAmount)}</div>
                </div>
                <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="text-nowrap">Off - %.</div>
                    <input type="number" oninput="calculateNetAmount(this.value)" name="discount" id="discount-inp"
                        class="text-right bg-transparent outline-none border-none w-full" min="0" max="100" placeholder="Enter here"/>
                </div>
                <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="text-nowrap">Net.</div>
                    <div id="net-amount" class="grow text-right">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(totalAmount)}</div>
                </div>
            `;

            articlesArrayDom.value = JSON.stringify(articlesArray);
        }

        function calculateNetAmount(value) {
            discount = parseFloat(value);
            netAmount = totalAmount - (totalAmount * (discount / 100));
            document.getElementById('net-amount').textContent = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            }).format(netAmount);
        }

        quantityDom.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                addArticle();
            }
        });

        // dtnamic bill code 
        let invoiceDom = document.getElementById('invoice');
        let tBodyDom = document.getElementById('tbody');
        let invoiceBannerDom = document.getElementById('invoice-banner');
        let invoiceHeaderDom = document.getElementById('invoice-header');

        let trCount = 1;

        function generateInvoice() {
            let lastInvoiceDom = customerDom.options[customerDom.selectedIndex].getAttribute('last-invoice');
            lastInvoice = JSON.parse(lastInvoiceDom);
            console.log(lastInvoice.invoice_no.replace("2025-", ""));
            
            let lastInvoiceNo = lastInvoice.invoice_no.replace("2025-", "")

            function generateInvoiceNo() {
                const todayYear = new Date().getFullYear();
                const nextInvoiceNo = String(parseInt(lastInvoiceNo, 10) + 1).padStart(4, '0');
                return todayYear + '-' + nextInvoiceNo;
            }

            let invoiceNo = generateInvoiceNo();
            invoiceNoDom.value = invoiceNo;

            function getInvoiceDate() {
                const today = new Date();

                // Extract day, month, and year
                const day = String(today.getDate()).padStart(2, '0');
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-based
                const year = today.getFullYear();

                // Return the formatted date
                return `${day}-${month}-${year}`;
            }

            // Get the current date
            let invoiceDate = getInvoiceDate();
            invoiceDateDom.value = invoiceDate;

            let customerDataDom = customerDom.options[customerDom.selectedIndex].getAttribute('customer-data');
            let customerData = JSON.parse(customerDataDom)
            console.log(customerData);

            let totalAmount = 0;
            let totalQuantity = 0;

            invoiceDom.innerHTML = `
                <div id="invoice" class="invoice flex flex-col h-full">
                    <div id="invoice-banner" class="invoice-banner w-full flex justify-between mt-8 px-5">
                        <div class="left w-50">
                            <div class="invoice-logo">
                                <img src="{{ asset('storage/uploads/images/Spark-Pair1.png') }}" alt="Track Point"
                                    class="w-[150px]" />
                            </div>
                        </div>
                        <div class="right w-50 my-auto pr-3 text-sm text-gray-500">
                            <div class="invoice-date">Date: ${invoiceDate}</div>
                            <div class="invoice-number">Invoice No.: ${invoiceNo}</div>
                            <div class="invoice-copy">Invoice Copy: Customer</div>
                        </div>
                    </div>
                    <hr class="w-100 my-5 border-gray-600">
                    <div id="invoice-header" class="invoice-header w-full flex justify-between px-5">
                        <div class="left w-50">
                            <div class="invoice-to text-sm text-gray-500">Invoice to:</div>
                            <div class="invoice-customer text-lg">${customerData.customer}</div>
                            <div class="invoice-person text-md">${customerData.person_name}</div>
                            <div class="invoice-address text-md">${customerData.address}, ${customerData.city}</div>
                            <div class="invoice-phone text-md">${customerData.phone.replace(/(\d{4})(\d{7})/, '$1-$2')}</div>
                        </div>
                        <div class="right w-50">
                            <div class="invoice-from text-sm text-gray-500">Invoice from:</div>
                            <div class="invoice-customer text-lg">M/s Track Point</div>
                            <div class="invoice-person text-md">Mr. Hasan</div>
                            <div class="invoice-address text-md">Meetha Dar, Karachi</div>
                            <div class="invoice-phone text-md">0312-5214864</div>
                        </div>
                    </div>
                    <hr class="w-100 mt-5 mb-5 border-gray-600">
                    <div id="invoice-body" class="invoice-body w-[95%] grow mx-auto">
                        <div class="invoice-table w-full">
                            <div class="table w-full border border-gray-600 rounded-lg pb-4 overflow-hidden">
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
                            <div class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Quantity - Pcs</div>
                                <div class="w-1/4 text-right grow">${totalQuantity}</div>
                            </div>
                            <div class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Amount</div>
                                <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(totalAmount)}</div>
                            </div>
                            <div class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Discount - %</div>
                                <div class="w-1/4 text-right grow">${discount}</div>
                            </div>
                        </div>
                        <div id="invoice-total" class="tr flex justify-between w-full px-2 gap-2 text-sm">
                            <div class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Previous Balance</div>
                                <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(customerData.balance)}</div>
                            </div>
                            <div
                                class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Net Amount</div>
                                <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(netAmount)}</div>
                            </div>
                            <div
                                class="total flex justify-between items-center border border-gray-600 rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Current Balance</div>
                                <div class="w-1/4 text-right grow">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }).format(netAmount + customerData.balance)}</div>
                            </div>
                        </div>
                    </div>
                    <hr class="w-full my-4 border-gray-600">
                    <div class="tfooter flex w-full text-sm px-4 justify-between mb-4">
                        <P>Company Name</P>
                        <p>&copy; Track Point | sparkpair.com | Spark Pair 2025.</p>
                    </div>
                </div>
            `;
            totalAmountInpDom.value = totalAmount
            totalQuantityInpDom.value = totalQuantity
            netAmountInpDom.value = netAmount

        trCount++
        }

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

        function validateCustomer() {
            if (customerDom.value === "") {
                customerDom.classList.add("border-[--border-error]");
                customerError.classList.remove("hidden");
                customerError.textContent = "Customer selection is required. Please choose a customer before proceeding.";
                return false;

            } else {
                customerDom.classList.remove("border-[--border-error]");
                customerError.classList.add("hidden");
                return true;
            }
        }

        function validateArticle() {
            if (articlesArray.length === 0) {
                if (articleNoDom.value.trim() === "") {
                    articleNoDom.classList.add("border-[--border-error]");
                    articleError.classList.remove("hidden");
                    articleError.textContent = "Article No is required. Please enter an article no before proceeding.";
                    return false;
                } else {
                    articleNoDom.classList.remove("border-[--border-error]");
                    articleError.classList.add("hidden");
                }
                if (quantityDom.value.trim() === "") {
                    quantityDom.classList.add("border-[--border-error]");
                    articleError.classList.remove("hidden");
                    articleError.textContent = "Quantity is required. Please enter a valid amount.";
                    return false;
                } else {
                    quantityDom.classList.remove("border-[--border-error]");
                    articleError.classList.add("hidden");
                }
            } else {
                articleNoDom.classList.remove("border-[--border-error]");
                quantityDom.classList.remove("border-[--border-error]");
                articleError.classList.add("hidden");
                return true;
            }
        }

        customerDom.addEventListener('change', function () {
            validateCustomer()
        })
        articleNoDom.addEventListener('input', function () {
            validateArticle()
        })
        quantityDom.addEventListener('input', function () {
            validateArticle()
        })

        function validateForNextStep() {
            let isValidCustomer = validateCustomer();
            let isValidArticle = validateArticle();

            let isValid = isValidCustomer && isValidArticle;

            if (!isValid) {
                messageBox.innerHTML = `
                    <div id="error-message"
                        class="bg-[--bg-error] text-[--text-error] border border-[--border-error] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                        <i class='bx bxs-error-alt'></i>
                        <p>Invalid details, please correct them.</p>
                    </div>
                `;
                messageBoxAnimation();
            }
            
            return isValid;
        }
    </script>
@endsection