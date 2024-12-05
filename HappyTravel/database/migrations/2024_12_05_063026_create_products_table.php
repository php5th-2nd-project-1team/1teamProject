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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->bigInteger('user_id')->unsigned();
            $table->char('product_category', 1);
            $table->string('product_img', 255);
            $table->string('product_content', 200);
            $table->string('product_title', 50);
            $table->string('product_price', 20);
            $table->timestamp('price_at');
            $table->timestamp('booking_at')->nullable();
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
        Schema::dropIfExists('products');
    }
};
