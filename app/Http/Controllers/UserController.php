<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Hash;
use Validator;
use Illuminate\Http\Request;
use App\Notifications\FollowedUser;

class UserController extends Controller
{
    /**
     * Redirect to user information page.
     *
     * @return redirect
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->to('/user/'.Auth::user()->name);
        }

        return redirect()->to('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param int $username
     *
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::query()->where('name', $username)->first();

        if (!isset($user)) {
            abort(404);
        }

        $discussions = $user->discussions->take(10);
        $comments = $user->comments->take(10);

        return view('user.index', compact('user', 'discussions', 'comments'));
    }

    /**
     * Display the following users list.
     *
     * @param string $username
     *
     * @return \Illuminate\Http\Response
     */
    public function following($username)
    {
        $user = User::query()->where('name', $username)->first();

        if (!isset($user)) {
            abort(404);
        }

        $followings = $user->followings;

        return view('user.following', compact('user', 'followings'));
    }

    /**
     * Display the list of user's discussions.
     *
     * @param string $username
     *
     * @return \Illuminate\Http\Response
     */
    public function discussions($username)
    {
        $user = User::query()->where('name', $username)->first();

        if (!isset($user)) {
            abort(404);
        }

        $discussions = $user->discussions;

        return view('user.discussions', compact('user', 'discussions'));
    }

    /**
     * Display the list of user's comments.
     *
     * @param string $username
     *
     * @return \Illuminate\Http\Response
     */
    public function comments($username)
    {
        $user = User::query()->where('name', $username)->first();

        if (!isset($user)) {
            abort(404);
        }

        $comments = $user->comments;

        return view('user.comments', compact('user', 'comments'));
    }

    /**
     * Follow or unfollow the other user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function doFollow($id)
    {
        $user = User::find($id);

        if (Auth::user()->isFollowing($id)) {
            Auth::user()->unfollow($id);
        } else {
            Auth::user()->follow($id);

            $user->notify(new FollowedUser(Auth::user()));
        }

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (!\Auth::id()) {
            abort(404);
        }

        $user = \Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['name', 'email', 'is_admin']);

        $user = User::query()->findOrFail($id);

        $this->authorize('update', $user);

        $user->update($input);

        return redirect()->back();
    }

    /**
     * changePassword.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request)
    {
        Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ])->validate();

        if (!Hash::check($request->get('old_password'), Auth::user()->password)) {
            return redirect()->back()
                ->withErrors(['old_password' => trans('passwords.check_old_password')]);
        }

        Auth::user()->update(['password' => bcrypt($request->get('password'))]);

        return redirect()->back();
    }

    /**
     * Show the notifications for auth user.
     *
     * @return \Illuminate\Http\Response
     */
    public function notifications()
    {
        if (!\Auth::id()) {
            abort(404);
        }

        $user = User::query()->findOrFail(\Auth::id());

        return view('user.notifications', compact('user'));
    }

    /**
     * Mark the auth user's notification as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsRead()
    {
        if (!\Auth::id()) {
            abort(404);
        }

        $user = User::query()->findOrFail(\Auth::id());

        $user->unreadNotifications->markAsRead();

        return view('user.notifications', compact('user'));
    }
}
