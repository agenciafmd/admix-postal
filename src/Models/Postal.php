<?php

namespace Agenciafmd\Postal\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Postal extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Notifiable, WithScopes;

    protected $table = 'postal';

    protected $guarded = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function cc(): Attribute
    {
        return Attribute::make(
            set: fn(?string $values) => $this->normalizeCopies($values),
        );
    }

    protected function bcc(): Attribute
    {
        return Attribute::make(
            set: fn(?string $values) => $this->normalizeCopies($values),
        );
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return [$this->to => $this->to_name];
    }

    private function normalizeCopies(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return Str::of($value)
            ->squish()
            ->replace(' ', '')
            ->replace(';', ',')
            ->explode(',')
            ->map(fn($value) => trim($value))
            ->implode(',');
    }
}
