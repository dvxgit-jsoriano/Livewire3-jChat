<?php

use App\Livewire\Admin\PageContacts;
use App\Livewire\Admin\PageDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

/**
 * Authentication Routes
 */
Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');

/**
 * Admin Routes
 */
Route::prefix('admin')->group(function () {
    Route::get('dashboard', PageDashboard::class)->name('dashboard');
    Route::get('contacts', PageContacts::class)->name('contacts');
    Route::get('chats', PageDashboard::class)->name('chats');
})->middleware(['auth']);
