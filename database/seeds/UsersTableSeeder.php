<?php

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
                'name' => 'admin',
                'email' => 'admin@pigjian.com',
                'password' => Hash::make('admin'),
                'status' => true,
                'is_admin' => true,
                'confirm_code' => str_random(64),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];

        DB::table('users')->insert($users);

        factory(User::class, 10)->create();
    }
}
