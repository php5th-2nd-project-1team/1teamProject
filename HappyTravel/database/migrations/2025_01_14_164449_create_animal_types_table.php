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
        Schema::create('animal_types', function (Blueprint $table) {
            $table->id('animal_type_id');
            $table->string('animal_type_name', 10)->nullable(false)->comment('동물종류 이름');
            $table->char('animal_type_num', 2)->nullable(false)->unique()->comment("'01' => '소형견', '02' => '중형견', '03' => '대형견', '04' => '고양이, '05' => '조류'");
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
        Schema::dropIfExists('animal_types');
    }
};
