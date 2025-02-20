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
        $partitions = Song::all();
        return view('choriste.partitions', compact('partitions'));
    }
}
