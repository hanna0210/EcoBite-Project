<?php

namespace App\Http\Livewire\Extensions\Emailer;

use App\Http\Livewire\Extensions\BaseExtensionComponent;
use App\Models\User;
use App\Traits\FirebaseAuthTrait;
use Spatie\Permission\Models\Role;
use App\Http\Livewire\Extensions\Emailer\Job\SendCustomEmailerMailJob;
use App\Http\Livewire\Extensions\Emailer\Mail\CustomEmailerMail;
use App\Http\Livewire\Extensions\Emailer\CommaSeparatedEmails;


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
        'emailBodyUpdate' => 'emailBodyUpdate',
        'showExtensions' => 'showExtensions',
        'closeDialog' => 'closeDialog',
    ];

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
        $this->showView = false;
        $this->emitUp('showExtensions');
    }

    public function showEmailerView()
    {
        $this->show();
        $this->emit('initEmailer');
    }


    public function emailBodyUpdate($body)
    {
        $this->body = $body;
    }

    public function sendEmails()
    {

        if (!$this->customReceiver) {
            $this->validate();
        } else {
            $this->validate(
                $this->rules + [
                    "customerEmails" => [new CommaSeparatedEmails],
                ]
            );
        }
        //
        //fetching topic to send message to
        try {
            if ($this->roleReceiver) {

                foreach ($this->customReceiverRoles as $role) {
                    //users with that roles
                    $emails = User::role($role)->pluck('email');
                    //send mail
                    $this->queueMail($emails);
                }
            } else if ($this->customReceiver) {
                $emails = explode(";",$this->customerEmails);
                //send mail
                $this->queueMail($emails);
            } else {
                $emails = User::pluck('email');
                //send mail
                $this->queueMail($emails);
            }

            //
            $this->showSuccessAlert(__("Email sent successfully!"));
            $this->emit('resetEmailer');
            $this->reset(['title']);
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Email sending failed!"));
        }
    }

    public function queueMail($emails)
    {

        //send mail
        foreach ($emails as $email) {
            SendCustomEmailerMailJob::dispatch($email, $this->title, $this->body)
                ->delay(now()->addMinutes(1));
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
