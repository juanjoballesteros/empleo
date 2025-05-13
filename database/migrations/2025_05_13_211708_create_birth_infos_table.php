<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('birth_infos', function (Blueprint $table): void {
            $table->id();
            $table->date('birthdate');
            $table->boolean('check')->default(true);
            $table->foreignId('department_id');
            $table->foreignId('city_id');
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birth_infos');
    }
};
