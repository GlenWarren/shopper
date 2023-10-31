<a href="{{ route('shopping_lists.index') }}" class="btn btn-primary">Home</a>

<h2>Add Items to {{ $shopping_list->name }}</h2>
<h3>Add a new Item:</h3>
<form method="post" action="{{ route('shopping_lists_items.store') }}">
    @csrf

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="price">Price:</label>
        <input value=0.00 type="text" class="form-control" id="price" name="price" required>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input value=1 type="number" class="form-control" id="quantity" name="quantity" required>
    </div>

    <input type="hidden" name="shopping_list_id" value="{{ $shopping_list->id }}">

    <button type="submit" class="btn btn-primary">Add Item</button>
</form>

<p>Shopping List: {{ $current_items->count() }} items</p>
@foreach ($current_items as $current_item)
    <p>
        {{ $current_item->quantity }} x {{ $current_item->item->name }} | Price: {{ $current_item->item->price * $current_item->quantity }}
        
        <form method="POST" action="{{ route('shopping_list_items.destroy', ['shopping_list_item' => $current_item->id, 'shopping_list_id' => $shopping_list->id]) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link text-danger">Remove</button>
        </form>
        
        <form method="POST" action="{{ route('shopping_list_items.move_up', ['shopping_list_item' => $current_item->id, 'shopping_list_id' => $shopping_list->id]) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link text-danger">Move Up</button>
        </form>
        
        <form method="POST" action="{{ route('shopping_list_items.move_down', ['shopping_list_item' => $current_item->id, 'shopping_list_id' => $shopping_list->id]) }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-link text-danger">Move Down</button>
        </form>
    </p>
@endforeach

<a href="{{ route('shopping_lists.show', ['shopping_list' => $shopping_list->id]) }}" class="btn btn-primary">FINISH</a>

<!-- TODO: Enable editing of Shopping name, limit and status -->

<!-- <h2>Edit {{ $shopping_list->name }} Details</h2>
<form method="put" action="{{ route('shopping_lists.update', ['shopping_list' => $shopping_list->id]) }}">
    @csrf

    <div class="form-group">
        <label for="name">Name:</label>
        <input value="{{ $shopping_list->name }}" type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="limit">Limit:</label>
        <input value="{{ $shopping_list->limit }}" type="text" class="form-control" id="limit" name="limit" placeholder="Optional">
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select class="form-control" id="status" name="status" required>
            <option value="{{ \App\Enums\ShoppingList\Status::ACTIVE }}">Active</option>
            <option value="{{ \App\Enums\ShoppingList\Status::ARCHIVED }}">Archived</option>
            <option value="{{ \App\Enums\ShoppingList\Status::COMPLETE }}">Complete</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Details</button>
</form> -->
