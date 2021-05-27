<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = $this->faker->words(4, true);

        return [
            'date' => $this->faker->dateTimeThisDecade(),
            'description' => $this->faker->paragraph(),
            'slug' => Str::slug($title),
            'title' => Str::ucfirst($title),
        ];
    }
}
