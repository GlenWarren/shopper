<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ShoppingListItem extends Model
{
    protected $fillable = [
        'shopping_list_id',
        'item_id',
        'position',
        'quantity',
        'status'
    ];

    // TODO: add constraints for position and quantity columns

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
}
