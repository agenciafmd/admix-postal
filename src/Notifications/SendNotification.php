<?php

namespace Agenciafmd\Postal\Notifications;

use Agenciafmd\Postal\Mails\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

//use Mixdinternet\Admix\Notifications\Channels\DashboardChannel;

class SendNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

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
        return ['mail'/*, DashboardChannel::class*/];
    }

    public function toMail($notifiable)
    {
        return new SendMail($notifiable, $this->from, $this->data, $this->attach, $this->subject);
    }

//    public function toDashboard($notifiable)
//    {
//        if (!$this->from) {
//            $email = config('mail.from.address');
//            $name = config('mail.from.name');
//        } else {
//            $email = key($this->from);
//            $name = current($this->from);
//        }
//
//        return [
//            'name' => "<strong>{$name}</strong> enviou um email para <strong>{$notifiable->to}</strong>",
//            'description' => '',
//            'image' => 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))),
//            'icon' => 'fa fa-envelope-o',
//        ];
//    }
}
