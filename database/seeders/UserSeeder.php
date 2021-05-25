<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin123@admin.com',
            'phone' => '0000000000000',
            'password' => Hash::make('NyWeDY&vFZ9jFtZ8wJ5xbn@TLGWLjr9@D9aj#pdqt636bW2JmQhd'),
            'role'=>1
        ]);
    }
}
