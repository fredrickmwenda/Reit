<?php

namespace App\Models;

use App\Models\Concerns\Expires;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureTicket extends Model
{
    use HasFactory;
    use Expires;

    protected $fillable = [
        'charges',
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
