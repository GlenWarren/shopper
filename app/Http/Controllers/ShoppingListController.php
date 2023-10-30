<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShoppingList;

class ShoppingListController extends Controller
{
    public function index()
    {
        // TODO: A user should be logging-in instead
        $current_user = User::find(1);

        $active_shopping_lists = $current_user->shoppingLists()->active()->get();
        return view('shopping_lists.index', ['active_shopping_lists' => $active_shopping_lists]);
    }

    public function show(int $id)
    {
        $shopping_list = ShoppingList::find($id);
        return view('shopping_lists.show', ['shopping_list' => $shopping_list]);
    }

    public function create()
    {
        $shopping_list = new ShoppingList;
        return view('shopping_lists.create', ['shopping_list' => $shopping_list]);
    }

    public function store(Request $request)
    {

    }

    public function edit(int $id)
    {
        $shopping_list = ShoppingList::find($id);
        return view('shopping_lists.edit', ['shopping_list' => $shopping_list]);
    }

    public function update(Request $request)
    {

    }

    public function destroy(int $id)
    {
        $shopping_list = ShoppingList::find($id);
        // TODO: now delete it

        
        // $active_shopping_lists = $current_user->shoppingLists()->active()->get();
        // return view('shopping_lists.index', ['active_shopping_lists' => $active_shopping_lists]);
    }
}
