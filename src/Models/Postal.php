<?php

namespace Agenciafmd\Postal\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Agenciafmd\Admix\Traits\WithSlug;
use Agenciafmd\Postal\Observers\PostalObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

#[ObservedBy([PostalObserver::class])]
class Postal extends Model implements AuditableContract
{
    use Auditable, Notifiable, Prunable, SoftDeletes, WithScopes, WithSlug;

    protected $table = 'postal';

    protected array $defaultSort = [
        'is_active' => 'desc',
        'name' => 'asc',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function prunable(): Builder
    {
        return static::query()->where('deleted_at', '<=', now()->subYear());
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return [$this->to => $this->to_name];
    }
}
