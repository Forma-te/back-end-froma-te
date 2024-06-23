<?php

namespace App\Listeners;

use App\Events\SupportReplied;
use App\Mail\SendMailSupportReplied as MailSendMailSupportReplied;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailSupportReplied implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SupportReplied $event): void
    {
        $replySupport = $event -> getReplySupport();
        $support = $replySupport->support;
        $user = $support->user;

        Mail::to($user->email)
                    ->send(new MailSendMailSupportReplied($replySupport, $user));
    }
}
