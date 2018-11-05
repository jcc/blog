<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('numRaters')->nullable()->comment('评分人数');
			$table->string('average', 10)->nullable()->comment('平均分');
			$table->string('subtitle', 100)->nullable();
			$table->string('author', 30)->nullable();
			$table->dateTime('pubdate')->nullable();
			$table->string('tags', 100)->nullable()->default('');
			$table->string('origin_title', 100)->nullable();
			$table->string('image', 100)->nullable();
			$table->string('binding', 20)->nullable()->comment('平装，精装什么的');
			$table->string('translator', 50)->nullable();
			$table->text('catalog', 65535)->nullable();
			$table->smallInteger('pages')->nullable();
			$table->string('alt', 100)->nullable()->comment('豆瓣详情页');
			$table->string('publisher', 50)->nullable();
			$table->string('isbn13', 50)->nullable();
			$table->string('title', 50)->nullable();
			$table->text('author_intro', 65535)->nullable();
			$table->text('summary', 65535)->nullable();
			$table->decimal('price', 7)->nullable();
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
		Schema::drop('book');
	}

}
