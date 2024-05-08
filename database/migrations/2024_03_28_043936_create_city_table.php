<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_city_id')->nullable()->constrained('cities');
            $table->foreignId('destination_city_id')->nullable()->constrained('cities');
            $table->foreignId('border_id')->constrained('borders');
            $table->text('route');
            $table->unsignedInteger('fare')->default(0);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
