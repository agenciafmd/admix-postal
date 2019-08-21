<?php

namespace Agenciafmd\Postal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Postal extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, Notifiable;

    protected $table = 'postal';

    protected $guarded = [
        //
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function setCcAttribute($value)
    {
        $this->attributes['cc'] = $this->normalizeCopies($value);
    }

    public function setBccAttribute($value)
    {
        $this->attributes['bcc'] = $this->normalizeCopies($value);
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1);
    }

    private function normalizeCopies($value)
    {
        return str_replace([' ', ','], ['', ','], $value);
    }
}
