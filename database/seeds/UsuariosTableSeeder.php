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
        	 ['username' => "Admin", 'password' => password_hash('1234', PASSWORD_DEFAULT)],
             ['username' => "portero1",  'password' => password_hash('1234', PASSWORD_DEFAULT)]            
        ]);
    }
}
