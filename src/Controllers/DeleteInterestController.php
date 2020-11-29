<?php

namespace ClarkWinkelmann\Interests\Controllers;

use ClarkWinkelmann\Interests\Interest;
use Flarum\Api\Controller\AbstractDeleteController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class DeleteInterestController extends AbstractDeleteController
{
    protected function delete(ServerRequestInterface $request)
    {
        $request->getAttribute('actor')->assertAdmin();

        /**
         * @var $interest Interest
         */
        $interest = Interest::query()->findOrFail(Arr::get($request->getQueryParams(), 'id'));

        $interest->delete();
    }
}
