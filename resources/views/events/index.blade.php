@extends('layouts.app')

@section('title', 'Overview')

@section('body')
    @php
        $reverse = false;

        /** @var \App\Collections\EventCollection $events */
    @endphp
    @foreach ($events->groupByDate() as $year => $months)
        <div class="year-section year-section--{{ $year }}" id="{{ $year }}">
            <div class="year-section__container">
                @foreach ($months as $month => $days)
                    <div class="timeline">
                        <h2 class="timeline__heading">{{ \Carbon\Carbon::createFromFormat('m Y', "$month $year")->format('F Y') }}</h2>
                        <div class="timeline__items">
                            @foreach ($days as $day => $events)
                                @php
                                    $reverse = !$reverse;
                                @endphp
                                @foreach ($events as $event)
                                    <div class="timeline__items__item{{ $reverse ? ' timeline__items__item--reverse' : '' }}">
                                        <div class="event-card event-card--{{ $event->category?->slug ?? 'generic' }}">
                                            <div class="event-card__header">
                                                <h3 class="event-card__header__title"><a name="{{ $event->slug }}" href="#{{ $event->slug }}">{{ $event->title }}</a></h3>
                                                <p class="event-card__header__date">{{ $event->date->format('d M Y') }}</p>
                                            </div>
                                            <div class="event-card__body">
                                                <p>{{ $event->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
