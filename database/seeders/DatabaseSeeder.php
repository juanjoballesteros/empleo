<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()
            ->for(Company::factory(), 'userable')
            ->create([
                'name' => 'Test User',
                'email' => 'admin@admin.com',
                'password' => '1234sangel',
            ]);

        $user->assignRole(Roles::EMPRESA);

        $candidate = User::factory()
            ->for(Candidate::factory(), 'userable')
            ->create([
                'name' => 'Test Candidate',
                'email' => 'juan@juan.com',
                'password' => '1234sangel',
            ]);

        $candidate->assignRole(Roles::CANDIDATO);
    }
}
