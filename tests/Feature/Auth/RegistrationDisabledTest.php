<?php

it('does not expose a public registration route', function () {
    $this->get('/register')->assertNotFound();
    $this->post('/register')->assertStatus(405);
});
