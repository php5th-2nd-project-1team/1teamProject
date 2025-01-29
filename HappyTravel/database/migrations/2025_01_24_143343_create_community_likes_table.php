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
        Schema::create('community_likes', function (Blueprint $table) {

            // 복합키 설정
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('community_id')->nullable(false);

            $table->char('community_likes_flg',1) ->nullable(false)->default('0');
            
            // // 중복 좋아요 방지 // TODO : unique 속성 주는 것은 컬럼 추가할 때 같이 추가하거나, 별도로 migration 파일을 만들어서 줘야 함. 
            // 안그러면 키가 없다고 오류 뜸
            // $table->unique(['user_id, community_id']);

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
        Schema::dropIfExists('community_likes');
    }
};
