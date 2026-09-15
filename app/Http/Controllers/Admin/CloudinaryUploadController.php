<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;

class CloudinaryUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $rateLimitKey = 'cloudinary-upload:'.$request->user()->getAuthIdentifier();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 30)) {
            return response()->json([
                'message' => 'Too many uploads. Please try again later.',
            ], 429);
        }

        RateLimiter::hit($rateLimitKey, 600);

        $data = $request->validate([
            'file' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp,avif',
                'dimensions:max_width=8000,max_height=8000',
                'max:10240',
            ],
            'folder' => [
                'nullable',
                'string',
                'max:120',
                'regex:/^[A-Za-z0-9][A-Za-z0-9\\/_-]{0,119}$/',
            ],
        ]);

        $file = $data['file'];

        try {
            $result = app(CloudinaryService::class)->upload(
                $file->getRealPath(),
                $data['folder'] ?? 'sena-studio/projects',
            );
        } catch (Throwable $exception) {
            Log::error('Cloudinary upload failed.', [
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
                'folder' => $data['folder'] ?? 'sena-studio/projects',
                'user_id' => $request->user()?->getAuthIdentifier(),
            ]);

            return response()->json([
                'message' => app()->isProduction()
                    ? 'Cloudinary upload failed. Check the server configuration and logs.'
                    : $exception->getMessage(),
            ], 502);
        }

        if (blank(data_get($result, 'secure_url')) || blank(data_get($result, 'public_id'))) {
            Log::error('Cloudinary returned an incomplete upload response.', [
                'folder' => $data['folder'] ?? 'sena-studio/projects',
                'user_id' => $request->user()?->getAuthIdentifier(),
            ]);

            return response()->json([
                'message' => 'Cloudinary returned an incomplete upload response.',
            ], 502);
        }

        return response()->json([
            'url' => data_get($result, 'secure_url'),
            'public_id' => data_get($result, 'public_id'),
        ]);
    }
}
