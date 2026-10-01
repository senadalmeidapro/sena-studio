<?php

function relativeLuminance(string $hex): float
{
    $rgb = array_map(
        static fn (string $channel): float => hexdec($channel) / 255,
        str_split(ltrim($hex, '#'), 2),
    );

    $linear = array_map(
        static fn (float $channel): float => $channel <= 0.04045
            ? $channel / 12.92
            : (($channel + 0.055) / 1.055) ** 2.4,
        $rgb,
    );

    return (0.2126 * $linear[0]) + (0.7152 * $linear[1]) + (0.0722 * $linear[2]);
}

function contrastRatio(string $foreground, string $background): float
{
    $luminances = [relativeLuminance($foreground), relativeLuminance($background)];
    sort($luminances);

    return ($luminances[1] + 0.05) / ($luminances[0] + 0.05);
}

it('keeps requested text color pairs at WCAG AA contrast in both themes', function () {
    $palettes = [
        'light' => [
            'bg' => '#F6F8FB', 'surface' => '#FFFFFF', 'surface-muted' => '#EEF2F7',
            'text' => '#172033', 'text-muted' => '#5B6779', 'accent' => '#3A6ED4',
            'on-accent' => '#FFFFFF', 'success' => '#2F7D5B', 'warning' => '#A15C07',
            'danger' => '#B42318',
        ],
        'dark' => [
            'bg' => '#0F1420', 'surface' => '#161C2B', 'surface-muted' => '#1D2536',
            'text' => '#E6EAF2', 'text-muted' => '#9AA6BA', 'accent' => '#7FA6F0',
            'on-accent' => '#0F1420', 'success' => '#5CC49A', 'warning' => '#E5B85C',
            'danger' => '#F08A7E',
        ],
    ];

    $pairs = [
        'text on bg' => ['text', 'bg'],
        'text on surface' => ['text', 'surface'],
        'muted text on bg' => ['text-muted', 'bg'],
        'muted text on surface' => ['text-muted', 'surface'],
        'muted text on muted surface' => ['text-muted', 'surface-muted'],
        'on-accent on accent' => ['on-accent', 'accent'],
        'accent on bg' => ['accent', 'bg'],
        'accent on surface' => ['accent', 'surface'],
        'success on surface' => ['success', 'surface'],
        'warning on surface' => ['warning', 'surface'],
        'danger on surface' => ['danger', 'surface'],
    ];

    foreach ($palettes as $theme => $palette) {
        foreach ($pairs as $label => [$foreground, $background]) {
            $ratio = contrastRatio($palette[$foreground], $palette[$background]);

            expect($ratio)->toBeGreaterThanOrEqual(4.5, "{$theme}: {$label} is {$ratio}:1");
        }
    }
});
