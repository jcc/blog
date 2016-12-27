<?php

namespace App\Console\Commands;

use App\User;
use Validator;
use RuntimeException;
use Identicon\Identicon;
use App\Scopes\StatusScope;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:admin
                            {user? : The ID of the user}
                            {--delete : Whether the user should be deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin or delete a user for the blog.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $option = $this->option('delete');

        if ($userId && !$option) {
            $user = User::findOrFail($userId);

            $this->info('username: ' . $user->name . ', email: ' . $user->email . ', is_admin: ' . $user->is_admin);

            return;
        } else if ($userId && $option) {
            if (User::withoutGlobalScope(StatusScope::class)->find($userId)->delete()) {
                $this->info('Deleted the user success!');
            } else {
                $this->error('Sorry, the system had made a mistake! Please check the system.');
            }
            return;
        }

        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is the password?(min: 6 character)');

        $data = [
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ];

        if ( $this->register($data) ) {
            $this->info('Register a new admin success! You can login in the dashboard by the account.');
        } else {
            $this->error('Something went wrong!');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if (!$validator->passes()) {
            throw new RuntimeException($validator->errors()->first());
        }

        return $this->create($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create($data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'status'   => true,
            'is_admin' => true,
            'password' => bcrypt($data['password']),
            'avatar'   => (new Identicon())->getImageDataUri($data['name'], 256),
        ]);
    }
}
