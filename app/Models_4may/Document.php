<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'created_by',
        'hand_over',
        'border_receipt',
        'booking_document',
      ];
}
