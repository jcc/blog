<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Image;
use Validator;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Services\FileManager\UploadManager;

class UserController extends Controller
{
    protected $user;

    protected $manager;

    public function __construct(UserRepository $user, UploadManager $manager)
    {
        $this->user = $user;

        $this->manager = $manager;
    }

    /**
     * Redirect to user information page.
     * 
     * @return redirect
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->to('/user/' . Auth::user()->name);
        }

        return redirect()->to('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = $this->user->getByName($username);

        if (!isset($user)) abort(404);

        $discussions = $user->discussions->take(10);
        $comments = $user->comments->take(10);

        return view('user.index', compact('user', 'discussions', 'comments'));
    }

    /**
     * Display the following users list.
     * 
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function following($username)
    {
        $user = $this->user->getByName($username);

        if (!isset($user)) abort(404);

        $followings = $user->followings;

        return view('user.following', compact('user', 'followings'));
    }

    /**
     * Display the list of user's discussions.
     * 
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function discussions($username)
    {
        $user = $this->user->getByName($username);

        if (!isset($user)) abort(404);

        $discussions = $user->discussions;

        return view('user.discussions', compact('user', 'discussions'));
    }

    /**
     * Display the list of user's comments.
     * 
     * @param  string $username
     * @return \Illuminate\Http\Response
     */
    public function comments($username)
    {
        $user = $this->user->getByName($username);

        if (!isset($user)) abort(404);

        $comments = $user->comments;

        return view('user.comments', compact('user', 'comments'));
    }

    /**
     * Follow or unfollow the other user.
     * 
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function doFollow($id)
    {
        $user = $this->user->getById($id);

        if (Auth::user()->isFollowing($id)) {
            Auth::user()->unfollow($id);
        } else {
            Auth::user()->follow($id);
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
        if (!\Auth::id()) abort(404);

        $user = $this->user->getById(\Auth::id());

        return view('user.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->except(['name', 'email', 'is_admin']);

        $user = $this->user->update($id, $input);

        return redirect()->back();
    }

    /**
     * Change the user's password.
     * 
     * @param  Request $request
     * @return Redirect
     */
    public function changePassword(Request $request)
    {
        if (! Hash::check($request->get('old_password'), Auth::user()->password)) {
            return redirect()->back()
                             ->withErrors(['old_password' => 'The password must be the same of current password.']);
        }

        Validator::make($request->all(), [
            'old_password' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ])->validate();

        $this->user->changePassword(Auth::user(), $request->get('password'));

        return redirect()->back();
    }


    /**
     * Upload the avatar.
     *
     * @param Request $request
     * @return mixed
     */
    public function avatar(Request $request)
    {
        $file = $request->file('avatar');
        $input = [ 'image' => $file ];
        $rules = [ 'image' => 'image' ];

        $validator = \Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json([
                        'success' => false,
                        'errors'  => $validator->getMessageBag()->toArray()
                    ]);
        }

        $destinationPath = 'avatar/' . Auth::user()->id . '/';

        $fileType = $file->getClientOriginalExtension();

        $filename = Auth::user()->id.'_'.time().'_'.str_random(12). '.' . $fileType;

        $file->storeAs($destinationPath, $filename);

        $imageWebpath = $this->manager->fileWebPath($destinationPath.$filename);

        $image = Image::make($imageWebpath)->fit(400)->stream();

        $this->manager->saveFile($destinationPath.$filename, $image->__toString());

        return response()->json([
                    'success' => true,
                    'avatar'  => $imageWebpath,
                    'image'   => $destinationPath.$filename
                ]);
    }

    /**
     * Crop the avatar.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cropAvatar(Request $request)
    {
        $photo   = $request->get('photo');

        $width   = (int)$request->get('w');
        $height  = (int)$request->get('h');
        $xAlign  = (int)$request->get('x');
        $yAlign  = (int)$request->get('y');

        $imageWebpath = $this->manager->fileWebPath($photo);

        $image = Image::make($imageWebpath)->crop($width, $height, $xAlign, $yAlign)->stream();

        $this->manager->saveFile($photo, $image->__toString());

        $this->user->saveAvatar(Auth::user()->id, $imageWebpath);

        return redirect('/user/profile');
    }

}
