<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    use HasFactory;
    protected $fillable = [
        'transporter_name',
        'contact_person',
        'email',
        'phone',
        'tax_register_number',
        'address',
        'city',
        'state',
        'pin_code',
        'country',
        'created_by',

      ];


      public function transporter()
      {
          return $this->belongsTo(Booking::class);
      }


}
