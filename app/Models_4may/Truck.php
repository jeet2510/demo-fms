<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;
    protected $fillable = [
        'truck_type',
        'number',
        'capacity',
        'created_by',
      ];


      // Truck.php

public function driver()
{
    return $this->belongsTo(Driver::class);
}

}
