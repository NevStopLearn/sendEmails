<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Jobs\SendReminderEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmails()
    {
        Mail::send('emails.crontab',['name'=>'蜡笔小新'],function($message){
            $users = User::all();
            foreach($users as $user){
                $message->bcc($user->email)->subject('测试邮件！');
            }
        });
    }

    public function queueEmails()
    {
        $users = User::all();
        foreach ($users as $user){
            $this->dispatch(new SendReminderEmail($user));
        }
        dump('邮件队列任务已添加成功！');
    }
}
