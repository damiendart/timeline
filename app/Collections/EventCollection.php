<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Collections;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @extends EloquentCollection<int, Event>
 */
class EventCollection extends EloquentCollection
{
    /**
     * @return Collection<int, Collection<int, Collection<int, Collection<int, Event>>>>
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

    /**
     * @return Collection<int, Collection<int, Collection<int, Collection<int, Event>>>>
     */
    public function groupByYearMonthAndDayDesc(): Collection
    {
        return $this->groupByYearMonthAndDay(true);
    }

    /**
     * @return Collection<int, int>
     */
    public function pluckUniqueYears(bool $descending = false): Collection
    {
        return $this->pluck('date')
            ->map(fn (Carbon $date) => $date->year)
            ->unique()
            ->unless(
                $descending,
                fn (Collection $collection, bool $_) => $collection->sort(),
                fn (Collection $collection, bool $_) => $collection->sortDesc(),
            )
            ->values();
    }

    /**
     * @return Collection<int, int>
     */
    public function pluckUniqueYearsDesc(): Collection
    {
        return $this->pluckUniqueYears(true);
    }
}
