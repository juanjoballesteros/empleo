<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
        });

        DB::insert("INSERT INTO departments (id, name) VALUES
            (5, 'ANTIOQUIA'),
            (8, 'ATLANTICO'),
            (11, 'BOGOTA D.C.'),
            (13, 'BOLIVAR'),
            (15, 'BOYACA'),
            (17, 'CALDAS'),
            (18, 'CAQUETA'),
            (19, 'CAUCA'),
            (20, 'CESAR'),
            (23, 'CORDOBA'),
            (25, 'CUNDINAMARCA'),
            (27, 'CHOCO'),
            (41, 'HUILA'),
            (44, 'LA GUAJIRA'),
            (47, 'MAGDALENA'),
            (50, 'META'),
            (52, 'NARIÑO'),
            (54, 'NORTE DE SANTANDER'),
            (63, 'QUINDIO'),
            (66, 'RISARALDA'),
            (68, 'SANTANDER'),
            (70, 'SUCRE'),
            (73, 'TOLIMA'),
            (76, 'VALLE DEL CAUCA'),
            (81, 'ARAUCA'),
            (85, 'CASANARE'),
            (86, 'PUTUMAYO'),
            (88, 'ARCHIPIELAGO DE SAN ANDRES, PROVIDENCIA Y SANTA CATALINA'),
            (91, 'AMAZONAS'),
            (94, 'GUAINIA'),
            (95, 'GUAVIARE'),
            (97, 'VAUPES'),
            (99, 'VICHADA')");
    }
};
