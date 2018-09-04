<?php
return [
    'global'   => true,
    'prefix'   => env('CSRF_PREFIX', 'csrf'),
    'strength' => env('CSRF_STRENGTH', 16),
];
