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
        Schema::table('community_photos', function(Blueprint $table){
            $table->foreign('user_id')->references('user_id')->on('community_photos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_photos', function(Blueprint $table){
            $table->dropForeign(['user_id']);
        }); 
    }
};
