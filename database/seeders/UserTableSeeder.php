<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::create([
					'nome' => 'Admin',
					'email' => 'admin@admin',
                    'role' => 'admin',
					'password' => Hash::make('12345678'),
					])->assignRole('super-admin');;

    }



}
