<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->unique();
			$table->string('nickname', 191)->nullable();
			$table->text('avatar', 65535)->nullable();
			$table->string('email', 191)->unique();
			$table->string('confirm_code', 64)->nullable()->unique();
			$table->boolean('status')->default(0);
			$table->boolean('is_admin')->default(0);
			$table->string('password', 191);
			$table->string('github_id', 191)->nullable();
			$table->string('github_name', 191)->nullable();
			$table->string('github_url', 191)->nullable();
			$table->string('weibo_name', 191)->nullable();
			$table->string('weibo_link', 191)->nullable();
			$table->string('website', 191)->nullable();
			$table->string('description', 191)->nullable();
			$table->enum('email_notify_enabled', array('yes','no'))->default('yes')->index();
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('users');
	}

}
