<?php

namespace App\Observers;

use App\Models\ReplySupport;
use Illuminate\Support\Str;

class SupportObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\ReplySupport  $user
     * @return void
     */
    public function creating(ReplySupport $reply)
    {
        $reply->id = Str::uuid();
    }
}
