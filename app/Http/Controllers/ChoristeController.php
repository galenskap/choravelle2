<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Pupitre;
use App\Models\Song;

class ChoristeController extends Controller
{
    public function trombinoscope()
    {
        $pupitres = Pupitre::with(['users' => function($query) {
            $query->where('is_active', true)
                  ->orderBy('name');
        }])->get();

        return view('choriste.trombinoscope', compact('pupitres'));
    }

    public function partitions(Request $request)
    {
        $query = Song::with(['files' => function($query) {
            $query->orderBy('updated_at', 'desc');
        }])
        ->with('folders');

        // Filtre par saison si un ID est fourni
        if ($request->folder) {
            $query->whereHas('folders', function ($query) use ($request) {
                $query->where('folders.id', $request->folder);
            });
        }

        $partitions = $query->get()
            ->sortByDesc(function($song) {
                $latestFileDate = $song->files->first()?->updated_at;
                return $latestFileDate && $latestFileDate->gt($song->updated_at) 
                    ? $latestFileDate 
                    : $song->updated_at;
            })
            ->values();

        // Récupérer toutes les saisons pour le filtre
        $folders = \App\Models\Folder::orderBy('name')->get();

        return view('choriste.partitions', compact('partitions', 'folders'));
    }

    public function partition(Song $song)
    {
        return view('choriste.partition', compact('song'));
    }
}
