<?php

namespace App\Listeners;

use App\Events\ValidateOrCreateCustomer;
use App\Mail\SendMailSaleToNewMembers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendValidateUserNotification implements ShouldQueue
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
    public function handle(ValidateOrCreateCustomer $event): void
    {
        Mail::to($event->member->email)->send(new SendMailSaleToNewMembers($event->member, $event->password));
    }
}
