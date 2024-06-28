<?php

namespace App\Events;

use App\Models\Company;
use App\Models\SaleInstructor;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlanInstructor
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public SaleInstructor $saleInstructor,
        public Company $company,
        public User $producer,
    ) {
    }

    public function getSaleInstructor(): SaleInstructor
    {
        return $this->saleInstructor;

    }

    public function getCompany(): Company
    {
        return $this->company;

    }
    public function getUser(): User
    {
        return $this->producer;
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
