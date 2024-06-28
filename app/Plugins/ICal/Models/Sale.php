<?php

namespace App\Plugins\ICal\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    protected $table = 'property';

    /**
     * @return Collection
     */
    public function getIcalsData(){
        return $this->whereNotNull('ical')->where('status', 'publish')->get();
    }
}
