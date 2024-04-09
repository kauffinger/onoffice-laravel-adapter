<?php

declare(strict_types=1);

return [
    'token' => env('ON_OFFICE_TOKEN'),
    'secret' => env('ON_OFFICE_SECRET'),
    'base_url' => env('ON_OFFICE_BASE_URL', 'https://api.onoffice.de/api/stable/api.php'),
];
