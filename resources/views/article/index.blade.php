@extends('layouts.app')
@section('title', 'Show Articles | Track Point')
@section('content')
    @php $authLayout = Auth::user()->layout; @endphp
    <!-- Modals -->
    {{-- article details modal --}}
    <div id="articleModal"
        class="mainModal hidden fixed flex-col space-y-4 inset-0 z-50 items-center justify-center bg-black bg-opacity-50 fade-in">
        <!-- Modal Content -->
        <div class="bg-[--secondary-bg-color] rounded-2xl shadow-lg w-[65rem] h-[30rem] p-5 relative">
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
                <div class="flex text-[--border-error] rounded-lg aspect-square overflow-hidden relative h-full">
                    <img id="articleImage"
                        src="{{ asset('/storage/uploads/images/1737209701_d2a447c86aa8f6f2f1ed542ab1c07377.jpg') }}"
                        alt="" class="h-full w-full object-cover">
                    <div id="no_image_dot_modal"
                        class="image_dot absolute top-2 left-2 w-[0.7rem] h-[0.7rem] bg-[--border-success] rounded-full shadow-md">
                    </div>
                </div>
                <div class="content grow overflow-y-auto h-full my-scroller-2 text-sm">
                    <h5 id="articleNumber"
                        class="text-4xl mt-1 mb-3 text-[--text-color] capitalize font-semibold sticky top-0 bg-[--secondary-bg-color] py-2">
                        #185</h5>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Category:</strong> <span
                            id="modal-category">1 pcs</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Season:</strong> <span
                            id="modal-season">Half</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Size:</strong> <span
                            id="modal-size">SML</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Sales Rate:</strong> <span
                            id="modal-sales-rate">250.00</span></p>
                    <hr class="my-3 mx-auto border-gray-600">
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Fabric Type:</strong> <span
                            id="modal-fabric-type">Cotton</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Quantity/Pcs:</strong> <span
                            id="modal-quantity">250</span></p>
                    <p class="text-[--secondary-text] mb-1 tracking-wide"><strong>Ready Date:</strong> <span
                            id="modal-ready-date">12-05-2025</span></p>
                    <hr class="my-3 mx-auto border-gray-600">

                    <div class="w-full text-left grow text-sm">
                        <div class="flex justify-between items-center bg-[--h-bg-color] rounded-md py-2 px-4 mb-4">
                            <div class="w-1/5">#</div>
                            <div class="grow ml-5">Title</div>
                            <div class="w-1/4">Rate</div>
                        </div>
                        <div id="modal-rate-list" class="overflow-y-auto my-scroller-2">
                            {{-- <div class="flex justify-between items-center border-t border-gray-600 py-2 px-4">
                                <div class="w-1/5">1</div>
                                <div class="grow ml-5">Hello</div>
                                <div class="w-1/4">50</div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-action"
            class="bg-[--secondary-bg-color] rounded-2xl shadow-lg max-w-3xl w-auto p-5 relative text-sm">
            <div class="flex w-full gap-4">
                <a id="track-article-in-modal" href="{{ route('article-track') }}"
                    class="w-full px-5 py-2 text-nowrap text-center border border-gray-600 hover:bg-[--h-bg-color] rounded-lg transition-all 0.3s ease-in-out">Track
                    Article</a>
                <button id="print-article-in-modal" type="button"
                    class="w-full px-5 py-2 text-nowrap text-center border border-gray-600 hover:bg-[--h-bg-color] rounded-lg transition-all 0.3s ease-in-out">Print
                    Article</button>
                <button id="add-image-in-modal" type="button"
                    class="hidden w-full px-5 py-2 text-nowrap text-center border border-gray-600 hover:bg-[--h-bg-color] rounded-lg transition-all 0.3s ease-in-out">Add
                    Image</button>
            </div>
        </div>
    </div>
    {{-- add image modal --}}
    <div id="addImageModal"
        class="mainModal hidden fixed inset-0 z-50 bg-black bg-opacity-50 fade-in">
        <!-- Modal Content -->

        <form method="POST" action="{{ route('add-image') }}" enctype="multipart/form-data" class="w-full h-full flex flex-col space-y-4 items-center justify-center">
            @csrf
            <div class="bg-[--secondary-bg-color] rounded-2xl shadow-lg w-[45rem] h-auto p-7 relative">
                <!-- Close Button -->
                <button id="close" type="button"
                    class="absolute z-[10] top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all duration-300 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Body -->
                <div id="modal_body" class="modal_body flex items-start gap-6 w-full h-full">
                    <div class="content grow">
                        <div class="flex flex-col justify-between space-y-6 h-full">
                            <div class="form-group w-full">
                                <h1 class="text-2xl text-[--text-color] font-medium mb-3">Article Details</h1>
                                <input id="article_details_in_modal" type="text" disabled
                                    class="text-sm w-full rounded-lg bg-[--bg-color] border-gray-600 text-[--text-color] px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out" />
                            </div>
                            <div class="grid grow">
                                <div
                                    class="border-dashed border-2 border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition-all duration-300 ease-in-out">
                                    <input id="image_upload" type="file" name="image_upload" accept="image/*"
                                        class="hidden" onchange="previewImage(event)" />
                                    <div id="image_preview" class="flex flex-col items-center max-w-[50%]">
                                        <img src="{{ asset('storage/uploads/images/image_icon.png') }}" alt="Upload Icon"
                                            class="w-16 h-16 mb-2" id="placeholder_icon" />
                                        <p id="upload_text" class="text-md text-gray-500">Upload Image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal-action"
                class="bg-[--secondary-bg-color] rounded-2xl shadow-lg w-[18rem] p-5 relative text-sm">
                <div class="flex w-full gap-4">
                    <button id="close" type="button"
                        class="w-1/2 px-5 py-2 text-nowrap text-center border border-gray-600 hover:bg-[--h-bg-color] rounded-lg transition-all 0.3s ease-in-out">Cancel</button>
                    <input type="hidden" id="article_id" name="article_id">
                    <button type="submit"
                        class="w-full px-5 py-2 text-nowrap text-center bg-[--success-color] text-white border border-transparent hover:bg-[--h-success-color] rounded-lg transition-all 0.3s ease-in-out">Add
                        Image</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center text-sm justify-center">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color] fade-in"> Show Articles </h1>

            <!-- Search Form -->
            <form id="search-form" method="GET" action="{{ route('article.index') }}" autocomplete="off"
                class="search-box w-[80%] text-sm mx-auto my-5 flex items-center gap-4">
                <!-- Search Input -->
                <div class="search-input relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search Article Number" id="article_no_search"
                        class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                </div>

                <!-- Filters -->
                <div class="filter-box flex flex-1 items-center gap-4">
                    <!-- Season Filter -->
                    <div class="filter-select relative w-full">
                        <select name="season" id="season"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all" {{ request('season') === 'all' ? 'selected' : '' }}>All Seasons</option>
                            @foreach ($seasons as $season)
                                <option value="{{ $season->id }}"
                                    {{ request('season') == $season->id ? 'selected' : '' }}>{{ $season->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Size Filter -->
                    <div class="filter-select relative w-full">
                        <select name="size" id="size"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all">All Sizes</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" {{ request('size') == $size->id ? 'selected' : '' }}>
                                    {{ $size->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="filter-select relative w-full">
                        <select name="category" id="category"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:outline-none focus:ring-2 focus:ring-[--primary-color] focus:ring-opacity-50">
                            <option value="all" {{ request('category') === 'all' ? 'selected' : '' }}>All Categories
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->title }}
                                </option>
                            @endforeach
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

                    @if (count($articles) > 0)
                        <div
                            class="add-new-article-btn absolute bottom-8 right-5 hover:scale-105 hover:bottom-9 transition-all group 0.3s ease-in-out">
                            <a href="{{ route('article.create') }}"
                                class="bg-[--primary-color] text-[--text-color] px-3 py-2.5 rounded-full hover:bg-[--h-primary-color] transition-all 0.3s ease-in-out">
                                <i class='bx bx-plus-medical'></i>
                            </a>
                            <span
                                class="absolute shadow-xl right-7 top-0 border border-gray-600 transform -translate-x-1/2 bg-[--h-secondary-bg-color] text-[--text-color] text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity 0.3s pointer-events-none">Add</span>
                        </div>
                    @endif

                    @if (count($articles) > 0)
                        <div class="details h-full">
                            <div class="container-parent h-full overflow-y-auto my-scroller">
                                @if ($authLayout == 'grid')
                                    <div
                                        class="card_container p-5 pr-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                        @foreach ($articles as $article)
                                            <div data-article="{{ $article }}"
                                                class="contextMenuToggle toggleModal card relative border border-gray-600 shadow-md rounded-xl h-[8rem] flex gap-3 p-2 cursor-pointer overflow-hidden fade-in">
                                                <div class="img aspect-square h-full rounded-md overflow-hidden">
                                                    <img src="{{ asset('storage/uploads/images/' . $article->image) }}"
                                                        alt="article" class="w-full h-full object-cover">
                                                    <div class="absolute top-0 right-0 group w-full h-full z-[1]">
                                                        @if ($article->image === 'no_image_icon.png')
                                                            <div
                                                                class="warning_dot absolute right-2 top-2 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                            </div>
                                                            <div
                                                                class="text-xs absolute opacity-0 right-2 top-1 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                                No Image</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="details text-start">
                                                    <h5 class="text-2xl mt-1 text-[--text-color] font-semibold">
                                                        #{{ $article->article_no }}</h5>
                                                    <p class="text-[--secondary-text] text-sm"><strong
                                                            class="font-medium">Season:</strong> <span
                                                            class="season">{{ $article->season->title }}</span></p>
                                                    <p class="text-[--secondary-text] text-sm"><strong
                                                            class="font-medium">Size:</strong> <span
                                                            class="size">{{ $article->size->title }}</p>
                                                    <p class="text-[--secondary-text] text-sm mt-"><strong
                                                            class="font-medium">Category:</strong> <span
                                                            class="sales-rate">{{ $article->category->title }}</p>
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
                                            <div class="p-2">Article No</div>
                                            <div class="p-2">Season</div>
                                            <div class="p-2">Size</div>
                                            <div class="p-2">Category</div>
                                            <div class="p-2">Sales Rate</div>
                                        </div>
                                        @foreach ($articles as $article)
                                            <div data-article="{{ $article }}"
                                                class="contextMenuToggle toggleModal relative group grid grid-cols-5 text-center border-b border-gray-600 items-center py-0.5 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all fade-in ease-in-out"
                                                onclick="toggleDetails(this)">
                                                @if ($article->image == 'no_image_icon.png')
                                                    <div
                                                        class="warning_dot absolute top-4 left-3 w-[0.5rem] h-[0.5rem] bg-[--border-warning] rounded-full group-hover:opacity-0 transition-all 0.3s ease-in-out">
                                                    </div>
                                                    <div
                                                        class="text-xs absolute opacity-0 top-3 left-3 text-nowrap text-[--border-warning] h-[1rem] group-hover:opacity-100 transition-all 0.3s ease-in-out">
                                                        No Image</div>
                                                @endif
                                                <div class="p-2">#{{ $article->article_no }}</div>
                                                <div class="p-2">{{ $article->season->title }}</div>
                                                <div class="p-2">{{ $article->size->title }}</div>
                                                <div class="p-2">{{ $article->category->title }}</div>
                                                <div class="p-2">{{ $article->sales_rate }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="no-article-message w-full h-full flex flex-col items-center justify-center gap-2">
                            <h1 class="text-sm text-[--secondary-text] capitalize">No Article Found</h1>
                            <a href="{{ route('article.create') }}"
                                class="text-sm bg-[--primary-color] text-[--text-color] px-4 py-2 rounded-md hover:bg-[--h-primary-color] hover:scale-105 hover:mb-2 transition-all 0.3s ease-in-out font-semibold">Add
                                New</a>
                        </div>
                    @endif
                </div>

                <div class="context-menu absolute top-0 left-0 text-sm z-50" style="display: none;">
                    <div
                        class="border border-gray-600 w-48 bg-[--secondary-bg-color] text-[--text-color] shadow-md rounded-xl transform transition-all 0.3s ease-in-out z-50">
                        <ul class="p-2">
                            <li>
                                <button id="show-details" type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Show
                                    Details</button>
                            </li>
                            <li>
                                <a id="track-article" href="{{ route('article-track') }}"
                                    class="flex w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Track
                                    Article</a>
                            </li>
                            <li>
                                <button id="show-details" type="button"
                                    class="w-full px-4 py-2 text-left hover:bg-[--h-bg-color] rounded-md transition-all 0.3s ease-in-out">Print
                                    Article</button>
                            </li>
                            <li id="add-img-in-context" class="hidden">
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
        $(document).ready(function() {
            let contextMenu = document.querySelector('.context-menu');
            let addImgInContext = document.getElementById('add-img-in-context');
            let isContextMenuOpened = false;

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

            function addContextMenuListenerToCards() {
                let contextMenuToggle = document.querySelectorAll('.contextMenuToggle');

                contextMenuToggle.forEach(toggle => {
                    toggle.addEventListener('contextmenu', (e) => {
                        generateContextMenu(e);
                    });
                });
            };

            addContextMenuListenerToCards();

            function generateContextMenu(e) {
                addImgInContext.classList.add('hidden');

                let ac_in_btn_context = document.getElementById('ac_in_btn_context');
                let item = e.target.closest('.toggleModal');
                let article = JSON.parse(item.dataset.article);

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
                        generateModal(item);
                    };
                });

                let trackArticle = document.getElementById('track-article');
                trackArticle.href = `/article-track?a_id=${article.id}`;

                document.addEventListener('click', (e) => {
                    if (e.target.id === "add-img-in-context-btn") {
                        generateAddImageModal(item);
                    };
                });

                if (article.image === "no_image_icon.png") {
                    addImgInContext.classList.remove('hidden');
                };

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

            function generateAddImageModal(item) {
                let article = JSON.parse(item.dataset.article);
                console.log(article.id);
                let article_details_in_modal = document.querySelector('#article_details_in_modal');

                article_details_in_modal.value =
                    `${article.article_no} | ${article.season.title} | ${article.size.title} | ${article.category.title} | ${article.fabric_type} | ${article.sales_rate} - Rs.`;

                openAddImageModal();

                document.getElementById('article_id').value = article.id;
                document.getElementById('addImageModal').classList.remove('hidden');
            };


            $('#article_no_search').on('input', function(e) {
                e.preventDefault();

                $(this).blur();

                submitForm();

                setTimeout(() => {
                    $(this).focus();
                }, 100);
            });

            $('#search-form').on('change', 'select', function(e) {
                if (e.type === 'keydown' && e.key !== 'Enter')
                    return;
                e.preventDefault();
                submitForm();
            });

            function submitForm() {
                let formData = $('#search-form').serialize();

                $.ajax({
                    url: $('#search-form').attr('action'),
                    method: 'GET',
                    data: formData,
                    success: function(response) {
                        const articles = $(response).find('.details').html();

                        if (articles === undefined || articles.trim() === "") {
                            $('.details').html(
                                '<div class="text-center text-[--border-error] pt-5 col-span-4">Article Not Found</div>'
                            );
                        } else {
                            $('.details').html(articles);
                            addListenerToCards();
                            addContextMenuListenerToCards();
                        };
                    },
                    error: function() {
                        alert('Error submitting form');
                    }
                });
            };

            const close = document.querySelectorAll('#close');

            let isModalOpened = false;
            let isAddImageModalOpened = false;

            close.forEach(function(btn) {
                btn.addEventListener("click", (e) => {
                    let targetedModal = e.target.closest(".mainModal")
                    if (targetedModal.id == 'articleModal') {
                        if (isModalOpened) {
                            closeArticleModal();
                        }
                    } else if (targetedModal.id == 'addImageModal') {
                        if (isAddImageModalOpened) {
                            closeAddImageModal();
                        }
                    }
                });
            });

            document.getElementById('articleModal').addEventListener('click', (e) => {
                if (e.target.id === 'articleModal') {
                    closeArticleModal();
                };
            });

            document.getElementById('addImageModal').addEventListener('click', (e) => {
                if (e.target.id === 'addImageModal') {
                    closeAddImageModal();
                };
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (isModalOpened == true) {
                        closeArticleModal();
                    }
                    if (isAddImageModalOpened == true) {
                        closeAddImageModal();
                    };
                    closeContextMenu();
                };
            });

            function addListenerToCards() {
                let card = document.querySelectorAll('.toggleModal');

                card.forEach(item => {
                    item.addEventListener('click', () => {
                        if (!isContextMenuOpened) {
                            generateModal(item);
                        };
                    });
                });
            };

            function generateModal(item) {
                let article = JSON.parse(item.dataset.article);
                let articleRatesArray = article.rates_array;

                let articleImage = document.getElementById('articleImage');

                let articleNumber = document.getElementById('articleNumber');
                articleNumber.textContent = `#${article.article_no}`;

                let modalCategory = document.getElementById('modal-category');
                modalCategory.textContent = `${article.category.title}`;

                let modalSeason = document.getElementById('modal-season');
                modalSeason.textContent = `${article.season.title}`;

                let modalSize = document.getElementById('modal-size');
                modalSize.textContent = `${article.size.title}`;

                let modalSalesRate = document.getElementById('modal-sales-rate');
                modalSalesRate.textContent = `${article.sales_rate}`;

                let modalFabricType = document.getElementById('modal-fabric-type');
                modalFabricType.textContent = `${article.fabric_type}`;

                let modalQuantity = document.getElementById('modal-quantity');
                modalQuantity.textContent = `${article.quantity}`;

                let modalReadyDate = document.getElementById('modal-ready-date');
                modalReadyDate.textContent = `${article.date}`;

                let modalRateList = document.getElementById('modal-rate-list');
                modalRateList.innerHTML = '';

                articleRatesArray.forEach((rate, index) => {
                    let rateItem = `
                        <div class="flex justify-between items-center border-t border-gray-600 py-2 px-4">
                            <div class="w-1/5">${index + 1}</div>
                            <div class="grow ml-5">${rate.title}</div>
                            <div class="w-1/4">${new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(rate.rate)}</div>
                        </div>
                    `;
                    modalRateList.innerHTML += rateItem;
                });


                let trackArticleInModal = document.getElementById('track-article-in-modal');
                let addImageInModal = document.getElementById('add-image-in-modal');
                trackArticleInModal.href = `/article-track?a_id=${article.id}`;

                let no_image_dot_modal = document.getElementById('no_image_dot_modal');

                if (article.image) {
                    articleImage.src = `/storage/uploads/images/${article.image}`;
                };

                if (article.image !== 'no_image_icon.png') {
                    no_image_dot_modal.classList.remove('bg-[--border-warning]');
                    no_image_dot_modal.classList.add('bg-transparent');
                    addImageInModal.classList.add('hidden');
                } else {
                    no_image_dot_modal.classList.add('bg-[--border-warning]');
                    no_image_dot_modal.classList.remove('bg-transparent');
                    addImageInModal.classList.remove('hidden');
                    addImageInModal.addEventListener('click', function() {
                        generateAddImageModal(item);
                    })
                };


                article.textContent = article.name;

                openModal();
                document.getElementById('articleModal').classList.remove('hidden');
                document.getElementById('articleModal').classList.add('flex');
            };

            addListenerToCards();

            function openModal() {
                isModalOpened = true;
                closeAllDropdowns();
                closeContextMenu();
            };

            function openAddImageModal() {
                isAddImageModalOpened = true;
                closeAllDropdowns();
                closeContextMenu();
            };

            function closeArticleModal() {
                isModalOpened = false;
                document.getElementById('articleModal').classList.add('hidden');
                document.getElementById('articleModal').classList.remove('flex');
            }

            function closeAddImageModal() {
                isAddImageModalOpened = false;
                document.getElementById('addImageModal').classList.add('hidden');
            }
        });
    </script>
@endsection
