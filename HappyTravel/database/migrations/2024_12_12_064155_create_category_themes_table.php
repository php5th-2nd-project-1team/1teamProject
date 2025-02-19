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
        Schema::create('category_themes', function (Blueprint $table) {
            $table->id('category_theme_id');
            $table->string('category_theme_name', 5)->nullable(false)->comment('테마 이름');
            $table->char('category_theme_num', 2)->nullable(false)->unique()->comment("'01' => 숙소, '02' => 식&음료,  '03' => 관광지,  '04' => 병원");
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
        Schema::dropIfExists('category_themes');
    }
};
