@extends('layouts.app')

@section('title', 'Overview')

@section('body')
    @php
        $reverse = false;
    @endphp
    @foreach ($groupedEvents as $year => $months)
        <div class="year-section year-section--{{ $year }}" id="{{ $year }}">
            <div class="year-section__container">
                @foreach ($months as $month => $days)
                    <div class="timeline">
                        <h2 class="timeline__heading">{{ $month }} {{ $year }}</h2>
                        <div class="timeline__items">
                            @foreach ($days as $day => $events)
                                @php
                                    $reverse = !$reverse;
                                @endphp
                                @foreach ($events as $event)
                                    <div class="timeline__items__item{{ $reverse ? ' timeline__items__item--reverse' : '' }}">
                                        @php
                                            /** @var \App\Models\Event $event */
                                        @endphp
                                        <div class="event-card event-card--{{ $event->category?->slug ?? 'generic' }}">
                                            <div class="event-card__header">
                                                <h3 class="event-card__header__title">{{ $event->title }}</h3>
                                                <p class="event-card__header__date">{{ $event->date }}</p>
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
