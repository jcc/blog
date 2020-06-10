<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'status'         => true,
        'confirm_code'   => Str::random(64),
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
    ];
});

$factory->state(App\User::class, 'admin', function () use ($factory) {
    $user = $factory->raw(App\User::class);

    return array_merge($user, ['is_admin' => 1, 'password' => bcrypt('admin')]);
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'parent_id' => 0,
        'path'      => $faker->url
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $category_ids = \App\Category::pluck('id')->random();
    $title = $faker->sentence(mt_rand(3,10));
    return [
        'user_id'      => $user_ids,
        'category_id'  => $category_ids,
        'last_user_id' => $user_ids,
        'slug'     => Str::slug($title),
        'title'    => $title,
        'subtitle' => strtolower($title),
        'content'  => $faker->paragraph,
        'page_image'       => $faker->imageUrl(),
        'meta_description' => $faker->sentence,
        'is_draft'         => false,
        'published_at'     => $faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now')
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'tag'              => $faker->word,
        'title'            => $faker->sentence,
        'meta_description' => $faker->sentence,
    ];
});

$factory->define(App\Discussion::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    return [
        'user_id'      => $user_ids,
        'last_user_id' => $user_ids,
        'title'        => $faker->sentence,
        'content'      => $faker->paragraph,
        'status'       => true,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $discussion_ids = \App\Discussion::pluck('id')->random();
    $type = ['discussions', 'articles'];
    return [
        'user_id'             => $user_ids,
        'commentable_type'    => $type[mt_rand(0, 1)],
        'commentable_id'      => $discussion_ids,
        'content'             => $faker->paragraph
    ];
});

$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        'name'  => $faker->name,
        'link'  => $faker->url,
        'image' => $faker->imageUrl()
    ];
});

$factory->define(App\Visitor::class, function (Faker\Generator $faker) {
    $article_id = \App\Article::pluck('id')->random();
    $num = $faker->numberBetween(1, 100);

    $article = App\Article::find($article_id);
    $article->view_count = $num;
    $article->save();

    return [
        'article_id' => $article_id,
        'ip'         => $faker->ipv4,
        'country'    => 'CN',
        'clicks'     => $num
    ];
});
