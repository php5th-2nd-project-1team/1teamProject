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
        Schema::table('post_facility_types', function(Blueprint $table){
            $table->foreign('facility_type_num')->references('facility_type_num')->on('facility_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_facility_types', function(Blueprint $table){
            $table->dropForeign(['facility_type_num']);
        });
    }
};
