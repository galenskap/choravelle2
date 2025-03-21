<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public $menuItems;

    public function __construct()
    {
        $this->menuItems = MenuItem::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('components.main-menu');
    }
} 