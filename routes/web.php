<?php

use App\Events\NewChatMessage;
use App\Events\NewChatRoom;
use App\Http\Controllers\AuthController;
use App\Livewire\Admin\PageContacts;
use App\Livewire\Admin\PageDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\ChatMessage;
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

Route::get('test-message/user/{user}/room/{room}/message/{message}', function ($user, $room, $message) {
    Log::debug("Test message route called with user: {$user}, room: {$room}, message: {$message}");
    $chatMessage = ChatMessage::create([
        'chat_room_id' => $room,
        'user_id' => $user,
        'message' => $message,
    ]);
    event(new NewChatMessage($chatMessage));
    //broadcast(new NewChatMessage($chatMessage))->toOthers();
})->name('test-message');
