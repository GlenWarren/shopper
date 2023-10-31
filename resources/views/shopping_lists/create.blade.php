<a href="{{ route('shopping_lists.index') }}" class="btn btn-primary">Home</a>
<h2>Create a New Shopping List</h2>
<form method="post" action="{{ route('shopping_lists.store') }}">
    @csrf

    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group">
        <label for="limit">Limit:</label>
        <input type="text" class="form-control" id="limit" name="limit" placeholder="Optional">
    </div>

    <button type="submit" class="btn btn-primary">Start Shopping List</button>
</form>
