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
        Schema::create('borders', function (Blueprint $table) {
            $table->id();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->string('border_name', 100); // Adjust length as needed
            $table->string('border_type', 50); // Adjust length as needed
            $table->unsignedInteger('border_charges')->default(0); // Assuming non-negative charges
            $table->integer('created_by')->nullable();
            $table->timestamps();

        });

        // Add foreign key constraint
        Schema::table('borders', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borders');
    }
};
