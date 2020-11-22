<?php

namespace ClarkWinkelmann\Interests\Providers;

use ClarkWinkelmann\Interests\Serializers\InterestSerializer;
use Flarum\Api\Event\WillGetData;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Event\GetApiRelationship;
use Flarum\Foundation\AbstractServiceProvider;

class UserAttributes extends AbstractServiceProvider
{
    public function register()
    {
        $this->app['events']->listen(GetApiRelationship::class, [$this, 'getApiRelationship']);
        $this->app['events']->listen(WillGetData::class, [$this, 'willGetData']);
    }

    public function getApiRelationship(GetApiRelationship $event)
    {
        if ($event->isRelationship(BasicUserSerializer::class, 'interests')) {
            return $event->serializer->hasMany($event->model, InterestSerializer::class, 'interests');
        }
    }

    public function willGetData(WillGetData $event)
    {
        // Handle all controllers with user included, like ShowDiscussion, ShowPost
        if (in_array('user.groups', $event->controller->include)) {
            $event->addInclude('user.interests');
        }

        // Handle all controllers for user resources, like ShowUser
        if (in_array('groups', $event->controller->include)) {
            $event->addInclude('interests');
        }
    }
}
