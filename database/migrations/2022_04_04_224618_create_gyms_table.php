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
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
<<<<<<< Updated upstream
            // $table->unsignedBigInteger('gym_manager_id');
            $table->string('city');
            $table->foreignId('gym_manager_id')->references('id')->on('users');
=======
            $table->foreignId('city_id')->references('id')->on('cities');
            $table->foreignId('city_manager_id')->references('id')->on('city_managers');
>>>>>>> Stashed changes
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
        Schema::dropIfExists('gyms');
    }
};
