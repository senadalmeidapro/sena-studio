<?php

namespace App\Support;

class Activity
{
    public static function color(string $action): string
    {
        return match (true) {
            str_contains($action, 'create') => '#059669',
            str_contains($action, 'update') => '#2563eb',
            str_contains($action, 'delete') => '#dc2626',
            str_contains($action, 'publish') => '#7c3aed',
            str_contains($action, 'login') => '#0d9488',
            default => '#64748b',
        };
    }

    public static function icon(string $action): string
    {
        return match (true) {
            str_contains($action, 'create') => 'heroicon-m-plus',
            str_contains($action, 'delete') => 'heroicon-m-trash',
            str_contains($action, 'delete-bulk') => 'heroicon-m-x-circle',
            str_contains($action, 'update') => 'heroicon-m-check',
            str_contains($action, 'publish'), str_contains($action, 'unpublish') => 'heroicon-m-check-badge',
            str_contains($action, 'login') => 'heroicon-m-key',
            default => 'heroicon-m-bolt',
        };
    }
}
