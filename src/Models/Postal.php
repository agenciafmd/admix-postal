<?php

namespace Agenciafmd\Postal\Models;

use Agenciafmd\Admix\Traits\WithScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Postal extends Model implements AuditableContract
{
    use Auditable, Notifiable, SoftDeletes, WithScopes;

    protected $table = 'postal';

    protected $guarded = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return [$this->to => $this->to_name];
    }
}
