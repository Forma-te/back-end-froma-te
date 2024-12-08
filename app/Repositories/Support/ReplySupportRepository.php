<?php

namespace App\Repositories\Support;

use App\Events\SupportReplied;
use App\Models\ReplySupport;
use App\Models\Support;
use App\Repositories\Traits\RepositoryTrait;

class ReplySupportRepository implements ReplySupportRepositoryInterface
{
    use RepositoryTrait;

    protected $entity;

    public function __construct(ReplySupport $model)
    {
        $this->entity = $model;
    }

    public function createReplyToSupport(array $data)
    {
        $user = $this->getUserAuth();

        $replySupport = $this->entity
                            ->create([
                            'support_id' => $data['support_id'],
                            'description' => $data['description'],
                            'producer_id' => $user->id,
    ]);

        event(new SupportReplied($replySupport));

        $support = Support::findOrFail($data['support_id']);
        $support->status = 'A';
        $support->save();

        return $replySupport;
    }

}
