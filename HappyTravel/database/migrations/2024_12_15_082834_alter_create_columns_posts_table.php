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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('post_subimg1', 255)->nullable(false);
            $table->string('post_subimg2', 255)->nullable(false);
            $table->string('post_subimg3', 255)->nullable(false);
            $table->double('post_lat')->nullable(false)->comment('위도');
            $table->double('post_lon')->nullable(false)->comment('경도');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('post_subimg1');
            $table->dropColumn('post_subimg2');
            $table->dropColumn('post_subimg3');
            $table->dropColumn('post_lat');
            $table->dropColumn('post_lon');
        });
    }
};
