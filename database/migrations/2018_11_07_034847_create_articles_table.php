<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('last_user_id')->unsigned();
			$table->string('slug', 191)->unique();
			$table->string('title', 191);
			$table->string('subtitle', 191);
			$table->text('content', 65535);
			$table->string('page_image', 191)->nullable();
			$table->string('meta_description', 191)->nullable();
			$table->boolean('is_original')->default(0);
			$table->boolean('is_draft')->default(0);
			$table->integer('view_count')->unsigned()->default(0)->index();
			$table->dateTime('published_at')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('articles');
	}

}
