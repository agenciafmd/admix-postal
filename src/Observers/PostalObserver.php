<?php

namespace Agenciafmd\Postal\Observers;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Support\Str;

class PostalObserver
{
    public function saving(Postal $postal): void
    {
        $slug = Str::of($postal->name)
            ->trim()
            ->slug();
        $count = $postal->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")
            ->count();
        $postal->slug = $count ? "{$slug}-{$count}" : $slug;
    }
}
