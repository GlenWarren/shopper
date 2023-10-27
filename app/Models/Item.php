<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'price',
        'favourite'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function shoppingList(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
}
