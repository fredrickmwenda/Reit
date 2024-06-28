<?php
/**
 * Created by PhpStorm.
 * User: JreamOQ ( jreamoq@gmail.com )
 * Date: 11/25/20
 * Time: 17:31
 */

namespace App\Repositories;

use App\Models\Sale;
use App\Models\SaleAvailability;

class PropertyAvailabilityRepository extends AbstractRepository
{
    private static $_inst;

    public static function inst()
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
    }

    public function __construct()
    {
        $this->model = new SaleAvailability();
    }



    public function updateRentedData($object)
    {

            $check_exists = $this->model->query()
                ->where('post_id', $object['id'])
                ->first();

            $data = [
                'post_id' => $object['id'],
                'price' => $object['base_price'],
                'rented' => 1,
                'status' => 'available',
                'is_base' => 1
            ];

            if ($check_exists) {
                $check_exists->update([
                    'rented' => 1
                ]);
            } else {
                $this->model->query()->create($data);
            }
        
    }

    public function getListUnavailable($data)
    {
        
        if (!empty($dates)) {
            $date_str = implode(',', $dates);
        }

        $query = $this->model->query();
        $query->selectRaw("post_id, rented, status");
        $query->whereRaw("(status = 'unavailable' OR rented > 0)");

        $res = $query->get();

        if (!$res->isEmpty()) {
            $temp = [];
            foreach ($res as $k => $v) {
                if (!in_array($v['post_id'], $temp)) {
                    $temp[] = $v['post_id'];
                }
            }
            return $temp;
        } else {
            return '';
        }
    }

    public function checkAvailability($post_id)
    {
      
        $checkAvail = $this->model->where('post_id', $post_id)->where('status', 'unavailable') ->get();

        if (!$checkAvail->isEmpty()) {
            return false;
        } else {
            return true;
        }
    }

    public function insertOrUpdate($data)
    {
        $checkExitst = $this->model->where([
            'post_id' => $data['post_id']
        ])->get();

        if ($checkExitst->count() > 0) {
            $this->update($checkExitst[0]['id'], $data);
        } else {
            $this->create($data);
        }
    }

    public function getDataAvailability($post_id)
    {
        
        $data = $this->model->where('post_id', $post_id)->get();

        return $data;
    }

    public function getDataAvailabilityForCalendar($post_id)
    {
        $data = $this->model->where('post_id', $post_id)->get();

        return $data;
    }
}