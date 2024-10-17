<?php

namespace App\Events;

use App\Models\Product;
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
    public $product;
    public $password;
    public $bankUsers;

    /**
     * Create a new event instance.
     */
    public function __construct(User $member, Product $product, $password, $bankUsers)
    {
        $this->member = $member;
        $this->product = $product;
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
