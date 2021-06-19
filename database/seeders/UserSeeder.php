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
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin2",
                "email" => "admin2@gmail.com",
                "role" => "admin",
                "password" => Hash::make("semarang"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin3",
                "email" => "admin3@gmail.com",
                "role" => "admin",
                "password" => Hash::make("yogyakarta"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin4",
                "email" => "admin4@gmail.com",
                "role" => "admin",
                "password" => Hash::make("jakarta"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin5",
                "email" => "admin5@gmail.com",
                "role" => "admin",
                "password" => Hash::make("medan"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin6",
                "email" => "admin6@gmail.com",
                "role" => "admin",
                "password" => Hash::make("bandung"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin7",
                "email" => "admin7@gmail.com",
                "role" => "admin",
                "password" => Hash::make("surabaya"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin8",
                "email" => "admin8@gmail.com",
                "role" => "admin",
                "password" => Hash::make("jayapura"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin9",
                "email" => "admin9@gmail.com",
                "role" => "admin",
                "password" => Hash::make("kudus"),
                "jenis_kelamin" => "Laki-Laki"
            ], [
                "name" => "admin10",
                "email" => "admin10@gmail.com",
                "role" => "admin",
                "password" => Hash::make("mojokerto"),
                "jenis_kelamin" => "Laki-Laki"
            ]
        ]);

        $users->each(function($user) {
            User::create($user);
        });
    }
}
