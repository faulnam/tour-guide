<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\AwardController as AdminAwardController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PageContentController as AdminPageContentController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectImageController as AdminProjectImageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\VehicleController as CustomerVehicleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Karyawan\AbsensiController as KaryawanAbsensiController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\TaskController as KaryawanTaskController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes — Apex Garage
|--------------------------------------------------------------------------
*/

// SEO Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Us & Facilities
Route::get('/about-us', [AboutController::class, 'index'])->name('about');

// Brands & Partners
Route::get('/clients', [ClientController::class, 'index'])->name('clients');

// Services & Modification Packages
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{parent}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/services/{parent}/{child}', [ServiceController::class, 'showChild'])->name('services.child');

// Tuning Portfolio & Builds Showcase
Route::get('/portfolio', [ProjectController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [ProjectController::class, 'show'])->name('portfolio.show');
Route::get('/portfolio-cat/{slug}', [ProjectController::class, 'byCategory'])->name('portfolio.category');

// Awards & Achievements
Route::get('/awards-publications', [AwardController::class, 'index'])->name('awards.index');
Route::get('/awards-publications/{slug}', [AwardController::class, 'show'])->name('awards.show');

// Blog & Automotive Insights
Route::get('/our-blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/our-blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact Us
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Public Booking Online (Transformed from Career)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/checkout/{code}', [BookingController::class, 'checkout'])->name('booking.checkout');

// Payment Gateway Simulator & Webhook
Route::post('/payment/simulate/{id}', [PaymentController::class, 'processSimulation'])->name('payment.simulate');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

// AI Automotive Tuning Assistant
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
Route::get('/chatbot/suggestions', [ChatbotController::class, 'getSuggestions'])->name('chatbot.suggestions');


/*
|--------------------------------------------------------------------------
| Authentication Routes (Unified 3 Roles: Admin, Karyawan, Customer)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Customer Portal Routes (/customer/*)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [CustomerBookingController::class, 'show'])->name('bookings.show');
    Route::get('/vehicles', [CustomerVehicleController::class, 'index'])->name('vehicles.index');
    Route::post('/vehicles', [CustomerVehicleController::class, 'store'])->name('vehicles.store');
    Route::delete('/vehicles/{id}', [CustomerVehicleController::class, 'destroy'])->name('vehicles.destroy');
});


/*
|--------------------------------------------------------------------------
| Karyawan / Mekanik Portal Routes (/karyawan/*)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard.index');
    
    // Sistem Absensi Kamera Webcam
    Route::get('/absensi', [KaryawanAbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/checkin', [KaryawanAbsensiController::class, 'checkIn'])->name('absensi.checkin');
    Route::post('/absensi/checkout', [KaryawanAbsensiController::class, 'checkOut'])->name('absensi.checkout');
    
    // Tugas Pengerjaan Modifikasi
    Route::get('/tasks', [KaryawanTaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{id}', [KaryawanTaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{id}/progress', [KaryawanTaskController::class, 'updateProgress'])->name('tasks.progress');
});


/*
|--------------------------------------------------------------------------
| Admin Portal Routes (/admin/*)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Overview
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Workshop Bookings Management
    Route::resource('bookings', AdminBookingController::class);

    // Camera Attendance Monitoring & Recap
    Route::get('attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
    Route::delete('attendances/{id}', [AdminAttendanceController::class, 'destroy'])->name('attendances.destroy');

    // Mechanics & Employee Management
    Route::resource('employees', AdminEmployeeController::class);

    // Workshop Modification Services & Projects
    Route::resource('services', AdminServiceController::class);
    Route::resource('projects', AdminProjectController::class);
    Route::delete('projects/{project}/images/{image}', [AdminProjectImageController::class, 'destroy'])->name('projects.images.destroy');
    Route::post('projects/{project}/images/reorder', [AdminProjectImageController::class, 'reorder'])->name('projects.images.reorder');

    Route::resource('clients', AdminClientController::class);
    Route::resource('awards', AdminAwardController::class);
    Route::resource('blog-categories', AdminBlogCategoryController::class);
    Route::resource('blog-posts', AdminBlogPostController::class);
    Route::resource('hero-slides', AdminHeroSlideController::class);
    Route::resource('testimonials', AdminTestimonialController::class);

    // Site Settings & Copywriting
    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    Route::get('page-contents', [AdminPageContentController::class, 'edit'])->name('page-contents.edit');
    Route::put('page-contents', [AdminPageContentController::class, 'update'])->name('page-contents.update');

    // Messages & Inquiries
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('messages/{message}/read', [AdminMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Newsletter Subscribers
    Route::get('subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
    Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // User Administration
    Route::resource('users', AdminUserController::class);
});
