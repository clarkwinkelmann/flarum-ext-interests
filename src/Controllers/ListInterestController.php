<?php

namespace ClarkWinkelmann\Interests\Controllers;

use ClarkWinkelmann\Interests\Interest;
use ClarkWinkelmann\Interests\Serializers\InterestSerializer;
use Flarum\Api\Controller\AbstractListController;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListInterestController extends AbstractListController
{
    public $serializer = InterestSerializer::class;

    protected function data(ServerRequestInterface $request, Document $document)
    {
        return Interest::query()->orderBy('name')->get();
    }
}
