<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function upcoming()
    {
        $events = Event::query()
            ->where('date', '>=', Carbon::today())
            ->where(function ($query) {
                $query->where('members_only', false)
                    ->orWhere(function ($query) {
                        $query->where('members_only', true)
                            ->where(function ($query) {
                                $query->where(fn() => Auth::check());
                            });
                    });
            })
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('events.upcoming', compact('events'));
    }

    public function past()
    {
        $events = Event::query()
            ->where('date', '<', Carbon::today())
            ->where(function ($query) {
                $query->where('members_only', false)
                    ->orWhere(function ($query) {
                        $query->where('members_only', true)
                            ->where(function ($query) {
                                $query->where(fn() => Auth::check());
                            });
                    });
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(5);

        return view('events.past', compact('events'));
    }
} 