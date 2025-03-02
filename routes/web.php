<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\SetupsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect(route('home'));
    });

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::post('/update-theme', [AuthController::class, 'updateTheme']);

    Route::get('/add-setups', [SetupsController::class, 'addSetups'])->name('addSetups');
    Route::post('/add-setups', [SetupsController::class, 'addSetupsPost'])->name('addSetupsPost');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::post('update-user-status', [UserController::class, 'updateStatus'])->name('update-user-status');
    Route::post('update-user-layout', [UserController::class, 'updateLayout'])->name('update-user-layout');

    Route::resource('article', ArticleController::class)->middleware('role:admin,accountant');
    Route::post('/add-image', [ArticleController::class, 'addImage'])->name('add-image');
    Route::get('/article-track', [ArticleController::class, 'articleTrack'])->name('article-track');
    
    Route::resource('customer', CustomerController::class)->middleware('role:admin');
    Route::post('update-customer-status', [CustomerController::class, 'updateStatus'])->name('update-customer-status');
    Route::get('/customer-statement', [CustomerController::class, 'customerStatment'])->name('customer-statement');

    Route::resource('invoice', InvoiceController::class)->middleware('role:admin');
    Route::post('/get-article-details', [InvoiceController::class, 'getArticleDetails']);
    
    Route::resource('payment', PaymentsController::class)->middleware('role:admin');
});
