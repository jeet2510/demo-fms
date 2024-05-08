<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'booking_id',
        'driver_id',
        'semi_buying_amount',
        'semi_border_charges',
        'semi_total_booking_amount',
        'semi_waiting_amount',
        'paid_amount',
        'transaction_date',
        'payment_mode',
        'reference_no',
        'amount',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}