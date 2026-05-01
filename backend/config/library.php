<?php

return [
    'storage_provider' => env('LIBRARY_STORAGE_PROVIDER', 'local'),
    'upload_max_kb' => (int) env('LIBRARY_UPLOAD_MAX_KB', 204800),

    'providers' => [
        'local' => [
            'disk' => env('LIBRARY_LOCAL_DISK', 'local'),
        ],
        'google_drive' => [
            'enabled' => env('LIBRARY_GOOGLE_DRIVE_ENABLED', false),
            'folder_id' => env('LIBRARY_GOOGLE_DRIVE_FOLDER_ID'),
        ],
        'onedrive' => [
            'enabled' => env('LIBRARY_ONEDRIVE_ENABLED', false),
            'folder_id' => env('LIBRARY_ONEDRIVE_FOLDER_ID'),
        ],
    ],
];
