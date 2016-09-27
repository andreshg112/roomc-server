<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HabitacionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('habitaciones')->insert([
            ['numero' => 1, 'motel_id'=>1],
            ['numero' => 2, 'motel_id'=>1],
            ['numero' => 3, 'motel_id'=>1],
            ['numero' => 4, 'motel_id'=>1],
            ['numero' => 5, 'motel_id'=>1],
            ['numero' => 6, 'motel_id'=>1],
            ['numero' => 7, 'motel_id'=>1],
            ['numero' => 8, 'motel_id'=>1],
        ]);
    }
}
