<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Subscriber;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesTest extends TestCase
{
	use DatabaseMigrations;

	public function setup():void {
		parent::setup();
		$this->user = factory('App\User')->create();
		$this->category = factory('App\Category')->create();
	}

	/** @test */
	public function users_can_view_a_list_of_series() {
		$series = factory('App\Series')->create();
		$this->withoutExceptionHandling()->get('/series')->assertSee($series->name);
	}

	/** @test */
	public function users_can_view_all_articles_in_a_series() {

		$series = factory('App\Series')->create();
		$art = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);

		$this->withoutExceptionHandling()->get('series/'.$series->id)->assertSee($art->title);
	}

}
