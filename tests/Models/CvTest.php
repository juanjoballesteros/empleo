<?php

declare(strict_types=1);

use App\Models\BasicEducationInfo;
use App\Models\Candidate;
use App\Models\ContactInfo;
use App\Models\Cv;
use App\Models\HigherEducation;
use App\Models\LanguageInfo;
use App\Models\PersonalInfo;
use App\Models\ResidenceInfo;
use App\Models\User;
use App\Models\WorkExperience;

test('to array', function () {
    $cv = Cv::factory()->create()->fresh();

    expect(array_keys($cv->toArray()))->toEqual([
        'id',
        'basic',
        'high',
        'work',
        'lang',
        'user_id',
        'candidate_id',
        'chat_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a user', function () {
    $cv = Cv::factory()->create();

    expect($cv->user)->toBeInstanceOf(User::class);
});

test('belongs to a candidate', function () {
    $cv = Cv::factory()->create();

    expect($cv->candidate)->toBeInstanceOf(Candidate::class);
});

test('has one personal info', function () {
    $cv = Cv::factory()->has(PersonalInfo::factory())->create();

    expect($cv->personalInfo)->toBeInstanceOf(PersonalInfo::class);
});

test('has one contact info', function () {
    $cv = Cv::factory()->has(ContactInfo::factory())->create();

    expect($cv->contactInfo)->toBeInstanceOf(ContactInfo::class);
});

test('has one residence info', function () {
    $cv = Cv::factory()->has(ResidenceInfo::factory())->create();

    expect($cv->residenceInfo)->toBeInstanceOf(ResidenceInfo::class);
});

test('has one basic education info', function () {
    $cv = Cv::factory()->has(BasicEducationInfo::factory())->create();

    expect($cv->basicEducationInfo)->toBeInstanceOf(BasicEducationInfo::class);
});

test('has many higher education info', function () {
    $cv = Cv::factory()->has(HigherEducation::factory(3))->create();

    expect($cv->higherEducations)->toHaveCount(3)->each->toBeInstanceOf(HigherEducation::class);
});

test('has many work experiences', function () {
    $cv = Cv::factory()->has(WorkExperience::factory(3))->create();

    expect($cv->workExperiences)->toHaveCount(3)->each->toBeInstanceOf(WorkExperience::class);
});

test('has many languages info', function () {
    $cv = Cv::factory()->has(LanguageInfo::factory(3))->create();

    expect($cv->languageInfos)->toHaveCount(3)->each->toBeInstanceOf(LanguageInfo::class);
});
