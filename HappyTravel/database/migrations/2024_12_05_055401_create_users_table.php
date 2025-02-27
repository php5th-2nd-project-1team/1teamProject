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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('account', 30)->unique();
            $table->string('password');
            $table->string('profile', 100)->default('/img/default.png');
            $table->string('name', 20);
            $table->string('nickname', 30);
            $table->char('gender', 1)->comment('0: 남자, 1: 여자');
            $table->string('address', 50);
            $table->string('detail_address', 100);
            $table->string('phone_number', 15)->comment('하이픈 포함 최대 15자리 까지 ex) 010-0000-0000');
            $table->string('refresh_token', 512)->nullable();
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
        Schema::dropIfExists('users');
    }
};
