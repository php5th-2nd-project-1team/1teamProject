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
            $table->char('report_result', 2)->nullable(false)->default('01')->comment('01=>처리전, 01=>처리중, 01=>처리완료');
            $table->timestamp('ban_at')->nullable();
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
