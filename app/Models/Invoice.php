<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'date',
        'customer_id',
        'receiver_id',
        'driver_id',
        'route_id',
        'buying_amount',
        'border_charges',
        'waiting_amount',
        'hand_over',
        'seprate_border_charge',
        'border_receipt',
        'semi_waiting_amount',
        'total_booking_amount',
        'semi_buying_amount',
        'semi_border_charges',
        'upload_document',
        'semi_total_booking_amount',
        'created_by',
      ];

      public function booking()
      {
          return $this->belongsTo(Booking::class,'booking_id', 'booking_id');
      }
      public function customer()
      {
          return $this->belongsTo(Customer::class);
      }
public function transporter()
      {
          return $this->belongsTo(Transporter::class);
      }
public function receiver()
      {
          return $this->belongsTo(Client::class);
      }

      public function route()
      {
          return $this->belongsTo(Route::class);
      }

      public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }


      public function getDriverCount()
      {
          $driverIds = explode(',', $this->driver_id);
          return count($driverIds);
      }

      public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function document()
    {
        return $this->hasMany(Document::class, 'booking_id', 'booking_id');
    }

    public function transations()
    {
        return $this->hasMany(Transaction::class, 'booking_id', 'booking_id');
    }
}
