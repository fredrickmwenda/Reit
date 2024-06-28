<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LucasDotVin\Soulbscription\Enums\PeriodicityType;
use LucasDotVin\Soulbscription\Models\Feature;
use LucasDotVin\Soulbscription\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $silver = Plan::create([
            'name'             => 'Silver',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 1,
        ]);

        $diamond = Plan::create([
            'name'             => 'Diamond',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 3,
            'grace_days'       => 3,
        ]);

        $gold = Plan::create([
            'name'             => 'Gold',
            'periodicity_type' => PeriodicityType::Month,
            'periodicity'      => 12,
            'grace_days'       => 7
        ]);



        // $trialPlan = Plan::create([
        //     'name'             => 'Trial',
        //     'periodicity_type' => PeriodicityType::Week,
        //     'periodicity'      => 1,
        // ]);

        $monthlyFeatures = Feature::take(2)->get();
        $quartelyFeatures = Feature::take(3)->get();
        $unlimitedFeatures = Feature::all();

        $silver->features()->attach($monthlyFeatures, ['charges' => 10]);
        $diamond->features()->attach($quartelyFeatures, ['charges' => 10]);
        $gold->features()->attach($unlimitedFeatures);
       

        // $trialPlan->features()->attach($limitedFeature, ['charges' => 3]);

    }
}
