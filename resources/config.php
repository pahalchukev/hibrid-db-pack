<?php

return [
    'execute_migrations' => env('HIBRID_VOD_DATABASE_EXECUTE_MIGRATIONS', false),

    'connection_name' => env('HIBRID_VOD_DATABASE_CONNECTION', 'system'),

    'attributes' => [
        // a list of virtual attributes that must to be added for each JSON response
        'appends' => [
            \HibridVod\Database\Models\User\User::class => [
                'full_name',
            ]
            // \Illuminate\Database\Eloquent\Model::class => [
            //    'attribute'
            // ]
        ],
        // a list of hidden attribute per model
        'hidden'  => [
            // \Illuminate\Database\Eloquent\Model::class => [
            //    'column'
            // ]
        ],
    ],
    'relations'  => [
        // a list of relations that must to be added for each `find` query
        'include' => [
            // \Illuminate\Database\Eloquent\Model::class => [
            //    'relation'
            // ]
        ],
    ],
];
