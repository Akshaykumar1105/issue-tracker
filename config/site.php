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

    'date' => 'jS M Y',
    'date_time' => 'jS M Y H:i A',
    'time' => 'h:i A',

];
?>