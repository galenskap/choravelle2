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

    public function partitions()
    {
        $partitions = Song::with(['files' => function($query) {
            $query->orderBy('updated_at', 'desc');
        }])
        ->get()
        ->sortByDesc(function($song) {
            $latestFileDate = $song->files->first()?->updated_at;
            return $latestFileDate && $latestFileDate->gt($song->updated_at) 
                ? $latestFileDate 
                : $song->updated_at;
        })
        ->values();

        return view('choriste.partitions', compact('partitions'));
    }

    public function partition(Song $song)
    {
        return view('choriste.partition', compact('song'));
    }
}
