<?php

/*
 * Copyright (c) 2022 Damien Dart, <damiendart@pobox.com>.
 * This file is distributed under the MIT licence. For more information,
 * please refer to the accompanying "LICENCE" file.
 */

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\CategoryFactory;
use Database\Factories\EventFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(
        CategoryFactory $categoryFactory,
        EventFactory $eventFactory,
    ): void {
        $categoryFactory
            ->has($eventFactory->count(50))
            ->count(5)
            ->create();
    }
}
