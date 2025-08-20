<?php

use App\Events\NewChatRoom;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\PageContacts;
use App\Livewire\Admin\PageDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

/**
 * Authentication Routes
 */
Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

/**
 * Admin Routes
 */
Route::prefix('admin')->group(function () {
    Route::get('dashboard', PageDashboard::class)->name('dashboard');
    Route::get('contacts', PageContacts::class)->name('contacts');
    Route::get('chats', PageDashboard::class)->name('chats');
})->middleware(['auth']);


Route::get('test/user/{user}/room/{room}', function ($user, $room) {
    Log::debug("Test route called with user: {$user}, room: {$room}");
    // Test call broadcast event for NewChatRoom
    $chatUser = User::find($user);
    $chatRoom = ChatRoom::find($room);
    event(new NewChatRoom($chatRoom, $chatUser));
    //broadcast(new NewChatRoom($chatRoom, $chatUser))->toOthers();
    //NewChatRoom::dispatch($chatRoom, $chatUser);
})->name('test');
