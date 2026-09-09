<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected const SUPPORTED = ['fr', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale') ?? session('locale', 'fr');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = 'fr';
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        if ($request->route('locale') === null && $request->route()?->getName() === 'home') {
            return redirect()->route('home', ['locale' => $locale]);
        }

        return $next($request);
    }
}
