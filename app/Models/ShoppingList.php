<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Enums\ShoppingList\Status;

class ShoppingList extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'limit'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShoppingListItem::class)->orderBy('position');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', Status::ACTIVE);
    }
}
