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
        
        foreach($users as $user){
            Mail::send([], [], function ($message) use ($request, $user) {
                $message->to($user->email)
                ->subject($request['subject'])
                ->setBody($request['body']);
            });
        }        foreach($managers as $manager){
            Mail::send([], [], function ($message) use ($request, $manager) {
                $message->to($manager->email)
                ->subject($request['subject'])
                ->setBody($request['body']);
            });
        }        foreach($admins as $admin){
            Mail::send([], [], function ($message) use ($request, $admin) {
                $message->to($admin->email)
                ->subject($request['subject'])
                ->setBody($request['body']);
            });
        }
        
        return view('thanks', compact('auth'))->with('message', 'メールを送信しました。');
    }
}
