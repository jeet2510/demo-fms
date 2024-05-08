<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Border extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'border_name',
        'border_type',
        'border_charges',
        'created_by',

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

public function routes()
{
    return $this->belongsToMany(Route::class);
}

}
