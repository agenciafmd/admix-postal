## F&MD - Postal

![Área Administrativa](https://github.com/agenciafmd/admix-postal/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-postal.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-postal)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Disparos de formulários de forma simples e configurável pelo admix

## Instalação

```bash
composer require agenciafmd/admix-postal:dev-master
```

Execute a migração

```bash
php artisan migrate
```

Se precisar do seed, faça a publicação

```bash
php artisan vendor:publish --tag=admix-postal:seeders
```

**não esqueça do `composer dumpautoload`**

## Request

Crie o arquivo `/packages/agenciafmd/frontend/src/Http/Requests/ContactRequest.php`

```php
<?php

namespace Agenciafmd\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    protected $errorBag = 'contact';

    public function rules()
    {
        return [
            'hp_name' => 'honeypot',
            'hp_time' => 'required|honeytime:5',

            'subject' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'city' => 'required',
            'state' => 'required',
            'message' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nome',
            'phone' => 'telefone',
            'city' => 'cidade',
            'state' => 'estado',
            'message' => 'mensagem'
        ];
    }

    public function authorize()
    {
        return true;
    }
}

```

## Controller

Crie o arquivo `/packages/agenciafmd/frontend/src/Http/Controllers/ContactController.php`

```php
<?php

namespace Agenciafmd\Frontend\Http\Controllers;

use Agenciafmd\Frontend\Http\Requests\ContactRequest;
use Agenciafmd\Postal\Notifications\SendNotification;
use Agenciafmd\Postal\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function index()
    {
        $view = [];

        return view('agenciafmd/frontend::pages.contact', $view);
    }

    public function send(ContactRequest $request)
    {

        // se houver anexos
        $attachments = null;
        if ($request->has('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $customName = Str::slug($request->get('name') . '-' . str_random(5)) . '.' . $image->getClientOriginalExtension();
                $attachments[] = storage_path(
                    'app/' . $image
                        ->storeAs('attachments', $customName, 'local')
                );
            }
        }

        // para customizar o assunto do email
        $subject = null;

        Postal::where('slug', Str::slug($request->get('subject')))->first()->notify(new SendNotification([
            'greeting' => $request->get('subject'),
            'introLines' => [
                '**Nome:** ' . $request->get('name'),
                '**E-mail:** ' . $request->get('email'),
                '**Telefone:** ' . $request->get('phone'),
                '**Cidade:** ' . $request->get('city') . ' - ' . $request->get('state'),
                '**Mensagem:** ' . nl2br($request->get('message')),
            ],
        ], [$request->get('email') => $request->get('name')], $attachments, $subject));

        flash('Mensagem enviada com sucesso')->success();

        return back();
    }
}
```

## Formulário

Crie o arquivo `/packages/agenciafmd/frontend/src/resources/views/pages/contact.blade.php`

```blade
{{ Form::open([
    'route' => 'frontend.contacts.send',
    'id' => 'form-contact',
    'class' => 'form needs-validation' . ((count($errors->contact) > 0) ? ' was-validated' : ''),
    'autocomplete' => 'off',
    'novalidate' => true
]) }}

{!! Honeypot::generate('hp_name', 'hp_time') !!}

...

<label for="name"
       class="sr-only">Nome</label>
{{ Form::text('name', null, [
    'class' => 'form-control ' . ($errors->contact->has('name') ? ' is-invalid' : ''),
    'id' => 'name',
    'placeholder' => 'Nome',
    'required' => true,
    ]) !!}
<div class="invalid-feedback">
    <span>
        @if($errors->contact->has('name'))
            {{ $errors->contact->first('name') }}
        @else
            O campo nome é obrigatório
        @endif
    </span>
</div>

...

{{ Form::close() }}
```

## Rotas

Crie o arquivo `/packages/agenciafmd/frontend/src/routes/web.php`

```php
Route::get('/fale-conosco', [ContactController::class, 'index'])
    ->name('frontend.contacts.index');
Route::post('/fale-conosco', [ContactController::class, 'send'])
    ->name('frontend.contacts.send');
```
