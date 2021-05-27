<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->timestamps();

            $table->unique(['slug', 'title']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
