<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CheckoutPage;
use App\Livewire\CheckoutSuccessPage;
use App\Livewire\CollectionPage;
use App\Livewire\Home;
use App\Livewire\ProductPage;
use App\Livewire\SearchPage;
use App\Livewire\Frontend\UserDashboard;
use App\Livewire\Frontend\UserProfile;
use App\Livewire\Frontend\OrderDetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class);

Route::get('/collections/{slug}', CollectionPage::class)->name('collection.view');

Route::get('/products/{slug}', ProductPage::class)->name('product.view');

Route::get('search', SearchPage::class)->name('search.view');

Route::get('checkout', CheckoutPage::class)->name('checkout.view');

Route::get('checkout/success', CheckoutSuccessPage::class)->name('checkout-success.view');


Route::view('dashboard1', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard1');

Route::get('/dashboard', UserDashboard::class)->name('dashboard')
    ->middleware(['auth', 'verified']);


Route::get('/profile', UserProfile::class)->name('profile')
    ->middleware(['auth']);

require __DIR__.'/auth.php';

Route::get('/orders/{order}', OrderDetail::class)
    ->middleware('auth')
    ->name('orders.show');
