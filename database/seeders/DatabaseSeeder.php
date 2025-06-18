<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\BasicEducationInfo;
use App\Models\BirthInfo;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\ContactInfo;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\LanguageInfo;
use App\Models\PersonalInfo;
use App\Models\ResidenceInfo;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\WorkExperience;
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

        Cv::factory()
            ->for($candidate)
            ->for($candidate->userable)
            ->has(PersonalInfo::factory())
            ->has(BirthInfo::factory())
            ->has(ContactInfo::factory())
            ->has(ResidenceInfo::factory())
            ->has(BasicEducationInfo::factory())
            ->has(HigherEducation::factory(2))
            ->has(WorkExperience::factory(2))
            ->has(LanguageInfo::factory(2))
            ->create();
    }
}
