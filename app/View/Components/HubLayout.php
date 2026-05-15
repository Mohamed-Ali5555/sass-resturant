<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class HubLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $mobileTitle = null,
    ) {}

    public function render(): View
    {
        return view('layouts.hub', [
            'documentTitle' => $this->title,
            'mobileNavTitle' => $this->mobileTitle,
        ]);
    }
}
