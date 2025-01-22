## F&MD - Postal

![Área Administrativa](https://github.com/agenciafmd/admix-postal/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-postal.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-postal)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Map all forms from your application and send them to specific emails

## Installation

```bash
composer require agenciafmd/admix-postal:dev-master
```

Run the migrations

```bash
php artisan migrate
```

If you want to use the seeder, run

```bash
php artisan vendor:publish --tag=admix-postal:seeders
```

## Usage

```php
    // if you want to send attachments
    $attachments = null;
    if ($request->has('images')) {
        $images = $request->file('images');
        foreach ($images as $image) {
            $customName = Str::of($request->name)->slug() . '-' . Str::random(5) . '.' . $image->getClientOriginalExtension();
            /* TODO: refactor with Storage */
            $attachments[] = storage_path(
                'app/' . $image
                    ->storeAs('attachments', $customName, 'local')
            );
        }
    }

    // fill if you want to customize the subject
    $customSubject = null;
    Postal::query()
        ->where('slug', 'slug-of-created-form')
        ->first()
        ->notify(new SendNotification([
            'greeting' => $request->subject,
            'introLines' => [
                '**Nome:** ' . $request->name,
                '**E-mail:** ' . $request->email,
                '**Telefone:** ' . $request->phone,
                '**Cidade:** ' . $request->city . ' - ' . $request->state,
                '**Mensagem:** ' . nl2br($request->message),
            ],
        ], [$request->email => $request->name], $attachments, $customSubject));
```
