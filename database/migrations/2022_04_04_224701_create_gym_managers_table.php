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
        Schema::create('gym_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->unique()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId("gym_id")->nullable()->references('id')->on('gyms');
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
        Schema::dropIfExists('gym_managers');
    }
};
