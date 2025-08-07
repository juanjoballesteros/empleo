<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BasicEducationInfo;
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
use Faker\Factory;
use Illuminate\Database\Seeder;
use Smknstd\FakerPicsumImages\FakerPicsumImagesProvider;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->for(Company::factory(), 'userable')
            ->create([
                'name' => 'Test User',
                'email' => 'admin@admin.com',
                'password' => '1234sangel',
            ]);

        $candidate = User::factory()
            ->for(Candidate::factory(), 'userable')
            ->create([
                'name' => 'Test Candidate',
                'email' => 'juan@juan.com',
                'password' => '1234sangel',
            ]);

        $cv = Cv::factory()
            ->completed()
            ->for($candidate)
            ->for($candidate->userable)
            ->has(PersonalInfo::factory())
            ->has(ContactInfo::factory())
            ->has(ResidenceInfo::factory())
            ->has(BasicEducationInfo::factory())
            ->has(HigherEducation::factory(2))
            ->has(WorkExperience::factory(2))
            ->has(LanguageInfo::factory(2))
            ->create();

        // Generate Example Images for Cv Steps
        $faker = Factory::create();
        $faker->addProvider(new FakerPicsumImagesProvider($faker));
        $image = $faker->image();

        $cv->personalInfo->addMedia($image)
            ->preservingOriginal()
            ->toMediaCollection('back');

        $cv->personalInfo->addMedia($image)
            ->preservingOriginal()
            ->toMediaCollection('front');

        $cv->personalInfo->addMedia($image)
            ->preservingOriginal()
            ->toMediaCollection('profile');

        $cv->basicEducationInfo->addMedia($image)
            ->preservingOriginal()
            ->toMediaCollection();

        $cv->higherEducations()->each(function (HigherEducation $higherEducation) use ($image) {
            $higherEducation->addMedia($image)
                ->preservingOriginal()
                ->toMediaCollection();
        });

        $cv->workExperiences()->each(function (WorkExperience $workExperience) use ($image) {
            $workExperience->addMedia($image)
                ->preservingOriginal()
                ->toMediaCollection();
        });

        $cv->languageInfos()->each(function (LanguageInfo $languageInfo) use ($image) {
            $languageInfo->addMedia($image)
                ->preservingOriginal()
                ->toMediaCollection();
        });
    }
}
