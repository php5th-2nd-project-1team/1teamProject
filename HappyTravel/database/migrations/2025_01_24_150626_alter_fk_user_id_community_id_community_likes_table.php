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
       Schema::table('community_likes', function(Blueprint $table){
            // 복합키 설정
            $table->primary(['user_id', 'community_id']);

            // 외래키 설정
            $table->foreign('user_id')->references('user_id')->on('users');

            // TODO : 외래키 설정 확인 바람. community_likes 자기 자신을 fk로 설정하려고 함.
            $table->foreign('community_id')->references('community_id')->on('community_boards');


       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_likes', function(Blueprint $table){
            $table->dropForeign(['user_id']);
            $table->dropForeing(['community_id']);
        });
    }
};
