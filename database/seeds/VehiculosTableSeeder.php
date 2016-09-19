<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class VehiculosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehiculos')->insert([
            ['marca' => 'MAZDA'],
            ['marca' => 'RENAULT'],
            ['marca' => 'CHEVROLET'],
            ['marca' => 'TOYOTA'],
            ['marca' => 'KIA'],
            ['marca' => 'FORD'],
            ['marca' => 'NISSAN'],
            ['marca' => 'DAEWOO'],
            ['marca' => 'FIAT'],
            ['marca' => 'VOLKSWAGEN'],
            ['marca' => 'JEEP'],
            ['marca' => 'HONDA'],
            ['marca' => 'DODGE'],
            ['marca' => 'OTRO']
        ]);
        
    }
}
