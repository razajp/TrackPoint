@extends('layouts.app')
@section('title', 'Home | Track Point')
@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto my-scroller-2">
        <div class="main-child grow">
            <div class="w-full h-full ]">
                <div class="row w-full flex gap-8">
                    <div class="left w-[70%] space-y-8">
                        <div class="banner flex w-full h-[14rem] bg-[--primary-color] shadow-lg rounded-2xl relative overflow-hidden">
                            <div class="left w-[50%]">
                                <div class="content w-full h-full py-12 pl-14 relative">
                                    <h1 class="text-4xl font-bold capitalize mb-1">Hi, {{ Auth::user()->name }}</h1>
                                    <p class="text-lg opacity-85 leading-tight">Welcome to Track Point – Manage your Business Effortlessly.</p>
                                    <div class="mt-8 flex gap-5">
                                        <a href="#" class="bg-white text-[--primary-color] px-4 py-2 border border-transparent rounded-lg shadow-md font-semibold hover:shadow-lg hover:bg-[--h-primary-color] hover:border-white hover:text-white hover:scale-[1.07] transition-all duration-300 ease-in-out">Get Started</a>
                                        <a href="#" class="bg-[--h-primary-color] border border-white px-4 py-2 rounded-lg shadow-md font-semibold hover:bg-white hover:border-transparent hover:text-[--primary-color] hover:scale-[1.07] transition-all duration-300 ease-in-out">View Reports</a>
                                    </div>
                                </div>
                            </div>
                            <div class="right w-[50%] h-full">
                                <div class="image w-full h-full relative">
                                    <img src="{{ asset('storage/uploads/images/dashboard_banner.png') }}" alt="" class="h-[95%] absolute -bottom-1 -right-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right w-[30%]">
                        <div class="banner flex w-full h-[32rem] bg-[--primary-color] shadow-lg rounded-2xl relative overflow-hidden">
                            <div class="w-full h-full p-5 flex flex-col justify-center text-white">
                                <h2 class="text-3xl font-bold mb-4">Calendar</h2>
                                <div class="content w-full h-full relative">
                                    <iframe src="https://calendar.google.com/calendar/embed?src=your_calendar_id&ctz=your_timezone"
                                        class="w-full h-full border-none rounded-lg shadow-lg">
                                    </iframe>
                                </div>                                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection