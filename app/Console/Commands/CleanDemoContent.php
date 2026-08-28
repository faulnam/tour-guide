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
    protected $description = 'Clean up and revert expired demo records/modifications (older than 5 minutes)';

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
                if (!class_exists($modelClass)) {
                    continue;
                }

                $action = $record->action ?? 'create';

                if ($action === 'create') {
                    // Action: CREATE -> Delete the created record and its uploaded files
                    $item = $modelClass::find($record->record_id);
                    if ($item) {
                        $this->deleteModelFiles($item, $record->file_paths);
                        $item->delete();
                        $count++;
                    }
                } elseif ($action === 'update') {
                    // Action: UPDATE -> Revert model back to original snapshot
                    $item = $modelClass::find($record->record_id);
                    if ($item && !empty($record->original_data)) {
                        $originalData = is_string($record->original_data) 
                            ? json_decode($record->original_data, true) 
                            : $record->original_data;

                        if (is_array($originalData)) {
                            // Revert without firing eloquent events to prevent re-tracking
                            if (method_exists($modelClass, 'withoutEvents')) {
                                $modelClass::withoutEvents(function () use ($item, $originalData) {
                                    $item->forceFill($originalData)->save();
                                });
                            } else {
                                $item->forceFill($originalData)->save();
                            }
                            $count++;
                        }
                    }
                } elseif ($action === 'delete') {
                    // Action: DELETE -> Restore/re-create the deleted record
                    if (!empty($record->original_data)) {
                        $originalData = is_string($record->original_data) 
                            ? json_decode($record->original_data, true) 
                            : $record->original_data;

                        if (is_array($originalData)) {
                            $existing = $modelClass::find($record->record_id);
                            if (!$existing) {
                                if (method_exists($modelClass, 'withoutEvents')) {
                                    $modelClass::withoutEvents(function () use ($modelClass, $originalData) {
                                        $newModel = new $modelClass();
                                        $newModel->forceFill($originalData)->save();
                                    });
                                } else {
                                    $newModel = new $modelClass();
                                    $newModel->forceFill($originalData)->save();
                                }
                                $count++;
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning("Failed to process expired demo record [{$record->record_type} ID {$record->record_id} action {$record->action}]: " . $e->getMessage());
            } finally {
                $record->delete();
            }
        }

        $this->info("Processed {$count} expired demo records/changes.");
        return Command::SUCCESS;
    }

    /**
     * Delete files associated with the model.
     */
    protected function deleteModelFiles($item, $explicitFilePaths = null): void
    {
        $fileAttributes = ['cover_image', 'image', 'logo', 'image_path', 'photo', 'avatar', 'check_in_photo', 'check_out_photo'];
        foreach ($fileAttributes as $attr) {
            if (!empty($item->$attr) && is_string($item->$attr) && Storage::disk('public')->exists($item->$attr)) {
                Storage::disk('public')->delete($item->$attr);
            }
        }

        if (!empty($explicitFilePaths)) {
            $paths = is_string($explicitFilePaths) ? json_decode($explicitFilePaths, true) : $explicitFilePaths;
            if (is_array($paths)) {
                foreach ($paths as $path) {
                    if (is_string($path) && Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
        }
    }
}
