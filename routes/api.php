<?php


use App\Http\Controllers\RocketChatController;
use Illuminate\Support\Facades\Route;

Route::post('/add-user', [RocketChatController::class, 'addUser']);
