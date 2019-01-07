<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.crontab',['name'=>$this->user->name],function($message){
            $message->to($this->user->email)->subject('测试邮件');
        });
        if(count(Mail::failures())<1){
            Log::info('发送给：'.$this->user->name.'的邮件,已发送成功！');
        }else{
            Log::info('发送给：'.$this->user->name.'的邮件,已发送失败！');
        }
    }
}
