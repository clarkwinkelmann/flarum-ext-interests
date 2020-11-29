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
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/resources/less/admin.less'),

    new Extend\Locales(__DIR__ . '/resources/locale'),

    (new Extend\Routes('api'))
        ->get('/interests', 'clarkwinkelmann-interests.index', Controllers\ListInterestController::class)
        ->post('/interests', 'clarkwinkelmann-interests.store', Controllers\StoreInterestController::class)
        ->patch('/interests/{id:[0-9]+}', 'clarkwinkelmann-interests.update', Controllers\UpdateInterestController::class)
        ->delete('/interests/{id:[0-9]+}', 'clarkwinkelmann-interests.delete', Controllers\DeleteInterestController::class),

    (new Extend\Model(User::class))
        ->belongsToMany('interests', Interest::class, 'clarkwinkelmann_interest_user'),

    function (Application $app, Dispatcher $events) {
        $app->register(Providers\SaveUser::class);
        $app->register(Providers\UserAttributes::class);

        $events->subscribe(Policies\UserPolicy::class);
    },
];
