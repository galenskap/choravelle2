<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Illuminate\View\Component;

class MainMenu extends Component
{
    public $menuItems;
    protected $userIsAuthenticated;

    public function __construct()
    {
        $this->userIsAuthenticated = auth()->check();
        $this->menuItems = MenuItem::getMenu();
    }

    public function shouldRenderItem($item)
    {
        return (!$item->is_private || $this->userIsAuthenticated) && 
               (!$item->parent || !$item->parent->is_private || $this->userIsAuthenticated);
    }

    public function render()
    {
        return view('components.main-menu');
    }
} 