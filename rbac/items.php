<?php

return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'issue-book' => [
        'type' => 2,
    ],
    'return-book' => [
        'type' => 2,
    ],
    'add-book' => [
        'type' => 2,
    ],
    'delete-book' => [
        'type' => 2,
    ],
    'add-employee' => [
        'type' => 2,
    ],
    'delete-employee' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'children' => [
            'login',
            'error',
            'index',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'ruleName' => 'administrator',
        'children' => [
            'issue-book',
            'return-book',
            'add-book',
            'delete-book',
            'logout',
            'guest',
        ],
    ],
    'manager' => [
        'type' => 1,
        'ruleName' => 'manager',
        'children' => [
            'add-employee',
            'delete-employee',
            'administrator',
            'guest',
        ],
    ],
];
