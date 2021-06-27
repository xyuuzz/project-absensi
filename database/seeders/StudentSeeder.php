<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_kelamin = ["Laki-Laki", "Perempuan"];

        $index = 1;
        while($index <= 30)
        {
            $user = [
                "name" => "maulaniku$index",
                "email" => "maulaniku$index@gmail.com",
                "role" => "student",
                "jenis_kelamin" => $jenis_kelamin[rand(0,1)],
                "password" => Hash::make("password$index")
            ];

            $student = [
                "classes_id" => rand(1,15),
                "nisn" => rand(10000000, 100000000) + $index,
                "nis" => rand(1000, 9788) + $index,
                "no_absen" => rand(1,30) + $index,
                "photo_profile" => "foto-profil.png",
            ];

            $user = User::create($user);
            $user->student()->create($student);

            $index++;
        }
    }
}
