<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
        	 ['username' => "Admin", 'password' => bcrypt('secret')],
             ['username' => "portero1",  'password' => bcrypt('1234')]            
        ]);
    }
}
