<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id('password_resets_id');
            $table->string('email')->index();
            $table->string('token'); // 토큰 저장
            $table->timestamp('created_at')->nullable(); // 생성 시간 (만료 시간 계산)
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
