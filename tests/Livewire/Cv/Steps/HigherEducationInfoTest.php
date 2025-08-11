<?php

declare(strict_types=1);

use App\Livewire\Cv\Steps\HigherEducation\Create;
use App\Livewire\Cv\Steps\HigherEducation\Edit;
use App\Livewire\Cv\Steps\HigherEducationInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\HigherEducation;
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

test('higher education screen can be rendered', function () {
    $response = $this->actingAs($this->user)->get('/cv/higher-education-info');

    $response->assertOk();
});

test('can check that not have', function () {
    $response = Livewire::actingAs($this->user)->test(HigherEducationInfo::class)
        ->call('check');

    $response->assertRedirectToRoute('cv.work-experience-info');
    $this->assertDatabaseHas('cvs', [
        'high' => true,
    ]);
});

test('can be created', function () {
    Storage::fake();

    $response = Livewire::actingAs($this->user)->test(Create::class, ['cv' => $this->user->cv])
        ->set('program', 'Programa')
        ->set('institution', 'Institución')
        ->set('type', 'UN')
        ->set('date_start', '2020-01-01')
        ->set('actual', false)
        ->set('date_end', '2020-02-03')
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('store');

    $response->assertHasNoErrors()
        ->assertDispatched('high.create');

    $this->assertDatabaseCount('higher_education', 1);
});

test('show validation errors', function () {
    $response = Livewire::actingAs($this->user)->test(Create::class)
        ->set('program', '')
        ->set('type', '')
        ->call('store');

    $response->assertHasErrors([
        'program',
        'type',
    ])->assertNoRedirect();

    $this->assertDatabaseCount('higher_education', 0);
});

test('can be deleted', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(HigherEducation::factory(2)))
        ->create();

    $this->assertDatabaseCount('higher_education', 2);

    $response = Livewire::actingAs($user)->test(HigherEducationInfo::class)
        ->call('delete', $user->cv->higherEducations()->first());

    $response->assertNoRedirect();
    $this->assertDatabaseCount('higher_education', 1);
});

test('send to work experience', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(HigherEducation::factory(2)))
        ->create();

    $response = Livewire::actingAs($user)
        ->test(HigherEducationInfo::class)
        ->call('navigate');

    $response->assertRedirect('/cv/work-experience-info');
});

test('can be updated', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(HigherEducation::factory(2)))
        ->create();
    $higherEducation = $user->cv->higherEducations->first();
    $higherEducation->addMedia(UploadedFile::fake()->image('certification_1.jpg'))
        ->toMediaCollection();

    $response = Livewire::actingAs($user)->test(Edit::class)
        ->call('edit', $higherEducation)
        ->assertSet('program', $higherEducation->program)
        ->assertSet('type', $higherEducation->type)
        ->assertSet('date_start', $higherEducation->date_start->toDateString())
        ->assertSet('actual', $higherEducation->actual)
        ->assertSet('date_end', $higherEducation->date_end->toDateString())
        ->set('program', 'Ingeniería')
        ->set('type', 'UN')
        ->set('date_start', '2020-01-01')
        ->set('actual', false)
        ->set('date_end', '2020-02-03')
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('update');

    $response->assertHasNoErrors()
        ->assertDispatched('high.edit');

    Storage::disk('public')->assertExists('2/certification.jpg')
        ->assertMissing('1/certification.jpg');
});
