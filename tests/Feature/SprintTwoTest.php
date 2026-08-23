<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprintTwoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Home Page.
     */
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Award-Winning');
        $response->assertSee('3,000+');
        $response->assertSee('Recent Projects');
        $response->assertSee('Latest Insights');
        $response->assertSee('Our Clients');
    }

    /**
     * Test About Us Page.
     */
    public function test_about_us_page_returns_successful_response(): void
    {
        $response = $this->get('/about-us');

        $response->assertStatus(200);
        $response->assertSee('Who We Are');
        $response->assertSee('Our Mission');
        $response->assertSee('Core Competencies');
        $response->assertSee('Selected Projects');
    }

    /**
     * Test Clients Page.
     */
    public function test_clients_page_returns_successful_response(): void
    {
        $response = $this->get('/clients');

        $response->assertStatus(200);
        $response->assertSee('Our Clients');
        $response->assertSee('Distinguished Partners');
    }

    /**
     * Test Contact Us Page.
     */
    public function test_contact_us_page_returns_successful_response(): void
    {
        $response = $this->get('/contact-us');

        $response->assertStatus(200);
        $response->assertSee('Jakarta Headquarters');
        $response->assertSee('Send Us A Message');
    }

    /**
     * Test Contact Us Form Submission.
     */
    public function test_contact_form_saves_to_database(): void
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company' => 'Doe Hospitality Corp',
            'message' => 'We are interested in discussing an interior architecture project for a boutique hotel.',
        ];

        $response = $this->post('/contact-us', $contactData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company' => 'Doe Hospitality Corp',
        ]);
    }

    /**
     * Test Career Page.
     */
    public function test_career_page_returns_successful_response(): void
    {
        $response = $this->get('/career');

        $response->assertStatus(200);
        $response->assertSee('Join The Crew');
        $response->assertSee('Open Positions');
    }

    /**
     * Test Newsletter Subscription.
     */
    public function test_newsletter_subscription_saves_to_database(): void
    {
        $response = $this->post('/newsletter/subscribe', [
            'email' => 'subscriber@example.com',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'subscriber@example.com',
        ]);
    }
}
