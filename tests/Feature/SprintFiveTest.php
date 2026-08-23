<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprintFiveTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->admin = User::where('email', 'admin@the-metrix.com')->first();
    }

    /**
     * Test Guest is redirected from Admin.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /**
     * Test Login Screen Renders.
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Metrix CMS');
    }

    /**
     * Test Admin Authentication with Valid Credentials.
     */
    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@the-metrix.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/admin');
    }

    /**
     * Test Admin Dashboard Overview.
     */
    public function test_admin_dashboard_can_be_accessed(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard Overview');
        $response->assertSee('Projects');
        $response->assertSee('Services');
        $response->assertSee('Clients');
    }

    /**
     * Test Admin Projects CRUD.
     */
    public function test_admin_can_create_edit_delete_projects(): void
    {
        // 1. Index
        $response = $this->actingAs($this->admin)->get('/admin/projects');
        $response->assertStatus(200);

        // 2. Store
        $service = Service::first();
        $projectData = [
            'service_id' => $service->id,
            'title' => 'Test Spatial Design Studio',
            'client' => 'Test Client Inc.',
            'location' => 'Jakarta, Indonesia',
            'size' => '500 m²',
            'year' => '2026',
            'description' => '<p>Test narrative description.</p>',
            'status' => 'published',
            'is_featured' => 1,
            'is_recent' => 1,
            'order' => 10,
        ];

        $storeResponse = $this->actingAs($this->admin)->post('/admin/projects', $projectData);
        $storeResponse->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Spatial Design Studio',
            'client' => 'Test Client Inc.',
        ]);

        $project = Project::where('title', 'Test Spatial Design Studio')->first();

        // 3. Edit & Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/projects/{$project->id}", [
            'service_id' => $service->id,
            'title' => 'Updated Spatial Design Studio',
            'status' => 'published',
        ]);
        $updateResponse->assertRedirect('/admin/projects');

        $this->assertDatabaseHas('projects', [
            'title' => 'Updated Spatial Design Studio',
        ]);

        // 4. Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete("/admin/projects/{$project->id}");
        $destroyResponse->assertRedirect('/admin/projects');

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    /**
     * Test Admin Services CRUD.
     */
    public function test_admin_can_create_edit_delete_services(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/services');
        $response->assertStatus(200);

        // Store
        $serviceData = [
            'title' => 'Urban Architecture Planning',
            'slug' => 'urban-architecture-planning',
            'excerpt' => 'Urban scale spatial master planning.',
            'order' => 5,
            'is_active' => 1,
        ];

        $storeResponse = $this->actingAs($this->admin)->post('/admin/services', $serviceData);
        $storeResponse->assertRedirect('/admin/services');

        $this->assertDatabaseHas('services', [
            'slug' => 'urban-architecture-planning',
        ]);

        $service = Service::where('slug', 'urban-architecture-planning')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/services/{$service->id}", [
            'title' => 'Urban Architecture & Master Planning',
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect('/admin/services');

        $this->assertDatabaseHas('services', [
            'title' => 'Urban Architecture & Master Planning',
        ]);

        // Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete("/admin/services/{$service->id}");
        $destroyResponse->assertRedirect('/admin/services');

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    /**
     * Test Admin Clients CRUD.
     */
    public function test_admin_can_create_edit_delete_clients(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/clients');
        $response->assertStatus(200);

        // Store
        $clientData = [
            'name' => 'Mandarin Oriental Hotel Group',
            'website_url' => 'https://mandarinoriental.com',
            'order' => 10,
            'is_active' => 1,
        ];

        $storeResponse = $this->actingAs($this->admin)->post('/admin/clients', $clientData);
        $storeResponse->assertRedirect('/admin/clients');

        $this->assertDatabaseHas('clients', [
            'name' => 'Mandarin Oriental Hotel Group',
        ]);

        $client = Client::where('name', 'Mandarin Oriental Hotel Group')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/clients/{$client->id}", [
            'name' => 'Mandarin Oriental Hospitality',
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect('/admin/clients');

        $this->assertDatabaseHas('clients', [
            'name' => 'Mandarin Oriental Hospitality',
        ]);

        // Destroy
        $destroyResponse = $this->actingAs($this->admin)->delete("/admin/clients/{$client->id}");
        $destroyResponse->assertRedirect('/admin/clients');

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    /**
     * Test Admin Logout.
     */
    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/logout');

        $this->assertGuest();
        $response->assertRedirect('/admin/login');
    }
}
