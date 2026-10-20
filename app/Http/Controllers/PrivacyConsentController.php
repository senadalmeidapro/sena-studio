<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PrivacyConsentController
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'consent_id' => ['required', 'uuid'],
            'provider' => ['required', 'string', 'max:120', Rule::in([config('services.analytics.provider')])],
            'choice' => ['required', Rule::in(['granted', 'denied'])],
            'policy_version' => ['required', 'string', Rule::in(['v1'])],
        ]);

        DB::table('privacy_consents')->insert([
            'consent_id' => $data['consent_id'],
            'provider' => $data['provider'],
            'choice' => $data['choice'],
            'policy_version' => $data['policy_version'],
            'created_at' => now(),
        ]);

        return response()->json(['recorded' => true], 201);
    }
}
