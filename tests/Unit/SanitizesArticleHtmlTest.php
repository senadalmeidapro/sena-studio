<?php

use App\Services\SanitizesArticleHtml;

it('removes executable html while keeping article formatting', function () {
    $html = app(SanitizesArticleHtml::class)->sanitize(
        '<h2>Title</h2><p onclick="alert(1)">Safe <strong>text</strong></p><script>alert(1)</script><a href="javascript:alert(1)">link</a>',
    );

    expect($html)
        ->toContain('<h2>Title</h2>')
        ->toContain('<strong>text</strong>')
        ->not->toContain('onclick')
        ->not->toContain('<script')
        ->not->toContain('javascript:');
});
