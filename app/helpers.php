<?php

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Model;

if (! function_exists('localized_route')) {
    /**
     * Génère une URL de route en injectant la locale courante en préfixe.
     */
    function localized_route(string $name, array|string|Model $parameters = [], bool $absolute = true): string
    {
        $params = is_array($parameters) ? $parameters : [$parameters];

        /** @var UrlGenerator $url */
        $url = app('url');

        return $url->route($name, ['locale' => app()->getLocale()] + $params, $absolute);
    }
}

if (! function_exists('alt_locale_url')) {
    /**
     * URL de la même page dans l'autre langue.
     */
    function alt_locale_url(string $name, array $parameters = []): string
    {
        $target = app()->getLocale() === 'fr' ? 'en' : 'fr';

        /** @var UrlGenerator $url */
        $url = app('url');

        return $url->route($name, ['locale' => $target] + $parameters);
    }
}

if (! function_exists('alt_locale_path')) {
    /**
     * Chemin de la page courante dans l'autre langue (par URL).
     */
    function alt_locale_path(): string
    {
        $segments = collect(explode('/', trim(request()->path(), '/')))->filter()->values();

        if (in_array($segments->first(), ['fr', 'en'], true)) {
            $segments->shift();
        }

        $target = app()->getLocale() === 'fr' ? 'en' : 'fr';
        $tail = $segments->isEmpty() ? '' : '/'.$segments->implode('/');

        return '/'.$target.$tail;
    }
}

if (! function_exists('current_locale')) {
    function current_locale(): string
    {
        return app()->getLocale() === 'en' ? 'en' : 'fr';
    }
}
