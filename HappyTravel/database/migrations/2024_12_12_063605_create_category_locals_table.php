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
        Schema::create('category_locals', function (Blueprint $table) {
            $table->id('category_local_id');
            $table->string('category_local_name', 10)->nullable(false)->comment('지역 이름');
            $table->char('category_local_num', 2)->nullable(false)->unique()->comment("'01' => '서울', '02' => '경기도', '03' => '강원도', '04' => '인천, '05' => '세종', '06' => '대전', '07' => '충청북도', '08' => '충청남도', '09' => 경상북도', '10' => '경상남도', '11' => '전라북도', '12' => '전라남도', '13' => '제주'");
            $table->string('category_local_img', 255)->nullable(false);
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
        Schema::dropIfExists('category_locals');
    }
};
