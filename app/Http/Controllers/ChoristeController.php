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
        $partitions = Song::with('files')
            ->orderByDesc(function($query) {
                return $query->select('updated_at')
                    ->from('files')
                    ->whereColumn('song_id', 'songs.id')
                    ->orderByDesc('updated_at')
                    ->limit(1);
            })
            ->orderByDesc('updated_at')
            ->get();

        return view('choriste.partitions', compact('partitions'));
    }

    public function partition(Song $song)
    {
        return view('choriste.partition', compact('song'));
    }
}
