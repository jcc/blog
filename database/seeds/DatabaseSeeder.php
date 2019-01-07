<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(ArticlesTableSeeder::class);
         $this->call(DiscussionsTableSeeder::class);
         $this->call(CommentsTableSeeder::class);
         $this->call(TagsTableSeeder::class);
         $this->call(LinksTableSeeder::class);
         $this->call(VisitorsTableSeeder::class);
         $this->call(PermissionTableSeeder::class);
    }
}
