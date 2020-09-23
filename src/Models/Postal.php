<?php

namespace Agenciafmd\Postal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Postal extends Model implements AuditableContract, Searchable
{
    use SoftDeletes, Auditable, Notifiable;

    protected $table = 'postal';

    protected $guarded = [
        //
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public $searchableType = "Formulários";

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            "{$this->name} ({$this->to})",
            route('admix.postal.edit', $this->id)
        );
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
        if(!$value) {
            return null;
        }
        
        return str_replace([' ', ','], ['', ','], $value);
    }
}
