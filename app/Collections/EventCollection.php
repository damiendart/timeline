<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace App\Collections;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class EventCollection extends EloquentCollection
{
    public function groupByDate(): Collection
    {
        return $this
            ->groupBy(
                function (Event $event): string {
                    return Carbon::parse($event->date)->format('Y');
                },
            )->map(
                function (Collection $years) {
                    return $years->groupBy(
                        function (Event $event): string {
                            return Carbon::parse($event->date)->format('m');
                        },
                    )->map(
                        function (Collection $months) {
                            return $months->groupBy(
                                function (Event $event): string {
                                    return Carbon::parse($event->date)->format('d');
                                },
                            );
                        },
                    );
                },
            );
    }
}
