<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function city()
    {
        return $this->hasMany(City::class);
    }
}
