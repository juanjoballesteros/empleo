<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residence_infos', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id');
            $table->foreignId('city_id');
            $table->string('address');
            $table->boolean('check')->default(true);
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residence_infos');
    }
};
