<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_experiences', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->date('date_start')->nullable();
            $table->boolean('actual');
            $table->date('date_end')->nullable();
            $table->string('post');
            $table->string('email');
            $table->bigInteger('phone');
            $table->string('address');
            $table->foreignId('department_id');
            $table->foreignId('city_id');
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }
};
