<?php

namespace App\Plugins\ICal\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SaleAvailability extends Model
{
    protected $table = 'apartment_availability';
    protected $guarded = [];

    protected $fillable = [
        'post_id', 
        'price', 'rented', 
        'status', 
        'is_base'];

    public function getItem($postID){
        $data = $this->where('post_id', $postID)
            ->first();
        return $data;
    }

    /**
     * @param $id
     * @param $from
     * @param $hotelID
     * @return Collection
     */
    public function getUnavailableData($id)
    {
        $data = $this->where('post_id', $id)
            ->whereRaw('(status = "unavailable" OR rented = 1)')
            ->get();
        return $data;
    }
}
