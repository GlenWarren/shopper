<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use App\Enums\ShoppingListItem\Status;

class ShoppingListItemController extends Controller
{
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'quantity' => 'integer',
        ]);

        $item = new Item;
        $item->user_id = 1; // TODO: use auth()->user()->id instead
        $item->name = $validated_data['name'];
        $item->price = $validated_data['price'];
        $item->favourite = 0;
        $item->save();

        $shopping_list_id = $request->input('shopping_list_id');
        $positions = ShoppingList::find($shopping_list_id)->items()->pluck('position')->all();

        $shopping_list_item = new ShoppingListItem;
        $shopping_list_item->shopping_list_id = $shopping_list_id;
        $shopping_list_item->item_id = $item->id;
        $shopping_list_item->quantity = $validated_data['quantity'];
        $shopping_list_item->status = Status::ACTIVE;
        $shopping_list_item->position = empty($positions) ? 1 : max($positions) + 1;
        $shopping_list_item->save();

        return redirect()->route('shopping_lists.edit', ['shopping_list' => $shopping_list_id])->with('success', 'Item added');
    }

    public function toggleStatus(Request $request, int $id)
    {
        // TODO: amend the status of the item (enable user to cross an item off the list)
    }

    public function destroy(Request $request, int $id)
    {
        $shopping_list_item = ShoppingListItem::find($id);
        $shopping_list_item->delete();

        return redirect()->route('shopping_lists.edit', ['shopping_list' => $request->query('shopping_list_id')])->with('success', 'Shopping list item deleted');
    }

    public function moveUp(Request $request, int $id)
    {
        return $this->moveItem(request: $request, id: $id, direction: 'up');
    }

    public function moveDown(Request $request, int $id)
    {
        return $this->moveItem(request: $request, id: $id, direction: 'down');
    }

    private function moveItem(Request $request, int $id, string $direction)
    {
        $shopping_list_id = $request->query('shopping_list_id');
        $positions_map = ShoppingList::find($shopping_list_id)->items()->pluck('position', 'id')->all();
        
        /* Only move item if there is more than one item in the shopping list */
        if (count($positions_map) > 1) {
            $ordered_ids = array_keys($positions_map);
            $index = array_search($id, $ordered_ids);
            $new_index = $direction === 'up' ? $index - 1 : $index + 1;

            /* If the new index is not set, then the item cannot be moved */
            if (isset($ordered_ids[$new_index])) {
                $id_to_swap_with = $ordered_ids[$new_index];

                $old_position = $positions_map[$ordered_ids[$index]];
                $new_position = $positions_map[$id_to_swap_with];
                
                // TODO: refactor these queries and saves into one update query
                $shopping_list_item = ShoppingListItem::find($id);
                $shopping_list_item->position = $new_position;
                $shopping_list_item->save();

                $shopping_list_item_to_swap_with = ShoppingListItem::find($id_to_swap_with);
                $shopping_list_item_to_swap_with->position = $old_position;
                $shopping_list_item_to_swap_with->save();
            }
        }

        return redirect()->route('shopping_lists.edit', ['shopping_list' => $shopping_list_id])->with('success', 'Shopping list item moved');
    }
}
