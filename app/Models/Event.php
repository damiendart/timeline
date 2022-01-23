<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    protected $fillable = [
        'date',
        'description',
        'slug',
        'title',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getAllEventsGroupedByDate(): Collection
    {
        return $this->latest('date')
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
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
