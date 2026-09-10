<?php

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class CloudinaryUpload extends Field
{
    protected string $view = 'filament.components.cloudinary-upload';

    protected string|Closure|null $folder = null;

    protected string|Closure|null $publicIdStatePath = null;

    public function folder(string|Closure|null $folder): static
    {
        $this->folder = $folder;

        return $this;
    }

    public function publicIdStatePath(string|Closure|null $path): static
    {
        $this->publicIdStatePath = $path;

        return $this;
    }

    public function getFolder(): string
    {
        return $this->evaluate($this->folder) ?? 'sena-studio/projects';
    }

    public function getPublicIdStatePath(): ?string
    {
        return $this->evaluate($this->publicIdStatePath);
    }

    public function getUploadUrl(): string
    {
        return url('/admin/cloudinary/upload');
    }

    public function getBaseUrl(): string
    {
        return url('/');
    }

    public function getXData(): string
    {
        $state = json_encode($this->getStatePath(), JSON_UNESCAPED_SLASHES);
        $publicId = $this->getPublicIdStatePath()
            ? '$wire.$entangle('.json_encode($this->getPublicIdStatePath(), JSON_UNESCAPED_SLASHES).')'
            : 'null';

        return '{'
            ."state: \$wire.\$entangle({$state}),"
            ."publicIdState: {$publicId},"
            .'uploadUrl: '.json_encode($this->getUploadUrl()).','
            .'csrf: '.json_encode(csrf_token()).','
            .'folder: '.json_encode($this->getFolder()).','
            .'base: '.json_encode($this->getBaseUrl())
            .'}';
    }
}
