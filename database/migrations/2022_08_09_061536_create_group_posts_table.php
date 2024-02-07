<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id');
            // $table->integer('user_id')->unsigned();
            // $table->integer('group_id')->default('0')->unsigned();
             $table->timestamps();
            // $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
             // $table->foreign('group_id')->on('groups')->references('id')->onDelete('cascade');
             // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //  $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
             $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_posts');
    }
}
