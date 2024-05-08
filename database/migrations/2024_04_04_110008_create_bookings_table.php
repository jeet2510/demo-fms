<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->nullable();
            $table->string('date');
            $table->integer('customer_id')->nullable();
            $table->integer('receiver_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('route_id')->nullable();
            $table->integer('buying_amount');
            $table->integer('border_charges');
            $table->integer('total_booking_amount');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
