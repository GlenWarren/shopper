<a href="{{ route('shopping_lists.index') }}" class="btn btn-primary">Home</a>
<h3>Shopping List</h3>
<p>{{ $shopping_list->name }}</p>
@foreach ($current_items as $current_item)
    <p>
        {{ $current_item->quantity }} x {{ $current_item->item->name }} | Price: {{ $current_item->item->price * $current_item->quantity }}
        <!-- TODO: display a dropdown menu with status options and a button to update status -->
        <!-- TODO: depending on status, list item should either be normal, in red, or crossed off -->
    </p>
@endforeach
<a href="{{ route('shopping_lists.edit', ['shopping_list' => $shopping_list->id]) }}" class="btn btn-primary">Edit Items</a>
