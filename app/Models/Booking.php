<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'date',
        'customer_id',
        'receiver_id',
        'transporter_id',
		'driver_id',
        'route_id',
        'buying_amount',
        'origin_city',
        'destination_city',
        'border_charges',
        'seprate_border_charge',
        'total_booking_amount',
        'semi_buying_amount',
        'semi_border_charges',
        'upload_document',
        'semi_total_booking_amount',
        'created_by',
    ];

        public function invoice()
        {
            return $this->hasOne(Invoice::class, 'booking_id', 'booking_id');
        }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
 public function transporter()
    {
        return $this->belongsTo(Transporter::class, 'transporter_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class , 'receiver_id', 'id');
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

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function transporterRelationship()
    {
        return $this->belongsTo(Transporter::class);
    }

    public function countDistinctDrivers()
    {
        $driverIds = explode(',', $this->driver_id);
        return count(array_unique($driverIds));
    }

    public function getCityDetail($id)
    {
        return City::where('id', $id)->first();
    }

    public function getCountryByCity($id)
    {
        return Country::where('id', $id)->first();
    }

//     public function transactions()
// {
//     return $this->hasMany(Transaction::class);
// }

}