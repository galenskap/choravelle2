<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                            ->when(Auth::check(), function ($query) {
                                return $query;
                            }, function ($query) {
                                return $query->where('id', null);
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
                            ->when(Auth::check(), function ($query) {
                                return $query;
                            }, function ($query) {
                                return $query->where('id', null);
                            });
                    });
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(5);

        return view('events.past', compact('events'));
    }

    public function show(Event $event)
    {
        if (!auth()->check() && $event->members_only) {
            abort(403);
        }

        return view('events.show', compact('event'));
    }
} 