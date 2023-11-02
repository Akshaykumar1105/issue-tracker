<?php

return [

    'name' => 'Issue Tracker',
    'role' => [
        'admin' => 'admin',
        'hr' => 'hr',
        'manager' => 'manager',
    ],

    'password' => [
        'expired' => 10
    ],

    'status' =>[
        'active' => 1,
        'is_active' => 0
    ],

    'table' => [
        'admin' => 'admin',
        'hr' => 'hr',
        'manager' => 'manager'
    ],

    'discount' => [
        'flat' => 'FLAT',
        'variable' => 'VARIABLE'
    ],

    'percentage' => '%',
    'currency' => '$',

    'date' => 'jS M Y',
    'date_time' => 'jS M Y H:i A',
    'time' => 'h:i A',

    'issue_status' => [
        'open' => 'OPEN',
        'in_progress' => 'IN_PROGRESS',
        'on_hold' => 'ON_HOLD',
        'send_for_review' => 'SEND_FOR_REVIEW',
        'completed' => 'COMPLETED'
    ],
];
?>