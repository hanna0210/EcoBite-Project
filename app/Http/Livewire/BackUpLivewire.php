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
            Artisan::call("backup:run --only-db");
            
            // Check if backup was actually successful by checking the output
            $output = Artisan::output();
            
            if (str_contains($output, 'Backup failed') || str_contains($output, 'Error')) {
                \Log::error('Database backup failed: ' . $output);
                $this->showErrorAlert(__("Database backup failed. Check logs for details."));
            } else {
                $this->showSuccessAlert(__("Database backup successful"));
            }
        } catch (Exception $error) {
            \Log::error('Database backup exception: ' . $error->getMessage());
            $this->showErrorAlert(__("Database backup failed") . ": " . $error->getMessage());
        }
    }

    public function newFullBackUp()
    {
        try {
            Artisan::call("backup:run");
            
            // Check if backup was actually successful by checking the output
            $output = Artisan::output();
            
            if (str_contains($output, 'Backup failed') || str_contains($output, 'Error')) {
                \Log::error('Full backup failed: ' . $output);
                $this->showErrorAlert(__("Whole System backup failed. Check logs for details."));
            } else {
                $this->showSuccessAlert(__("Whole System backup successful"));
            }
        } catch (Exception $error) {
            \Log::error('Full backup exception: ' . $error->getMessage());
            $this->showErrorAlert(__("Whole System backup failed") . ": " . $error->getMessage());
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

            Storage::delete($this->selectedModel);
            $this->showSuccessAlert(__("Backup Deleted"));
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Backup delete Failed"));
        }
    }


    public function downloadBackup($file)
    {
        return Storage::download($file);
    }
}