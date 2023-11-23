<?php

namespace Agenciafmd\Postal\Observers;

use Agenciafmd\Postal\Models\Postal;
use Illuminate\Support\Str;

class PostalObserver
{
    public function saving(Postal $postal): void
    {
        if ($slug = $this->generateSlug($postal)) {
            $postal->slug = $slug;
        }
    }

    private function generateSlug(Postal $postal): ?string
    {
        if ($postal->getRawOriginal('name') === $postal->name) {
            return null;
        }

        $slug = Str::of($postal->name)
            ->trim()
            ->slug();
        $lastSlug = $postal->withTrashed()
            ->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")
            ->orderBy('slug', 'desc')
            ->first()?->slug;
        if (!$lastSlug) {
            return $slug;
        }

        $lastSlugId = (int) Str::of($lastSlug)
            ->afterLast('-')
            ->__toString();

        return ($lastSlugId >= 0) ? "{$slug}-" . ($lastSlugId + 1) : $slug;
    }
}
