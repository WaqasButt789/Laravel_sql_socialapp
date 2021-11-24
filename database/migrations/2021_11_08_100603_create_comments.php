<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id('cid');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('p_id')->unsigned();
            $table->string('file');
            $table->string('comment');
            $table->timestamps();
            $table->foreign('user_id')->references('uid')->on('users');
            $table->foreign('p_id')->references('pid')->on('posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
