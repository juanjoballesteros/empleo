<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_infos', function (Blueprint $table): void {
            $table->id();
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('first_surname');
            $table->string('second_surname')->nullable();
            $table->string('sex');
            $table->string('document_type');
            $table->string('document_number');
            $table->date('birthdate');
            $table->text('description')->nullable();
            $table->boolean('check')->default(true);
            $table->foreignId('department_id');
            $table->foreignId('city_id');
            $table->foreignId('cv_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_infos');
    }
};
