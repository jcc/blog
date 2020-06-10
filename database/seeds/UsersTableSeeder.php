<?php

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => config('blog.admin_name'),
                'email' => config('blog.admin_email'),
                'password' => Hash::make(config('blog.admin_password')),
                'status' => true,
                'is_admin' => true,
                'confirm_code' => Str::random(64),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];

        DB::table('users')->insert($users);

        factory(User::class, 10)->create();
    }
}
