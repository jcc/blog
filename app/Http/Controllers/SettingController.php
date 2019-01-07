<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
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
     *
     * @return Redirect
     */
    public function setNotification(Request $request)
    {
        $input = [
            'email_notify_enabled' => $request->get('email_notify_enabled') ? 'yes' : 'no',
        ];

        User::query()->where('id', \Auth::id())->update($input);

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
