<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
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

    /**
     * Display the specified resource.
     */
    public function show(Event $event): Response
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): Response
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): Response
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): Response
    {
    }
}
