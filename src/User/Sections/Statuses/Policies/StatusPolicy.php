<?php
namespace AwemaPL\Task\User\Sections\Statuses\Policies;

use AwemaPL\Task\User\Sections\Statuses\Models\Status;
use Illuminate\Foundation\Auth\User;

class StatusPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User $user
     * @param  Status $status
     * @return bool
     */
    public function isOwner(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }


}
