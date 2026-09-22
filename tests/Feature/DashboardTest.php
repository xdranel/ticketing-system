<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->role(UserRole::Admin)->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee($admin->name);
        $response->assertSee('admin');
        $response->assertSee(route('admin.dashboard'));
        $response->assertDontSee(route('agent.dashboard'));
    }

    public function test_agent_can_access_agent_dashboard(): void
    {
        $agent = User::factory()->role(UserRole::Agent)->create();

        $response = $this->actingAs($agent)->get(route('agent.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Agent Dashboard');
        $response->assertSee($agent->name);
        $response->assertSee('agent');
        $response->assertSee(route('agent.dashboard'));
        $response->assertDontSee(route('admin.dashboard'));
    }

    public function test_customer_can_access_customer_dashboard(): void
    {
        $customer = User::factory()->role(UserRole::Customer)->create();

        $response = $this->actingAs($customer)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Customer Dashboard');
        $response->assertSee($customer->name);
        $response->assertSee('customer');
        $response->assertSee(route('dashboard'));
        $response->assertDontSee(route('admin.dashboard'));
        $response->assertDontSee(route('agent.dashboard'));
    }

    public function test_customer_cannot_access_admin_dashboard(): void
    {
        $customer = User::factory()->role(UserRole::Customer)->create();

        $response = $this->actingAs($customer)->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }
}
