<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ShoppingList;
use App\Enums\ShoppingList\Status;

class ShoppingListController extends Controller
{
    public function index()
    {
        // TODO: A user should be logging-in instead
        $current_user = User::find(1);
        if (is_null($current_user)) {
            $current_user = new User;
            $current_user->first = 'Daffy';
            $current_user->last = 'Duck';
            $current_user->save();
        }

        $active_shopping_lists = $current_user->shoppingLists()->active()->get();

        return view('shopping_lists.index', ['active_shopping_lists' => $active_shopping_lists]);
    }

    public function show(int $id)
    {
        $shopping_list = ShoppingList::find($id);
        $current_items = $shopping_list->items()->get();

        // TODO: calculate total price to display to user

        return view('shopping_lists.show', ['shopping_list' => $shopping_list, 'current_items' => $current_items]);
    }

    public function create()
    {
        $shopping_list = new ShoppingList;

        return view('shopping_lists.create', ['shopping_list' => $shopping_list]);
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'limit' => 'nullable|numeric',
        ]);

        $shopping_list = new ShoppingList;

        $shopping_list->user_id = 1; // TODO: use the current user instead: auth()->user()->id;
        $shopping_list->name = $validated_data['name'];
        $shopping_list->limit = $validated_data['limit'];
        $shopping_list->status = Status::ACTIVE;
        $shopping_list->save();

        return redirect()->route('shopping_lists.edit', ['shopping_list' => $shopping_list->id])->with('success', 'Shopping list created');
    }

    public function edit(int $id)
    {
        $shopping_list = ShoppingList::find($id);
        $current_items = $shopping_list->items()->get();

        // TODO: enable user to select favourites or from stored items

        // TODO: calculate total price to display to user

        return view('shopping_lists.edit', ['shopping_list' => $shopping_list, 'current_items' => $current_items]);
    }

    public function update(Request $request)
    {
        // TODO: enable update of shopping list name and limit
    }

    public function destroy(int $id)
    {
        $shopping_list = ShoppingList::find($id);

        // TODO: delete shopping list items

        $shopping_list->delete();

        return redirect()->route('shopping_lists.index')->with('success', 'Shopping list deleted');
    }
}
