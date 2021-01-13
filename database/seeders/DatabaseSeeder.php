<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
<<<<<<< HEAD
use App\Models\User;
use App\Models\Meeting;
=======
use App\Models\Meeting;
use App\Models\User;
>>>>>>> 725251808e590e57407bc8c314f28126062528cd

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
<<<<<<< HEAD
        // User::factory(1)->create();
=======
        User::factory(1)->create();
>>>>>>> 725251808e590e57407bc8c314f28126062528cd
        Meeting::factory(10)->create();
    }
}
