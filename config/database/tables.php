<?php
return [
    'users' => [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ],
    'people' => [
        'user_id',
        'last_name',
        'username',
    ],
    'images' => [
        'name',
        'path',
        'person_id',
        'user_id',
        'upload_time',
        'update_time',
        'remove_time',
    ],
    'langs' => [
        'language',
        'abbreviation',
    ]
];
