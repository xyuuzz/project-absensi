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
            ]
        ]);

        $users->each(function($user) {
            $u = User::create($user);
            if($user["role"] === "teacher") {
                $u->teacher()->create([
                    "nign" => 3213123,
                    "mapel" => "Sejarah"
                ]);
            } else if($user["role"] === "student") {
                $u->student()->create([
                    "classes_id" => 1,
                    "nisn" => "32132321321",
                    "nis" => 3232,
                    "no_absen" => 33,
                    "photo_profile" => "foto-profil.png"
                ]);
            }
        });
    }
}
