<?php

namespace App\Console\Commands;

use App\Models\DemoRecord;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CleanDemoContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired demo records and associated files (older than 3 minutes)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();
        $expiredRecords = DemoRecord::where('expires_at', '<=', $now)->get();
        $count = 0;

        foreach ($expiredRecords as $record) {
            try {
                $modelClass = $record->record_type;
                if (class_exists($modelClass)) {
                    $item = $modelClass::find($record->record_id);
                    if ($item) {
                        // Delete any associated file if exists
                        $fileAttributes = ['cover_image', 'image', 'logo', 'image_path', 'photo'];
                        foreach ($fileAttributes as $attr) {
                            if (!empty($item->$attr) && Storage::disk('public')->exists($item->$attr)) {
                                Storage::disk('public')->delete($item->$attr);
                            }
                        }

                        $item->delete();
                        $count++;
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("Failed to delete expired demo record [{$record->record_type} ID {$record->record_id}]: " . $e->getMessage());
            } finally {
                $record->delete();
            }
        }

        $this->info("Cleaned {$count} expired demo records.");
        return Command::SUCCESS;
    }
}
