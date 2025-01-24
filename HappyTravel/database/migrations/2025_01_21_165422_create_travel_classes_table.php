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
        Schema::create('travel_classes', function (Blueprint $table) {
            $table->id('class_id');
            $table->unsignedBigInteger('user_id');
            $table->string('class_title');
            $table->longText('class_content');
            $table->decimal('class_price', 10, 2); // DECIMAL(10, 2) for class_price
            $table->string('class_title_img', 255);
            $table->string('location', 255);
            $table->timestamp('class_date');
            $table->timestamps(0); // CURRENT_TIMESTAMP()
            $table->softDeletes(); // deleted_at column
    
            // // 외래 키 설정 (user_id2가 users 테이블을 참조한다고 가정)
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_classes');
    }
};
