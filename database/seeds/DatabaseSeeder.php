<?php


use Illuminate\Database\Seeder;
use Database\Seeders\{
    UsersSeeder,
    LabelSeeder,
    PostSeeder,
    CommentSeeder,
    PostLabelSeeder,
    RoleSeeder,
    CategorySeeder,
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

        $this->call([
            RoleSeeder::class,
            UsersSeeder::class,
            LabelSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
            PostLabelSeeder::class,

        ]);
    }
}
