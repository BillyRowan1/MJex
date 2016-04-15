<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function getIndex()
    {
        return view('contact');
    }

    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required',
        ]);

        $user['name'] = $request->input('name');
        $user['email'] = $request->input('email');
        $user['subject'] = $request->input('subject','User contact from Mjex website');
        $user['message'] = $request->input('message');
        $user['phone'] = $request->input('phone','');

        Mail::send('emails.contact', ['user' => $user], function ($m) use ($user) {
            $m->to(config('mail.contact'))->subject('Contact from Mjex:' . $user['subject']);
        });

        return redirect()->back()->with('message','Message sent. Thank you for contacting us');
    }
}
