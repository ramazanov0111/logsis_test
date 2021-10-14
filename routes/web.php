<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class,'index'])->name('index');
Route::post('/authors', [MainController::class,'getAuthors'])->name('authors');
Route::post('/books', [MainController::class,'getBooks'])->name('books');
Route::post('/book', [MainController::class,'getUsersTask']);
