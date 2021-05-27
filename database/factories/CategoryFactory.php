<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Category::class;

    public function definition(): array
    {
        $title = $this->faker->words(3, true);

        return [
            'title' => Str::ucfirst($title),
            'slug' => Str::slug($title),
        ];
    }
}
