@foreach ($active_shopping_lists as $shopping_list)
    <p>Name: {{ $shopping_list->name }}, Created: {{ $shopping_list->created_at }}</p>
@endforeach