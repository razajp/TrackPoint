<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Track Point')</title>
    <script src="{{ asset('tailwind.js') }}"></script>
    <script src="{{ asset('jquery.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        :root {
            --bg-color: #111827;
            /* Default dark theme background */
            --h-bg-color: #374151;
            --secondary-bg-color: #1f2937;
            --h-secondary-bg-color: hsl(215, 28%, 13%);
            /* Default dark theme secondary background */
            --text-color: #ffffff;
            /* Default dark theme text color */
            --secondary-text: #d1d5db;
            /* Default dark theme secondary text */
            --primary-color: #2563eb;
            --h-primary-color: #1f56cd;
            /* Default dark theme primary color */
            --bg-warning: hsl(45, 50%, 25%);
            --bg-success: hsl(130, 50%, 25%);
            --bg-error: hsl(360, 50%, 25%);
            --border-warning: hsl(45, 100%, 45%);
            --border-success: hsl(130, 100%, 45%);
            --border-error: hsl(360, 100%, 45%);
            --text-warning: hsl(45, 30%, 95%);
            --text-success: hsl(130, 30%, 95%);
            --text-error: hsl(360, 30%, 95%);

            --danger-color: hsl(0, 65%, 51%);
            --h-danger-color: hsl(0, 65%, 41%);
            --success-color: hsl(142, 65%, 36%);
            --h-success-color: hsl(142, 65%, 26%);
        }

        [data-theme='light'] {
            --bg-color: #f3f4f6;
            --h-bg-color:#e4e7ee;
            --secondary-bg-color: #ffffff;
            --h-secondary-bg-color: hsl(0, 0%, 96%);
            --text-color: #1f2937;
            --secondary-text: #4b5563;
            --bg-warning: hsl(45, 100%, 87%);
            --bg-success: hsl(130, 100%, 87%);
            --bg-error: hsl(360, 100%, 87%);
            --border-warning: hsl(45, 100%, 45%);
            --border-success: hsl(130, 100%, 45%);
            --border-error: hsl(360, 100%, 45%);
            --text-warning: hsl(45, 75%, 40%);
            --text-success: hsl(130, 75%, 40%);
            --text-error: hsl(360, 75%, 40%);
        }

        [data-theme="dark"] input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            /* Invert icon color for dark mode */
        }

        .fade-in {
            animation: fadeIn 0.35s ease-in-out;
        }

        /* Example animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .fade-out {
            animation: fadeOut 0.35s forwards !important;
        }

        .bg-\[--danger-color\],
        .bg-\[--success-color\],
        .bg-\[--primary-color\] {
            color: white !important;
        }

        .card {
            transition: all 0.3s ease-in-out;
            position: relative;
        }

        .card:hover {
            transform: translateY(-0.3rem);
            background-color: var(--h-secondary-bg-color);
            box-shadow: 0 5px 0.8rem var(--bg-color);
        }

        .card button {
            transition: all 0.2s ease-in-out;
        }

        .card:hover button {
            scale: 1.1;
        }

        .active_inactive_dot {
            opacity: 100;
            transition: all 0.2s ease-in-out;
        }

        .active_inactive {
            opacity: 0;
            transition: all 0.2s ease-in-out;
        }

        .card:hover .active_inactive {
            opacity: 100;
        }

        .card:hover .active_inactive_dot {
            opacity: 0;
        }

        .my-scroller::-webkit-scrollbar {
            width: 8px;
            /* Adjust width to include buttons */
            height: 8px;
            /* For horizontal scrollbars */
        }

        .my-scroller::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            /* Semi-transparent thumb */
            border-radius: 2vw;
            /* Rounded corners */
            transition: background-color 0.3s ease;
        }

        .my-scroller::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.6);
            /* Brighter on hover */
        }

        .my-scroller::-webkit-scrollbar-track {
            background: transparent;
            /* Invisible track */
        }

        .my-scroller::-webkit-scrollbar-button {
            background: rgba(255, 255, 255, 0.2);
            /* Semi-transparent button background */
            height: 12px;
            /* Height of the button */
            width: 12px;
            /* Width for horizontal scrollbars */
            border-radius: 50%;
            /* Circular button appearance */
            transition: all 0.3s ease;
        }

        .my-scroller::-webkit-scrollbar-button:hover {
            background: rgba(255, 255, 255, 0.5);
            /* Brighter on hover */
        }

        .my-scroller::-webkit-scrollbar-button:vertical:decrement {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"><path d="M12 8l6 6H6z"/></svg>') center no-repeat;
            background-size: 15px 15px;
            /* Adjust icon size */
        }

        .my-scroller::-webkit-scrollbar-button:vertical:increment {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"><path d="M12 16l6-6H6z"/></svg>') center no-repeat;
            background-size: 15px 15px;
            /* Adjust icon size */
        }

        .my-scroller::-webkit-scrollbar-button:horizontal:decrement {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"><path d="M8 12l6-6v12z"/></svg>') center no-repeat;
            background-size: 15px 15px;
            /* Adjust icon size */
        }

        .my-scroller::-webkit-scrollbar-button:horizontal:increment {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24"><path d="M16 12l-6-6v12z"/></svg>') center no-repeat;
            background-size: 15px 15px;
            /* Adjust icon size */
        }

        .my-scroller-2::-webkit-scrollbar {
            display: none;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
            /* For Firefox */
        }

        input::-webkit-calendar-picker-indicator {
            display: none !important;
            -webkit-appearance: none;
        }

        .nav-link.active {
            background-color: var(--h-bg-color) !important;
        }

        .nav-link.active i {
            color: var(--primary-color) !important;
        }

        .nav-link.active:hover i {
            color: var(--h-primary-color) !important;
        }

        strong {
            font-weight: 700 !important;
        }
    </style>
</head>

<body class="bg-[--bg-color] text-[--text-color] min-h-screen flex items-center justify-center"
    cz-shortcut-listen="true">
    <!-- Displaying Error, Success, and Warning Messages in Alert Box -->
    <!-- <div id="messageBox" class="absolute top-3 {{ request()->is('login') || request()->is('register') ? 'left-3' : 'left-20' }} flex flex-col space-y-3 z-50"> -->

    @if (Auth::check())
        @component('layouts.components.sidebar')
        @endcomponent
    @endif
    
    <div class="wrapper flex-1 flex flex-col h-screen relative">
        <div id="messageBox" class="absolute top-5 mx-auto flex items-center flex-col space-y-3 z-50 text-sm w-full select-none pointer-events-none">
            @if (session('success'))
                @if (is_array(session('success')))
                    @foreach (session('success') as $message)
                        <div id="success-message"
                            class="bg-[--bg-success] text-[--text-success] border border-[--border-success] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                            <i class='bx bxs-badge-check'></i>
                            <p>{{ $message }}</p>
                        </div>
                    @endforeach
                @else
                    <div id="success-message"
                        class="bg-[--bg-success] text-[--text-success] border border-[--border-success] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                        <i class='bx bxs-badge-check'></i>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
            @endif

            @if (session('warning'))
                @if (is_array(session('warning')))
                    @foreach (session('warning') as $message)
                        <div id="warning-message"
                            class="bg-[--bg-warning] text-[--text-warning] border border-[--border-warning] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                            <i class='bx bxs-error'></i>
                            <p>{{ $message }}</p>
                        </div>
                    @endforeach
                @else
                    <div id="warning-message"
                        class="bg-[--bg-warning] text-[--text-warning] border border-[--border-warning] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                        <i class='bx bxs-error'></i>
                        <p>{{ session('warning') }}</p>
                    </div>
                @endif
            @endif
            
            @if (session('error'))
                @if (is_array(session('error')))
                    @foreach (session('error') as $message)
                        <div id="error-message"
                            class="bg-[--bg-error] text-[--text-error] border border-[--border-error] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                            <i class='bx bxs-error-alt'></i>
                            <p>{{ $message }}</p>
                        </div>
                    @endforeach
                @else
                    <div id="error-message"
                        class="bg-[--bg-error] text-[--text-error] border border-[--border-error] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                        <i class='bx bxs-error-alt'></i>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
            @endif
        </div>
        @yield('content')
        <script>
            function messageBoxAnimation() {
                setTimeout(function() {
                    // Select all messages by their IDs or classes
                    const messages = document.querySelectorAll('#error-message, #success-message, #warning-message');
    
                    messages.forEach((message) => {
                        if (message) {
                            message.classList.add('fade-out');
                            message.addEventListener('animationend', () => {
                                message.style.display = 'none'; // Hide the element after animation
                            });
                        }
                    });
                }, 5000); // Trigger fade-out after 5 seconds
            }
            messageBoxAnimation()
    
            const html = document.documentElement;
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.querySelector('#themeToggle i');
            const messageBox = document.getElementById("messageBox");
    
            themeToggle?.addEventListener('click', () => {
                changeTheme();
    
                // Get the current theme from the HTML element
                const currentTheme = $('html').attr('data-theme');
    
                // Send an AJAX request to update the theme in the database
                $.ajax({
                    url: '/update-theme', // Route to your controller
                    type: 'POST',
                    data: {
                        theme: currentTheme,
                        _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            messageBox.innerHTML = `
                                <div id="success-message"
                                    class="bg-[--bg-success] text-[--text-success] border border-[--border-success] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                                    <i class='bx bxs-badge-check'></i>
                                    <p>Theme updated successfully! Your preferences have been saved.</p>
                                </div>
                            `;
                            messageBoxAnimation()
                        } else {
                            messageBox.innerHTML = `
                                <div id="error-message"
                                    class="bg-[--bg-error] text-[--text-error] border border-[--border-error] px-5 py-2 rounded-2xl flex items-center gap-2 fade-in">
                                    <i class='bx bxs-error-alt'></i>
                                    <p>Failed to update theme. Please try again later.</p>
                                </div>
                            `;
                            messageBoxAnimation()
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });
    
            function changeTheme() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
    
                themeIcon?.classList.toggle('fa-sun');
                themeIcon?.classList.toggle('fa-moon');
            }
    
            document.addEventListener('focus', function(event) {
                if (event.target.matches('input[type="date"]')) {
                    event.target.showPicker(); // Trigger the date picker
                } else if (event.target.matches('input[type="month"]')) {
                    event.target.showPicker(); // Trigger the date picker
                }
            }, true); // Use capturing phase
    
            // Get today's date in YYYY-MM-DD format
            const today = new Date().toISOString().split('T')[0];
            let dateInputs;
            
            // Select all inputs with the class "restrict-future-date"
            function restrictFutureDate() {
                dateInputs = document.querySelectorAll('.restrict-future-date');
    
                // Apply the max attribute to each input
                dateInputs.forEach(input => {
                    input.setAttribute('max', today);
                });
            }
            restrictFutureDate();
            
            const previewImage = (event) => {
                const file = event.target.files[0];
                const placeholderIcon = document.getElementById("placeholder_icon");
                const uploadText = document.getElementById("upload_text");
    
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        placeholderIcon.src = e.target.result;
                        placeholderIcon.classList.add("rounded-md", "w-full", "h-auto");
                        uploadText.textContent = "Preview";
                    };
                    reader.readAsDataURL(file);
                }
            };
    
            const dashedBorder = document.querySelector(".border-dashed");
            if (dashedBorder) {
                dashedBorder.addEventListener("click", () => {
                    document.getElementById("image_upload").click();
                });
            }
        </script>
    
        @if (Auth::user() && Auth::user()->theme === 'dark')
            <script>
                changeTheme();
            </script>
        @endif
        @component('layouts.components.footer')
        @endcomponent
    </div>
    <script>
        let isLogoutModalOpened = false;
        // Get all dropdown triggers and menus in the document
        const dropdownTriggers = document.querySelectorAll('.dropdown-trigger'); // Clickable triggers
        const dropdownMenus = document.querySelectorAll('.dropdownMenu'); // Dropdown menus
    
        // Function to close all dropdowns
        function closeAllDropdowns() {
            dropdownMenus.forEach(menu => {
                menu.classList.add('hidden'); // Hide all dropdowns
                menu.classList.remove('opacity-100', 'scale-100'); // Remove visibility and scale classes
                menu.classList.add('opacity-0', 'scale-95'); // Add hidden and collapsed styles
            });
        }
    
        // Add event listeners for each dropdown trigger
        dropdownTriggers.forEach((trigger, index) => {
            const dropdownMenu = dropdownMenus[index]; // Get the corresponding dropdown menu
    
            // Toggle dropdown visibility on trigger click
            trigger.addEventListener('click', function(e) {
                console.log('gg');
                // Prevent clicking on the trigger from closing it
                e.stopPropagation();
    
                // Check if the clicked dropdown is already open
                if (dropdownMenu.classList.contains('hidden')) {
                    // Close all dropdowns
                    closeAllDropdowns();
    
                    // Show the dropdown menu with animation
                    dropdownMenu.classList.remove('hidden');
                    setTimeout(() => {
                        dropdownMenu.classList.add('opacity-100', 'scale-100');
                        dropdownMenu.classList.remove('opacity-0', 'scale-95');
                    }, 10); // Delay to trigger transition
                } else {
                    // Hide the dropdown menu with animation
                    dropdownMenu.classList.remove('opacity-100', 'scale-100');
                    dropdownMenu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        dropdownMenu.classList.add('hidden');
                    }, 300); // Match transition duration
                }
            });
        });

        document.getElementById('logoutModal').addEventListener('click', (e) => {
            if (e.target.id === 'logoutModal') {
                closeModal();
            };
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isLogoutModalOpened) {
                closeModal();
                closeContextMenu();
            };
        });
    
        // Close any open dropdown when clicking anywhere else on the document
        document.addEventListener('click', function(e) {
            // Check if the click is outside of any dropdown trigger or menu
            if (!e.target.closest('.dropdown-trigger') && !e.target.closest('.dropdownMenu')) {
                closeAllDropdowns();
            }
        });
    
        function openModal() {
            isLogoutModalOpened = true;
            document.getElementById('logoutModal').classList.remove('hidden');
            closeAllDropdowns();
        }
    
        function closeModal() {
            document.getElementById('logoutModal').classList.add('hidden');
        }

        document.addEventListener("contextmenu", e => e.preventDefault());
    </script>
</body>

</html>
