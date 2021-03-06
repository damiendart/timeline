<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace App\Models;

use App\Collections\EventCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'date' => 'immutable_datetime:Y-m-d',
    ];

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'date',
        'description',
        'slug',
        'title',
    ];

    /**
     * @return BelongsTo<Category, Event>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @param Event[] $models
     */
    public function newCollection(array $models = []): EventCollection
    {
        return new EventCollection($models);
    }
}
