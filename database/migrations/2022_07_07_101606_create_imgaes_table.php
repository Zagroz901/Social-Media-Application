<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImgaesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imgaes', function (Blueprint $table) {
            $table->increments('id');
           // $table->integer('post_id')->unsigned();
            $table->longText('value_img');
            $table->timestamps();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imgaes');
    }
}
