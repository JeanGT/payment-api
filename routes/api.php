<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/balance', [AccountController::class, 'getBalance']);
Route::post('/event', [EventController::class, 'handle']);
Route::post('/reset', [BankController::class, 'reset']);