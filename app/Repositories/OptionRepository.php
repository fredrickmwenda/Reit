<?php
namespace App\Repositories;

use App\Models\Option;

class OptionRepository extends AbstractRepository
{
    private static $_inst;
    private static $_themeOption = [];

    /**
     * Get the singleton instance of OptionRepository.
     *
     * @return self
     */
    public static function inst()
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
    }

    /**
     * OptionRepository constructor.
     */
    public function __construct()
    {
        // Call parent constructor if needed, e.g., parent::__construct();
        $this->model = new Option();
    }

    /**
     * Get an option by key.
     *
     * @param string $key
     * @return mixed
     */
    public function getOption($key)
    {
        // Return the cached option if it exists
        if (isset(self::$_themeOption[$key])) {
            return self::$_themeOption[$key];
        }

        // Query the option from the database
        $option = $this->model->where('name', $key)->first();

        // Cache the option
        self::$_themeOption[$key] = $option;

        return $option;
    }
}
