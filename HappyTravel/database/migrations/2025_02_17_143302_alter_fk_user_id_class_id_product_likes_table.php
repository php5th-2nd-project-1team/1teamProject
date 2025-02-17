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
        Schema::table('product_likes', function(Blueprint $table){
            // 외래 키 설정
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('class_id')->references('class_id')->on('travel_classes');

            // 복합키 설정
            $table->primary(['user_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_likes', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeign(['class_id']);
        });
    }
};
