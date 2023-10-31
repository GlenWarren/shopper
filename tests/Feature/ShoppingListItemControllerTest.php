<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\ShoppingList;
use App\Models\ShoppingListItem;
use App\Enums\ShoppingListItem\Status;

class ShoppingListItemControllerTest extends TestCase
{
    use RefreshDatabase;

    private $current_user;
    private $shopping_list;

    public function setUp(): void
    {
        parent::setUp();
        $this->current_user = new User(['id' => 1, 'first' => 'Bugs', 'last' => 'Bunny']);
        $this->current_user->save();
        $this->shopping_list = new ShoppingList(['user_id' => $this->current_user->id, 'name' => 'Big Tesco Shop', 'status' => 'active', 'limit' => null]);
        $this->shopping_list->save();
        foreach (['Bananas', 'Peaches', 'Sardines', 'Flour'] as $index => $item_name) {
            $item = new Item(['user_id' => $this->current_user->id, 'name' => $item_name]);
            $item->save();
            $shopping_list_item = new ShoppingListItem(['shopping_list_id' => $this->shopping_list->id, 'item_id' => $item->id, 'position' => $index + 1]);
            $shopping_list_item->save();
        }
    }

    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */
    public function testStore()
    {
        $data = [
            'name' => 'KitKat',
            'price' => 2.50,
            'quantity' => 3,
            'shopping_list_id' => $this->shopping_list->id
        ];
        $response = $this->post('/shopping-list-item', $data);

        $this->assertDatabaseHas('items', [
            'user_id' => $this->current_user->id,
            'name' => $data['name'],
            'price' => $data['price'],
            'favourite' => 0,
        ]);

        $new_item = Item::where('name', $data['name'])->first();
        $this->assertDatabaseHas('shopping_list_items', [
            'shopping_list_id' => $this->shopping_list->id,
            'item_id' => $new_item->id,
            'position' => $this->shopping_list->items()->count(),
            'quantity' => $data['quantity'],
            'status' => Status::ACTIVE,
        ]);

        $response->assertRedirect(route('shopping_lists.edit', ['shopping_list' => $this->shopping_list->id]));
        $response->assertSessionHas('success', 'Item added');
    }

    public function testDestroy()
    {
        $shopping_list_item = $this->shopping_list->items()->first();

        $response = $this->delete("/shopping-list-item/{$shopping_list_item->id}");

        // TODO: fix these two lines
        // $response->assertRedirect(route('shopping_lists.edit', ['shopping_list' => $this->shopping_list->id]));
        // $response->assertSessionHas('success', 'Shopping list item deleted');

        $this->assertDatabaseMissing('shopping_list_items', ['id' => $shopping_list_item->id]);
    }

    public function testMoveUp()
    {
        $shopping_list_item = ShoppingListItem::where('item_id', 2)->first();

        $response = $this->post("/shopping-list-item/{$shopping_list_item->id}/move-up");

        // TODO: fix this
        $this->assertEquals($shopping_list_item->position, 1, 'Position was not adjusted a expected');
    }

    public function testMoveDown()
    {
        $shopping_list_item = $this->shopping_list->items()->get()->first();

        $response = $this->post("/shopping-list-item/{$shopping_list_item->id}/move-down");

        // TODO: fix this
        $this->assertEquals($shopping_list_item->position, 2, 'Position was not adjusted a expected');
    }
}
