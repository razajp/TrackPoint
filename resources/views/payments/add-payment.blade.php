@extends('layouts.app')
@section('title', 'Add Payment | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]">
                Add Payment
            </h1>

            <!-- Progress Bar -->
            <div class="mb-5 max-w-2xl mx-auto ">
                <div class="flex justify-between mb-2 progress-indicators">
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--primary-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step1-indicator" onclick="gotoStep(1)">
                        Enter Details
                    </span>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--h-bg-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step2-indicator" onclick="gotoStep(2)">
                        Enter Payment
                    </span>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden bg-[--h-bg-color] rounded-full">
                    <div class="transition-all duration-500 ease-in-out w-1/2 bg-[--primary-color]" id="progress-bar"></div>
                </div>
            </div>

            <!-- Form -->
            <form id="form" action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data"
                class="bg-[--secondary-bg-color] rounded-xl shadow-xl p-8 border border-[--h-bg-color] pt-12 max-w-2xl mx-auto relative overflow-hidden">
                @csrf
                <div
                    class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-sm">
                    <h4>Add Payments</h4>
                </div>
                <!-- Step 1: Basic Information -->
                <div class="step1 space-y-4 ">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- customer --}}
                        <div class="form-group">
                            <label for="customer" class="block font-medium text-[--secondary-text] mb-1">Customer</label>
                            <div class="relative">
                                <select id="customer" name="customer_id"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                    <option value="">-- select customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ str_replace(' ', '-', $customer->id) }}"
                                            data-customer="{{ $customer }}">
                                            {{ $customer->customer }} | {{ $customer->city }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <div id="customer-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                        </div>

                        {{-- balance --}}
                        <div class="form-group">
                            <label for="balance"
                                class="block text-sm font-medium text-[--secondary-text] mb-1">Balance</label>
                            <input type="text" id="balance"
                                class="w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Select customer first" disabled />
                        </div>

                        {{-- person_name --}}
                        <div class="form-group">
                            <label for="person_name" class="block text-sm font-medium text-[--secondary-text] mb-1">Person
                                Name</label>
                            <input type="text" id="person_name"
                                class="w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Select customer first" disabled />
                        </div>

                        {{-- Type --}}
                        <div class="form-group">
                            <label for="type" class="block text-sm font-medium text-[--secondary-text] mb-1">Payment
                                Type</label>
                            <div class="relative">
                                <select id="type" name="type"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                    <option value="">-- select type --</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="slip">Slip</option>
                                    <option value="online">Online</option>
                                    <option value="adjustment">Adjustment</option>
                                </select>
                                @error('type')
                                    <!-- Display error message for 'type' -->
                                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <div id="type-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Enter Payment -->
                <div class="step2 hidden space-y-4 ">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <div id="details" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <h1 class="text-[--danger-color] font-medium text-center col-span-2">Select Payment Type.</h1>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        let customerDom = document.getElementById('customer');
        let balanceInput = document.getElementById('balance');
        let personNameInput = document.getElementById('person_name');
        let typeDom = document.getElementById('type');
        let detailsDom = document.getElementById('details');
        let customerName;

        customerDom.addEventListener('change', function() {
            let customerDataDom = customerDom.options[customerDom.selectedIndex].dataset.customer;
            let customerData = JSON.parse(customerDataDom);
            customerName = customerData.customer;
            personNameInput.value = customerData.person_name;
            balanceInput.value = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(customerData.balance);
        });

        typeDom.addEventListener('change', function() {
            let type = this.value;
            updateDetailsDom(type)
            if (type) {
                gotoStep(2)
            }
        });

        function updateDetailsDom(type) {
            if (type === 'cash') {
                detailsDom.innerHTML = `
                {{-- date --}}
                <div class="form-group">
                    <label for="date" class="restrict-future-date block text-sm font-medium text-[--secondary-text] mb-1">Payment Date</label>
                    <input type="date" id="date" name="date"
                        class="restrict-future-date w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Select Payment Date" />
                    @error('date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- amount --}}
                <div class="form-group">
                    <label for="amount" class="block text-sm font-medium text-[--secondary-text] mb-1">Amount</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Amount here"/>
                    @error('amount')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            `;
            } else if (type === 'adjustment') {
                detailsDom.innerHTML = `
                {{-- date --}}
                <div class="form-group">
                    <label for="date" class="restrict-future-date block text-sm font-medium text-[--secondary-text] mb-1">Payment Date</label>
                    <input type="date" id="date" name="date"
                        class="w-full restrict-future-date rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Select Payment Date" />
                    @error('date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- amount --}}
                <div class="form-group">
                    <label for="amount" class="block text-sm font-medium text-[--secondary-text] mb-1">Amount</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Amount here"/>
                    @error('amount')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- remarks --}}
                <div class="form-group col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-[--secondary-text] mb-1">Remarks</label>
                    <input type="text" id="remarks" name="remarks"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Remarks here"/>
                    @error('remarks')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            `;
            } else if (type === 'cheque') {
                detailsDom.innerHTML = `
                {{-- date --}}
                <div class="form-group">
                    <label for="date"
                        class="restrict-future-date block text-sm font-medium text-[--secondary-text] mb-1">Payment
                        Date</label>
                    <input type="date" id="date" name="date"
                        class="w-full restrict-future-date rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Select Payment Date" />
                    @error('date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- amount --}}
                <div class="form-group">
                    <label for="amount" class="block text-sm font-medium text-[--secondary-text] mb-1">Amount</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Amount here" />
                    @error('amount')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- cheque_no --}}
                <div class="form-group">
                    <label for="cheque_no" class="block text-sm font-medium text-[--secondary-text] mb-1">Cheque No</label>
                    <input type="number" id="cheque_no" name="cheque_no"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Cheque No here" />
                    @error('cheque_no')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- bank --}}
                <div class="form-group">
                    <label for="bank" class="block text-sm font-medium text-[--secondary-text] mb-1">Bank Name</label>
                    <input type="text" id="bank" name="bank"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Bank Name here" />
                    @error('bank')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- issue_date --}}
                <div class="form-group">
                    <label for="issue_date" class="block text-sm font-medium text-[--secondary-text] mb-1">Issue Date</label>
                    <input type="date" id="issue_date" name="issue_date"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Issue Date here" />
                    @error('issue_date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- clear_date --}}
                <div class="form-group">
                    <label for="clear_date" class="block text-sm font-medium text-[--secondary-text] mb-1">Clear Date</label>
                    <input type="date" id="clear_date" name="clear_date"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Clear Date here" />
                    @error('clear_date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            `;
            } else if (type === 'slip') {
                detailsDom.innerHTML = `
                {{-- date --}}
                <div class="form-group">
                    <label for="date"
                        class="restrict-future-date block text-sm font-medium text-[--secondary-text] mb-1">Payment
                        Date</label>
                    <input type="date" id="date" name="date"
                        class="w-full restrict-future-date rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Select Payment Date" />
                    @error('date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- amount --}}
                <div class="form-group">
                    <label for="amount" class="block text-sm font-medium text-[--secondary-text] mb-1">Amount</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Amount here" />
                    @error('amount')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- slip_no --}}
                <div class="form-group">
                    <label for="slip_no" class="block text-sm font-medium text-[--secondary-text] mb-1">Slip No</label>
                    <input type="number" id="slip_no" name="slip_no"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Slip No here" />
                    @error('slip_no')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- party --}}
                <div class="form-group">
                    <label for="party" class="block text-sm font-medium text-[--secondary-text] mb-1">Party Name</label>
                    <input type="text" id="party" name="party" readonly
                        class="w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"/>
                    @error('party')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- issue_date --}}
                <div class="form-group">
                    <label for="issue_date" class="block text-sm font-medium text-[--secondary-text] mb-1">Issue Date</label>
                    <input type="date" id="issue_date" name="issue_date"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Issue Date here" />
                    @error('issue_date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- clear_date --}}
                <div class="form-group">
                    <label for="clear_date" class="block text-sm font-medium text-[--secondary-text] mb-1">Clear Date</label>
                    <input type="date" id="clear_date" name="clear_date"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Clear Date here" />
                    @error('clear_date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            `;
            
            setPartyname();
            } else if (type === 'online') {
                detailsDom.innerHTML = `
                {{-- date --}}
                <div class="form-group">
                    <label for="date"
                        class="restrict-future-date block text-sm font-medium text-[--secondary-text] mb-1">Payment
                        Date</label>
                    <input type="date" id="date" name="date"
                        class="w-full restrict-future-date rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Select Payment Date" />
                    @error('date')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- amount --}}
                <div class="form-group">
                    <label for="amount" class="block text-sm font-medium text-[--secondary-text] mb-1">Amount</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Amount here" />
                    @error('amount')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- t_id --}}
                <div class="form-group">
                    <label for="t_id" class="block text-sm font-medium text-[--secondary-text] mb-1">Transactio ID</label>
                    <input type="number" id="t_id" name="t_id"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Transactio ID here" />
                    @error('t_id')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- bank --}}
                <div class="form-group">
                    <label for="bank" class="block text-sm font-medium text-[--secondary-text] mb-1">Bank Name</label>
                    <input type="text" id="bank" name="bank"
                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                        placeholder="Enter Bank Name here" />
                    @error('bank')
                    <!-- Display error message for 'name' -->
                    <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            `;
            } else {
                detailsDom.innerHTML = `
                <h1 class="text-[--danger-color] font-medium text-center col-span-2">Select Payment Type.</h1>
            `;
            }

            restrictFutureDate();
        }

        function setPartyname() {
            let partyInput = document.getElementById('party');

            if (partyInput && customerName) {
                partyInput.value = customerName;
            } else {
                console.error("Error: customerData ya party input undefined hai.");
            }
        }
        const customer = document.getElementById('customer');
        const customerError = document.getElementById('customer-error');
        const Type = document.getElementById('type');
        const TypeError = document.getElementById('type-error'); 

        // Validate customer
        function validateCustomer() {
            if (!customer.value) {
                customer.classList.add('border-[--border-error]');
                customerError.classList.remove('hidden');
                customerError.textContent = "Customer name is required.";
                return false;
            } else {
                customer.classList.remove('border-[--border-error]');
                customerError.classList.add('hidden');
                customerError.textContent = "";
                return true;
            }
        }

        // Validate type
        function validateType() {
            if (!Type.value) {
                Type.classList.add('border-[--border-error]');
                TypeError.classList.remove('hidden');
                TypeError.textContent = "Payment type is required.";
                return false;
            } else {
                Type.classList.remove('border-[--border-error]');
                TypeError.classList.add('hidden');
                TypeError.textContent = "";
                return true;
            }
        }

        // Live validation on change
        customer.addEventListener('change', validateCustomer);
        Type.addEventListener('change', validateType);

        function validateForNextStep() {
            let isValidCustomer = validateCustomer(); // Validate once and store result
            let isValidType = validateType();        // Validate once and store result

            let isValid = isValidCustomer && isValidType; // ✅ Both should be valid

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
