<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
             $table->bigIncrements('id');
            $table->integer('user_id_1');
            $table->integer('user_id_2')->nullable();
            $table->boolean('approved')->default(false);
            $table->timestamps();
            // $table->foreign('user_id_1')->references('id')
            // ->on('users') ->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('user_id_2')->references('id')
            // ->on('users') ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
}
