<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3000',
        'http://26.155.91.192:3000',
        'https://votaciones-ivory.vercel.app',
        'https://votaciones-git-master-urommels-projects.vercel.app',
        'https://votaciones-708621156652.us-central1.run.app',
        'http://localhost:4200',
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
