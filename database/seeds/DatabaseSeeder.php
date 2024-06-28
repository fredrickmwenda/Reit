<?php

use Database\Seeders\FeatureSeeder;
use Database\Seeders\PlanSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   /**
    * Seed the application's database.
    *
    * @return void
    */
   public function run()
   {
      // $this->call(TaxonomySeeder::class);
      //$this->call(RoleTableSeeder::class);
      //$this->call(UserTableSeeder::class);
      $this->call(FeatureSeeder::class);
      $this->call(PlanSeeder::class);
   }
}
