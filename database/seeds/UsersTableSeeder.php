<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master_admin = User::create([
            'role_id' => '1',
            'username' => 'master',
            'first_name' => 'David Paul',
            'last_name' => 'Eligio',
            'email' => 'dpe.developer001@gmail.com',
            'password' => bcrypt('admin'),
        ]);
        $admin = User::create([
            'role_id' => '2',
            'username' => 'admin',
            'first_name' => 'David Paul',
            'last_name' => 'Ferrer',
            'email' => 'admin@laravel-adminlte.com',
            'password' => bcrypt('admin'),
        ]);
        $doctor = User::create([
            'role_id' => '3',
            'username' => 'drjunncdizon',
            'first_name' => 'Junn',
            'last_name' => 'Dizon',
            'email' => 'drjunncdizon@yahoo.com',
            'password' => bcrypt('asdasd'),
        ]);
        $patient = User::create([
            'role_id' => '4',
            'username' => '123123',
            'first_name' => 'Kyouma',
            'last_name' => 'Hououin',
            'sex' => 'male',
            'birthdate' => '1994-12-14',
            'occupation' => 'Scientist',
            'contact_number' => '09673700022',
            'email' => 'hououinkyouma.000001@gmail.com',
            'password' => bcrypt('asdasd'),
        ]);
        $master_admin->assignRole(1);
        $admin->assignRole(2);
        $doctor->assignRole(3);
        $patient->assignRole(4);
    }
}
