<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupPostTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_post_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('value');
            $table->timestamps();
            $table->foreignId('post_id')->constrained('group_posts')->cascadeOnDelete();
           // $table->foreignId('story_id')->constrained('stories')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_post_texts');
    }
}
