<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Collections\EventCollection;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Event $event): RedirectResponse
    {
        $years = $event
            ->select('date')
            ->get()
            ->pluckUniqueYearsDesc();

        return redirect()->route(
            'year',
            ['year' => (string) $years->first()],
        );
    }

    public function indexByYear(Event $event, int $year): View
    {
        $years = $event
            ->select('date')
            ->get()
            ->pluckUniqueYearsDesc();

        if ($years->doesntContain($year)) {
            abort(404);
        }

        /** @var EventCollection $events */
        $events = $event->latest('date')
            ->whereYear('date', '=', $year)
            ->with('category')
            ->get();

        return view(
            'events.index',
            [
                'events' => $events,
                'selectedYear' => $year,
                'years' => $years,
            ],
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request, Event $event): RedirectResponse
    {
        $newEvent = $event->create($request->all());

        return redirect()
            ->route('year', ['year' => $newEvent->date->year])
            ->withFragment($newEvent->slug);
    }

    public function show(Event $event): RedirectResponse
    {
        return redirect()
            ->route('year', ['year' => $event->date->year])
            ->withFragment($event->slug);
    }

    public function edit(Event $event): View
    {
        return view(
            'events.edit',
            ['event' => $event],
        );
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->all());

        return redirect()
            ->route('year', ['year' => $event->date->year])
            ->withFragment($event->slug);
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('home');
    }
}
