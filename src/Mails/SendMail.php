<?php

namespace Agenciafmd\Postal\Mails;

use Illuminate\Mail\Mailable;

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

        if ($this->postal->cc) {
            $mail->cc($this->postal->cc);
        }

        if ($this->postal->bcc) {
            $mail->bcc($this->postal->bcc);
        }

        // TODO: refatorar para remover o else
        if ($this->attach) {
            if (is_array($this->attach)) {
                foreach ($this->attach as $attach) {
                    $mail->attach($attach);
                }
            } else {
                $mail->attach($this->attach);
            }
        }

        $this->withSwiftMessage(function ($message) {
            $headers = $message->getHeaders();
            $headers->addTextHeader('X-Mailgun-Tag', config('app.name'));
        });

        return $mail;
    }
}
