<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gallery_comments', function (Blueprint $table) {
            $table->id('user_gallery_comment_id');
            $table->bigInteger('user_galleries_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('comment', 200);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_gallery_comments');
    }
};
