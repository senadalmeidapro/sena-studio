<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    protected const BOT_PATTERNS = [
        'bot',
        'crawler',
        'spider',
        'slurp',
        'curl',
        'perl',
        'python-requests',
        'headlesschrome',
        'semrush',
        'ahrefs',
        'petalbot',
        'bytespider',
        'gptbot',
        'ccbot',
        'bingpreview',
        'facebookexternalhit',
        'whatsapp',
        'telegrambot',
        'linkedinbot',
        'applebot',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $response->isSuccessful()) {
            return $response;
        }

        if ($request->method() !== 'GET') {
            return $response;
        }

        if ($request->headers->has('X-Livewire')) {
            return $response;
        }

        $path = '/'.trim($request->path(), '/');

        if ($path === '/') {
            return $response;
        }

        if ($this->isExcluded($path)) {
            return $response;
        }

        $userAgent = (string) $request->userAgent();
        $ip = (string) $request->ip();

        PageView::create([
            'path' => $path,
            'route_name' => $request->route()?->getName(),
            'locale' => $request->route('locale') ?? app()->getLocale(),
            'referer' => mb_substr((string) $request->headers->get('referer'), 0, 512) ?: null,
            'user_agent' => mb_substr($userAgent, 0, 512) ?: null,
            'ip_hash' => hash('sha256', $ip.'|'.$userAgent),
            'is_bot' => $this->isBot($userAgent),
            'created_at' => now(),
        ]);

        return $response;
    }

    protected function isExcluded(string $path): bool
    {
        if (str_starts_with($path, '/admin')) {
            return true;
        }

        if (str_starts_with($path, '/livewire') || str_starts_with($path, '/vendor') || str_starts_with($path, '/build')) {
            return true;
        }

        if ($path === '/up' || $path === '/robots.txt' || $path === '/sitemap.xml' || $path === '/_debugbar') {
            return true;
        }

        if (str_ends_with($path, '.css') || str_ends_with($path, '.js') || str_ends_with($path, '.png') || str_ends_with($path, '.jpg') || str_ends_with($path, '.jpeg') || str_ends_with($path, '.svg') || str_ends_with($path, '.ico') || str_ends_with($path, '.woff') || str_ends_with($path, '.woff2') || str_ends_with($path, '.pdf')) {
            return true;
        }

        return false;
    }

    protected function isBot(string $userAgent): bool
    {
        if ($userAgent === '') {
            return false;
        }

        $agent = strtolower($userAgent);

        foreach (self::BOT_PATTERNS as $pattern) {
            if (str_contains($agent, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
