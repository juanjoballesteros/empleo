<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->bigInteger('salary');
            $table->string('type');
            $table->string('location');
            $table->foreignId('department_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('company_id');
            $table->timestamps();
        });
    }
};
