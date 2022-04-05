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
       
        Schema::create('coaches_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->references('id')->on('coaches');
            $table->foreignId('session_id')->references('id')->on('training_sessions');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coaches_sessions');
    }
};
