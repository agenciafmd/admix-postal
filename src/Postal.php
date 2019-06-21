<?php

namespace Agenciafmd\Postal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#use Mixdinternet\Sortable\Traits\Sortable;

class Postal extends Model implements AuditableContract
{
    use SoftDeletes, Auditable, HasSlug, Notifiable;

    protected $table = 'postal';

    protected $guarded = [
        //
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeIsActive($query)
    {
        $query->where('is_active', 1)
            ->sort();
    }
}