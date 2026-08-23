<?php

namespace Tests\Feature;

use App\Models\Award;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\ContactMessage;
use App\Models\HeroSlide;
use App\Models\JobVacancy;
use App\Models\NewsletterSubscriber;
use App\Models\PageContent;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SprintSixTest extends TestCase
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
     * Test Awards CRUD.
     */
    public function test_admin_can_manage_awards(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/awards');
        $response->assertStatus(200);

        // Create
        $storeResponse = $this->actingAs($this->admin)->post('/admin/awards', [
            'title' => 'World Interior Design Gold Trophy 2026',
            'slug' => 'world-interior-gold-2026',
            'description' => '<p>Prestigious global award.</p>',
            'published_date' => '2026-06-01',
            'order' => 1,
            'is_active' => 1,
        ]);
        $storeResponse->assertRedirect('/admin/awards');
        $this->assertDatabaseHas('awards', ['slug' => 'world-interior-gold-2026']);

        $award = Award::where('slug', 'world-interior-gold-2026')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)->put("/admin/awards/{$award->id}", [
            'title' => 'World Interior Design Platinum Trophy 2026',
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect('/admin/awards');
        $this->assertDatabaseHas('awards', ['title' => 'World Interior Design Platinum Trophy 2026']);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/awards/{$award->id}");
        $deleteResponse->assertRedirect('/admin/awards');
        $this->assertDatabaseMissing('awards', ['id' => $award->id]);
    }

    /**
     * Test Job Vacancies CRUD.
     */
    public function test_admin_can_manage_job_vacancies(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/job-vacancies');
        $response->assertStatus(200);

        // Create
        $storeResponse = $this->actingAs($this->admin)->post('/admin/job-vacancies', [
            'title' => 'Lead Architectural Lighting Designer',
            'slug' => 'lead-lighting-designer',
            'responsibilities' => 'Design computational lighting simulations',
            'requirements' => '5+ years experience in Dialux',
            'is_active' => 1,
        ]);
        $storeResponse->assertRedirect('/admin/job-vacancies');
        $this->assertDatabaseHas('job_vacancies', ['slug' => 'lead-lighting-designer']);

        $job = JobVacancy::where('slug', 'lead-lighting-designer')->first();

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/job-vacancies/{$job->id}");
        $deleteResponse->assertRedirect('/admin/job-vacancies');
        $this->assertDatabaseMissing('job_vacancies', ['id' => $job->id]);
    }

    /**
     * Test Blog Posts & Categories CRUD.
     */
    public function test_admin_can_manage_blog_posts_and_categories(): void
    {
        // Category Create
        $catResponse = $this->actingAs($this->admin)->post('/admin/blog-categories', [
            'title' => 'Sustainable Architecture',
            'slug' => 'sustainable-architecture',
        ]);
        $catResponse->assertRedirect('/admin/blog-categories');
        $this->assertDatabaseHas('blog_categories', ['slug' => 'sustainable-architecture']);

        $category = BlogCategory::where('slug', 'sustainable-architecture')->first();

        // Post Create
        $postResponse = $this->actingAs($this->admin)->post('/admin/blog-posts', [
            'blog_category_id' => $category->id,
            'title' => 'Circular Materials in Modern Hospitality',
            'slug' => 'circular-materials-modern-hospitality',
            'excerpt' => 'Exploring eco-friendly materials.',
            'content' => '<p>In-depth article content about sustainability.</p>',
            'author' => 'Metrix Research Team',
            'is_published' => 1,
        ]);
        $postResponse->assertRedirect('/admin/blog-posts');
        $this->assertDatabaseHas('blog_posts', ['slug' => 'circular-materials-modern-hospitality']);

        $post = BlogPost::where('slug', 'circular-materials-modern-hospitality')->first();

        // Delete Post
        $this->actingAs($this->admin)->delete("/admin/blog-posts/{$post->id}");
        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    /**
     * Test Hero Slides & Testimonials CRUD.
     */
    public function test_admin_can_manage_hero_slides_and_testimonials(): void
    {
        // Hero Slide Create
        $slideResponse = $this->actingAs($this->admin)->post('/admin/hero-slides', [
            'page' => 'home',
            'title' => 'Redefining Architectural Aesthetics',
            'subtitle' => 'Global interior design excellence.',
            'order' => 1,
            'is_active' => 1,
        ]);
        $slideResponse->assertRedirect('/admin/hero-slides');
        $this->assertDatabaseHas('hero_slides', ['title' => 'Redefining Architectural Aesthetics']);

        // Testimonial Create
        $testiResponse = $this->actingAs($this->admin)->post('/admin/testimonials', [
            'client_name' => 'Alexander Tan',
            'client_company' => 'Managing Director, Horizon Hotels',
            'message' => 'Metrix delivered beyond our highest expectations.',
            'rating' => 5,
            'order' => 1,
            'is_active' => 1,
        ]);
        $testiResponse->assertRedirect('/admin/testimonials');
        $this->assertDatabaseHas('testimonials', ['client_name' => 'Alexander Tan']);
    }

    /**
     * Test Site Settings Form & Cache Invalidation.
     */
    public function test_admin_can_update_site_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/settings');
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($this->admin)->put('/admin/settings', [
            'stat_years_exp' => '30+',
            'stat_sqm_designed' => '1,500,000+',
            'company_name' => 'The Metrix Interior Architecture Studio',
        ]);
        $updateResponse->assertRedirect('/admin/settings');

        $this->assertEquals('30+', SiteSetting::get('stat_years_exp'));
        $this->assertEquals('The Metrix Interior Architecture Studio', SiteSetting::get('company_name'));
    }

    /**
     * Test Page Content Copywriting Form.
     */
    public function test_admin_can_update_page_contents(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/page-contents');
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($this->admin)->put('/admin/page-contents', [
            'contents' => [
                'home_hero_title' => 'TRANSFORMATIVE SPACES FOR THE FUTURE',
            ],
        ]);
        $updateResponse->assertRedirect('/admin/page-contents');

        $this->assertEquals('TRANSFORMATIVE SPACES FOR THE FUTURE', PageContent::get('home_hero_title'));
    }

    /**
     * Test Messages Inbox & Mark As Read.
     */
    public function test_admin_can_manage_inbox_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Jessica Wong',
            'email' => 'jessica@luxuryproperties.com',
            'company' => 'Luxury Properties Ltd',
            'phone' => '+62 812 3456 7890',
            'message' => 'We would like to request a consultation for our upcoming boutique hotel.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/messages');
        $response->assertStatus(200);
        $response->assertSee('Jessica Wong');

        // Show message (marks as read)
        $showResponse = $this->actingAs($this->admin)->get("/admin/messages/{$message->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('We would like to request a consultation');

        $this->assertTrue($message->fresh()->is_read);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/messages/{$message->id}");
        $deleteResponse->assertRedirect('/admin/messages');
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    /**
     * Test Subscribers List and CSV Export.
     */
    public function test_admin_can_export_subscribers_csv(): void
    {
        NewsletterSubscriber::create([
            'email' => 'client.partner@globalgroup.com',
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/subscribers');
        $response->assertStatus(200);
        $response->assertSee('client.partner@globalgroup.com');

        // CSV Export
        $exportResponse = $this->actingAs($this->admin)->get('/admin/subscribers/export');
        $exportResponse->assertStatus(200);
        $exportResponse->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    /**
     * Test Super Admin Users Management.
     */
    public function test_super_admin_can_manage_users(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);

        // Create
        $createResponse = $this->actingAs($this->admin)->post('/admin/users', [
            'name' => 'Editor Assistant',
            'email' => 'editor@the-metrix.com',
            'password' => 'secretPassword123',
            'role' => 'editor',
        ]);
        $createResponse->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', ['email' => 'editor@the-metrix.com']);

        $user = User::where('email', 'editor@the-metrix.com')->first();

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete("/admin/users/{$user->id}");
        $deleteResponse->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
