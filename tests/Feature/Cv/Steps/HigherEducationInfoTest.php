<?php

declare(strict_types=1);

use App\Enums\Roles;
use App\Livewire\Cv\Steps\HigherEducation\Edit;
use App\Livewire\Cv\Steps\HigherEducationInfo;
use App\Models\Candidate;
use App\Models\Cv;
use App\Models\Department;
use App\Models\HigherEducation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('higher education screen can be rendered', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $user->assignRole(Roles::CANDIDATO);

    $response = $this->actingAs($user)->get("/cv/{$user->cv->id}/higher-education-info");

    $response->assertOk();
});

it('can be created', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();
    $department = Department::all()->random()->first();

    $response = Livewire::test(HigherEducationInfo::class, ['cv' => $user->cv])
        ->set('type', 'UN')
        ->set('semester', 7)
        ->set('licensed', 'Si')
        ->set('date_semester', '2020-01-01')
        ->set('program', 'Ingeniería')
        ->set('department_id', $department->id)
        ->set('city_id', $department->cities->random()->first()->id)
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('store');

    $response->assertHasNoErrors();

    $this->assertDatabaseCount('higher_education', 1);
});

it('show validation errors', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory())
        ->create();

    $response = Livewire::test(HigherEducationInfo::class, ['cv' => $user->cv])
        ->set('type', '')
        ->set('semester', '')
        ->set('licensed', '')
        ->set('date_semester', '')
        ->set('program', '')
        ->call('store');

    $response->assertHasErrors([
        'type',
        'semester',
        'licensed',
        'date_semester',
        'program',
        'department_id',
        'city_id',
    ])->assertNoRedirect();

    $this->assertDatabaseCount('higher_education', 0);
});

it('can be deleted', function () {
    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(HigherEducation::factory(2)))
        ->create();

    $this->assertDatabaseCount('higher_education', 2);

    $response = Livewire::test(HigherEducationInfo::class, ['cv' => $user->cv])
        ->call('delete', $user->cv->higherEducations()->first());

    $response->assertNoRedirect();
    $this->assertDatabaseCount('higher_education', 1);
});

test('send to work experience', function () {
    $response = Livewire::test(HigherEducationInfo::class, ['cv' => Cv::factory()->create()])
        ->call('navigate');

    $response->assertRedirect('/cv/1/work-experience-info');
});

it('can be updated', function () {
    Storage::fake();

    $user = User::factory()
        ->for(Candidate::factory(), 'userable')
        ->has(Cv::factory()->has(HigherEducation::factory(2)))
        ->create();
    $higherEducation = $user->cv->higherEducations->first();
    $higherEducation->addMedia(UploadedFile::fake()->image('certification_1.jpg'))
        ->toMediaCollection();

    $response = Livewire::test(Edit::class)
        ->call('edit', $higherEducation)
        ->assertSet('type', $higherEducation->type)
        ->assertSet('semester', $higherEducation->semester)
        ->assertSet('date_semester', $higherEducation->date_semester->format('Y-m-d'))
        ->assertSet('licensed', $higherEducation->licensed)
        ->assertSet('program', $higherEducation->program)
        ->assertSet('department_id', $higherEducation->department_id)
        ->assertSet('city_id', $higherEducation->city_id)
        ->set('type', 'UN')
        ->set('semester', 7)
        ->set('licensed', 'Si')
        ->set('date_semester', '2020-01-01')
        ->set('licensed', 'Si')
        ->set('program', 'Ingeniería')
        ->set('department_id', $higherEducation->department_id)
        ->set('city_id', $higherEducation->city_id)
        ->set('certification', UploadedFile::fake()->image('certification.jpg'))
        ->call('update');

    $response->assertHasNoErrors()
        ->assertDispatched('refresh');

    Storage::disk('public')->assertExists('2/certification.jpg')
        ->assertMissing('1/certification.jpg');
});
