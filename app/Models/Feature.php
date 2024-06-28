<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HandlesRecurrence;

class Feature extends Model
{
    use HasFactory;
    use HandlesRecurrence;
    use SoftDeletes;

    protected $fillable = [
        'consumable',
        'name',
        'periodicity_type',
        'periodicity',
        'quota',
        'postpaid',
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class)
            ->using(FeaturePlan::class);
    }

    public function tickets()
    {
        return $this->hasMany(FeatureTicket::class);
    }
}

