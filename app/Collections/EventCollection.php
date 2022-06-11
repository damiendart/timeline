<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace App\Collections;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class EventCollection extends EloquentCollection
{
    /**
     * @return Collection<int, Collection<int, Collection<int, Collection<Event>>>>
     */
    public function groupByYearMonthAndDay(bool $descending = false): Collection
    {
        // @phpstan-ignore-next-line
        return $this
            ->groupBy('date.year')
            ->sortKeys(SORT_REGULAR, $descending)
            ->map(
                function (Collection $years) use ($descending): Collection {
                    return $years
                        ->groupBy('date.month')
                        ->sortKeys(SORT_REGULAR, $descending)
                        ->map(
                            function (Collection $months) use ($descending): Collection {
                                return $months
                                    ->groupBy('date.day')
                                    ->sortKeys(SORT_REGULAR, $descending)
                                    ->map(
                                        fn (Collection $events): Collection => $events->sortBy(
                                            'date',
                                            SORT_REGULAR,
                                            $descending,
                                        ),
                                    );
                            },
                        );
                },
            );
    }

    /** @return Collection<int, Collection<int, Collection<int, Collection<Event>>>> */
    public function groupByYearMonthAndDayDesc(): Collection
    {
        return $this->groupByYearMonthAndDay(true);
    }
}
