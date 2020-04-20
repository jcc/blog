<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArticleTest extends TestCase
{
	use DatabaseMigrations;
    
	public function setup(): void {
		parent::setup();

		$this->user = factory('App\User')->create();
		$this->category = factory('App\Category')->create();
    }

	/** @test */
	public function it_knows_if_it_is_a_part_of_a_series() {
		$article = factory('App\Article')->create([
			'series_id'=>null
		]);
		$this->assertFalse($article->isPartofSeries());
		$article = factory('App\Article')->create([
			'series_id'=>factory('App\Series')->create()->id
		]);
		$this->assertTrue($article->isPartofSeries());
	}

	/** @test */
	public function it_knows_the_next_and_prev_video_in_the_series() {
		$series = factory('App\Series')->create();
		$article2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$article1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$this->assertEquals($article2->id,$article1->nextArticle()->id);
		$this->assertEquals($article1->id,$article2->previousArticle()->id);
	}



}
