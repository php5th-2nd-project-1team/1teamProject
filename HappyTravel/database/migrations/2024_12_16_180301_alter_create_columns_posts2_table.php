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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('post_detail_num', 20)->nullable(true);
            $table->string('post_detail_addr', 50)->nullable(false);
            $table->string('post_detail_time', 50)->nullable(false);
            $table->string('post_detail_site', 500)->nullable(true);
            $table->string('post_detail_price', 50)->nullable(false);
            $table->char('post_detail_parking', 1)->nullable(false)->comment('0 : 불가능, 1: 가능');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('post_detail_num');
            $table->dropColumn('post_detail_addr');
            $table->dropColumn('post_detail_time');
            $table->dropColumn('post_detail_price');
            $table->dropColumn('post_detail_site');
            $table->dropColumn('post_detail_parking');
        });
    }
};
