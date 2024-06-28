<?php

/**
 * Created by PhpStorm.
 * User: JreamOQ ( jreamoq@gmail.com )
 * Date: 11/25/20
 * Time: 17:31
 */

namespace App\Repositories;

use App\Models\Rent;


class RentRepository extends AbstractRepository
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
        $this->model = new Rent();
    }

    public function getRents($data)
    {
        $query = $this->model->query();

        // Filter by property name if provided
        if (isset($data['property_name'])) {
            $query->where('property_name', 'like', '%' . $data['property_name'] . '%');
        }

        // Filter by description if provided
        if (isset($data['description'])) {
            $query->where('description', 'like', '%' . $data['description'] . '%');
        }

        // Filter by price range if provided
        if (isset($data['min_price'])) {
            $query->where('price', '>=', $data['min_price']);
        }

        if (isset($data['max_price'])) {
            $query->where('price', '<=', $data['max_price']);
        }

        // Filter by availability
        if (isset($data['available'])) {
            $query->where('available', $data['available']);
        }

        // Additional criteria can be added based on your requirements

        return $query->where('status', 'publish')->get();
    }



    public function getRentsAvailable($data)
    {
        $query = $this->model->query();

        // Your existing filters...

        // Filter by availability (available = true)
        $query->where('available', true);

        return $query->get();
    }



    public function getRentsUnavailable($data)
    {
        $query = $this->model->query();

        // Your existing filters...

        // Filter by availability (available = false)
        $query->where('available', false);

        return $query->get();
    }
}
