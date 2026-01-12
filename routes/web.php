<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});


//Get Chat ID

// Route::get("/get-updates", function () {
//     $updates = Telegram::getUpdates();
//     return $updates;
// });


// Route::get('/send-message', function () {

//     $chatId = env('TELEGRAM_CHAT_ID');
//     $message = 'Hello, this is a message from Laravel!';

//     Telegram::sendMessage([
//         'chat_id' => $chatId,
//         'text' => $message,
//     ]);

//     return 'Message sent to Telegram!';
// });
