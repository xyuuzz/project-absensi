<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jenis_kelamin = ["Laki-Laki", "Perempuan"];
        $mapel = ["Sejarah", "Pemdas", "B.Indo"];

        $index = 1;
        while($index <= 50)
        {
            $user = [
                "name" => "maulana$index",
                "email" => "maulana$index@gmail.com",
                "role" => "teacher",
                "jenis_kelamin" => $jenis_kelamin[rand(0,1)],
                "password" => Hash::make("password$index")
            ];

            $teacher = [
                "nign" => 12837912 + $index,
                "mapel" => $mapel[rand(0,2)]
            ];

            $user = User::create($user);
            $user->teacher()->create($teacher);

            $index++;
        }
    }
}
