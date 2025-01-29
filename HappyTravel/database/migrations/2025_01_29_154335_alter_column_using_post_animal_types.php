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
        Schema::table('post_animal_types', function (Blueprint $table) {
            $table->char('using', 1)->default('1')->comment('사용여부');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_animal_types', function(Blueprint $table){
            $table->dropColumn('using');
        });
    }
};
