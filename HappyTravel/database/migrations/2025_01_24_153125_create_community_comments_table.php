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
        Schema::create('community_comments', function (Blueprint $table) {
            $table->id('community_comment_id');
            $table->unsignedBigInteger('community_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('comment_content',300)->nullable(false);
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
        Schema::dropIfExists('community_comments');
    }
};
