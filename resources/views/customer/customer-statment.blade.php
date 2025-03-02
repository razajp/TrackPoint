@extends('layouts.app')
@section('title', 'Show Customers | Track Point')
@section('content')

    <style>
        input#date-to[disabled],
        input#date-from[disabled] {
            opacity: 0.3;
            cursor: not-allowed;
        }
    </style>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center justify-center text-sm">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color] fade-in">Customer Statement</h1>

            <!-- Search Form -->
            <div class="search-box w-[80%] mx-auto my-5 flex items-center gap-4 fade-in">
                <div class="flex flex-1 items-center gap-4">
                    <!-- customer -->
                    <div class="filter-select relative w-full grow">
                        <select id="customer"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.5s ease-in-out"
                            onchange="selectChanged(this)">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer }} | {{ $customer->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- date-to -->
                    <div class="filter-select relative w-1/2 flex items-center gap-3">
                        <label for="date-to" class="block text-[--text-color] font-medium text-nowrap">Date To :</label>
                        <input disabled type="date" name="date-to" value="" id="date-to"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.5s ease-in-out"
                            onchange="restrictDate(this, 'dateTo')">
                    </div>

                    <!-- date-from -->
                    <div class="filter-select relative w-1/2 flex items-center gap-3">
                        <label for="date-from" class="block text-[--text-color] font-medium text-nowrap">Date From :</label>
                        <input disabled type="date" name="date-from" value="" id="date-from"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all 0.5s ease-in-out"
                            onchange="restrictDate(this, 'dateFrom')">
                    </div>

                    <!-- button -->
                    <div class="filter-select relative w-1/4">
                        <button
                            class="w-full px-4 py-2 rounded-lg bg-[--primary-color] text-[--text-color] hover:bg-[--h-primary-color] transition-all 0.5s ease-in-out">Search</button>
                    </div>
                </div>
            </div>

            <section class="text-center mx-auto fade-in">
                <div
                    class="show-box mx-auto w-[80%] h-[70vh] bg-[--secondary-bg-color] rounded-xl shadow-md relative overflow-y-hidden">
                    <div id="table_container" class="rounded-tl-xl rounded-tr-xl h-full text-sm flex flex-col">
                        <div class="grid grid-cols-7 bg-[--primary-color] font-medium">
                            <div class="p-2">Date</div>
                            <div class="p-2">Transaction</div>
                            <div class="p-2">Ref.#</div>
                            <div class="p-2">Desc.</div>
                            <div class="p-2">Sales</div>
                            <div class="p-2">Payment</div>
                            <div class="p-2">Balance</div>
                        </div>

                        <div id="table-body" class="table-body overflow-y-auto my-scroller-2 grow">
                            {{-- <div
                            class="modalToggle grid grid-cols-7 text-center border-b border-gray-600 items-center p-2 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all 0.5s ease-in-out">
                                <div class="p-2">13/2/2012</div>
                                <div class="p-2 font-medium">Invoice</div>
                                <div class="p-2">2025-0001</div>
                                <div class="p-2">qty 150</div>
                                <div class="p-2">15000</div>
                                <div class="p-2">-</div>
                                <div class="p-2">15000</div>
                            </div>
                            <div
                            class="modalToggle grid grid-cols-7 text-center border-b border-gray-600 items-center p-2 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all 0.5s ease-in-out">
                                <div class="p-2">14/2/2012</div>
                                <div class="p-2 font-medium">Payment</div>
                                <div class="p-2">32517485</div>
                                <div class="p-2">Cheque | M.B.</div>
                                <div class="p-2">-</div>
                                <div class="p-2">5000</div>
                                <div class="p-2">10000</div>
                            </div> --}}

                            @php
                                $totalSales = 0;
                                $totalPayment = 0;
                            @endphp

                            @if (isset($customerStatement) && count($customerStatement) > 0)
                                @foreach ($customerStatement as $statement)
                                    <div
                                        class="modalToggle grid grid-cols-7 text-center text-xs border-b border-gray-600 items-center py-1 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all 0.5s ease-in-out fade-in">
                                        <div class="p-2">{{ $statement['date'] }}</div>
                                        <div class="p-2 font-medium">{{ $statement['transaction'] }}</div>
                                        <div class="p-2">{{ $statement['reference'] }}</div>
                                        <div class="p-2">{{ $statement['description'] }}</div>
                                        <div class="p-2">{{ $statement['sales'] }}</div>
                                        <div class="p-2">{{ $statement['payment'] }}</div>
                                        @if ($statement['balance'] >= 0)
                                            <div class="p-2">{{ number_format($statement['balance'], 1, '.', ',') }}
                                            </div>
                                        @else
                                            <div class="p-2 text-[--border-error]">-
                                                ({{ number_format(abs($statement['balance']), 1, '.', ',') }})
                                            </div>
                                        @endif
                                    </div>

                                    @if ($statement['transaction'] == 'Invoice')
                                        @php
                                            $totalSales += $statement['net_amount'];
                                        @endphp
                                    @elseif ($statement['transaction'] == 'Payment')
                                        @php
                                            $totalPayment += $statement['amount'];
                                        @endphp
                                    @endif
                                @endforeach
                                <div
                                    class="ptint-statement-btn absolute bottom-20 right-5 hover:scale-105 hover:bottom-22 transition-all 0.5s group ease-in-out z-10">
                                    <button type="button" id="print-report"
                                        class="bg-[--primary-color] text-[--text-color] px-3 py-2.5 rounded-full hover:bg-[--h-primary-color] transition-all 0.5s ease-in-out">
                                        <i class="bx bxs-file-export text-md"></i>
                                    </button>
                                    <span
                                        class="absolute shadow-xl right-0 top-2.5 border border-gray-600 transform -translate-x-1/2 bg-[--h-secondary-bg-color] text-[--text-color] text-xs text-nowrap rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-all 0.5s ease-in-out pointer-events-none">
                                        Print Statement
                                    </span>
                                </div>
                            @else
                                <div class="text-center text-[--border-error] py-5">No data found!</div>
                            @endif
                        </div>

                        @php
                            if (!isset($previousBalance)) {
                                $previousBalance = 0;
                            }
                        @endphp

                        <div id="calc-bottom" class="flex w-full gap-4 p-5">
                            <div
                                class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Previous Balance (Rs.)</div>

                                @if (isset($previousBalance) && $previousBalance < 0)
                                    <div class="grow text-right text-[--border-error]">-
                                        ({{ number_format(abs($previousBalance), 1, '.', ',') }})</div>
                                @else
                                    <div class="grow text-right">{{ number_format($previousBalance, 1, '.', ',') }}</div>
                                @endif
                            </div>
                            <div
                                class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Sales (Rs.)</div>
                                <div id="total-amount" class="grow text-right">
                                    {{ number_format($totalSales, 1, '.', ',') }}</div>
                            </div>
                            <div
                                class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Payment (Rs.)</div>
                                <div id="total-amount" class="grow text-right">
                                    {{ number_format($totalPayment, 1, '.', ',') }}</div>
                            </div>
                            <div
                                class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Balnce (Rs.)</div>
                                <div id="net-amount" class="grow text-right">
                                    {{ number_format($previousBalance + $totalSales - $totalPayment, 1, '.', ',') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script>
                const customer = document.getElementById('customer');
                const dateTo = document.getElementById('date-to');
                const dateFrom = document.getElementById('date-from');
                const searchBtn = document.querySelector('.search-box button');

                searchBtn.addEventListener('click', () => {
                    resetURL();

                    $.ajax({
                        url: '/customer-statement',
                        type: 'GET',
                        data: {
                            customerId: customer.value,
                            dateTo: dateTo.value,
                            dateFrom: dateFrom.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Check if .card_container exists in the response and get its HTML
                            const tableBody = $(response).find('#table_container').html();

                            if (tableBody === undefined || tableBody.trim() === "") {
                                alert('No data found!');
                            } else {
                                $('#table_container').html(tableBody);
                            }
                        },
                    });
                });

                selectChanged(document.querySelector('#customer').value)

                function selectChanged(selectElem) {
                    if (selectElem.value != "") {
                        dateTo.disabled = false;
                        dateFrom.disabled = false;
                    } else {
                        dateTo.disabled = true;
                        dateFrom.disabled = true;
                    }
                }

                function restrictDate(dateInputElem, inputType) {
                    if (inputType == 'dateTo') {
                        let date = dateInputElem.value;
                        dateFrom.min = date;
                    } else {
                        let date = dateInputElem.value;
                        dateTo.max = date;
                    }
                }

                document.addEventListener("DOMContentLoaded", function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const c_id = urlParams.get("c_id");

                    if (c_id) {
                        const option = customer?.querySelector(`option[value="${c_id}"]`);
                        if (option) {
                            option.selected = true;
                        }
                        searchBtn?.click();
                    }
                });

                function resetURL() {
                    const url = new URL(window.location.href);
                    url.searchParams.delete("c_id"); // Remove c_id

                    // Replace the URL without reloading the page
                    window.history.replaceState({}, document.title, url);
                }
            </script>
        </div>
    </main>
@endsection
