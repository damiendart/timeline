<?php

// Copyright (C) 2022 Damien Dart, <damiendart@pobox.com>.
// This file is distributed under the MIT licence. For more information,
// please refer to the accompanying "LICENCE" file.

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create(
            'categories',
            function (Blueprint $table): void {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title')->unique();
                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
