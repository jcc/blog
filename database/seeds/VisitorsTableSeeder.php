<?php

use App\Visitor;
use Illuminate\Database\Seeder;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Visitor::class, 100)->create();
    }
}
