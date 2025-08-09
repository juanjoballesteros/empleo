<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('higher_education', function (Blueprint $table): void {
            $table->id();
            $table->string('program');
            $table->string('institution');
            $table->string('type');
            $table->date('date_start');
            $table->string('actual');
            $table->date('date_end')->nullable();
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('higher_education');
    }
};
