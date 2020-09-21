<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->truncate();

//        Event::create([
//            'name' => "Laravel and Coffee",
//            'city' => "Dublin",
//            'venue' => "Cup of Joe",
//            'description' => "Let's learn Laravel together!"
//        ]);
//
//        Event::create([
//            'name' => "IoT and the Raspberry Pi",
//            'city' => "Columbus",
//            'state' => "Columbus Library",
//            'description' => "Weather monitoring with the Pi"
//        ]);

        $faker = \Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            Event::create([
                'name' => $faker->sentence(2),
                'city' => $faker->city,
                'state' => $faker->company,
                'description' => $faker->paragraphs(1, true),
            ]);
        }
    }
}
