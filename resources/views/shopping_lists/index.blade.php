<p>Your Shopping Lists</p>

@foreach ($active_shopping_lists as $shopping_list)
    <p>Name: {{ $shopping_list->name }} <a href="{{ route('shopping_lists.show', ['shopping_list' => $shopping_list->id]) }}" class="btn btn-primary">View</a></p>
@endforeach

<a href="{{ route('shopping_lists.create') }}" class="btn btn-primary">Create a New Shopping List</a>