<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticleTest extends TestCase
{
    use DatabaseMigrations;

    public function setup(): void
    {
        parent::setup();
        $this->user = factory('App\User')->create();
        $this->category = factory('App\Category')->create();
    }

    /** @test */
    public function next_art_in_series_is_recommended_if_in_a_series()
    {
        $series = factory('App\Series')->create();
        $art1 = factory('App\Article')->create([
            'series_id' => $series->id,
            'number_in_series' => 1
        ]);
        $art2 = factory('App\Article')->create([
            'series_id' => $series->id,
            'number_in_series' => 2
        ]);
        $this->get($art1->slug)->assertSee($art2->title);
        $this->get($art1->slug)->assertSee("Next Article");
        $this->get($art2->slug)->assertDontSee("Next Article"); // there is no next article
    }
}
