<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\Expires;

class FeatureConsumption extends Model
{
    use HasFactory;
    use Expires;
   

    protected $fillable = [
        'consumption',
        'expired_at',
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function subscriber()
    {
        return $this->morphTo('subscriber');
    }
}
