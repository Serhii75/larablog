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
        if (env('APP_ENV') === 'testing') {
            $this->runTestSeeders();
        } else {
            $this->runDevelopmentSeeders();
        }
    }

    protected function runDevelopmentSeeders()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            TagsTableSeeder::class,
            PostsTableSeeder::class,
            PostTagTableSeeder::class,
            CommentsTableSeeder::class,
            LikesTableSeeder::class,
        ]);
    }

    protected function runTestSeeders()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
        ]);
    }
}
