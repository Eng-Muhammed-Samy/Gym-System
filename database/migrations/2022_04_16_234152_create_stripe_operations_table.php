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
        Schema::create('stripe_operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("gym_member_id")->references('id')->on('users')->onDelete('cascade');
            $table->foreignId("package_id")->references('id')->on('packages')->onDelete('cascade');
            $table->foreignId("gym_id")->references('id')->on('gyms')->onDelete('cascade');
            $table->decimal('paid_amount', 8, 2);
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
        Schema::dropIfExists('stripe_operations');
    }
};
