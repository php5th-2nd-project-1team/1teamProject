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
        Schema::create('community_boards', function (Blueprint $table) {
            $table->id('community_id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->char('community_type',1)->nullable(false)->default(0);
            $table->string('community_title',50)->nullable(false);
            $table->longText('community_content')->nullable(false);
            $table->bigInteger('community_view')->nullable(false)->default(0);       
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
        Schema::dropIfExists('community_boards');
    }
};
