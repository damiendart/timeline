<?php

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
