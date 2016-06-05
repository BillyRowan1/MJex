<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mail;
use Log;
use Mjex\User;

class DomainEmailController extends Controller
{

    public function postForward(Request $request) {
        $subject = $request->input('subject');
        $recipient = $request->input('recipient');
        $from = $request->input('from');
        $body = $request->input('body-html');
        // Find user in system to make it anonymous
        $from = extract_email_address($from);
        $user = User::where('email', $from)->first();
        if($user) $from = $user->community_name . '@mjex.co';

        if($recipient) {
            $actualRecipient = explode('@', $recipient)[0];
            $user = User::where('community_name', $actualRecipient)->first();

            if($user) {
                Mail::send('emails.mailgun', ['body' => $body], function ($m) use ($user, $recipient, $subject, $from) {
                    $m->from($from);
                    $m->replyTo($from);
                    $m->to($user->email)->subject($subject);
                });

                Log::info('Forwarded email from Mailgun to '. $user->email);
            }
        }

    }
}
