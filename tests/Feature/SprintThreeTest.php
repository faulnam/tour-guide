<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprintThreeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Services Index.
     */
    public function test_services_index_returns_successful_response(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
        $response->assertSee('Our Services');
        $response->assertSee('Interior Design');
        $response->assertSee('Interior Styling');
        $response->assertSee('3D Visualization');
        $response->assertSee('Work Space');
    }

    /**
     * Test Parent Service Detail (/services/interior-design).
     */
    public function test_parent_service_page_returns_successful_response(): void
    {
        $response = $this->get('/services/interior-design');

        $response->assertStatus(200);
        $response->assertSee('Interior Design');
        $response->assertSee('Restaurant &amp; Bar', false);
        $response->assertSee('Work Space');
    }

    /**
     * Test Sub-Service Detail (/services/interior-design/restaurant-bar).
     */
    public function test_sub_service_child_page_returns_successful_response(): void
    {
        $response = $this->get('/services/interior-design/restaurant-bar');

        $response->assertStatus(200);
        $response->assertSee('Restaurant &amp; Bar Projects', false);
        $response->assertSee('Burger &amp; Lobster - Plaza Indonesia', false);
    }

    /**
     * Test Portfolio Detail Page (/portfolio/burger-lobster-plaza-indonesia).
     */
    public function test_portfolio_detail_page_returns_successful_response(): void
    {
        $response = $this->get('/portfolio/burger-lobster-plaza-indonesia');

        $response->assertStatus(200);
        $response->assertSee('Burger &amp; Lobster - Plaza Indonesia', false);
        $response->assertSee('Project Specifications');
        $response->assertSee('758 m²');
        $response->assertSee('Plaza Indonesia Management');
        $response->assertSee('Project Gallery');
    }

    /**
     * Test Portfolio by Category Page (/portfolio-cat/restaurant-bar).
     */
    public function test_portfolio_by_category_page_returns_successful_response(): void
    {
        $response = $this->get('/portfolio-cat/restaurant-bar');

        $response->assertStatus(200);
        $response->assertSee('Restaurant &amp; Bar Projects', false);
        $response->assertSee('Burger &amp; Lobster - Plaza Indonesia', false);
    }
}
