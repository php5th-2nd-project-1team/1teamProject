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
        Schema::table('post_animal_types', function(Blueprint $table){
            $table->foreign('animal_type_num')->references('animal_type_num')->on('animal_types');
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
            $table->dropForeign(['animal_type_num']);
        });
    }
};
