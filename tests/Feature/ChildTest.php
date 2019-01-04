<?php

namespace Tests\Feature;

use App\Child;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChildTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function can_create_a_new_child()
    {
        $this->withoutExceptionHandling();

        $child = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName
        ];

        $this->post('/children', $child)->assertRedirect('/children');

        $this->assertDatabaseHas('children', $child);

        $this->get('/children')->assertSee($child['first_name']);
    }

    /** @test */
    public function has_error_when_no_first_name_is_given()
    {
        $child = [
            'last_name' => $this->faker->lastName
        ];

        $response = $this->post('/children', $child);

        $response->assertSessionHasErrors();
    }

}
