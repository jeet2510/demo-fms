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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('Whatsapp_number');
            $table->text('address_1'); //  the first line of the driver's address
            $table->text('address_2'); //  the second line of the driver's address
            $table->string('country'); //  the country of the driver
            $table->string('state'); //  the state of the driver
            $table->string('city'); //  the city of the driver
            $table->integer('truck_type_id')->nullable(); //  the ID of the truck type, nullable
            $table->string('truck_number'); //  the number of the truck assigned to the driver
            $table->string('truck_expiry_date'); //  the expiry date of the truck
            $table->string('id_card_number'); //  the ID card number of the driver
            $table->string('id_card_expiry_date'); //  the expiry date of the ID card
            $table->string('driving_license_number'); //  the driving license number of the driver
            $table->string('driving_license_expiry_date'); //  the expiry date of the driving license
            $table->string('passport_number'); //  the passport number of the driver
            $table->string('passport_expiry_date'); //  the expiry date of the passport
            $table->string('passport'); //  the file path of the passport image
            $table->string('id_card'); //  the file path of the ID card image
            $table->string('driving_license'); //  the file path of the driving license image
            $table->string('truck_document'); //  the file path of the truck document
            $table->integer('created_by')->nullable(); //  the ID of the user who created the record, nullable
            $table->timestamps(); // Automatically manages 'created_at' and 'updated_at' timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
