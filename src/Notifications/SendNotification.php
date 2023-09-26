<?php

namespace Agenciafmd\Postal\Notifications;

//use Agenciafmd\Leads\Channels\LeadChannel;
use Agenciafmd\Postal\Models\Postal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Symfony\Component\Mime\Email;

//use Agenciafmd\Leads\Models\Lead;

class SendNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function __construct(
        public array $data = [],
        public array $from = [],
        public array $attach = [],
        public ?string $subject = null,
    ) {
        //
    }

    public function via(Postal $notifiable): array
    {
        return [
            MailChannel::class,
//            LeadChannel::class,
        ];
    }

    public function toMail(Postal $notifiable): MailMessage
    {
        $content = array_merge([
            'greeting' => __('Hi :name!', ['name' => $notifiable->to_name]),
            'introLines' => [
                __('This email sent by the website through the :name form.', ['name' => $notifiable->name]),
            ],
            'outroLines' => [
            ],
        ], $this->data);

        $mail = (new MailMessage())
            ->markdown('admix-mail::markdown.email')
            ->theme('admix-mail::theme.tabler')
            ->level('default')
            ->subject(($this->subject) ?? config('app.name') . ' | ' . $notifiable->subject);

        if ($content['greeting']) {
            $mail->greeting($content['greeting']);
        }

        foreach ($content['introLines'] as $introLine) {
            $mail->line($introLine);
        }

        if ($content['actionText'] && $content['actionUrl']) {
            $mail->action($content['actionText'], $content['actionUrl']);
        }

        foreach ($content['outroLines'] as $outroLine) {
            $mail->line($outroLine);
        }

        if ($this->from) {
            $mail->replyTo(key($this->from), current($this->from));
        }

        if ($cc = $notifiable->cc) {
            $ccs = array_map('trim', explode(',', $cc));
            foreach ($ccs as $cc) {
                $mail->cc($cc);
            }
        }

        if ($bcc = $notifiable->bcc) {
            $bccs = array_map('trim', explode(',', $bcc));
            foreach ($bccs as $bcc) {
                $mail->bcc($bcc);
            }
        }

        /* TODO: modificar para o attachFromStorage quando subir a versão do laravel */
        foreach ($this->attach as $attach) {
            $mail->attach($attach);
        }

        $mail->withSymfonyMessage(function (Email $message) {
            $message->getHeaders()
                ->addTextHeader(
                    'X-Mailgun-Tag', config('app.name')
                );
        });

        return $mail;
    }

//    public function toLead($data)
//    {
//        Lead::create([
//            'source' => $data['source'],
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'phone' => $data['phone'],
//            'description' => $data['message'],
//        ]);
//    }
}
