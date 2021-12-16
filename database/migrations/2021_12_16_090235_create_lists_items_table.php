<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListsItemsTable extends Migration
{
    public function up()
    {
        Schema::create('lists_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('todo_items')->cascadeOnDelete();
            $table->foreignId('list_id')->references('id')->on('todo_lists')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lists_items');
    }
}
