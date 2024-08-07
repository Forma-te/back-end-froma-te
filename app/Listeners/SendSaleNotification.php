<?php

namespace App\Listeners;

use App\Events\SaleToNewAndOldMembers;
use App\Mail\SendMailSaleToNewMembers;
use App\Mail\SendMailSaleToOldMembers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSaleNotification implements ShouldQueue
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
    public function handle(SaleToNewAndOldMembers $event): void
    {
        if ($event->password) {
            Mail::to($event->member->email)->send(new SendMailSaleToNewMembers($event->member, $event->course, $event->password, $event->bankUsers));
        } else {
            Mail::to($event->member->email)->send(new SendMailSaleToOldMembers($event->member, $event->course, $event->bankUsers));
        }
    }
}
