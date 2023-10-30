<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shopping_lists', [ShoppingListController::class, 'index']);
Route::get('/shopping_list', [ShoppingListController::class, 'show']);
Route::get('/create_shopping_list', [ShoppingListController::class, 'create']);
Route::post('/shopping_list', [ShoppingListController::class, 'store']);
