<?php

use App\Http\Controllers\LogoutController;
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

Route::middleware('whitelist')->group(function () {

    Route::get('/', \App\Livewire\Login::class)->name('login')->middleware('guest');

    Route::get('/infoPHP', function(){
        return view('info');
    });

    // Route::middleware(['customer.service'])->group(function () {

    // });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', \App\Livewire\Khususon\Index::class)->name('dashboard');
        Route::post('/logout', LogoutController::class)->name('logout');
        Route::get('/rekening', \App\Livewire\Account\Index::class)->name('rekening');
        
        Route::get('/account_setting', \App\Livewire\AccountSetting::class)->name('account-setting');

        Route::middleware('website1')->group(function(){

            Route::get('/transactions', \App\Livewire\Transactions::class)->name('transactions');
            Route::get('/members', \App\Livewire\MemberLiveWire::class)->name('members');
     
            Route::get('/log', \App\Livewire\Log\Index::class)->name('log');
        });

        Route::middleware('website2')->group(function(){

            Route::get('/tt-atas', \App\Livewire\Transfer\Index::class)->name('tt-atas');
            Route::get('/pinjam-atas', \App\Livewire\Transfer\Index::class)->name('pinjam-atas');
            Route::get('/log-transfer', \App\Livewire\Log\Index::class)->name('log-transfer');
        });

        Route::middleware('website3')->group(function(){

            Route::get('/cashbooks', \App\Livewire\Cashbooks::class)->name('cashbooks');
            Route::get('/expenditures', \App\Livewire\Expenditures::class)->name('expenditures');
        });

        });

        Route::get('/users', \App\Livewire\ListUser::class)->name('users')->middleware(['super.admin']);

    });

