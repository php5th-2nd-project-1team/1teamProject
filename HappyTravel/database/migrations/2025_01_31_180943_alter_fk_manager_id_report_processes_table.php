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
        Schema::table('report_processes', function(Blueprint $table){
            $table->foreign('manager_id')->references('manager_id')->on('report_processes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_processes', function(Blueprint $table){
            $table->dropForeign(['manager_id']);
        }); 
    }
};
