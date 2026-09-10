<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CloudinaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CloudinaryUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'file' => ['required', 'file', 'image', 'max:10240'],
            'folder' => ['nullable', 'string', 'max:120'],
        ]);

        $file = $data['file'];

        $result = app(CloudinaryService::class)->upload(
            $file->getRealPath(),
            $data['folder'] ?? 'sena-studio/projects',
        );

        return response()->json([
            'url' => data_get($result, 'secure_url'),
            'public_id' => data_get($result, 'public_id'),
        ]);
    }
}
