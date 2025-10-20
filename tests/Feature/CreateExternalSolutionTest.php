<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateExternalSolutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('external-solutions.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New External Solution');
    }

    public function test_store_creates_record_and_redirects()
    {
        $user = User::factory()->create();

        $payload = [
            'application_name' => 'Test App',
            'company_customer' => 'Test Co',
        ];

        $response = $this->actingAs($user)->post(route('external-solutions.store'), $payload);

        $response->assertRedirect(route('external-solutions.index', ['status' => 'operational']));
        $this->assertDatabaseHas('external_solutions', ['application_name' => 'Test App']);
    }
}
