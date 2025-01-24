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
        Schema::table('community_comments', function(Blueprint $table){
            $table->foreign('community_id')->references('community_id')->on('community_boards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('community_comments', function(Blueprint $table){
            $table->dropForeign(['community_id']);
        }); 
    }
};
