<?php

it('injects the configured analytics script into the public layout', function () {
    config()->set('services.analytics.script', '<script defer data-domain="example.test" src="https://analytics.example/script.js"></script>');

    $this->get('/en')
        ->assertSuccessful()
        ->assertSee('<script defer data-domain="example.test" src="https://analytics.example/script.js"></script>', escape: false);
});
