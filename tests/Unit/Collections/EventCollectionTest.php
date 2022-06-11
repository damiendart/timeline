<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

namespace Tests\Unit\Collections;

use App\Collections\EventCollection;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @internal
 * @covers \App\Collections\EventCollection
 */
class EventCollectionTest extends TestCase
{
    public function testGroupingEventsByYearMonthAndDay(): void
    {
        $collection = new EventCollection();

        $collection->push(
            new Event(['date' => Carbon::parse('2022-09-05')]),
            new Event(['date' => Carbon::parse('2022-09-04')]),
            new Event(['date' => Carbon::parse('2022-09-04')]),
            new Event(['date' => Carbon::parse('2021-05-21')]),
            new Event(['date' => Carbon::parse('2022-05-21')]),
            new Event(['date' => Carbon::parse('2023-05-21')]),
            new Event(['date' => Carbon::parse('2023-05-21')]),
            new Event(['date' => Carbon::parse('2023-01-12')]),
            new Event(['date' => Carbon::parse('2023-01-11')]),
        );

        $grouped = $collection->groupByYearMonthAndDay();

        $this->assertInstanceOf(Collection::class, $grouped);

        $this->assertSame($collection[0], $grouped[2022][9][5][0]);
        $this->assertSame($collection[1], $grouped[2022][9][4][0]);
        $this->assertSame($collection[2], $grouped[2022][9][4][1]);
        $this->assertSame($collection[3], $grouped[2021][5][21][0]);
        $this->assertSame($collection[4], $grouped[2022][5][21][0]);
        $this->assertSame($collection[5], $grouped[2023][5][21][0]);
        $this->assertSame($collection[6], $grouped[2023][5][21][1]);
        $this->assertSame($collection[7], $grouped[2023][1][12][0]);
        $this->assertSame($collection[8], $grouped[2023][1][11][0]);

        $this->assertEquals([2021, 2022, 2023], $grouped->keys()->toArray());
        $this->assertEquals([5, 9], $grouped[2022]->keys()->toArray());
        $this->assertEquals([1, 5], $grouped[2023]->keys()->toArray());
        $this->assertEquals([4, 5], $grouped[2022][9]->keys()->toArray());
        $this->assertEquals([21], $grouped[2022][5]->keys()->toArray());
        $this->assertEquals([11, 12], $grouped[2023][1]->keys()->toArray());
        $this->assertEquals([21], $grouped[2022][5]->keys()->toArray());
    }

    public function testGroupingEventsByYearMonthAndDayDescending(): void
    {
        $collection = new EventCollection();

        $collection->push(
            new Event(['date' => Carbon::parse('2022-09-05')]),
            new Event(['date' => Carbon::parse('2022-09-04')]),
            new Event(['date' => Carbon::parse('2022-09-04')]),
            new Event(['date' => Carbon::parse('2021-05-21')]),
            new Event(['date' => Carbon::parse('2022-05-21')]),
            new Event(['date' => Carbon::parse('2023-05-21')]),
            new Event(['date' => Carbon::parse('2023-05-21')]),
            new Event(['date' => Carbon::parse('2023-01-12')]),
            new Event(['date' => Carbon::parse('2023-01-11')]),
        );

        $grouped = $collection->groupByYearMonthAndDayDesc();

        $this->assertInstanceOf(Collection::class, $grouped);

        $this->assertSame($collection[0], $grouped[2022][9][5][0]);
        $this->assertSame($collection[1], $grouped[2022][9][4][0]);
        $this->assertSame($collection[2], $grouped[2022][9][4][1]);
        $this->assertSame($collection[3], $grouped[2021][5][21][0]);
        $this->assertSame($collection[4], $grouped[2022][5][21][0]);
        $this->assertSame($collection[5], $grouped[2023][5][21][0]);
        $this->assertSame($collection[6], $grouped[2023][5][21][1]);
        $this->assertSame($collection[7], $grouped[2023][1][12][0]);
        $this->assertSame($collection[8], $grouped[2023][1][11][0]);

        $this->assertEquals([2023, 2022, 2021], $grouped->keys()->toArray());
        $this->assertEquals([9, 5], $grouped[2022]->keys()->toArray());
        $this->assertEquals([5, 1], $grouped[2023]->keys()->toArray());
        $this->assertEquals([5, 4], $grouped[2022][9]->keys()->toArray());
        $this->assertEquals([21], $grouped[2022][5]->keys()->toArray());
        $this->assertEquals([12, 11], $grouped[2023][1]->keys()->toArray());
        $this->assertEquals([21], $grouped[2022][5]->keys()->toArray());
    }
}
