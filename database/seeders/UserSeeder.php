<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
//        DB::table('users')->insert([
//            'uuid' => Str::uuid(),
//            'first_name' => 'yunus',
//            'last_name' => 'shaikh',
//            'is_admin' => true,
//            'email' => 'yunus@gmail.com',
//            'password' => Hash::make('yunus123'),
//            'address' => 'Maharashtra',
//            'phone_number' => '9999999999',
//        ]);

        User::factory()->count(2)->create();
    }
}
