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
        Schema::create('facility_types', function (Blueprint $table) {
            $table->id('facility_type_id');
            $table->string('facility_type_name', 20)->nullable(false)->comment('시설종류 이름');
            $table->char('facility_type_num', 2)->nullable(false)->unique()->comment("'01' => '펫메뉴', '02' => '드라이룸', '03' => '애견수영장', '04' => '애견놀이터, '05' => '잔디마당'");
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
        Schema::dropIfExists('facility_types');
    }
};
