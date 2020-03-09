<?php

use Illuminate\Database\Seeder;

class BusinessDaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weekdays = [
            'Monday' => 1,
            'Tuesday' => 2,
            'Wednesday' => 3,
            'Thurday' => 4,
            'Friday' => 5,
        ];

        foreach ($weekdays as $day => $iso) {
            factory('App\BusinessDay')->create([
                'name' => $day,
                'iso' => $iso,
            ]);
        }

        factory('App\BusinessDay')->create([
            'name' => 'Saturday',
            'iso' => 6,
            'open' => '10:00',
            'close' => '15:00',
        ]);
    }
}
