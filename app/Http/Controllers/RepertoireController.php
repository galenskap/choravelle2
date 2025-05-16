<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;

class RepertoireController extends Controller
{
    public function index()
    {
        $seasons = Folder::orderBy('order')
            ->with(['songs' => function ($query) {
                $query->orderBy('folder_song.order');
            }])
            ->get();

        return view('repertoire.index', [
            'seasons' => $seasons,
        ]);
    }
} 