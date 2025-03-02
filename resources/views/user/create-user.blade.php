@extends('layouts.app')
@section('title', 'Create User | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]">
                Add User
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
                        Upload Image
                    </span>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden bg-[--h-bg-color] rounded-full">
                    <div class="transition-all duration-500 ease-in-out w-1/2 bg-[--primary-color]" id="progress-bar"></div>
                </div>
            </div>

            <!-- Form -->
            <form id="form" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data"
                class="bg-[--secondary-bg-color] rounded-xl shadow-xl p-8 border border-[--h-bg-color] pt-12 max-w-2xl mx-auto relative overflow-hidden">
                @csrf
                <div
                    class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-sm">
                    <h4>Add New User</h4>
                </div>
                <!-- Step 1: Basic Information -->
                <div class="step1 space-y-6 ">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- name -->
                        <div class="form-group">
                            <label for="name" class="block font-medium text-[--secondary-text] mb-2">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter your name" required />
                            @error('name')
                                <!-- Display error message for 'name' -->
                                <div class="text-[--border-error] mt-1">{{ $message }}</div>
                            @enderror
                            <div id="name-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- username -->
                        <div class="form-group">
                            <label for="username"
                                class="block font-medium text-[--secondary-text] mb-2">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter your username" required />
                            @error('username')
                                <!-- Display error message for 'username' -->
                                <div class="text-[--border-error] mt-1">{{ $message }}</div>
                            @enderror
                            <div id="username-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- phone -->
                        <div class="form-group">
                            <label for="password"
                                class="block font-medium text-[--secondary-text] mb-2">Password</label>
                            <input type="password" id="password" name="password" value="{{ old('password') }}"
                                class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                placeholder="Enter your password" required />
                            @error('password')
                                <!-- Display error message for 'password' -->
                                <div class="text-[--border-error] mt-1">{{ $message }}</div>
                            @enderror
                            <div id="password-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                        </div>

                        <!-- role -->
                        <div class="form-group">
                            <label for="role" class="block font-medium text-[--secondary-text] mb-2">Role</label>
                            <div class="relative">
                                <select id="role" name="role"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                    <option value="guest">Guest</option>
                                    <option value="admin">Admin</option>
                                    <option value="accountant">Accountant</option>
                                </select>
                            </div>
                            @error('role')
                                <!-- Display error message for 'role' -->
                                <div class="text-[--border-error] mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 2: Production Details -->
                <div class="step2 hidden space-y-6 ">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <label for="image_upload"
                            class="border-dashed border-2 border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition-all duration-300 ease-in-out">
                            <input id="image_upload" type="file" name="image_upload" accept="image/*" class="opacity-0"
                                onchange="previewImage(event)" />
                            <div id="image_preview" class="flex flex-col items-center max-w-[50%]">
                                <img src="{{ asset('storage/uploads/images/image_icon.png') }}" alt="Upload Icon"
                                    class="w-16 h-16 mb-2" id="placeholder_icon" />
                                <p id="upload_text" class="text-md text-gray-500">Upload Picture</p>
                            </div>
                            @error('image_upload')
                                <!-- Display error message for 'name' -->
                                <div class="text-[--border-error] mt-1">{{ $message }}</div>
                            @enderror
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        const nameDom = document.getElementById("name");
        const nameError = document.getElementById("name-error");
        const users = @json($users);
        const usernameDom = document.getElementById("username");
        const usernameError = document.getElementById("username-error");
        const passwordDom = document.getElementById("password");
        const passwordError = document.getElementById("password-error");

        function validateName() {
            // Validate Name
            if (nameDom.value.trim() === "") {
                nameDom.classList.add("border-[--border-error]");
                nameError.classList.remove("hidden");
                nameError.textContent = "Name field is required.";
                return false;
            } else {
                nameDom.classList.remove("border-[--border-error]");
                nameError.classList.add("hidden");
                return true;
            }
        }

        function validateUsername() {
           // Validate Username
           if (usernameDom.value.trim() === "") {
                usernameDom.classList.add("border-[--border-error]");
                usernameError.classList.remove("hidden");
                usernameError.textContent = "Username field is required.";
                return false;
            } else if (users.some(user => user.username === usernameDom.value.trim())) {
                usernameDom.classList.add("border-[--border-error]");
                usernameError.classList.remove("hidden");
                usernameError.textContent = "Username is already taken.";
                return false;
            } else {
                usernameDom.classList.remove("border-[--border-error]");
                usernameError.classList.add("hidden");
                return true;
            }
        }

        function validatePassword() {
            // Validate Password
            if (passwordDom.value.trim() === "") {
                passwordDom.classList.add("border-[--border-error]");
                passwordError.classList.remove("hidden");
                passwordError.textContent = "Password field is required.";
                return false;
            } else if (passwordDom.value.length < 3) {
                passwordDom.classList.add("border-[--border-error]");
                passwordError.classList.remove("hidden");
                passwordError.textContent = "Password must be at least 3 characters.";
                return false;
            } else {
                passwordDom.classList.remove("border-[--border-error]");
                passwordError.classList.add("hidden");
                return true;
            }
        }
        
        passwordDom.addEventListener("input", function () {
            validatePassword()
        })
        
        usernameDom.addEventListener("input", function () {
            validateUsername()
        });

        nameDom.addEventListener("input", function(){
            validateName()
        });

        function validateForNextStep() {
            let isValidName = validateName();
            let isValidUsername = validateUsername();
            let isValidPasswird = validatePassword();

            let isValid = isValidName || isValidUsername || isValidPasswird;

            if (!isValid) {
                messageBox.innerHTML = `
                    <div id="error-message"
                        class="bg-[--bg-error] text-[--text-error] border border-[--border-error] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                        <i class='bx bxs-error-alt'></i>
                        <p>Invalid details, please correct them.</p>
                    </div>
                `;
                messageBoxAnimation();
            } else {
                isValid = true
            }

            return isValid;
        }
    </script>
@endsection
