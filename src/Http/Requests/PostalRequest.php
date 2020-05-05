<?php

namespace Agenciafmd\Postal\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class PostalRequest extends FormRequest
{
    protected $errorBag = 'admix';

    public function rules()
    {
        return [
            'is_active' => ['required', 'boolean'],
            'name' => ['required', 'max:150'],
            'to_name' => ['required', 'max:150'],
            'to' => ['required', 'email'],
            'subject' => ['required', 'max:150'],
            'cc' => function ($attribute, $value, $fail) {
                $emails = explode(',', $value);

                foreach ($emails as $email) {
                    $validation = Validator::make(['email' => $email], ['email' => ['nullable', 'email']]);

                    if ($validation->fails()) {
                        $fail('O(s) email(s) em cópia não está(ão) em um formato válido');
                    }
                }
            },
            'bcc' => function ($attribute, $value, $fail) {
                $emails = explode(',', $value);

                foreach ($emails as $email) {
                    $validation = Validator::make(['email' => $email], ['email' => ['nullable', 'email']]);

                    if ($validation->fails()) {
                        $fail('O(s) email(s) em cópia oculta não está(ão) em um formato válido');
                    }
                }
            },
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'to_name' => 'para (nome)',
            'to' => 'para (email)',
            'subject' => 'assunto',
            'cc' => 'cópia',
            'bcc' => 'cópia oculta',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
