<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
        	'name' => 'Lenard Mangay-ayam',
        	'username' => 'admin',
        	'email' => 'lenard.mangayayam@gmail.com',
        	'password' => bcrypt('admin')
        ]);
    }
}
