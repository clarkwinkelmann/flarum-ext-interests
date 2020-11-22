<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->create('clarkwinkelmann_interest_user', function (Blueprint $table) {
            $table->unsignedInteger('interest_id');
            $table->unsignedInteger('user_id');

            $table->primary(['interest_id', 'user_id']);

            $table->foreign('interest_id')->references('id')->on('clarkwinkelmann_interests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    },
    'down' => function (Builder $schema) {
        $schema->dropIfExists('clarkwinkelmann_interest_user');
    },
];
