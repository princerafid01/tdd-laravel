<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::post('/books', [BookController::class , 'store']);
Route::patch('/books/{book}', [BookController::class , 'update']);
Route::delete('/books/{book}', [BookController::class , 'destroy']);
