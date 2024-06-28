<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentAvailability extends Model
{
    use HasFactory;
    protected $table = 'gmz_rent_availability';

    protected $fillable = ['post_id', 'check_in', 'check_out', 'price', 'booked', 'status', 'is_base'];
}
