<?php

namespace App\Http\Middleware;

use App\Models\DemoRecord;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CleanDemoContentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Opportunistic cleanup of expired demo records (> 3 minutes)
        try {
            if (Schema::hasTable('demo_records')) {
                $expiredRecords = DemoRecord::where('expires_at', '<=', now())->get();
                foreach ($expiredRecords as $record) {
                    try {
                        $modelClass = $record->record_type;
                        if (class_exists($modelClass)) {
                            $item = $modelClass::find($record->record_id);
                            if ($item) {
                                $fileAttributes = ['cover_image', 'image', 'logo', 'image_path', 'photo'];
                                foreach ($fileAttributes as $attr) {
                                    if (!empty($item->$attr) && Storage::disk('public')->exists($item->$attr)) {
                                        Storage::disk('public')->delete($item->$attr);
                                    }
                                }
                                $item->delete();
                            }
                        }
                    } catch (\Throwable $e) {
                        // ignore individual record error
                    } finally {
                        $record->delete();
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore if DB is unreachable
        }

        return $next($request);
    }
}
