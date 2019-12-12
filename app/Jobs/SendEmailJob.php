<?php

namespace App\Jobs;

use App\Mail\SendEmailToUser;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $subject;
    protected $message;
    protected $task;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param $subject
     * @param $message
     */
    public function __construct(User $user, $subject, $message, $task)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->message = $message;
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user)->send(new SendEmailToUser($this->subject, $this->message));
        $this->user->createLog($this->task);
    }
}
