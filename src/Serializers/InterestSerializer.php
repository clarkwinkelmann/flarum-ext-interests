<?php

namespace ClarkWinkelmann\Interests\Serializers;

use ClarkWinkelmann\Interests\Interest;
use Flarum\Api\Serializer\AbstractSerializer;

class InterestSerializer extends AbstractSerializer
{
    protected $type = 'clarkwinkelmann-interests';

    /**
     * @param Interest $model
     * @return array
     */
    protected function getDefaultAttributes($model)
    {
        return [
            'name' => $model->name,
            'color' => $model->color,
            'icon' => $model->icon,
        ];
    }
}
