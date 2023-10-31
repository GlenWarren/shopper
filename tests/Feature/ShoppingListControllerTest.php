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
use App\Enums\ShoppingList\Status as ShoppingListStatus;

class ShoppingListControllerTest extends TestCase
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
        foreach (['Bananas', 'Peaches', 'Sardines'] as $index => $item_name) {
            $item = new Item(['user_id' => $this->current_user->id, 'name' => $item_name]);
            $item->save();
            $shopping_list_item = new ShoppingListItem(['shopping_list_id' => $this->shopping_list->id, 'item_id' => $item->id, 'position' => $index + 1]);
            $shopping_list_item->save();
        }
    }

    public function testIndex()
    {
        $response = $this->get("/shopping-lists");
        $response->assertStatus(200)
            ->assertViewIs('shopping_lists.index')
            ->assertViewHas('active_shopping_lists', new Collection([$this->shopping_list]));
    }

    public function testShow()
    {
        $response = $this->get("/shopping-list/{$this->shopping_list->id}");
        $response->assertStatus(200)
            ->assertViewIs('shopping_lists.show')
            ->assertViewHas('shopping_list', $this->shopping_list)
            ->assertViewHas('current_items', $this->shopping_list->items()->get());
    }

    public function testCreate()
    {
        $response = $this->get("/new-shopping-list");
        $response->assertStatus(200)
            ->assertViewIs('shopping_lists.create')
            ->assertViewHas('shopping_list', new ShoppingList);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testStore()
    {
        // TODO: also test behaviour when request data fails validation
        $data = [
            'name' => 'Test Shopping List',
            'limit' => 35,
        ];
        $response = $this->post('/shopping-list', $data);

        $this->assertDatabaseHas('shopping_lists', [
            'user_id' => $this->current_user->id,
            'name' => $data['name'],
            'limit' => $data['limit'],
            'status' => ShoppingListStatus::ACTIVE,
        ]);

        $new_shopping_list = ShoppingList::where('name', $data['name'])->first();
        $response->assertRedirect(route('shopping_lists.edit', ['shopping_list' => $new_shopping_list->id]));
        $response->assertSessionHas('success', 'Shopping list created');
    }

    public function testEdit()
    {
        $response = $this->get("/shopping-lists/{$this->shopping_list->id}/edit");
        $response->assertStatus(200)
            ->assertViewIs('shopping_lists.edit')
            ->assertViewHas('shopping_list', $this->shopping_list)
            ->assertViewHas('current_items', $this->shopping_list->items()->get());
    }
}
