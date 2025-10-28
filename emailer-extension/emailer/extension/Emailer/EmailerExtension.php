<?php

namespace App\Http\Livewire\Extensions\Emailer;

use App\Http\Livewire\Extensions\BaseExtensionComponent;
use App\Models\User;
use App\Traits\FirebaseAuthTrait;
use Spatie\Permission\Models\Role;
use App\Http\Livewire\Extensions\Emailer\Job\SendCustomEmailerMailJob;
use App\Http\Livewire\Extensions\Emailer\Mail\CustomEmailerMail;
use App\Http\Livewire\Extensions\Emailer\CommaSeparatedEmails;
use Exception;


class EmailerExtension extends BaseExtensionComponent
{

    use FirebaseAuthTrait;

    public $showCreate = false;
    public $allReceiver = true;
    public $roleReceiver;
    public $customReceiver;
    public $customReceiverRoles;
    public $title;
    public $body;
    public $customerEmails;

    public $rules = [
        "title" => "required",
        "body" => "required",
    ];

    protected $listeners = [
        'showEmailerView' => 'showEmailerView',
        'showExtensions' => 'showExtensions',
        'closeDialog' => 'closeDialog',
    ];

    public function mount()
    {
        // Set showView to true when component loads as a standalone page
        $this->showView = true;
        $this->emit('initEmailer');
    }

    public function render()
    {
        return view('livewire.extensions.emailer.index', [
            'roles' => Role::all(),
        ]);
    }

    public function updatedAllReceiver()
    {
        $this->customReceiver = !$this->allReceiver;
        $this->roleReceiver = !$this->allReceiver;
    }
    public function updatedRoleReceiver()
    {
        $this->allReceiver = !$this->roleReceiver;
        $this->customReceiver = !$this->roleReceiver;
    }

    public function updatedCustomReceiver()
    {
        $this->allReceiver = !$this->customReceiver;
        $this->roleReceiver = !$this->customReceiver;
    }

    public function showExtensions()
    {
        // Redirect back to extensions page or previous page
        return redirect()->route('extensions');
    }

    public function showEmailerView()
    {
        $this->show();
        $this->emit('initEmailer');
    }

    public function sendEmails()
    {

        if ($this->customReceiver) {
            $this->validate(
                $this->rules + [
                    "customerEmails" => ["required", new CommaSeparatedEmails],
                ]
            );
        } else {
            $this->validate();
        }
        //
        //fetching topic to send message to
        try {
            $emailsSent = 0;
            
            if ($this->roleReceiver) {
                if (empty($this->customReceiverRoles)) {
                    $this->showErrorAlert(__("Please select at least one role"));
                    return;
                }

                foreach ($this->customReceiverRoles as $role) {
                    //users with that roles
                    $emails = User::role($role)->pluck('email')->toArray();
                    //send mail
                    if (!empty($emails)) {
                        $this->queueMail($emails);
                        $emailsSent += count($emails);
                    }
                }
            } else if ($this->customReceiver) {
                $emails = array_map('trim', explode(";", $this->customerEmails));
                $emails = array_filter($emails); // Remove empty values
                //send mail
                if (!empty($emails)) {
                    $this->queueMail($emails);
                    $emailsSent += count($emails);
                }
            } else {
                $emails = User::pluck('email')->toArray();
                //send mail
                if (!empty($emails)) {
                    $this->queueMail($emails);
                    $emailsSent += count($emails);
                }
            }

            if ($emailsSent > 0) {
                $this->showSuccessAlert(__("Email queued successfully! $emailsSent email(s) will be sent."));
                $this->emit('resetEmailer');
                $this->reset(['title', 'customReceiverRoles', 'customerEmails']);
            } else {
                $this->showWarningAlert(__("No recipients found to send emails to."));
            }
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Email sending failed!"));
        }
    }

    public function queueMail($emails)
    {
        //send mail
        foreach ($emails as $email) {
            // Skip invalid emails
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            
            SendCustomEmailerMailJob::dispatch($email, $this->title, $this->body)
                ->delay(now()->addSeconds(30));
        }
    }


    //Alert
    public function showSuccessAlert($message = "", $time = 3000)
    {
        $this->alert('success', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
            "timer" => $time,
        ]);
    }

    public function showWarningAlert($message = "", $time = 3000)
    {
        $this->alert('warning', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
            "timer" => $time,
        ]);
    }

    public function showErrorAlert($message = "", $time = 3000)
    {
        $this->alert('error', "", [
            'position'  =>  'center',
            'text' => $message,
            'toast'  =>  false,
            "timer" => $time,
        ]);
    }
}
