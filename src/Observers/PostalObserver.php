<?php

namespace Agenciafmd\Postal\Observers;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Support\Str;

class PostalObserver
{
    public function saving(Postal $postal): void
    {
        $postal->slug = Str::of($postal->name)
            ->trim()
            ->slug();
    }
}
