<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'driver_name',
        'email',
        'phone_number',
        'whatsapp_number',
        'address_1',
        'address_2',
        'country',
        'state',
        'city',
        'all_documents',
        'truck_type_id',
        'truck_number',
        'truck_expiry_date',
        'id_card_number',
        'id_card_expiry_date',
        'driving_license_number',
        'driving_license_expiry_date',
        'passport_number',
        'passport_expiry_date',
        'passport',
        'id_card',
        'driving_license',
        'truck_document',
        'created_by',
      ];

      public function truck_type()
      {
          return $this->belongsTo(Truck::class, 'truck_type_id');
      }

      public function bookings()
      {
          return $this->belongsToMany(Booking::class);
      }

}