<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class KitchenLayout extends Component
{
    public function __construct(
        public readonly string $title = 'Kitchen Display',
    ) {}

    public function render(): View
    {
        return view('layouts.kitchen');
    }
}
