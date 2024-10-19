<?php


use App\Http\Controllers\RocketChatController;
use Illuminate\Support\Facades\Route;

Route::post('/add-user', [RocketChatController::class, 'addUser']);
Route::post('/add-group', [RocketChatController::class, 'addGroup']);
Route::post('/start-chat', [RocketChatController::class, 'startChat']);
