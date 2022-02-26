<?php


use Illuminate\Database\Seeder;
use Database\Seeders\UsersSeeder;
//use Database\Seeders\RoleSeeder;
use App\Models\{
    User,
    Category,
    Label,
    Post,
    Comment,
};

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$seedersArray = [
            RoleSeeder::class,
            UsersSeeder::class,
        ];
        //call seeders
        foreach ($seedersArray as $seeder) $this->call($seeder);*/

    User::factory(25)->create();
    Category::factory(10)->create();
    Label::factory(25)->create();
    Post::factory(50)->create();
    Comment::factory(8)->create();

    }
}
