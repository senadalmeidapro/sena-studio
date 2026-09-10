<?php

$cloudinaryUrl = env('CLOUDINARY_URL');

if (filled($cloudinaryUrl)) {
    // Format Cloudinary officiel : cloudinary://API_KEY:API_SECRET@CLOUD_NAME
    $parsed = parse_url($cloudinaryUrl);

    return [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', $parsed['host'] ?? null),
        'api_key' => env('CLOUDINARY_API_KEY', $parsed['user'] ?? null),
        'api_secret' => env('CLOUDINARY_API_SECRET', $parsed['pass'] ?? null),
    ];
}

return [
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
];
