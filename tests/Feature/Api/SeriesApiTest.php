<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SeriesApiTest extends TestCase
{
	use DatabaseMigrations;

	public function setup():void {
		parent::setup();
		$this->artisan('db:seed', ['--class' => 'PermissionTableSeeder']);
		$this->actingAsAdmin();
        $this->user = factory('App\User')->create();
        $this->category = factory('App\Category')->create();
    }
    
    /** @test */
	public function an_admin_can_see_a_list_of_series_in_the_dashboard() {
		$series = factory('App\Series',2)->create();
		$response = $this->get('/api/series');
		$response->assertSee($series[0]->title);
		$response->assertSee($series[1]->title);
	}

	/** @test */
	public function an_admin_can_create_a_series() {
		$this->withoutExceptionHandling()->post('/api/series/new',[
			'name'=>'foobar',
			'description'=>'lorem ipsum'
		]);
		$this->assertDatabaseHas('series',['name'=>'foobar']);
	}

	/** @test */
	public function an_admin_can_update_a_series_name() {
		$series = factory('App\Series')->create(['name'=>'foobar']);
		$this->json('patch','api/series/'.$series->id,[
			'name'=>'lorem_ipsum',
			'description'=>'lorem ipsum'
		]);
		$this->assertDatabaseHas('series',['name'=>'lorem_ipsum']);
	}


	/** @test */
	public function an_admin_can_change_the_order_of_articles_in_a_series() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$art2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$art3 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>3
		]);
		$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1,2]]);
		$this->assertEquals(1,$art3->refresh()->number_in_series);
		$this->assertEquals(2,$art1->refresh()->number_in_series);
		$this->assertEquals(3,$art2->refresh()->number_in_series);
	}

	/** @test */
	public function articles_can_be_deleted_by_updating_the_order() {

			$series = factory('App\Series')->create();
			$art1 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>1
			]);
			$art2 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>2
			]);
			$art3 = factory('App\Article')->create([
				'series_id'=>$series->id,
				'number_in_series'=>3
			]);
			$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1]]);
			$this->assertEquals(1,$art3->refresh()->number_in_series);
			$this->assertEquals(2,$art1->refresh()->number_in_series);
			$this->assertEquals(null,$art2->refresh()->number_in_series);
	}

	/** @test */
	public function articles_can_be_added_by_updating_the_order() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$art2 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>2
		]);
		$art3 = factory('App\Article')->create();

		$this->json('patch','api/series/order/'.$series->id,['articles'=>[3,1,2]]);
		$this->assertEquals(1,$art3->refresh()->number_in_series);
		$this->assertEquals(2,$art1->refresh()->number_in_series);
		$this->assertEquals(3,$art2->refresh()->number_in_series);

	}

	/** @test */
	public function an_admin_can_delete_a_series() {
		$series = factory('App\Series')->create();
		$art1 = factory('App\Article')->create([
			'series_id'=>$series->id,
			'number_in_series'=>1
		]);
		$this->json('delete','api/series/'.$series->id);
		$this->assertDatabaseMissing('series',['name'=>$series->name]);
		$this->assertEquals(null,$art1->fresh()->series_id);
    }
    
    /** @test */
    public function a_non_admin_cannot_access_the_series_api() {
        auth()->user()->update(['is_admin'=>0]);
        $this->be(factory("App\User")->create());

		$this->json('delete','api/series/1')->assertStatus(404);
        $this->json('patch','api/series/order/1')->assertStatus(404);
        $this->post('/api/series/new')->assertStatus(404);
        $this->get('/api/series')->assertStatus(404);
    }
}
