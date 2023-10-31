<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Item;

class ShoppingListItem extends Model
{
    protected $fillable = [
        'shopping_list_id',
        'item_id',
        'position',
        'quantity',
        'status'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
