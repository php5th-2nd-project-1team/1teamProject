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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('user_id');
            $table->char('report_category', 2)->nullable(false)->comment('01=>포스트, 02=>포스트 댓글, 03=>자유게시판, 04=>자유게시판 댓글, 05=>상품');
            $table->char('report_code', 2)->nullable(false)->comment('01=>욕설/비속어 포함, 02=>갈등 조장 및 허위사실 유포, 03=>폭력적 또는 혐오스러운 컨텐츠, 04=>도배 및 광고글, 05W=>기타');
            $table->char('report_status', 2)->nullable(false)->default('01')->comment('01=>처리전, 01=>처리중, 01=>처리완료');
            $table->string('report_url', 200)->nullable(false);
            $table->string('report_text', 200)->nullable();
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
        Schema::dropIfExists('reports');
    }
};
