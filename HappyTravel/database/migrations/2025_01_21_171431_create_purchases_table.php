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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id('purchase_id'); // 결제 고유 ID
            $table->unsignedBigInteger('user_id'); // 결제한 유저의 ID
            $table->unsignedBigInteger('class_id'); // 결제한 여행 클래스 ID
            $table->decimal('purchase_price', 10, 2); // 결제 금액
            $table->string('reservations_name');
            $table->string('contact'); // 연락처
            $table->integer('reservations_number'); // 참여 인원수
            $table->string('animal_type')->nullable(); // 동물 종류
            $table->text('notes')->nullable(); // 주의사항;
            $table->timestamp('purchase_date')->useCurrent(); // 결제 날짜, 현재 시간을 기본값으로 설정
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at 필드 (소프트 삭제)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
