<?php

namespace ClarkWinkelmann\Interests;

use Flarum\Extend;
use Flarum\Foundation\Application;
use Flarum\User\User;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/resources/locale'),

    (new Extend\Routes('api'))
        ->get('/interests', 'clarkwinkelmann-interests.index', Controllers\ListInterestController::class),

    (new Extend\Model(User::class))
        ->belongsToMany('interests', Interest::class, 'clarkwinkelmann_interest_user'),

    function (Application $app, Dispatcher $events) {
        $app->register(Providers\SaveUser::class);
        $app->register(Providers\UserAttributes::class);

        $events->subscribe(Policies\UserPolicy::class);
    },
];
