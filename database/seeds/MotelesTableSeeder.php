<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MotelesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	  DB::table('moteles')->insert([
            ['nombre' => 'Acapulco',
             'direccion' => 'calle 44 #12-34',
             'telefono' => '3211237856',
             'administrador_id' => 1, ],
            ['nombre' => 'Acapulco 2',
             'direccion' => 'calle 9 #11-34',
             'telefono' => '3003457856',
             'administrador_id' => 1, ]
        ]);
        
    }
}
