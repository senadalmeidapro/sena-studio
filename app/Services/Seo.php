<?php

namespace App\Services;

class Seo
{
    protected string $title = '';

    protected string $description = '';

    protected ?string $canonical = null;

    protected string $type = 'website';

    protected string $image = '/images/brand/sena-mark.svg';

    public function set(
        ?string $title = null,
        ?string $description = null,
        ?string $canonical = null,
        string $type = 'website',
        ?string $image = null,
    ): static {
        $this->title = $title ?? $this->title;
        $this->description = $description ?? $this->description;
        $this->canonical = $canonical ?? $this->canonical;
        $this->type = $type;
        $this->image = $image ?? $this->image;

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
            : (config('app.description') ?: config('app.name').' — développement web, applications et solutions sur mesure.');
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
}
