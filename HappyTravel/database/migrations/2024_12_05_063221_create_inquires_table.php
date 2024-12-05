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
        Schema::create('inquires', function (Blueprint $table) {
            $table->id('inquire_id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->string('inquire_title', 50);
            $table->string('inquire_content', 200);
            $table->string('inquire_img', 255);
            $table->string('inquire_answer', 200);
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
        Schema::dropIfExists('inquires');
    }
};
