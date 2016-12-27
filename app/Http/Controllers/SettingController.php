<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class SettingController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display the current user setting list.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting.index');
    }

    /**
     * Display the notification page for setting.
     * 
     * @return \Illuminate\Http\Response
     */
    public function notification()
    {
        return view('setting.notification');
    }

    /**
     * Set the email notification.
     * 
     * @param Request $request [description]
     * @return  Redirect
     */
    public function setNotification(Request $request)
    {
        $input = [
            'email_notify_enabled' => $request->get('email_notify_enabled') ? 'yes' : 'no'
        ];

        $this->user->update(\Auth::id(), $input);

        return redirect()->back();
    }

    /**
     * Display the bindings page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function binding()
    {
        return view('setting.binding');
    }
}
