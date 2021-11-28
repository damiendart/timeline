<?php

declare(strict_types=1);

namespace Database\Seeders;

use Database\Factories\EventFactory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(EventFactory $eventFactory): void
    {
        $eventFactory->count(250)->create();
    }
}
