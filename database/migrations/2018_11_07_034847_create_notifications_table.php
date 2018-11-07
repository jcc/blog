<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->char('id', 36)->primary();
			$table->string('type', 191);
			$table->string('notifiable_type', 191);
			$table->bigInteger('notifiable_id')->unsigned();
			$table->text('data', 65535);
			$table->dateTime('read_at')->nullable();
			$table->timestamps();
			$table->index(['notifiable_type','notifiable_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
