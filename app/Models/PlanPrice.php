<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPrice extends Model
{
    use HasFactory;

    protected $table = 'plan_prices';


    protected $guarded = [];

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
}
