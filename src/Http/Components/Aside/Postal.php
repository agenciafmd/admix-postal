<?php

namespace Agenciafmd\Postal\Http\Components\Aside;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Postal extends Component
{
    public function __construct(
        public string $icon = '',
        public string $label = '',
        public string $url = '',
        public bool   $active = false,
        public bool   $visible = false,
    )
    {
    }

    public function render(): View
    {
        $this->icon = __(config('admix-postal.icon'));
        $this->label = __(config('admix-postal.name'));
        $this->url = route('admix.postal.index');
        $this->active = request()?->currentRouteNameStartsWith('admix.postal');
        $this->visible = true;

        return view('admix::components.aside.item');
    }
}