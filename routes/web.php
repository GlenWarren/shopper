<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ShoppingListItemController;

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

Route::get('/shopping_lists', [ShoppingListController::class, 'index'])->name('shopping_lists.index');
Route::get('/shopping_list/{shopping_list}', [ShoppingListController::class, 'show'])->name('shopping_lists.show');
Route::get('/new_shopping_list', [ShoppingListController::class, 'create'])->name('shopping_lists.create');
Route::post('/shopping_list', [ShoppingListController::class, 'store'])->name('shopping_lists.store');
Route::get('/shopping_lists/{shopping_list}/edit', [ShoppingListController::class, 'edit'])->name('shopping_lists.edit');
Route::put('/shopping_list', [ShoppingListController::class, 'store'])->name('shopping_lists.update');

Route::post('/shopping_list_item', [ShoppingListItemController::class, 'store'])->name('shopping_lists_items.store');
Route::delete('/shopping_list_item/{shopping_list_item}', [ShoppingListItemController::class, 'destroy'])->name('shopping_list_items.destroy');
Route::post('/shopping_list_item/{shopping_list_item}/move_up', [ShoppingListItemController::class, 'moveUp'])->name('shopping_list_items.move_up');
Route::post('/shopping_list_item/{shopping_list_item}/move_down', [ShoppingListItemController::class, 'moveDown'])->name('shopping_list_items.move_down');
Route::post('/shopping_list_item/{shopping_list_item}/status', [ShoppingListItemController::class, 'toggleStatus'])->name('shopping_list_items.status');
