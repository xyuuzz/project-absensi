<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $users = collect([
            [
                "name" => "maulana",
                "email" => "maulanayuusuf023@gmail.com",
                "role" => "admin",
                "password" => Hash::make("maulanayusuf"),
            ],
            [
                "name" => "bagus",
                "email" => "sukabagus@gmail.com",
                "role" => "teacher",
                "password" => Hash::make("sukabagus"),
            ],
            [
                "name" => "nanakana",
                "email" => "kananana1212@gmail.com",
                "role" => "student",
                "password" => Hash::make("nanakana"),
            ]
        ]);

        $users->each(function($user) {
            User::create($user);
        });
    }
}
