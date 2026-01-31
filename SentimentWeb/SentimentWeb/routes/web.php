<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SentimentController;

Route::get('/', [SentimentController::class, 'index'])->name('home');
Route::post('/analyze', [SentimentController::class, 'analyze'])->name('analyze');