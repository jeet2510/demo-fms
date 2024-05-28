<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [

        'destination_city_id',
        'origin_city_id',
        'created_by',
        'border_id',
        'route',
        'fare',

    ];

    // Route.php
    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function originCountry()
    {
        //origin_city_id has been che is field name for original country
        return $this->belongsTo(Country::class, 'origin_city_id');
    }

    public function destinationCountry()
    {
        //destination_city_id has been che is field name for destination country
        return $this->belongsTo(Country::class, 'destination_city_id');
    }


//    public function borders()
//    {
//        return $this->belongsToMany(Border::class);
//    }

public function border()
    {
        return $this->belongsTo(Border::class, 'border_id');
    }


    // Route model
// public function borders()
// {
//     return $this->belongsToMany(Border::class);
// }

public function border_charges()
   {
       $border_ids = $this->border_id;
       $border_ids = explode(',', $border_ids);
       $border_charges = 0;

       if($border_ids) {
           foreach ($border_ids as $border_id) {
               $border = Border::find($border_id);
               $border_charges += $border->border_charges ?? 0;
           }
       }
       return $border_charges;
   }

//    public function borders()
//    {
//        return $this->hasMany(Border::class);
//    }

}