<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $groupedEvents = Event::latest('date')
            ->with('category')
            ->get()
            ->groupBy(
                function (Event $event) {
                    return Carbon::parse($event->date)->format('Y');
                },
            )->map(
                function (Collection $years) {
                    return $years->groupBy(
                        function (Event $event) {
                            return Carbon::parse($event->date)->format('m');
                        }
                    )->map(
                        function (Collection $months) {
                            return $months->groupBy(
                                function (Event $event) {
                                    return Carbon::parse($event->date)->format('d');
                                }
                            );
                        }
                    );
                },
            );

        return view(
            'events.index',
            ['groupedEvents' => $groupedEvents],
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
    }

    public function show(Event $event): RedirectResponse
    {
        return redirect()->route('home')->withFragment($event->slug);
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

        return redirect()->route('home')->withFragment($event->slug);
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('home');
    }
}
