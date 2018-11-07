<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable()->index();
			$table->string('name', 191);
			$table->string('secret', 100);
			$table->text('redirect', 65535);
			$table->boolean('personal_access_client');
			$table->boolean('password_client');
			$table->boolean('revoked');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_clients');
	}

}
