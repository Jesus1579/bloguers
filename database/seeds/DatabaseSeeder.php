<?php

use Database\Seeders\RoleSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seedersArray = [
            RoleSeeder::class,
            UsersSeeder::class,
        ];
        //call seeders
        foreach ($seedersArray as $seeder) $this->call($seeder);
    }
}
