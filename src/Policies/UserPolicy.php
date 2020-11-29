<?php

namespace ClarkWinkelmann\Interests\Policies;

use Flarum\User\AbstractPolicy;
use Flarum\User\User;

class UserPolicy extends AbstractPolicy
{
    protected $model = User::class;

    public function editInterests(User $actor, User $user)
    {
        if ($actor->hasPermission('clarkwinkelmann-interests.editAny')) {
            return true;
        }

        return $actor->id === $user->id && $actor->hasPermission('clarkwinkelmann-interests.editOwn');
    }
}
