<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    // Show a page by slug
    public function show($slug = 'home')
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return View::make('cms.page')
            ->with('page', $page)
            ->with('blocks', $page->blocks);
    }
}
