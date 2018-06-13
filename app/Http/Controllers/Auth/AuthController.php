<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\User;
use Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::query()->where('github_id', $githubUser->id)->first();

        if (auth()->check()) {
            $currentUser = auth()->user();

            if ($currentUser->github_id) {
                return redirect()->back();
            } else {
                if ($user) {
                    return redirect()->back();
                } else {
                    $this->bindGithub($currentUser, $githubUser);

                    return redirect()->back();
                }
            }
        } else {
            if ($user) {
                auth()->loginUsingId($user->id);
                // article
                return redirect()->to('/');
            } else {
                $this->registerUser($githubUser);
                return redirect()->to('auth/github/register');
            }
        }
    }

    /**
     * Bind the github account.
     *
     * @param $currentUser
     * @param $registerData
     * @return mixed
     */
    public function bindGithub($currentUser, $registerData)
    {
        $currentUser->github_id = $registerData->user['id'];
        $currentUser->github_name = $registerData->nickname;
        $currentUser->github_url = $registerData->user['url'];

        return $currentUser->save();
    }

    /**
     * Save the register data in session.
     *
     * @param $registerData
     */
    public function registerUser($registerData)
    {
        $data['avatar'] = $registerData->user['avatar_url'];
        $data['github_id'] = $registerData->user['id'];
        $data['github_name'] = $registerData->nickname;
        $data['github_url'] = $registerData->user['url'];
        $data['name'] = $registerData->nickname;
        $data['nickname'] = $registerData->user['name'];
        $data['email'] = $registerData->user['email'];

        session()->put('oauthData', $data);
    }

    /**
     * Display the github oauth for register page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (! session()->has('oauthData')) {
            return redirect()->to('login');
        }

        $oauthData = array_merge(session('oauthData'), request()->old());

        return view('auth.github_register', compact('oauthData'));
    }

    /**
     * Store a new user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        if (! session()->has('oauthData')) {
            return redirect('login');
        }

        $this->validator(request()->all())->validate();

        $oauthData = session('oauthData');

        $data = array_merge($oauthData, request()->all());

        $data['password'] = bcrypt($data['password']);

        $data['status'] = true;

        auth()->guard()->login(User::create($data));

        session()->forget('oauthData');

        return redirect()->to('article');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

}
