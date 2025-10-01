<?php

namespace App\Http\Livewire\Components;

use Exception;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class QueueJobsTable extends Component
{
    use WithPagination, LivewireAlert;

    protected $paginationTheme = 'tailwind';

    public $showHeader = true;
    public $showBorder = true;
    public $showDeleteAll = true;
    public $perPage = 15;

    protected function getListeners()
    {
        return [
            'confirmedDeleteJob',
            'confirmedDeleteAllJobs',
        ];
    }

    public function mount($showHeader = true, $showBorder = true, $showDeleteAll = true, $perPage = 15)
    {
        $this->showHeader = $showHeader;
        $this->showBorder = $showBorder;
        $this->showDeleteAll = $showDeleteAll;
        $this->perPage = $perPage;
    }

    public function deleteJob($jobId)
    {
        $this->alert('question', __('Are you sure?'), [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'text' => __('This job will be permanently deleted and cannot be recovered.'),
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonColor' => '#d33',
            'confirmButtonText' => __('Yes, delete it!'),
            'cancelButtonText' => __('Cancel'),
            'onConfirmed' => 'confirmedDeleteJob',
            'data' => [
                'jobId' => $jobId
            ]
        ]);
    }

    public function deleteAllJobs()
    {
        $this->alert('question', __('Delete all jobs?'), [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
            'text' => __('All jobs in the queue will be permanently deleted and cannot be recovered.'),
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'confirmButtonColor' => '#d33',
            'confirmButtonText' => __('Yes, delete all!'),
            'cancelButtonText' => __('Cancel'),
            'onConfirmed' => 'confirmedDeleteAllJobs'
        ]);
    }

    public function confirmedDeleteAllJobs()
    {
        try {
            $this->isDemo();
            $deletedCount = DB::table('jobs')->delete();

            if ($deletedCount > 0) {
                $this->alert('success', __(':count jobs deleted successfully!', ['count' => $deletedCount]), [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                $this->resetPage();
            } else {
                $this->alert('info', __('No jobs found to delete.'), [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            }
        } catch (\Exception $e) {
            $this->alert('error', __('Error deleting jobs: :error', ['error' => $e->getMessage()]), [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
            ]);
        }
    }
    public function confirmedDeleteJob($data)
    {
        try {
            $this->isDemo();
            $jobId = $data['data']['jobId'];
            $deleted = DB::table('jobs')->where('id', $jobId)->delete();

            if ($deleted) {
                $this->alert('success', __('Job deleted successfully!'), [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                $this->resetPage();
            } else {
                $this->alert('error', __('Job not found or already processed.'), [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            }
        } catch (\Exception $e) {
            $this->alert('error', __('Error deleting job: :error', ['error' => $e->getMessage()]), [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        $jobs = DB::table('jobs')
            ->select([
                'id',
                'queue',
                'payload',
                'attempts',
                'reserved_at',
                'available_at',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.components.queue-jobs-table', compact('jobs'));
    }


    //misc
    public function isDemo($catchError = false)
    {
        return;
        if (!App::environment('production')) {
            $errorMessage = __("App is in demo version. Some changes can't be made");
            if ($catchError) {
                $this->showErrorAlert($errorMessage);
            } else {
                throw new Exception($errorMessage);
            }
        };
    }
}