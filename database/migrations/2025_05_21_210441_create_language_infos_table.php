<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('language_infos', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('write');
            $table->string('speak');
            $table->string('read');
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('language_infos');
    }
};
