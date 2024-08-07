<?php

namespace App\Listeners;

use App\Events\OrderPlanInstructor;
use App\Mail\SendMailOrderPlanInstructor as MailSendMailOrderPlanInstructor;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailOrderPlanInstructor implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlanInstructor $event): void
    {
        $saleInstructor = $event->getSaleInstructor();
        $company = $event->getCompany();
        $producer = $event->getUser();


        Mail::to($producer->email)->send(new MailSendMailOrderPlanInstructor($saleInstructor, $company, $producer));
    }
}
