<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdministradorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('administradores')->insert([
        	 'user_id' => 1         
        ]);
    }
}
