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

    'date' => 'Do MMMM, YYYY',
    'date_time' => 'Y-m-d H:i:s',
    'time' => 'h:i A',

];
?>