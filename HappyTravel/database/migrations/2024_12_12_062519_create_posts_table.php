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
            $table->unsignedBigInteger('manager_id')->nullable(false);
            $table->char('category_local_num', 2)->nullable(false);
            $table->char('category_theme_num', 2)->nullable(false);
            $table->string('post_local_name', 10)->nullable(false)->comment('지역 이름. 예) 인천 강화군');
            $table->string('post_title', 50)->nullable(false);
            $table->string('post_content', 50)->nullable(false)->comment('상단 내용 ex) 강화도 방직공장을 개조한 레트로 감성카페');
            $table->longText('post_detail_content')->nullable(false);
            $table->string('post_img', 200)->nullable(false);
            $table->integer('post_like')->nullable(false)->default(0);
            $table->bigInteger('post_view')->nullable(false)->default(0);
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
