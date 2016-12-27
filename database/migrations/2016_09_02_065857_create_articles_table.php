<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('last_user_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle');
            // $table->json('content');
            $table->text('content');
            $table->string('page_image')->nullable();
            $table->string('meta_description')->nullable();
            $table->boolean('is_original')->default(false);
            $table->boolean('is_draft')->default(false);
            $table->integer('view_count')->unsigned()->default(0)->index();
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
