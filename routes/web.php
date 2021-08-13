<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookStoreController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::any('/add-author', [BookStoreController::class, 'addAuthor']);
Route::any('/add-publication', [BookStoreController::class, 'addPublication']);
Route::any('/add-book', [BookStoreController::class, 'addBook']);
Route::any('/crud-author', [BookStoreController::class, 'crudAuthor']);
Route::any('/crud-publication', [BookStoreController::class, 'crudPublication']);
Route::any('/crud-book', [BookStoreController::class, 'crudBooks']);
Route::any('/view-author', [BookStoreController::class, 'viewAuthor']);
Route::any('/view-book', [BookStoreController::class, 'viewBook']);

