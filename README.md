## F&MD - Postal

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-postal.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-postal)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Disparos de formulários de forma simples

## Instalação

```
composer require agenciafmd/admix-postal:dev-master
```

Execute a migração

```
php artisan migrate
```

## Request

Crie o arquivo `/packages/agenciafmd/frontend/src/Http/Requests/ContactsRequest.php`

```php
<?php

namespace Agenciafmd\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactsRequest extends FormRequest
{
    protected $errorBag = 'contacts';

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

Crie o arquivo `/packages/agenciafmd/frontend/src/Http/Controllers/ContactsController.php`

```php
<?php

namespace Agenciafmd\Frontend\Http\Controllers;

use Agenciafmd\Frontend\Http\Requests\ContactsRequest;
use Agenciafmd\Postal\Notifications\SendNotification;
use Agenciafmd\Postal\Postal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ContactsController extends Controller
{
    public function index()
    {
        $view = [];

        return view('agenciafmd/frontend::pages.contact', $view);
    }

    public function send(ContactsRequest $request)
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
    'class' => 'form needs-validation' . ((count($errors->contacts) > 0) ? ' was-validated' : ''),
    'autocomplete' => 'off',
    'novalidate' => true
]) }}

{!! Honeypot::generate('hp_name', 'hp_time') !!}

...

<label for="name"
       class="sr-only">Nome</label>
{{ Form::text('name', null, [
    'class' => 'form-control ' . ($errors->contacts->has('name') ? ' is-invalid' : ''),
    'id' => 'name',
    'placeholder' => 'Nome',
    'required' => true,
    ]) !!}
<div class="invalid-feedback">
    <span>
        @if($errors->contacts->has('name'))
            {{ $errors->contacts->first('name') }}
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
Route::get('/fale-conosco', 'ContactsController@index')->name('frontend.contacts.index');
Route::post('/fale-conosco', 'ContactsController@send')->name('frontend.contacts.send');
```
