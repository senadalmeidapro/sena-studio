<?php

it('does not expose a public registration route', function () {
    $this->get('/register')->assertNotFound();
    $this->post('/register')->assertStatus(405);
});

it('does not show a sign-up link on the login page', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertDontSee("Don't have an account?")
        ->assertDontSee('Sign up')
        ->assertDontSee('register');
});
