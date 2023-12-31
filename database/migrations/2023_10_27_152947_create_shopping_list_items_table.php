<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ShoppingListItem\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shopping_list_id');
            $table->foreignId('item_id');
            $table->unsignedInteger('position');
            $table->unsignedInteger('quantity')->default(1);
            $table->enum('status', [Status::ACTIVE, Status::INCOMPLETE, Status::COMPLETE])->default(Status::ACTIVE);
            $table->timestamps();
            $table->unique(['shopping_list_id','item_id'], 'shopping_list_item_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_list_items');
    }
};
