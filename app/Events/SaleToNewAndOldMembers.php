<?php

namespace App\Events;

use App\Models\Course;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaleToNewAndOldMembers
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $member;
    public $course;
    public $password;
    public $bankUsers;

    /**
     * Create a new event instance.
     */
    public function __construct(User $member, Course $course, $password, $bankUsers)
    {
        $this->member = $member;
        $this->course = $course;
        $this->password = $password;
        $this->bankUsers = $bankUsers;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
