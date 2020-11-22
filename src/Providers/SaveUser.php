<?php

namespace ClarkWinkelmann\Interests\Providers;

use Flarum\Foundation\AbstractServiceProvider;
use Flarum\User\Event\Saving;
use Flarum\User\User;
use Illuminate\Support\Arr;

class SaveUser extends AbstractServiceProvider
{
    public function register()
    {
        $this->app['events']->listen(Saving::class, [$this, 'saving']);
    }

    public function saving(Saving $event)
    {
        $interests = Arr::get($event->data, 'relationships.interests.data');

        if (is_array($interests)) {
            // TODO: check the actor is allowed to edit that user

            $interestIds = [];

            foreach ($interests as $interest) {
                // TODO: check the ID exists
                $interestIds[] = Arr::get($interest, 'id');
            }

            $event->user->afterSave(function (User $user) use ($interestIds) {
                $user->interests()->sync($interestIds);
            });
        }
    }
}
