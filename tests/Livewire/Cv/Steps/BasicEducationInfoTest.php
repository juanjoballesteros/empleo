<?php

declare(strict_types=1);

use App\Livewire\Cv\Steps\BasicEducationInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
});

test('basic education screen can be rendered', function () {
    $response = $this->actingAs($this->user)->get('/cv/basic-education-info');

    $response->assertOk();
});

test('can check that not have', function () {
    $response = Livewire::actingAs($this->user)->test(BasicEducationInfo::class)
        ->call('check');

    $response->assertRedirectToRoute('cv.higher-education-info');
    $this->assertDatabaseHas('cvs', [
        'basic' => true,
    ]);
});

test('can be created', function () {
    Storage::fake('public');

    $response = Livewire::actingAs($this->user)->test(BasicEducationInfo::class)
        ->set('program', 'BACHILLER')
        ->set('level', 11)
        ->set('end_date', '2020-01-01')
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/higher-education-info');

    $this->assertDatabaseCount('basic_education_infos', 1);

    Storage::disk('public')->assertExists('1/certification.jpg');
});

test('show validation errors', function () {
    $response = Livewire::actingAs($this->user)->test(BasicEducationInfo::class)
        ->set('level')
        ->set('end_date')
        ->call('store');

    $response->assertHasErrors([
        'level',
        'end_date',
        'certification',
    ])->assertNoRedirect();
});

test('can be updated', function () {
    Storage::fake('public');

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(App\Models\BasicEducationInfo::factory()))
        ->create();
    $basicEducation = $user->cv->basicEducationInfo;
    $basicEducation->addMedia(UploadedFile::fake()->image('certification_1.jpg'))
        ->toMediaCollection();

    $response = Livewire::actingAs($user)->test(BasicEducationInfo::class);

    $response->assertSet('program', 'BACHILLER')
        ->assertSet('level', $basicEducation->level)
        ->assertSet('program', $basicEducation->program)
        ->assertSet('end_date', $basicEducation->end_date->format('Y-m-d'));

    $response->set('level', 11)
        ->set('program', 'BACHILLER')
        ->set('end_date', '2020-01-01')
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertRedirect('/cv/higher-education-info');

    $this->assertDatabaseCount('basic_education_infos', 1);

    Storage::disk('public')->assertExists('2/certification.jpg')
        ->assertMissing('1/certification.jpg');

});
