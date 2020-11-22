<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('clarkwinkelmann_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('clarkwinkelmann_interests');
    },
];
