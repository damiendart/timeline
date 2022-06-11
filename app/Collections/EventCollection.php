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
    /** @return Collection<int, Collection<int, Collection<int, Collection<Event>>>> */
    public function groupByDate(): Collection
    {
        // @phpstan-ignore-next-line
        return $this
            ->groupBy('date.year')
            ->map(
                function (Collection $years): Collection {
                    return $years
                        ->groupBy('date.month')
                        ->map(
                            function (Collection $months): Collection {
                                // @phpstan-ignore-next-line
                                return $months->groupBy('date.day');
                            },
                        );
                },
            );
    }
}
