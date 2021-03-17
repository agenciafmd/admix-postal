<?php

namespace Agenciafmd\Postal\Mails;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Arr;

class SendMail extends Mailable
{
    public $subject;
    protected $postal;
    protected $sendFrom;
    protected $data;
    protected $attach;

    public function __construct($postal, $sendFrom, $data, $attach, $subject)
    {
        $this->postal = $postal;

        $this->sendFrom = $sendFrom;

        $this->data = $data;

        $this->attach = $attach;

        $this->subject = $subject;
    }

    public function build()
    {
        $content = array_merge([
            'greeting' => 'Olá ' . $this->postal->to_name . '!',
            'introLines' => [
                'Segue e-mail enviado pelo site através do formulário de ' . $this->postal->name,
            ],
            'outroLines' => [
            ],
        ], $this->data);

        $mail = $this->to($this->postal->to, $this->postal->to_name)
            ->subject(($this->subject) ?? config('app.name') . ' | ' . $this->postal->subject)
            ->markdown('agenciafmd/admix::markdown.email')
            ->with($content);

        if ($this->sendFrom) {
            $mail->replyTo(key($this->sendFrom), current($this->sendFrom));
        }

        if ($cc = $this->postal->cc) {
            $ccs = explode(',', $cc);
            foreach ($ccs as $cc) {
                $mail->cc($cc);
            }
        }

        if ($bcc = $this->postal->bcc) {
            $bccs = explode(',', $bcc);
            foreach ($bccs as $bcc) {
                $mail->bcc($bcc);
            }
        }

        if ($this->attach) {
            foreach (Arr::wrap($this->attach) as $attach) {
                $mail->attach($attach);
            }
        }

        $this->withSwiftMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Tag', config('app.name'));
        });

        return $mail;
    }
}
