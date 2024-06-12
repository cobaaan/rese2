<?php

namespace App\Http\Controllers;

use Auth;

use App\Jobs\SendEmailJob;

use App\Models\Admin;
use App\Models\Manager;
use App\Models\User;

use App\Http\Requests\MailRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function mailForm(Request $request) {
        $requests = $request->all();
        unset($requests['_token']);
        $auth = Auth::user();
        
        return view('mail_form', compact('requests', 'auth'));
    }
    
    public function sendMail(MailRequest $request) {
        $auth = Auth::user();
        $admins = Admin::all();
        $managers = Manager::all();
        $users = User::all();
        
        $recipients = $admins->merge($managers)->merge($users);
        
        foreach($recipients as $recipient) {
            Mail::send([], [], function ($message) use ($request, $recipient) {
                $message->to($recipient->email)
                ->subject($request['subject'])
                ->setBody($request['body']);
            });
        }
        
        return view('thanks', compact('auth'))->with('message', 'メールを送信しました。');
    }
}
