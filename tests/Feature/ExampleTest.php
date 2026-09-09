<?php

test('returns a successful response', function () {
    $response = $this->get(localized_route('home'));

    $response->assertOk();
});
