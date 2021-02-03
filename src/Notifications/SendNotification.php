<?php

namespace Agenciafmd\Postal\Notifications;

use Agenciafmd\Leads\Channels\LeadChannel;
use Agenciafmd\Postal\Mails\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;
use Agenciafmd\Leads\Models\Lead;

class SendNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public $data;

    public $from;

    public $attach;

    public $subject;

    public function __construct($data, $from = null, $attach = null, $subject = null)
    {
        $this->data = $data;

        $this->from = $from;

        $this->attach = $attach;

        $this->subject = $subject;
    }

    public function via($notifiable)
    {
        return [
            MailChannel::class,
            LeadChannel::class,
        ];
    }

    public function toMail($notifiable)
    {
        return new SendMail($notifiable, $this->from, $this->data, $this->attach, $this->subject);
    }

    public function toLead($data)
    {
        Lead::create([
            'source' => $data['source'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'description' => $data['message'],
        ]);
    }
}
