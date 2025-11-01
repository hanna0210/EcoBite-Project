<?php

namespace App\Http\Livewire;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class BackUpLivewire extends BaseLivewireComponent
{

    protected $listeners = [
        'deleteModel',
        'refreshTable' => '$refresh',
    ];


    public function render()
    {
        return view('livewire.backup');
    }


    public function getBackupsProperty()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $appName = config('backup.backup.name');
        
        // Get all backup files from the backup directory
        if ($disk->exists($appName)) {
            $files = collect($disk->allFiles($appName))
                ->filter(function ($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'zip';
                })
                ->sortByDesc(function ($file) use ($disk) {
                    return $disk->lastModified($file);
                })
                ->values()
                ->toArray();
        } else {
            $files = [];
        }
        
        return $files;
    }

    public function newBackUp()
    {
        try {
            // Verify database connection first
            try {
                \DB::connection()->getPdo();
            } catch (\Exception $e) {
                throw new Exception(__("Database connection failed. Please check your database configuration."));
            }

            // Get the current number of backups
            $backupsBefore = count($this->backups);
            
            // Run the backup command
            Artisan::call("backup:run --only-db");
            
            // Get the output
            $output = Artisan::output();
            
            // Check if backup was actually successful
            if (str_contains($output, 'Backup failed') || str_contains($output, 'Error')) {
                \Log::error('Database backup failed: ' . $output);
                throw new Exception(__("Database backup failed. Check logs for details."));
            }
            
            // Verify a new backup was created
            $this->resetBackupsCache();
            $backupsAfter = count($this->backups);
            
            if ($backupsAfter > $backupsBefore) {
                $latestBackup = $this->backups[0] ?? null;
                $backupName = $latestBackup ? basename($latestBackup) : '';
                $this->showSuccessAlert(__("Database backup created successfully!") . " ({$backupName})");
                $this->emit('refreshTable');
            } else {
                throw new Exception(__("Backup command completed but no backup file was created."));
            }
            
        } catch (Exception $error) {
            \Log::error('Database backup exception: ' . $error->getMessage());
            $this->showErrorAlert(__("Database backup failed") . ": " . $error->getMessage());
        }
    }
    
    // Helper method to reset the backups cache
    private function resetBackupsCache()
    {
        // Force refresh by clearing the cached property
        unset($this->backups);
    }

    public function newFullBackUp()
    {
        try {
            // Verify database connection first
            try {
                \DB::connection()->getPdo();
            } catch (\Exception $e) {
                throw new Exception(__("Database connection failed. Please check your database configuration."));
            }

            // Get the current number of backups
            $backupsBefore = count($this->backups);
            
            // Run the full backup command (database + files)
            Artisan::call("backup:run");
            
            // Get the output
            $output = Artisan::output();
            
            // Check if backup was actually successful
            if (str_contains($output, 'Backup failed') || str_contains($output, 'Error')) {
                \Log::error('Full backup failed: ' . $output);
                throw new Exception(__("Full backup failed. Check logs for details."));
            }
            
            // Verify a new backup was created
            $this->resetBackupsCache();
            $backupsAfter = count($this->backups);
            
            if ($backupsAfter > $backupsBefore) {
                $latestBackup = $this->backups[0] ?? null;
                $backupName = $latestBackup ? basename($latestBackup) : '';
                $this->showSuccessAlert(__("Full system backup created successfully!") . " ({$backupName})");
                $this->emit('refreshTable');
            } else {
                throw new Exception(__("Backup command completed but no backup file was created."));
            }
            
        } catch (Exception $error) {
            \Log::error('Full backup exception: ' . $error->getMessage());
            $this->showErrorAlert(__("Full backup failed") . ": " . $error->getMessage());
        }
    }


    public function initiateDelete($file)
    {

        $this->selectedModel = $file;
        $this->confirm('Delete', [
            'icon' => 'question',
            'toast' => false,
            'text' =>  __('Are you sure you want to delete the selected data?'),
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __("Cancel"),
            'onConfirmed' => 'deleteModel',
            'onCancelled' => 'cancelled'
        ]);
    }


    public function deleteModel()
    {
        try {
            $disk = Storage::disk('local');
            
            // Verify the file exists before trying to delete
            if (!$disk->exists($this->selectedModel)) {
                throw new Exception(__("Backup file not found."));
            }
            
            $fileName = basename($this->selectedModel);
            
            // Delete the backup file
            $disk->delete($this->selectedModel);
            
            // Refresh the backups list
            $this->resetBackupsCache();
            $this->emit('refreshTable');
            
            $this->showSuccessAlert(__("Backup deleted successfully") . ": {$fileName}");
            
        } catch (Exception $error) {
            \Log::error('Backup deletion failed: ' . $error->getMessage());
            $this->showErrorAlert($error->getMessage() ?? __("Backup delete failed"));
        }
    }


    public function downloadBackup($file)
    {
        try {
            $disk = Storage::disk('local');
            
            // Verify the file exists before trying to download
            if (!$disk->exists($file)) {
                $this->showErrorAlert(__("Backup file not found."));
                return;
            }
            
            // Download the backup file
            return $disk->download($file);
            
        } catch (Exception $error) {
            \Log::error('Backup download failed: ' . $error->getMessage());
            $this->showErrorAlert(__("Failed to download backup") . ": " . $error->getMessage());
        }
    }
    
    /**
     * Get information about the current database being backed up
     */
    public function getDatabaseInfo()
    {
        try {
            $database = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host');
            return [
                'database' => $database,
                'host' => $host,
            ];
        } catch (Exception $e) {
            return null;
        }
    }
}