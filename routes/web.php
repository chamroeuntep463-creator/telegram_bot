<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',\App\Livewire\Frontend\Home::class)->name('home');
Route::get('/dashboard',\App\Livewire\Frontend\Dashboard::class)->name('dashboard');
Route::get('/product-assessment',\App\Livewire\Frontend\ProductAssessment::class)->name('product-assessment');
Route::get('/products',\App\Livewire\Frontend\ProductList::class)->name('products.index');
Route::get('/ai-bot', \App\Livewire\Frontend\AiBot::class)->name('ai-bot');
Route::get('/date', \App\Livewire\Frontend\Date::class)->name('date');
Route::get('/telegram-bot', \App\Livewire\Frontend\TelegramBot::class)->name('telegram-bot');