<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChildTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_must_login_to_view_children()
    {
        $response = $this->get('/children');

        $response->assertRedirect('/login');
    }
}
