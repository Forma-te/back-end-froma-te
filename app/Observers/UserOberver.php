<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserOberver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $user->id = Str::uuid(); 
    }

   
}
