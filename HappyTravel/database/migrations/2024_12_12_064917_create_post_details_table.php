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
        Schema::create('post_details', function (Blueprint $table) {
            $table->id('post_detail_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('manager_id');
            $table->string('post_detail_num', 20)->nullable(false);
            $table->string('post_detail_addr', 50)->nullable(false);
            $table->string('post_detail_time', 50)->nullable(false);
            $table->string('post_detail_site', 100)->nullable(true);
            $table->string('post_detail_price', 50)->nullable(false)->comment('상세 정보 포함 위해 varchar로 선택함 (아이 500원, 성인 1,000원 등)');
            $table->char('post_detail_parking', 1)->nullable(false)->comment('0 = false, 1 = true');
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
        Schema::dropIfExists('post_details');
    }
};
