<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\ShoppingList;
use App\Models\Item;

class User extends Model
{
    protected $fillable = [
        'first',
        'last',
    ];

    public function shoppingLists(): HasMany
    {
        return $this->hasMany(ShoppingList::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}
