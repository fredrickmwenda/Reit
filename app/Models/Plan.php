<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Models\Concerns\HandlesRecurrence;

class Plan extends Model
{
    use HasFactory;
    use HandlesRecurrence;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'grace_days',
        'name',
        'periodicity_type',
        'periodicity',
    ];

    public function features()
    {
        return $this->belongsToMany(Feature::class)
            ->using(FeaturePlan::class)
            ->withPivot(['charges']);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function calculateGraceDaysEnd(Carbon $recurrenceEnd)
    {
        return $recurrenceEnd->copy()->addDays($this->grace_days);
    }

    public function getHasGraceDaysAttribute()
    {
        return ! empty($this->grace_days);
    }

    public function prices()
    {
        return $this->hasOne(PlanPrice::class);
    }
}







