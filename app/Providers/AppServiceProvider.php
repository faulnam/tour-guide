<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Automatically force HTTPS when served through ngrok or HTTPS reverse proxies
        if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || 
            (isset($_SERVER['HTTP_HOST']) && str_contains($_SERVER['HTTP_HOST'], 'ngrok'))) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share active services and site settings with public views
        View::composer(['layouts.app', 'partials.header', 'partials.footer'], function ($view) {
            if (Schema::hasTable('services')) {
                $navServices = Service::whereNull('parent_id')
                    ->active()
                    ->with(['children' => function ($q) {
                        $q->where('is_active', true)->orderBy('order')->orderBy('title');
                    }])
                    ->ordered()
                    ->get();
                $view->with('navServices', $navServices);
            }
        });

        // Track content created, updated, or deleted by demo users and set 5-minute expiration
        \Illuminate\Support\Facades\Event::listen('eloquent.created: *', function ($eventName, array $data) {
            try {
                if (empty($data[0]) || !is_object($data[0])) return;
                $model = $data[0];
                if ($model instanceof \App\Models\DemoRecord) return;

                if (auth()->check()) {
                    $user = auth()->user();
                    $isDemo = (method_exists($user, 'isDemo') && $user->isDemo()) ||
                              str_starts_with(strtolower($user->email ?? ''), 'demo') || 
                              str_contains(strtolower($user->email ?? ''), 'demo');

                    if ($isDemo && $model->getKey() && Schema::hasTable('demo_records')) {
                        $fileAttributes = ['cover_image', 'image', 'logo', 'image_path', 'photo', 'avatar', 'check_in_photo', 'check_out_photo'];
                        $capturedFiles = [];
                        foreach ($fileAttributes as $attr) {
                            if (!empty($model->$attr)) {
                                $capturedFiles[] = $model->$attr;
                            }
                        }

                        \App\Models\DemoRecord::create([
                            'record_type' => get_class($model),
                            'record_id' => $model->getKey(),
                            'user_id' => $user->id,
                            'action' => 'create',
                            'original_data' => null,
                            'file_paths' => !empty($capturedFiles) ? $capturedFiles : null,
                            'expires_at' => now()->addMinutes(5),
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Silently fail if table not available or error occurs
            }
        });

        \Illuminate\Support\Facades\Event::listen('eloquent.updating: *', function ($eventName, array $data) {
            try {
                if (empty($data[0]) || !is_object($data[0])) return;
                $model = $data[0];
                if ($model instanceof \App\Models\DemoRecord) return;

                if (auth()->check()) {
                    $user = auth()->user();
                    $isDemo = (method_exists($user, 'isDemo') && $user->isDemo()) ||
                              str_starts_with(strtolower($user->email ?? ''), 'demo') || 
                              str_contains(strtolower($user->email ?? ''), 'demo');

                    if ($isDemo && $model->getKey() && Schema::hasTable('demo_records')) {
                        // Check if this record was already created by demo user (if so, it will be deleted entirely upon expiry)
                        $wasCreatedInDemo = \App\Models\DemoRecord::where('record_type', get_class($model))
                            ->where('record_id', $model->getKey())
                            ->where('action', 'create')
                            ->exists();

                        if (!$wasCreatedInDemo) {
                            $existingUpdate = \App\Models\DemoRecord::where('record_type', get_class($model))
                                ->where('record_id', $model->getKey())
                                ->where('action', 'update')
                                ->first();

                            if ($existingUpdate) {
                                // Keep earliest original_data snapshot, just extend expiration
                                $existingUpdate->update([
                                    'expires_at' => now()->addMinutes(5),
                                ]);
                            } else {
                                \App\Models\DemoRecord::create([
                                    'record_type' => get_class($model),
                                    'record_id' => $model->getKey(),
                                    'user_id' => $user->id,
                                    'action' => 'update',
                                    'original_data' => $model->getOriginal(),
                                    'file_paths' => null,
                                    'expires_at' => now()->addMinutes(5),
                                ]);
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Silently fail
            }
        });

        \Illuminate\Support\Facades\Event::listen('eloquent.deleting: *', function ($eventName, array $data) {
            try {
                if (empty($data[0]) || !is_object($data[0])) return;
                $model = $data[0];
                if ($model instanceof \App\Models\DemoRecord) return;

                if (auth()->check()) {
                    $user = auth()->user();
                    $isDemo = (method_exists($user, 'isDemo') && $user->isDemo()) ||
                              str_starts_with(strtolower($user->email ?? ''), 'demo') || 
                              str_contains(strtolower($user->email ?? ''), 'demo');

                    if ($isDemo && $model->getKey() && Schema::hasTable('demo_records')) {
                        $wasCreatedInDemo = \App\Models\DemoRecord::where('record_type', get_class($model))
                            ->where('record_id', $model->getKey())
                            ->where('action', 'create')
                            ->first();

                        if ($wasCreatedInDemo) {
                            $wasCreatedInDemo->delete();
                        } else {
                            \App\Models\DemoRecord::create([
                                'record_type' => get_class($model),
                                'record_id' => $model->getKey(),
                                'user_id' => $user->id,
                                'action' => 'delete',
                                'original_data' => $model->getAttributes(),
                                'file_paths' => null,
                                'expires_at' => now()->addMinutes(5),
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Silently fail
            }
        });
    }
}
