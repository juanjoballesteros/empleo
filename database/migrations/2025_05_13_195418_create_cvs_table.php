<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table): void {
            $table->id();
            $table->boolean('basic')->default(false);
            $table->boolean('high')->default(false);
            $table->boolean('work')->default(false);
            $table->boolean('lang')->default(false);
            $table->foreignId('user_id');
            $table->foreignId('candidate_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};
