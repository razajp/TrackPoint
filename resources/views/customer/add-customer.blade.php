@extends('layouts.app')
@section('title', 'Add Customer | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color] fade-in"> Add Customer. </h1>

            <!-- Progress Bar -->
            <div class="mb-5 max-w-2xl mx-auto">
                <div class="flex justify-between mb-2 progress-indicators">
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--primary-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step1-indicator" onclick="gotoStep(1)">Enter Details</span>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--h-bg-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step2-indicator" onclick="gotoStep(2)">Upload Image</span>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden bg-[--h-bg-color] rounded-full">
                    <div class="transition-all duration-500 ease-in-out w-1/2 bg-[--primary-color]" id="progress-bar"></div>
                </div>
            </div>

            <!-- Form -->
            <form id="form" action="{{ route('customer.store') }}" method="post" enctype="multipart/form-data"
                class="bg-[--secondary-bg-color] text-sm rounded-xl shadow-xl p-8 border border-[--h-bg-color] pt-12 max-w-2xl mx-auto  relative overflow-hidden">
                @csrf
                <div
                    class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-sm">
                    <h4>Add New Customer</h4>
                </div>
                <!-- Step 1: Basic Information -->
                <div class="step1 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- customer -->
                        <div class="form-group">
                            <label for="customer"
                                class="block text-sm font-medium text-[--secondary-text] mb-2">Customer.</label>
                            <input type="text" id="customer" name="customer" value="{{ old('customer', 'M/s ') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter customer" required />
                            @error('customer')
                                <!-- Display error message for 'customer' -->
                                <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div id="customer-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- person_name -->
                        <div class="form-group">
                            <label for="person_name" class="block text-sm font-medium text-[--secondary-text] mb-2">Person
                                Name.</label>
                            <input type="text" id="person_name" name="person_name"
                                value="{{ old('person_name', 'Mr. ') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter person name" required />
                            @error('person_name')
                                <!-- Display error message for 'person_name' -->
                                <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div id="person_name-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- phone -->
                        <div class="form-group">
                            <label for="phone" class="block text-sm font-medium text-[--secondary-text] mb-2">Phone
                                Number.</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter phone number" required oninput="formatPhoneNo(this)" />
                            @error('phone')
                                <!-- Display error message for 'phone' -->
                                <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div id="phone-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- city -->
                        <div class="form-group">
                            <label for="city"
                                class="block text-sm font-medium text-[--secondary-text] mb-2">City.</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter city" required />
                            @error('city')
                                <!-- Display error message for 'city' -->
                                <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div id="city-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- address -->
                        <div class="form-group col-span-2">
                            <label for="address"
                                class="block text-sm font-medium text-[--secondary-text] mb-2">Address.</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter address" required />
                            @error('address')
                                <!-- Display error message for 'address' -->
                                <div class="text-[--border-error] text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div id="address-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Production Details -->
                <div class="step2 hidden space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <label for="image_upload"
                            class="border-dashed border-2 border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition-all duration-300 ease-in-out">
                            <input id="image_upload" type="file" name="image_upload" accept="image/*" class="opacity-0"
                                onchange="previewImage(event)" />
                            <div id="image_preview" class="flex flex-col items-center max-w-[50%]">
                                <img src="{{ asset('storage/uploads/images/image_icon.png') }}" alt="Upload Icon"
                                    class="w-16 h-16 mb-2" id="placeholder_icon" />
                                <p id="upload_text" class="text-md text-gray-500">Upload Picture</p>
                            </div>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        function formatPhoneNo(input) {
            let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters

            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4, 11); // Insert hyphen after 4 digits
            }

            input.value = value; // Update the input field
        }
        // Get DOM elements
            const customer = document.getElementById('customer');
            const customers = @json($customers);
            const customerError = document.getElementById('customer-error');
            const person_name = document.getElementById('person_name');
            const person_nameError = document.getElementById('person_name-error');
            const phone = document.getElementById('phone');
            const phoneError = document.getElementById('phone-error');
            const city = document.getElementById('city');
            const cityError = document.getElementById('city-error');
            const address = document.getElementById('address');
            const addressError = document.getElementById('address-error');
            // const messageBox = document.getElementById("messageBox");

            function showError(input, errorElement, message) {
                input.classList.add("border-[--border-error]");
                errorElement.classList.remove("hidden");
                errorElement.textContent = message;
                return false; // Return false on error
            }

            function hideError(input, errorElement) {
                input.classList.remove("border-[--border-error]");
                errorElement.classList.add("hidden");
                return true; // Return true if no error
            }

            function validateCustomerName() {
                let customerName = customer.value.trim().toLowerCase();
                let cityName = city.value.trim().toLowerCase();
                let existingCustomer = customers.find(c => 
                    c.customer.toLowerCase() === customerName && c.city.toLowerCase() === cityName
                );

                if (!customerName || customerName === "m/s") {
                    return showError(customer, customerError, "Customer name is required.");
                } else if (existingCustomer) {
                    return showError(customer, customerError, `This customer already exists in ${existingCustomer.city}.`);
                } else {
                    return hideError(customer, customerError);
                }
            }

            function validatePersonName() {
                let personName = person_name.value.trim().toLowerCase();
                return personName && personName !== "mr."
                    ? hideError(person_name, person_nameError)
                    : showError(person_name, person_nameError, "Person name is required.");
            }

            function validatePhoneNumber() {
                let phoneNo = phone.value.replace(/\D/g, '').trim();
                let isDuplicate = customers.some(c => c.phone.replace(/\D/g, '') === phoneNo);

                if (!phoneNo) {
                    return showError(phone, phoneError, "Phone number is required.");
                } else if (isDuplicate) {
                    return showError(phone, phoneError, "This phone number is already registered.");
                } else {
                    return hideError(phone, phoneError);
                }
            }

            function validateCity() {
                let cityName = city.value.trim();
                return cityName ? hideError(city, cityError) : showError(city, cityError, "City is required.");
            }

            function validateAddress() {
                let addressText = address.value.trim();
                return addressText ? hideError(address, addressError) : showError(address, addressError, "Address is required.");
            }

            // 🔹 **Live Validation Events**
            customer.addEventListener("input", validateCustomerName);
            city.addEventListener("input", validateCustomerName);
            person_name.addEventListener("input", validatePersonName);
            phone.addEventListener("input", validatePhoneNumber);
            city.addEventListener("input", validateCity);
            address.addEventListener("input", validateAddress);

            function validateForNextStep(){
                let isValid = validateCustomerName() 
                    || validatePersonName() 
                    || validatePhoneNumber() 
                    || validateCity() 
                    || validateAddress();

                if (!isValid) {
                    messageBox.innerHTML = `
                        <div id="warning-message"
                            class="bg-[--bg-warning] text-[--text-warning] border border-[--border-warning] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
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
