<?php

namespace ClarkWinkelmann\Interests;

use Flarum\Database\AbstractModel;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $icon
 */
class Interest extends AbstractModel
{
    protected $table = 'clarkwinkelmann_interests';
}
