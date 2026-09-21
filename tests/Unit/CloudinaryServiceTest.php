<?php

use App\Services\CloudinaryService;

it('extracts the Cloudinary public id from delivered image formats', function (string $extension) {
    $url = "https://res.cloudinary.com/demo/image/upload/v123456/sena-studio/projects/demo.{$extension}.{$extension}";

    expect(app(CloudinaryService::class)->publicIdFromUrl($url))
        ->toBe("sena-studio/projects/demo.{$extension}");
})->with(['png', 'jpg', 'jpeg', 'webp', 'svg']);

it('keeps a logical Cloudinary path unchanged when it is not an URL', function () {
    expect(app(CloudinaryService::class)->publicIdFromUrl('sena-studio/projects/demo.jpeg'))
        ->toBe('sena-studio/projects/demo.jpeg');
});

it('ignores delivery transformations when extracting the public id', function () {
    $url = 'https://res.cloudinary.com/demo/image/upload/f_auto,q_auto,w_960/v123456/sena-studio/projects/demo.png.png';

    expect(app(CloudinaryService::class)->publicIdFromUrl($url))
        ->toBe('sena-studio/projects/demo.png');
});

it('adds Cloudinary delivery optimizations only to Cloudinary image URLs', function () {
    expect(media_url(
        'https://res.cloudinary.com/demo/image/upload/v123/sena-studio/projects/demo.jpeg.jpeg',
        'f_auto,q_auto,w_960',
    ))
        ->toContain('/image/upload/f_auto,q_auto,w_960/v123/');

    expect(media_url('https://example.com/image.jpeg', 'f_auto,q_auto,w_960'))
        ->toBe('https://example.com/image.jpeg');
});
