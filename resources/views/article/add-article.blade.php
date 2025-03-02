@extends('layouts.app')
@section('title', 'Add Article | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center justify-center">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-6 text-center text-[--primary-color] fade-in"> Add Article </h1>

            <!-- Progress Bar -->
            <div class="mb-5 max-w-5xl mx-auto fade-in">
                <div class="flex justify-between mb-2 progress-indicators">
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--primary-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step1-indicator" onclick="gotoStep(1)">Enter Details</span>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--h-bg-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step2-indicator" onclick="gotoStep(2)">Enter Rates</span>
                    <span
                        class="text-xs font-semibold inline-block py-1 px-3 uppercase rounded text-[--text-color] bg-[--h-bg-color] transition-all duration-300 ease-in-out cursor-pointer"
                        id="step3-indicator" onclick="gotoStep(3)">Upload Image</span>
                </div>
                <div class="flex h-2 mb-4 overflow-hidden bg-[--h-bg-color] rounded-full">
                    <div class="transition-all duration-500 ease-in-out w-1/3 bg-[--primary-color]" id="progress-bar"></div>
                </div>
            </div>

            <div class="row max-w-5xl mx-auto flex gap-4">
                <!-- Form -->
                <form id="form" method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data"
                    class="bg-[--secondary-bg-color] rounded-xl shadow-xl p-8 border border-[--h-bg-color] pt-12 grow relative overflow-hidden fade-in">
                    @csrf
                    <div
                        class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-xs">
                        <h4>Add New Article</h4>
                    </div>
                    <!-- Step 1: Basic Information -->
                    <div class="step1 space-y-4 ">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- article no --}}
                            <div class="form-group">
                                <label for="article_no"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Article No</label>
                                <input id="article_no" type="number" name="article_no"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    value="{{ old('article_no') }}" />
                                @error('article_no')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="article_no-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                            {{-- date --}}
                            <div class="form-group">
                                <label for="date"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Date</label>
                                <input id="date" type="date" name="date"
                                    class="restrict-future-date w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    value="{{ old('date') }}" />
                                @error('date')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="date-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                            {{-- category --}}
                            <div class="form-group">
                                <label for="category"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Category</label>
                                <div class="relative">
                                    <select id="category" name="category_id"
                                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                        <option value="">-- select category --</option>
                                        @foreach ($types as $type)
                                            @if ($type->type === 'pcs_category')
                                                <option value="{{ str_replace(' ', '-', $type->id) }}"
                                                    {{ old('category_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <!-- Display error message for 'name' -->
                                        <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                    <div id="category-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                                </div>
                            </div>
                            {{-- size --}}
                            <div class="form-group">
                                <label for="size"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Size</label>
                                <div class="relative">
                                    <select id="size" name="size_id"
                                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                        <option value="">-- select size --</option>
                                        @foreach ($types as $type)
                                            @if ($type->type === 'pcs_size')
                                                <option value="{{ str_replace(' ', '-', $type->id) }}"
                                                    {{ old('size_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('size_id')
                                        <!-- Display error message for 'name' -->
                                        <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                    <div id="size-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                                </div>
                            </div>
                            {{-- seasson --}}
                            <div class="form-group">
                                <label for="season"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Season</label>
                                <div class="relative">
                                    <select id="season" name="season_id"
                                        class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                                        <option value="">-- select season --</option>
                                        @foreach ($types as $type)
                                            @if ($type->type === 'pcs_season')
                                                <option value="{{ str_replace(' ', '-', $type->id) }}"
                                                    {{ old('season_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('season_id')
                                        <!-- Display error message for 'name' -->
                                        <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                    @enderror
                                    <div id="season-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                                </div>
                            </div>
                            {{-- quantity --}}
                            <div class="form-group">
                                <label for="quantity"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Quantity-Pcs</label>
                                <input id="quantity" type="number" name="quantity"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    value="{{ old('quantity') }}" />
                                @error('quantity')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="quantity-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                            {{-- extra_pcs --}}
                            <div class="form-group">
                                <label for="extra_pcs" class="block text-xs font-medium text-[--secondary-text] mb-1">Extra
                                    Pcs</label>
                                <input id="extra_pcs" type="number" name="extra_pcs"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    value="{{ old('extra_pcs') }}" />
                                @error('extra_pcs')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="extra_pcs-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                            {{-- fabric_type --}}
                            <div class="form-group">
                                <label for="fabric_type"
                                    class="block text-xs font-medium text-[--secondary-text] mb-1">Fabric Type</label>
                                <input id="fabric_type" type="text" name="fabric_type"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    value="{{ old('fabric_type') }}" />
                                @error('fabric_type')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                                <div id="fabric_type-error" class="text-[--border-error] text-xs mt-1 hidden"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Production Details -->
                    <div class="step2 hidden space-y-6 ">
                        <div class="flex justify-between gap-4">
                            {{-- title --}}
                            <div class="form-group grow">
                                <input id="title" type="text"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    placeholder="Enter Title" />
                            </div>
                            {{-- rate --}}
                            <div class="form-group w-1/3">
                                <input id="rate" type="number"
                                    class="w-full rounded-lg bg-[--h-bg-color] border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                    placeholder="Enter Rate" />
                            </div>
                            {{-- add rate button --}}
                            <div class="form-group flex w-10 shrink-0">
                                <input type="button" value="+"
                                    class="w-full bg-[--primary-color] text-[--text-color] rounded-lg cursor-pointer border border-[--primary-color]"
                                    onclick="addRate()" />
                            </div>
                        </div>
                        {{-- rate showing --}}
                        <div id="rate-table" class="w-full text-left text-sm">
                            <div class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 mb-4">
                                <div class="grow ml-5">Title</div>
                                <div class="w-1/4">Rate</div>
                                <div class="w-[10%] text-center">Action</div>
                            </div>
                            <div id="rate-list" class="space-y-4 h-[250px] overflow-y-auto my-scroller-2">
                                <div class="text-center bg-[--h-bg-color] rounded-lg py-2 px-4">No Rates Added</div>
                            </div>
                        </div>
                        {{-- calc bottom --}}
                        <div id="calc-bottom" class="flex w-full gap-4 text-sm">
                            <div
                                class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="grow ml-5">Total - Rs.</div>
                                <div class="w-1/4">0.00</div>
                            </div>
                            <div
                                class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap grow">Sales Rate - Rs.</div>
                                <input type="text" name="sales_rate" id="sales_rate" value="0.00"
                                    class="text-right bg-transparent outline-none border-none" />
                            </div>
                        </div>
                        <input type="hidden" name="rates_array" id="rates_array" value="[]" />
                    </div>

                    <!-- Step 3: Production Details -->
                    <div class="step3 hidden space-y-4  h-full">
                        <div class="grid grid-cols-1 md:grid-cols-1 h-full">
                            <div
                                class="border-dashed h-full border-2 border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition-all duration-300 ease-in-out">
                                <input id="image_upload" type="file" name="image_upload" accept="image/*"
                                    class="hidden" onchange="previewImage(event)" />
                                <div id="image_preview" class="flex flex-col items-center max-w-[50%]">
                                    <img src="{{ asset('storage/uploads/images/image_icon.png') }}" alt="Upload Icon"
                                        class="w-20 h-20 mb-2" id="placeholder_icon" />
                                    <p id="upload_text" class="text-sm text-gray-500">Upload article</p>
                                </div>
                                @error('image_upload')
                                    <!-- Display error message for 'name' -->
                                    <div class="text-[--border-error] text-xs mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Form -->
                <div
                    class="bg-[--secondary-bg-color] rounded-xl shadow-xl p-8 border border-[--h-bg-color] w-[35%] pt-12 relative overflow-hidden fade-in">
                    <div
                        class="form-title text-center absolute top-0 left-0 w-full bg-[--primary-color] py-1 shadow-lg uppercase font-semibold text-xs">
                        <h4>Last Record</h4>
                    </div>

                    <!-- Step 1: Basic Information -->
                    <div class="step1 space-y-4 ">
                        @if ($lastRecord)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Article No</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->article_no }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Date</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->date }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Category</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->category->title }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Size</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->size->title }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Season</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->season->title }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Quantity-Dz</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->quantity }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Extra Pcs</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out"
                                        value="{{ $lastRecord->extra_pcs }}" />
                                </div>
                                <div class="form-group">
                                    <h3 class="block text-xs font-medium text-[--secondary-text] mb-1">Fabric Type</h3>
                                    <input disabled
                                        class="w-full bg-transparent rounded-lg border-gray-600 text-[--text-color] text-sm px-3 py-2 border focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out text-nowrap overflow-x-auto"
                                        value="{{ $lastRecord->fabric_type }}" />
                                </div>
                            </div>
                        @else
                            <div class="text-center text-xs text-[--border-error]">No records found</div>
                        @endif
                    </div>

                    <!-- Step 2: Production Details -->
                    <div class="step2 hidden space-y-6  h-full text-sm flex flex-col">
                        @if ($lastRecord)
                            <div class="w-full text-left grow">
                                <div class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 mb-4">
                                    <div class="grow ml-5">Title</div>
                                    <div class="w-1/4">Rate</div>
                                </div>
                                <div id="rate-list" class="space-y-4 h-[250px] overflow-y-auto my-scroller-2">
                                    @if (count($lastRecord->rates_array) === 0)
                                        <div class="text-center bg-[--h-bg-color] rounded-lg py-2 px-4">No Rates Added
                                        </div>
                                    @else
                                        @foreach ($lastRecord->rates_array as $rate)
                                            @php
                                                $lastRecord->total_rate += $rate['rate'];
                                            @endphp
                                            <div
                                                class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4">
                                                <div class="grow ml-5">{{ $rate['title'] }}</div>
                                                <div class="w-1/4">{{ number_format($rate['rate'], 2, '.', '') }}</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col w-full gap-4">
                                <div
                                    class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                    <div class="grow">Total - Rs.</div>
                                    <div class="w-1/4 text-right">{{ number_format($lastRecord->total_rate, 2, '.', '') }}
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                    <div class="text-nowrap grow">Sales Rate - Rs.</div>
                                    <div class="w-1/4 text-right">{{ number_format($lastRecord->sales_rate, 2, '.', '') }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-xs text-[--border-error]">No records found</div>
                        @endif
                    </div>

                    <!-- Step 3: Production Details -->
                    <div class="step3 hidden space-y-6  text-sm">
                        @if ($lastRecord)
                            <div class="grid grid-cols-1 md:grid-cols-1">
                                <div
                                    class="border-dashed border-2 border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition-all duration-300 ease-in-out">
                                    <input id="image_upload" type="file" name="image_upload" accept="image/*"
                                        class="hidden" onchange="previewImage(event)" />
                                    <div id="image_preview" class="flex flex-col items-center max-w-[50%]">
                                        <img src="{{ asset('storage/uploads/images/' . $lastRecord->image) }}"
                                            alt="Last Image" class="placeholder_icon mb-2 rounded-lg w-full h-auto" />
                                        <p class="upload_text text-md text-gray-500">Image</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-xs text-[--border-error]">No records found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let titleDom = document.getElementById('title');
        let rateDom = document.getElementById('rate');
        let calcBottom = document.querySelector('#calc-bottom');
        let ratesArrayDom = document.getElementById('rates_array');
        let rateCount = 0;

        let totalRate = 0.00;

        let ratesArray = [];

        function addRate() {
            let title = titleDom.value;
            let rate = rateDom.value;

            if (title && rate && ratesArray.filter(rate => rate.title === title).length === 0) {
                let rateList = document.querySelector('#rate-list');

                if (rateCount === 0) {
                    rateList.innerHTML = '';
                }

                rateCount++;
                let rateRow = document.createElement('div');
                rateRow.classList.add('flex', 'justify-between', 'items-center', 'bg-[--h-bg-color]', 'rounded-lg', 'py-2',
                    'px-4');
                rateRow.innerHTML = `
                    <div class="grow ml-5">${title}</div>
                    <div class="w-1/4">${parseFloat(rate).toFixed(2)}</div>
                    <div class="w-[10%] text-center">
                        <button onclick="deleteRate(this)" type="button" class="text-[--danger-color] text-xs px-2 py-1 rounded-lg hover:text-[--h-danger-color] transition-all duration-300 ease-in-out">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                rateList.insertBefore(rateRow, rateList.firstChild);

                titleDom.value = '';
                rateDom.value = '';

                titleDom.focus();

                totalRate += parseFloat(rate);

                ratesArray.push({
                    title: title,
                    rate: rate
                });

                updateRates();
            }
        }

        function deleteRate(element) {
            element.parentElement.parentElement.remove();
            rateCount--;
            if (rateCount === 0) {
                let rateList = document.querySelector('#rate-list');
                rateList.innerHTML = `
                    <div class="text-center bg-[--h-bg-color] rounded-lg py-2 px-4">No Rates Added</div>
                `;
            }

            titleDom.focus();

            let rate = parseFloat(element.parentElement.previousElementSibling.innerText);
            totalRate -= rate;

            let title = element.parentElement.previousElementSibling.previousElementSibling.innerText;
            ratesArray = ratesArray.filter(rate => rate.title !== title);

            updateRates();
        }

        function updateRates() {
            calcBottom.innerHTML = `
                <div class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="grow ml-5">Total - Rs.</div>
                    <div class="w-1/4">${totalRate.toFixed(2)}</div>
                </div>
                <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                    <div class="text-nowrap grow">Sales Rate - Rs.</div>
                    <input type="text" name="sales_rate" id="sales_rate" value="${totalRate.toFixed(2)}" class="text-right bg-transparent outline-none border-none"/>
                </div>
            `;

            ratesArrayDom.value = JSON.stringify(ratesArray);
        }

        rateDom.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                addRate();
            }
        });

        const articles = @json($articles);
        const articleNoDom = document.querySelector('#article_no');
        const articleNoError = document.querySelector('#article_no-error');
        const dateDom = document.querySelector('#date');
        const dateError = document.querySelector('#date-error');
        const categoryDom = document.querySelector('#category');
        const categoryError = document.querySelector('#category-error');
        const sizeDom = document.querySelector('#size');
        const sizeError = document.querySelector('#size-error');
        const seasonDom = document.querySelector('#season');
        const seasonError = document.querySelector('#season-error');
        const quantityDom = document.querySelector('#quantity');
        const quantityError = document.querySelector('#quantity-error');
        const extraPcsDom = document.querySelector('#extra_pcs');
        const extraPcsError = document.querySelector('#extra_pcs-error');
        const fabricTyprDom = document.querySelector('#fabric_type');
        const fabricTyprError = document.querySelector('#fabric_type-error');

        function validateArticleNo() {
            let existingArticle = articles.find(a => a.article_no === parseFloat(articleNoDom.value))
            if (articleNoDom.value === "") {
                articleNoDom.classList.add("border-[--border-error]");
                articleNoError.classList.remove("hidden");
                articleNoError.textContent = "Article No field is required.";
                return false;
            } else if (existingArticle) {
                articleNoDom.classList.add("border-[--border-error]");
                articleNoError.classList.remove("hidden");
                articleNoError.textContent = "Article No is already exist.";
                return false;
            } else {
                articleNoDom.classList.remove("border-[--border-error]");
                articleNoError.classList.add("hidden");
                return true;
            }
        }

        function validateDate() {
            if (dateDom.value === "") {
                dateDom.classList.add("border-[--border-error]");
                dateError.classList.remove("hidden");
                dateError.textContent = "Date field is required.";
                return false;
            } else {
                dateDom.classList.remove("border-[--border-error]");
                dateError.classList.add("hidden");
                return true;
            }
        }

        function validateCategory() {
            if (categoryDom.value === "") {
                categoryDom.classList.add("border-[--border-error]");
                categoryError.classList.remove("hidden");
                categoryError.textContent = "Category field is required.";
                return false;
            } else {
                categoryDom.classList.remove("border-[--border-error]");
                categoryError.classList.add("hidden");
                return true;
            }
        }

        function validateSize() {
            if (sizeDom.value === "") {
                sizeDom.classList.add("border-[--border-error]");
                sizeError.classList.remove("hidden");
                sizeError.textContent = "Size field is required.";
                return false;
            } else {
                sizeDom.classList.remove("border-[--border-error]");
                sizeError.classList.add("hidden");
                return true;
            }
        }

        function validateSeason() {
            if (seasonDom.value === "") {
                seasonDom.classList.add("border-[--border-error]");
                seasonError.classList.remove("hidden");
                seasonError.textContent = "Season field is required.";
                return false;
            } else {
                seasonDom.classList.remove("border-[--border-error]");
                seasonError.classList.add("hidden");
                return true;
            }
        }

        function validateQuantity() {
            if (quantityDom.value === "") {
                quantityDom.classList.add("border-[--border-error]");
                quantityError.classList.remove("hidden");
                quantityError.textContent = "Quantity field is required.";
                return false;
            } else if (quantityDom.value < 0) {
                quantityDom.classList.add("border-[--border-error]");
                quantityError.classList.remove("hidden");
                quantityError.textContent = "Quantity is lessthen 0.";
                return false;
            } else {
                quantityDom.classList.remove("border-[--border-error]");
                quantityError.classList.add("hidden");
                return true;
            }
        }

        function validateExtraPcs() {
            if (extraPcsDom.value === "") {
                extraPcsDom.classList.add("border-[--border-error]");
                extraPcsError.classList.remove("hidden");
                extraPcsError.textContent = "Extra Pcs field is required.";
                return false;
            } else {
                extraPcsDom.classList.remove("border-[--border-error]");
                extraPcsError.classList.add("hidden");
                return true;
            }
        }

        function validateFabricType() {
            if (fabricTyprDom.value === "") {
                fabricTyprDom.classList.add("border-[--border-error]");
                fabricTyprError.classList.remove("hidden");
                fabricTyprError.textContent = "Quantity field is required.";
                return false;
            } else {
                fabricTyprDom.classList.remove("border-[--border-error]");
                fabricTyprError.classList.add("hidden");
                return true;
            }
        }

        articleNoDom.addEventListener('input', function () {
            validateArticleNo();
        })

        dateDom.addEventListener('change', function () {
            validateDate();
        })

        categoryDom.addEventListener('change', function () {
            validateCategory();
        })

        sizeDom.addEventListener('change', function () {
            validateSize();
        })

        seasonDom.addEventListener('change', function () {
            validateSeason();
        })

        quantityDom.addEventListener('input', function () {
            validateQuantity();
        })

        extraPcsDom.addEventListener('input', function () {
            validateExtraPcs();
        })

        fabricTyprDom.addEventListener('input', function () {
            validateFabricType();
        })

        function validateForNextStep(){
            let isValid = validateArticleNo() 
                || validateDate() 
                || validateCategory()
                || validateSize()
                || validateSeason()
                || validateQuantity()
                || validateExtraPcs()
                || validateFabricType()
            ;

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
