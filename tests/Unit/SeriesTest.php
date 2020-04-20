<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesTest extends TestCase
{
	use DatabaseMigrations;
    
	public function setup(): void {
		parent::setup();

		$this->user = factory('App\User')->create();
		$this->category = factory('App\Category')->create();
    }

	/** @test */
	public function it_knows_what_articles_it_owns() {
		$series = factory('App\Series')->create();
		$a1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$a2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$a3 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>3
		]);
		$this->assertInstanceOf('\App\Article',$series->articles()->first());
		$this->assertEquals($a1->id,$series->articles[0]->id);
		$this->assertEquals($a3->id,$series->articles[2]->id);
	}

	/** @test */
	public function an_article_can_be_added() {
		$series = factory('App\Series')->create();
		$article = factory('App\Article')->create([
			'series_id'=>null
		]);
		$this->assertCount(0,$series->articles);
		$series->add($article);
		$this->assertCount(1,$series->fresh()->articles);
		$this->assertEquals($article->id,$series->fresh()->articles[0]->id);
	}

	/** @test */
	public function an_article_can_be_removed() {
		$series = factory('App\Series')->create();
		$article = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$this->assertCount(1,$series->articles);
		$series->remove($article);
		$this->assertCount(0,$series->fresh()->articles);
		
	}

	/** @test */
	public function an_article_added_to_a_series_is_the_last_article() {
		$series = factory('App\Series')->create();
		$a1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$a2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$a3 = factory('App\Article')->create();
		$series->add($a3);
		$this->assertEquals(3,$series->fresh()->articles[2]->number_in_series);
	}

	/** @test */
	public function when_an_article_is_removed_the_number_in_series_for_other_articles_is_updated() {
		
		$series = factory('App\Series')->create();
		$arts = factory('App\Article',4)->create();
		foreach ($arts as $a) {
			$series->fresh()->add($a);
		}
		$series = $series->fresh();
		$this->assertEquals([1,2,3,4],$series->articles()->pluck('number_in_series')->toArray());

		$series->remove($arts[1]);
		$series = $series->fresh();
		$this->assertEquals([1,2,3],$series->articles()->pluck('number_in_series')->toArray());
	}

}
