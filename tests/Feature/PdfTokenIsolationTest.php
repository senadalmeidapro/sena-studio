<?php

use Illuminate\Support\Facades\File;

it('keeps semantic browser color tokens out of PDF views', function () {
    $pdfViews = File::allFiles(resource_path('views/pdf'));

    expect($pdfViews)->not->toBeEmpty();

    foreach ($pdfViews as $view) {
        expect($view->getContents())
            ->not->toMatch('/var\(\s*--/i', $view->getRelativePathname());
    }
});
