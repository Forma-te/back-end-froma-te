<?php

namespace App\Listeners;

use App\Events\ActivateInstructor;
use App\Mail\SendMailActivateInstructor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailActiveInstructor implements ShouldQueue
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
    public function handle(ActivateInstructor $event): void
    {
        $salePlan = $event->getSalePlan();
        $user =  $salePlan->producer;
        Mail::to($user->email)->send(new SendMailActivateInstructor($salePlan));

    }
}
