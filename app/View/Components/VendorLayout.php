<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class VendorLayout extends Component
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
            'sidebarPartial' => 'layouts.partials.vendor-sidebar',
            'shellFlashPartial' => 'vendor.partials.flash',
            'panelAriaLabel' => __('Vendor panel navigation'),
        ]);
    }
}
