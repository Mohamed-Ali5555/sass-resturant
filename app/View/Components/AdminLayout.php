<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $mobileTitle = null,
    ) {}

    public function render(): View
    {
        return view('layouts.panel-shell', [
            'documentTitle' => $this->title,
            'mobileNavTitle' => $this->mobileTitle,
            'sidebarPartial' => 'layouts.partials.admin-sidebar',
            'shellFlashPartial' => 'admin.partials.flash',
            'panelAriaLabel' => __('Admin panel navigation'),
        ]);
    }
}
