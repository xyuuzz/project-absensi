<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\{UserSeeder, ClassesSeeder, ScheduleSeeder};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ClassesSeeder::class);
        $this->call(ScheduleSeeder::class);
    }
}
