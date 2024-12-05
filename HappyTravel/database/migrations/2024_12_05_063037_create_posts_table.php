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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('post_id');
            $table->bigInteger('manager_id')->unsigned();
            $table->char('category_local_num', 2);
            $table->char('category_theme_num', 2);
            $table->string('post_content', 200);
            $table->string('post_title', 50);
            $table->string('post_img', 255);
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
        Schema::dropIfExists('posts');
    }
};
