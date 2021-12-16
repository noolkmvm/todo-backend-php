<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersListsTable extends Migration
{
    public function up()
    {
        Schema::create('users_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('list_id')->references('id')->on('todo_lists')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_lists');
    }
}
