<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthAccessTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_access_tokens', function(Blueprint $table)
		{
			$table->string('id', 100)->primary();
			$table->integer('user_id')->nullable()->index();
			$table->integer('client_id');
			$table->string('name', 191)->nullable();
			$table->text('scopes', 65535)->nullable();
			$table->boolean('revoked');
			$table->timestamps();
			$table->dateTime('expires_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_access_tokens');
	}

}
