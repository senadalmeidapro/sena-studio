<?php

namespace App\Services;

class Seo
{
    protected string $title = '';

    protected string $description = '';

    protected ?string $canonical = null;

    protected string $type = 'website';

    protected string $image = '/images/brand/sena-mark.svg';

    protected array $structuredData = [];

    protected string $robots = 'index, follow';

    public function set(?string $title = null, ?string $description = null, ?string $canonical = null, string $type = 'website', ?string $image = null, ?array $structuredData = null, ?string $robots = null): static
    {
        $this->title = $title ?? $this->title;
        $this->description = $description ?? $this->description;
        $this->canonical = $canonical ?? $this->canonical;
        $this->type = $type;
        $this->image = $image ?? $this->image;
        $this->structuredData = $structuredData ?? $this->structuredData;
        $this->robots = $robots ?? $this->robots;

        return $this;
    }

    public function title(?string $fallback = null): string
    {
        return $this->title !== '' ? $this->title.' — '.config('app.name') : ($fallback ?: config('app.name'));
    }

    public function description(): string
    {
        return $this->description !== ''
            ? $this->description
            : (config('app.description') ?: config('app.name').' — backend engineering, APIs and business applications.');
    }

    public function canonical(): string
    {
        return $this->canonical ?: url()->current();
    }

    public function type(): string
    {
        return $this->type;
    }

    public function image(): string
    {
        return media_url($this->image) ?? asset('/images/brand/sena-mark.svg');
    }

    public function structuredData(): array
    {
        return $this->structuredData;
    }

    public function robots(): string
    {
        return $this->robots;
    }
}
