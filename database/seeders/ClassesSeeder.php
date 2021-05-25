<?php

namespace Database\Seeders;

use App\Models\Classes;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = ["X RPL", "X OTKP", "X BDP", "X AKL", "X UPW",
                    "XI RPL", "XI OTKP", "XI BDP", "XI AKL", "XI UPW",
                    "XII RPL", "XII OTKP", "XII BDP", "XII AKL", "XII UPW"];
        
        foreach($class as $c)
        {
            Classes::create([
                "class" => $c
            ]);
        }
    }
}
