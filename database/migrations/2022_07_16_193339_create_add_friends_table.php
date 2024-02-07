<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_friends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_requested');
            $table->unsignedInteger('accesptor');
            // $table->boolean('status');
            // $table->integer('accesptor');
            $table->timestamps();
            // $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // $table->foreignId('friend_id')->constrained('users')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_friends');
    }
}
