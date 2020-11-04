<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        factory(\App\Models\Student::class, 10)->create();
        factory(\App\Models\Lesson::class, 10)->create();
        factory(\App\Models\Location::class, 10)->create();
    }
}
