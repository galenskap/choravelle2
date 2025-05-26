<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public function render()
    {
        $menuItems = MenuItem::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->with(['children' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->get();

        return view('components.main-menu', [
            'menuItems' => $menuItems
        ]);
    }
} 