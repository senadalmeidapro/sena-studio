<?php

use App\Models\User;
use App\Services\CloudinaryService;
use Illuminate\Http\UploadedFile;

function tinyPng(): UploadedFile
{
    return UploadedFile::fake()
        ->createWithContent(
            'demo.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='),
        )
        ->mimeType('image/png');
}

it('returns the Cloudinary URL and public id after a successful admin upload', function () {
    $user = User::factory()->create();

    $service = Mockery::mock(CloudinaryService::class);
    $service
        ->shouldReceive('upload')
        ->once()
        ->andReturn([
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/sena-studio/projects/demo.webp',
            'public_id' => 'sena-studio/projects/demo',
        ]);

    app()->instance(CloudinaryService::class, $service);

    $response = $this->actingAs($user)->post(route('admin.cloudinary.upload'), [
        'file' => tinyPng(),
        'folder' => 'sena-studio/projects',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'url' => 'https://res.cloudinary.com/demo/image/upload/v1/sena-studio/projects/demo.webp',
            'public_id' => 'sena-studio/projects/demo',
        ]);
});

it('rejects unsupported upload formats before calling Cloudinary', function () {
    $user = User::factory()->create();

    $service = Mockery::mock(CloudinaryService::class);
    $service->shouldNotReceive('upload');
    app()->instance(CloudinaryService::class, $service);

    $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->post(route('admin.cloudinary.upload'), [
            'file' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
            'folder' => 'sena-studio/projects',
        ])
        ->assertUnprocessable();
});

it('returns a gateway error when Cloudinary fails', function () {
    $user = User::factory()->create();

    $service = Mockery::mock(CloudinaryService::class);
    $service
        ->shouldReceive('upload')
        ->once()
        ->andThrow(new RuntimeException('Cloudinary unavailable'));

    app()->instance(CloudinaryService::class, $service);

    $this->actingAs($user)
        ->post(route('admin.cloudinary.upload'), [
            'file' => tinyPng(),
            'folder' => 'sena-studio/projects',
        ])
        ->assertStatus(502)
        ->assertJson([
            'message' => 'Cloudinary unavailable',
        ]);
});

it('rejects invalid Cloudinary folder names', function () {
    $user = User::factory()->create();

    $service = Mockery::mock(CloudinaryService::class);
    $service->shouldNotReceive('upload');
    app()->instance(CloudinaryService::class, $service);

    $this->actingAs($user)
        ->withHeaders(['Accept' => 'application/json'])
        ->post(route('admin.cloudinary.upload'), [
            'file' => tinyPng(),
            'folder' => '../private',
        ])
        ->assertUnprocessable();
});
