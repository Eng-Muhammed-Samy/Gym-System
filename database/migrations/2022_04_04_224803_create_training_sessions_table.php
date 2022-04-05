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
        if (!Schema::hasTable('training_sessions')) {
            Schema::create('training_sessions', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->date('session_date');
                $table->foreignId('gym_id')->references('id')->on('gyms')->onDelete('cascade');
                $table->foreignid('coach_id')->references('id')->on('coaches');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_sessions');
    }
};
