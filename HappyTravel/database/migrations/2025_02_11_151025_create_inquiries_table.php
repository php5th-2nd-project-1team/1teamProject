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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id('inquiry_id')->comment('문의 아이디');
            $table->unsignedBigInteger('user_id')->comment('유저 아이디');
            $table->string('inquiry_title', 50)->comment('문의 제목');
            $table->longText('inquiry_content')->comment('문의 내용');
            $table->tinyInteger('inquiry_secret')->comment('문의 비밀글 여부');
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
        Schema::dropIfExists('inquiries');
    }
};
