@extends('layouts.app')
@section('title', 'Article Track | Track Point')
@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex items-center justify-center fade-in">
        <div class="main-child grow">
            <h1 class="text-3xl font-bold mb-5 text-center text-[--primary-color]"> Article Track </h1>

            <!-- Search Form -->
            <div class="search-box w-[80%] mx-auto my-5 flex items-center text-sm gap-4">
                <div class="flex flex-1 items-center gap-4">
                    <!-- article -->
                    <div class="filter-select relative w-full grow">
                        <select id="article"
                            class="w-full px-4 py-2 rounded-lg bg-[--h-bg-color] text-[--text-color] placeholder-[--text-color] appearance-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-300 ease-in-out">
                            <option value="">-- Select Article --</option>
                            @foreach( $articles as $article )
                                <option value="{{ $article->id }}">#{{ $article->article_no }} | {{ $article->category->title }} | {{ $article->season->title }} | {{ $article->size->title }} | {{ $article->fabric_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <section class="text-center mx-auto text-sm">
                <div class="show-box mx-auto w-[80%] h-[70vh] bg-[--secondary-bg-color] rounded-xl shadow-md relative overflow-y-hidden">
                    <div id="table_container" class="rounded-tl-lg rounded-tr-lg h-full text-sm flex flex-col">
                        <div class="flex bg-[--primary-color] px-2 font-medium">
                            <div class="p-2 w-5 text-center">#.</div>
                            <div class="p-2 w-full">Date</div>
                            <div class="p-2 w-full grow">Customer</div>
                            <div class="p-2 w-1/2">Invoice No.#</div>
                            <div class="p-2 w-1/2">Qty - Pcs.</div>
                            <div class="p-2 w-1/2">Rate</div>
                            <div class="p-2 w-1/2">Amount</div>
                            <div class="p-2 w-1/2">Off in Invoice</div>
                            <div class="p-2 w-1/2">Net Amount</div>
                        </div>

                        <div id="table-body" class="table-body overflow-y-auto my-scroller-2 grow">

                            @php
                                $totalQuantity = 0;
                                $soldQuantity = 0;
                                $totalBalance = 0;
                            @endphp

                            @if( isset($filteredInvoices) && count($filteredInvoices) > 0 )
                                @foreach( $filteredInvoices as $key => $invoice )
                                    <div class="modalToggle flex text-center text-xs border-b border-gray-600 items-center py-1 cursor-pointer hover:bg-[--h-secondary-bg-color] transition-all ease-in-out fade-in">
                                        <div class="p-2 w-5">{{ $key + 1 }}.</div>
                                        <div class="p-2 w-full">{{ $invoice->date }}</div>
                                        <div class="p-2 w-full gorw">{{ $invoice->customer->customer }} | {{ $invoice->customer->city }}</div>
                                        <div class="p-2 w-1/2">{{ $invoice->invoice_no }}</div>
                                        <div class="p-2 w-1/2">{{ $invoice->articles_array['quantity'] }}</div>
                                        <div class="p-2 w-1/2">{{ number_format($invoice->rate, 2, '.', ',') }}</div>
                                        <div class="p-2 w-1/2">{{ number_format(($invoice->article['sales_rate'] * $invoice->articles_array['quantity']), 1, '.', ',') }}</div>
                                        <div class="p-2 w-1/2">{{ $invoice->discount }}%.</div>
                                        <div class="p-2 w-1/2">{{ number_format((($invoice->article['sales_rate'] * $invoice->articles_array['quantity']) - (($invoice->article['sales_rate'] * $invoice->articles_array['quantity']) * ($invoice->discount / 100))), 1, '.', ',') }}</div>
                                    </div>
                                    @php
                                        $totalQuantity = $invoice->article['quantity'];
                                        $soldQuantity = $invoice->article['sold_quantity'];
                                        $totalBalance += (($invoice->article['sales_rate'] * $invoice->articles_array['quantity']) - (($invoice->article['sales_rate'] * $invoice->articles_array['quantity']) * ($invoice->discount / 100)));
                                    @endphp
                                @endforeach
                                <div
                                    class="ptint-report-btn absolute bottom-20 right-5 hover:scale-105 hover:bottom-22 transition-all 0.5s group ease-in-out z-10">
                                    <button type="button" id="print-report"
                                        class="bg-[--primary-color] text-[--text-color] px-3 py-2.5 rounded-full hover:bg-[--h-primary-color] transition-all 0.5s ease-in-out">
                                        <i class="bx bxs-file-export text-md"></i>
                                    </button>
                                    <span
                                        class="absolute shadow-xl right-0 top-2.5 border border-gray-600 transform -translate-x-1/2 bg-[--h-secondary-bg-color] text-[--text-color] text-xs text-nowrap rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-all 0.5s ease-in-out pointer-events-none">
                                        Print Report
                                    </span>
                                </div>
                            @else
                                <div class="text-center text-[--border-error] py-5">No data found!</div>
                            @endif
                        </div>

                        <div id="calc-bottom" class="flex w-full gap-4 p-5 text-sm">
                            <div class="total flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Quantity</div>
                                <div class="grow text-right">{{ $totalQuantity }} - Pcs.</div>
                            </div>
                            <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Sold Quantity</div>
                                <div id="total-amount" class="grow text-right">{{ $soldQuantity }} - Pcs.</div>
                            </div>
                            <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Available Stock</div>
                                <div id="total-amount" class="grow text-right">{{ $totalQuantity - $soldQuantity }} - Pcs.</div>
                            </div>
                            <div class="final flex justify-between items-center bg-[--h-bg-color] rounded-lg py-2 px-4 w-full">
                                <div class="text-nowrap">Total Balnce (Rs.)</div>
                                <div id="net-amount" class="grow text-right">{{ number_format($totalBalance, 1, '.', ',') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script>
                const article = document.getElementById('article');

                function sendRequest(article) {
                    resetURL();
                    $.ajax({
                        url: '/article-track',
                        type: 'GET',
                        data: {
                            articleId: article.value,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            const tableBody = $(response).find('#table_container').html();

                            if (tableBody === undefined || tableBody.trim() === "") {
                                alert('No data found!');
                            } else {
                                $('#table_container').html(tableBody);
                            };
                        },
                    });
                };

                article.addEventListener('change', () => {
                    sendRequest(article);
                });

                document.addEventListener("DOMContentLoaded", function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    const a_id = urlParams.get("a_id");

                    if (a_id) {
                        const option = article?.querySelector(`option[value="${a_id}"]`);
                        if (option) {
                            option.selected = true;
                        }
                        sendRequest(option);
                    };
                });

                function resetURL() {
                    const url = new URL(window.location.href);
                    url.searchParams.delete("a_id");

                    window.history.replaceState({}, document.title, url);
                };
            </script>
        </div>
    </main>
@endsection
