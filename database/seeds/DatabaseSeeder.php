<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsuariosTableSeeder::class);
        $this->call(VehiculosTableSeeder::class);
        $this->call(AdministradorTableSeeder::class);
        $this->call(MotelesTableSeeder::class);
        $this->call(HabitacionesTableSeeder::class);
        $this->call(PorterosTableSeeder::class);
    }
}
