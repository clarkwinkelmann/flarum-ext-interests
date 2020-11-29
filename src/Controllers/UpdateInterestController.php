<?php

namespace ClarkWinkelmann\Interests\Controllers;

use ClarkWinkelmann\Interests\Interest;
use ClarkWinkelmann\Interests\Serializers\InterestSerializer;
use ClarkWinkelmann\Interests\Validator\InterestValidator;
use Flarum\Api\Controller\AbstractShowController;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateInterestController extends AbstractShowController
{
    public $serializer = InterestSerializer::class;

    protected $validator;

    public function __construct(InterestValidator $validator)
    {
        $this->validator = $validator;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $request->getAttribute('actor')->assertAdmin();

        $attributes = Arr::get($request->getParsedBody(), 'data.attributes');

        $this->validator->assertValid($attributes);

        /**
         * @var $interest Interest
         */
        $interest = Interest::query()->findOrFail(Arr::get($request->getQueryParams(), 'id'));

        $interest->name = Arr::get($attributes, 'name') ?: '';
        $interest->color = Arr::get($attributes, 'color') ?: null;
        $interest->icon = Arr::get($attributes, 'icon') ?: null;
        $interest->save();

        return $interest;
    }
}
