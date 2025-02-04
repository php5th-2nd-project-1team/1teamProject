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
        Schema::create('report_processes', function (Blueprint $table) {
            $table->id('report_process_id');
            $table->unsignedBigInteger('report_id');
            $table->unsignedBigInteger('manager_id');
            $table->char('report_result', 2)->nullable(false)->comment('01=>혐의없음, 02=>정지, 03=>영구정지');
            $table->string('report_reason', 200)->nullable(false);
            $table->dateTime('ban_at')->nullable();
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
        Schema::dropIfExists('report_processes');
    }
};
