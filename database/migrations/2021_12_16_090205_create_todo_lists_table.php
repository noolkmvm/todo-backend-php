<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodoListsTable extends Migration
{
    public function up()
    {
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('description', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('todo_lists');
    }
}
