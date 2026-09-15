<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class CloudinaryUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $data = $request->validate([
            'file' => ['required', 'file', 'image', 'max:10240'],
            'folder' => ['nullable', 'string', 'max:120'],
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
