<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $title = $this->faker->words(4, true);

        return [
            'slug' => Str::slug($title),
            'title' => Str::ucfirst($title),
        ];
    }
}