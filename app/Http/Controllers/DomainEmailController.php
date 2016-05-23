<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mail;
use Log;

class DomainEmailController extends Controller
{

    public function postForward(Request $request) {
        $subject = $request->input('subject');
        $recipient = $request->input('recipient');
        $from = $request->input('from');
        $body = $request->input('body-html');

        if($recipient) {
            $actualRecipient = explode('@', $recipient)[0];
            $user = User::where('community_name', $actualRecipient)->first();

            if($user) {
                Mail::send('emails.mailgun', ['body' => $body], function ($m) use ($user, $from, $recipient, $subject) {
                    $m->from($from);

                    $m->to($user->email)->subject($subject);
                });

                Log::info('Forwarded email from Mailgun to '. $user->email);
            }
        }

    }
}
