<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;
use LucasDotVin\Soulbscription\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Feature::create([
        //     'consumable'       => true,
        //     'name'             => 'manage-tasks-limited',
        //     'periodicity_type' => PeriodicityType::Month,
        //     'periodicity'      => 1,
        // ]);

        Feature::create([
            'consumable'       => false,
            'name'             => 'listing-of-properties',
        ]);
        Feature::create([
            'consumable'       => false,
            'name'             => 'analytics-and-reporting',
        ]);
        Feature::create([
            'consumable'       => false,
            'name'             => 'training-and-onboarding',
        ]);
        Feature::create([
            'consumable'       => false,
            'name'             => 'dedicated-support',
        ]);
        Feature::create([
            'consumable'       => false,
            'name'             => 'communication-tools',
        ]);

    }
}
