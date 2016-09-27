<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PorterosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('porteros')->insert([
        	 'user_id' => 2, 
        	 'motel_id'=>1      
        ]);
    }
}
