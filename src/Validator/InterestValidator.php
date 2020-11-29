<?php

namespace ClarkWinkelmann\Interests\Validator;

use Flarum\Foundation\AbstractValidator;

class InterestValidator extends AbstractValidator
{
    protected $rules = [
        'name' => 'required|string|max:255',
        'color' => 'nullable|string|max:255',
        'icon' => 'nullable|string|max:255',
    ];
}
